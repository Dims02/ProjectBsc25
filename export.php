<?php
if (!isLoggedIn()) {
    header("Location: /login");
    exit;
}
require_once "config.php";

// Get survey id and export type.
$surveyId = isset($_GET['survey_id']) ? (int)$_GET['survey_id'] : null;
$type     = isset($_GET['type']) ? $_GET['type'] : 'json';

$user   = getUserFromJWT();
$survey = getSurvey($surveyId);
$survey->title ??= "Survey";

// Remove spaces from the survey title.
$surveyNewTitle = str_replace(' ', '_', $survey->title);

// Build filename.
if ($type === 'pdf') {
    $filename = $surveyNewTitle . "_" . ($user->entity ?? "") . "_Report.pdf";
} else {
    $filename = $surveyNewTitle . "_" . ($user->entity ?? "") . "_Report.json";
}

global $pdo;

// Retrieve recommendations using getIncorrectResponses() function.
if ($surveyId) {
    $results = getIncorrectResponses($user->id, $surveyId);
} else {
    header("Location: /surveys");
    exit;
}

if ($type === 'pdf') {
    // --- Group the responses by question group (page) ---
    $groupedResults = [];
    foreach ($results as $row) {
        $groupId = $row['group_id'];
        if (!isset($groupedResults[$groupId])) {
            $groupedResults[$groupId] = [
                'group_title'         => $row['group_title'] ?? 'Unnamed Group',
                'group_recommendation'=> $row['group_recommendation'] ?? "Review this topic for more details.",
                'questions'           => []
            ];
        }
        $groupedResults[$groupId]['questions'][] = $row;
    }
    
        // Build the recommendations LaTeX string.
        if (empty($groupedResults)) {
            $recs = "The entity is fully compliant with the directive.";
        } else {
            $recs = "";
            foreach ($groupedResults as $group) {
                $groupTitle = addslashes($group['group_title']);
                $groupRec   = addslashes($group['group_recommendation']);
                $recs .= "\\section*{Group: $groupTitle}\n";
                $recs .= "$groupRec \\\\[1em]\n";
                foreach ($group['questions'] as $item) {
                    $questionText  = addslashes($item['question']);
                    $yourAnswer    = addslashes($item['your_answer']);
                    $correctAnswer = addslashes($item['correct_answer']);
                    $questionRec   = addslashes($item['recommendation']);
                
                    $recs .= "\\begin{itemize}\n";
                    $recs .= "\\item \\textbf{Question:} $questionText\n";
                    $recs .= "\\item \\textbf{Your Answer:} $yourAnswer\n";
                    $recs .= "\\item \\textbf{Correct Answer:} $correctAnswer\n";
                    $recs .= "\\item \\textbf{Recommendation:} $questionRec\n";
                    $recs .= "\\end{itemize}\n";
                    $recs .= "\\hrule\\vspace{1em}\n";
                }
                
                $recs .= "\\newpage\n";
            }
        }


    
    // Load LaTeX template.
    $latexTemplate = include 'latex_template.php';
    // Define placeholders.
    $placeholders = [
        '%SURVEY_TITLE%'    => addslashes($survey->title),
        '%DOCUMENT_AUTHOR%' => addslashes($user->name . " " . $user->surname . (!empty($user->entity) ? " ({$user->entity})" : 'Unknown')),
        '%DOCUMENT_DATE%'   => date('d F Y'),
        '%RECOMMENDATIONS%' => $recs,
        '%LOGO_PATH%'       => 'media/ubiOriginal.jpg', // adjust path if necessary
    ];
    
    // Replace placeholders in the LaTeX template.
    $latexCode = strtr($latexTemplate, $placeholders);
    
    // Save LaTeX to a temporary file.
    $tempDir = sys_get_temp_dir();
    $texFile = $tempDir . DIRECTORY_SEPARATOR . 'export_' . time() . '.tex';
    $pdfFile = str_replace('.tex', '.pdf', $texFile);
    file_put_contents($texFile, $latexCode);
    
    $pdflatexPath = "/usr/bin/pdflatex";
    $command = $pdflatexPath . " -interaction=nonstopmode -output-directory=" . escapeshellarg($tempDir) . " " . escapeshellarg($texFile) . " 2>&1";
    $outputLatex = shell_exec($command);
    
    if (file_exists($pdfFile)) {
        header('Content-Type: application/pdf');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        readfile($pdfFile);
        
        // Clean up temporary files.
        unlink($texFile);
        unlink($pdfFile);
        exit;
    } else {
        echo "Error compiling LaTeX file. Command output:<br><pre>" . htmlspecialchars($outputLatex) . "</pre>";
        exit;
    }
    
} else {
    // --- JSON Export ---
    header('Content-Type: application/json');
    header('Content-Disposition: attachment; filename="' . $filename . '"');
    echo json_encode($results);
}
?>

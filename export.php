<?php
if (!isLoggedIn()) {
    header("Location: /login");
    exit;
}

$surveyId = isset($_GET['survey_id']) ? (int)$_GET['survey_id'] : null;
$type     = isset($_GET['type']) ? $_GET['type'] : 'json';

$user   = getUserFromJWT();
$survey = getSurvey($surveyId);
$survey->title ??= "Survey";

// Remove spaces from the survey title.
$surveyNewTitle = str_replace(' ', '_', $survey->title);

// Build the filename.
if ($type === 'pdf') {
    $filename = $surveyNewTitle . "_" . ($user->entity ?? "") . "_Report.pdf";
} else {
    $filename = $surveyNewTitle . "_" . ($user->entity ?? "") . "_Report.json";
}

global $pdo;

// Retrieve recommendations.
if ($surveyId) {
    $results = getExportRecommendation($surveyId, $user->id);
} else {
    header("Location: /surveys");
    exit;
}

if ($type === 'pdf') {
    // --- Generate PDF via LaTeX using external template ---
    
    // Load the LaTeX template from external file
    $latexTemplate = include 'latex_template.php';
    
    // Build recommendations LaTeX string
    if (empty($results)) {
        // If there are no recommendations, set a compliance message.
        $recs = "The entity is fully compliant with the directive.";
    } else {
        $recs = "";
        foreach ($results as $row) {
            $title = addslashes($row['title']);
            $rec   = addslashes($row['recommendation']);
            $recs .= "\\subsection*{Title: $title}\n";
            $recs .= "$rec \\\\[1em]\n";
            $recs .= "\\hrule\n\\vspace{1em}\n";
        }
    }
    
    // Define placeholders to be replaced in template
    $placeholders = [
        '%SURVEY_TITLE%'    => addslashes($survey->title),
        '%DOCUMENT_AUTHOR%' => addslashes($user->name . (!empty($user->entity) ? " ({$user->entity})" : 'Unknown')),
        '%DOCUMENT_DATE%'   => date('d F Y'),
        '%RECOMMENDATIONS%' => $recs,
        '%LOGO_PATH%'       => 'media/ubiOriginal.jpg',  // make sure the path is correct
    ];
    
    // Replace placeholders in LaTeX template
    $latexCode = strtr($latexTemplate, $placeholders);
    
    // Save LaTeX to temporary file
    $tempDir = sys_get_temp_dir();
    $texFile = $tempDir . DIRECTORY_SEPARATOR . 'export_' . time() . '.tex';
    $pdfFile = str_replace('.tex', '.pdf', $texFile);
    file_put_contents($texFile, $latexCode);
    
    // Compile with pdflatex
    $pdflatexPath = '"C:\Users\dimat\AppData\Local\Programs\MiKTeX\miktex\bin\x64\pdflatex.exe"';
    $command = $pdflatexPath . " -interaction=nonstopmode -output-directory=" . escapeshellarg($tempDir) . " " . escapeshellarg($texFile) . " 2>&1";
    $outputLatex = shell_exec($command);
    
    if (file_exists($pdfFile)) {
        header('Content-Type: application/pdf');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        readfile($pdfFile);
        
        // Clean temporary files
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

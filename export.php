<?php
if (!isLoggedIn()) {
    header("Location: /login");
    exit;
}

require_once "config.php";

$surveyId = isset($_GET['survey_id']) ? (int)$_GET['survey_id'] : null;
$type     = isset($_GET['type']) ? $_GET['type'] : 'json';

$user     = getUserFromJWT();
$survey   = getSurvey($surveyId);
$survey->title ??= "Survey";

$surveyNewTitle = str_replace(' ', '_', $survey->title);

$filename = $surveyNewTitle . "_" . ($user->entity ?? "") . "_Report." . ($type === 'pdf' ? "pdf" : "json");

if (!$surveyId) {
    header("Location: /surveys");
    exit;
}

$desiredLevel = getUserDesiredComplianceLevel($user->id, $surveyId);
$results = getIncorrectResponses($user->id, $surveyId, $desiredLevel);

// Group the results
$groupedResults = [];
foreach ($results as $row) {
    $groupId = $row['group_id'];
    if (!isset($groupedResults[$groupId])) {
        $groupedResults[$groupId] = [
            'group_title'          => $row['group_title'] ?? 'Unnamed Group',
            'group_recommendation' => $row['group_recommendation'] ?? "Review this topic for more details.",
            'questions'            => []
        ];
    }

    // Strip HTML tags
    $row['question']       = strip_tags($row['question']);
    $row['your_answer']    = strip_tags($row['your_answer']);
    $row['recommendation'] = strip_tags($row['recommendation']);

    $groupedResults[$groupId]['questions'][] = $row;
}

if ($type === 'json') {
    header('Content-Type: application/json');
    header('Content-Disposition: attachment; filename="' . $filename . '"');
    echo json_encode(array_values($groupedResults));
    exit;
}

// PDF Export
if ($type === 'pdf') {
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
                $questionText = addslashes($item['question']);
                $yourAnswer   = addslashes($item['your_answer']);
                $recText      = addslashes($item['recommendation']);
                $recs .= "\\begin{itemize}\n";
                $recs .= "\\item \\textbf{Question:} $questionText\n";
                $recs .= "\\item \\textbf{Your Answer:} $yourAnswer\n";
                $recs .= "\\item \\textbf{Recommendation:} $recText\n";
                $recs .= "\\end{itemize}\n";
                $recs .= "\\hrule\\vspace{1em}\n";
            }
            $recs .= "\\newpage\n";
        }
    }

    $latexTemplate = include 'latex_template.php';
    $placeholders = [
        '%SURVEY_TITLE%'    => addslashes($survey->title),
        '%DOCUMENT_AUTHOR%' => addslashes($user->name . " " . $user->surname . (!empty($user->entity) ? " ({$user->entity})" : 'Unknown')),
        '%DOCUMENT_DATE%'   => date('d F Y'),
        '%RECOMMENDATIONS%' => $recs,
        '%LOGO_PATH%'       => 'media/ubiOriginal.jpg'
    ];

    $latexCode = strtr($latexTemplate, $placeholders);
    $tempDir   = sys_get_temp_dir();
    $texFile   = $tempDir . DIRECTORY_SEPARATOR . 'export_' . time() . '.tex';
    $pdfFile   = str_replace('.tex', '.pdf', $texFile);
    file_put_contents($texFile, $latexCode);

    $pdflatexPath = "/usr/bin/pdflatex";
    $command = "$pdflatexPath -interaction=nonstopmode -output-directory=" . escapeshellarg($tempDir) . " " . escapeshellarg($texFile) . " 2>&1";
    $output = shell_exec($command);

    if (file_exists($pdfFile)) {
        header('Content-Type: application/pdf');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        readfile($pdfFile);
        unlink($texFile);
        unlink($pdfFile);
        exit;
    } else {
        echo "Error compiling LaTeX file:<br><pre>" . htmlspecialchars($output) . "</pre>";
        exit;
    }
}
?>

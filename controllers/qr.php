<?php
// qr.php: Render a styled HTML page with embedded QR code and card icon for a survey

// --- Load Composer autoloader ---
require_once __DIR__ . '/../vendor/autoload.php';

use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\RoundBlockSizeMode;
use Endroid\QrCode\Writer\PngWriter;

// --- Auth: only admins allowed ---
if (!isAdminFromJWT() || !isLoggedIn()) {
    header('HTTP/1.1 403 Forbidden');
    exit('Access denied');
}

// --- Validate survey_id ---
if (empty($_GET['survey_id']) || !ctype_digit($_GET['survey_id'])) {
    http_response_code(400);
    exit('Missing or invalid survey_id');
}
$surveyId = (int) $_GET['survey_id'];

// --- Load survey ---
$survey = getSurvey($surveyId);
if (!$survey) {
    http_response_code(404);
    exit('Survey not found');
}

// --- Construct public URL ---
$host      = $_SERVER['HTTP_HOST'];
$surveyUrl = sprintf('https://%s/survey?id=%d', $host, $survey->id);

// --- Path to full logo ---
$logoPath = __DIR__ . '/../media/ubi2.png';

// --- Build QR code with embedded full logo ---
$builder = new Builder(
    writer: new PngWriter(),
    writerOptions: [],
    validateResult: false,
    data: $surveyUrl,
    encoding: new Encoding('UTF-8'),
    errorCorrectionLevel: ErrorCorrectionLevel::High,
    size: 1080,
    margin: 20,
    roundBlockSizeMode: RoundBlockSizeMode::Margin,
    logoPath: file_exists($logoPath) ? $logoPath : null,
    logoResizeToWidth: file_exists($logoPath) ? 200 : null,
    logoPunchoutBackground: file_exists($logoPath)
);
$result  = $builder->build();
$dataUri = $result->getDataUri();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= htmlspecialchars($survey->title) ?> — QR Code</title>
  <style>
    body {
      background: #f3f4f6;
      margin: 0;
      font-family: sans-serif;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }
    .card {
      position: relative;
      background: #ffffff;
      padding: 2rem;
      border-radius: 2rem;
      box-shadow: 0 4px 6px rgba(0,0,0,0.1);
      text-align: center;
      max-width: 360px;
    }
    .card .card-icon {
      position: absolute;
      top: 0rem;
      left: 2rem;
      width: 150px;
      height: 150px;
      object-fit: contain;
    }
    .card .qr {
      margin-bottom: 1rem;
	  margin-top: 5rem;
      width: 100%;
      height: auto;
    }
    .card h1 {
      font-size: 2rem;
      margin: 0.5rem 0;
    }
    .card p {
      color: #4b5563;
      margin-top: 0.25rem;
    }
  </style>
</head>
<body>
  <div class="card">
    <!-- Top-left full icon -->
    <?php if (file_exists(__DIR__ . '/../media/ubifull.png')): ?>
      <img class="card-icon" src="/media/ubifull.png" alt="Logo">
    <?php endif; ?>

    <!-- QR code with embedded logo -->
    <img class="qr" src="<?= $dataUri ?>" alt="QR code for <?= htmlspecialchars($survey->title) ?>">

    <!-- HTML label -->
    <h1><?= htmlspecialchars($survey->title) ?></h1>
    <p>Scan me to take the survey</p>
  </div>
</body>
</html>

<?php
// --- Load Composer autoloader ---
require_once __DIR__ . '/../vendor/autoload.php';

use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\RoundBlockSizeMode;
use Endroid\QrCode\Writer\PngWriter;

$encodedSurveyId = $_GET['survey_id'] ?? null;
$survey = getSurvey(decodeSurveyCode( $encodedSurveyId));

$host      = $_SERVER['HTTP_HOST'];
$surveyUrl = sprintf('https://%s/survey?id=%s', $host, $encodedSurveyId);

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
    logoResizeToWidth: file_exists($logoPath) ? 225 : null,
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
  <title>QR Code</title>
  <link rel="icon" href="/media/ubiround.png" type="image/png">
  <script src="https://cdn.jsdelivr.net/npm/html2canvas@1.4.1/dist/html2canvas.min.js" defer></script>
  <style>
    body { 
      background: #0c2340;
      margin: 0;
      font-family: sans-serif;
      display: flex;
      justify-content: center;
	  flex-direction: column;
      align-items: center;
      height: 100vh;
    }
    .card {
      position: relative;
      background: white;
      padding: 2rem;
      border-radius: 2rem;
      text-align: center;
      max-width: 360px;
      overflow: hidden;
    }
    .card .card-icon {
      display: block;
      margin: 0 auto 1rem;
      max-width: 200px;
      height: auto;
      object-fit: contain;
    }

    .card .qr {
      margin-bottom: 1rem;
	  margin-top: 0rem;
      width: 100%;
      height: auto;
	  max-width: 300px;
	  max-height: 300px;
	  
    }
    .card h1 {
      font-size: 2rem;
      margin: 0.5rem 0;
	  color:  #0c2340;
    }
    .card p {
      color:  #0c2340;
      margin-top: 0.25rem;
    }
	.download-icon-container {
      margin-top: 1rem;
      text-align: center;
    }
    .download-icon-container button {
      background: none;
      border: none;
      cursor: pointer;
      padding: 0;
    }
    .download-icon-container img {
      width: 34px;  
      height: 34px;
    }
  </style>
</head>
<body>
  <div class="card" id="card">
    <?php if (file_exists(__DIR__ . '/../media/ubifull.png')): ?>
      <img class="card-icon" src="/media/ubifull.png" alt="Logo">
    <?php endif; ?>
    <img class="qr" src="<?= $dataUri ?>" alt="QR code for <?= htmlspecialchars($survey->title) ?>">
    <h1><?= htmlspecialchars($survey->title) ?></h1>
    <p>Scan me to take the survey</p>
  </div>

  <div class="download-icon-container">
    <button id="downloadBtn">
      <img src="/media/download.png" alt="Download Card">
    </button>
  </div>


  <script>
  document.addEventListener('DOMContentLoaded', () => {
    document.getElementById('downloadBtn').addEventListener('click', () => {
      const card = document.getElementById('card');
      html2canvas(card, {
        useCORS: true,
        backgroundColor: null,
        scale: window.devicePixelRatio || 1
      }).then(canvas => {
        const link = document.createElement('a');
        link.download = 'QR_CODE.png';
        link.href     = canvas.toDataURL('image/png');
        link.click();
      }).catch(() => alert('Download failed, please try again.'));
    });
  });
</script>


</body>
</html>
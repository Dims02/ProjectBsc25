<?php
include 'includes/config.php';
include 'includes/header.php';

if (!isset($_GET['group_id'])) {
    echo "<p>No survey selected.</p>";
    include 'includes/footer.php';
    exit;
}

$group_id = intval($_GET['group_id']);

// For now, simulate group details and questions; replace these with actual DB queries later
$group = ['group_id' => $group_id, 'group_name' => 'Customer Satisfaction', 'recommendation' => 'We value your feedback!'];
$questions = [
    ['question_id' => 1, 'question_text' => 'How satisfied are you with our service?', 'weight' => 1.0],
    ['question_id' => 2, 'question_text' => 'How likely are you to recommend us to a friend?', 'weight' => 1.0]
];
?>

<h1><?= htmlspecialchars($group['group_name']) ?></h1>
<p><?= htmlspecialchars($group['recommendation']) ?></p>

<form id="surveyForm" method="post" action="survey.php?group_id=<?= $group_id ?>">
  <?php foreach ($questions as $q): ?>
    <div class="mb-3">
      <label class="form-label"><?= htmlspecialchars($q['question_text']) ?></label>
      <select class="form-select" name="question_<?= $q['question_id'] ?>" required>
        <option value="">Select an answer</option>
        <option value="1">1 - Strongly Disagree</option>
        <option value="2">2 - Disagree</option>
        <option value="3">3 - Neutral</option>
        <option value="4">4 - Agree</option>
        <option value="5">5 - Strongly Agree</option>
      </select>
    </div>
  <?php endforeach; ?>
  <button type="submit" class="btn btn-primary">Submit Survey</button>
</form>

<!-- Placeholder for survey results (charts, export buttons, etc.) -->
<div id="resultsContainer" class="mt-5" style="display: none;">
  <h2>Survey Results</h2>
  <canvas id="resultsChart"></canvas>
  <div class="mt-3">
    <button class="btn btn-secondary" id="exportPDF">Export as PDF</button>
    <button class="btn btn-secondary" id="exportJSON">Export as JSON</button>
  </div>
</div>

<?php include 'includes/footer.php'; ?>

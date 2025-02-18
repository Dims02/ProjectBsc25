<?php
include 'includes/config.php';  // For database connection (if needed)
include 'includes/header.php';

// For demonstration, assume you have an array of groups (replace with your DB query later)
$groups = [
  ['group_id' => 1, 'group_name' => 'Customer Satisfaction', 'recommendation' => 'Improve service quality.'],
  ['group_id' => 2, 'group_name' => 'Employee Feedback', 'recommendation' => 'Enhance work environment.']
];
?>

<h1 class="mb-4">Available Surveys</h1>
<div class="list-group">
  <?php foreach ($groups as $group): ?>
    <a href="survey.php?group_id=<?= $group['group_id'] ?>" class="list-group-item list-group-item-action">
      <?= htmlspecialchars($group['group_name']) ?>
    </a>
  <?php endforeach; ?>
</div>

<?php include 'includes/footer.php'; ?>

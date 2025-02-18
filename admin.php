<?php
include 'includes/config.php';
include 'includes/header.php';

// For demonstration, simulate a list of survey groups
$groups = [
  ['group_id' => 1, 'group_name' => 'Customer Satisfaction', 'recommendation' => 'Improve service quality.'],
  ['group_id' => 2, 'group_name' => 'Employee Feedback', 'recommendation' => 'Enhance work environment.']
];
?>

<h1>Admin Panel</h1>
<nav class="mb-3">
  <a href="index.php" class="btn btn-secondary">Back to Home</a>
</nav>

<div id="adminContent">
  <?php foreach ($groups as $group): ?>
    <div class="card mb-3">
      <div class="card-body">
        <h5 class="card-title"><?= htmlspecialchars($group['group_name']) ?></h5>
        <p class="card-text"><?= htmlspecialchars($group['recommendation']) ?></p>
        <!-- Links for editing or deleting -->
        <a href="edit_survey.php?group_id=<?= $group['group_id'] ?>" class="btn btn-primary me-2">Edit</a>
        <a href="delete_survey.php?group_id=<?= $group['group_id'] ?>" class="btn btn-danger">Delete</a>
      </div>
    </div>
  <?php endforeach; ?>
  <a href="create_survey.php" class="btn btn-success">Create New Survey</a>
</div>

<?php include 'includes/footer.php'; ?>

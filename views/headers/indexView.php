<?php require_once __DIR__ . '/../partials/header.php'; ?>
<?php require_once __DIR__ . '/../partials/nav.php'; ?>
<?php require_once __DIR__ . '/../partials/banner.php'; ?>

<main class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
    <!-- Summary Stats -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        <div class="bg-white shadow-md rounded-lg p-6 text-center">
            <h2 class="text-lg font-semibold text-gray-900">Total Surveys Taken</h2>
            <p class="text-3xl font-bold text-indigo-600"><?= htmlspecialchars($NumSurveyTaken, ENT_QUOTES, 'UTF-8') ?></p>
        </div>
        <div class="bg-white shadow-md rounded-lg p-6 text-center">
            <h2 class="text-lg font-semibold text-gray-900">Ongoing Surveys</h2>
            <p class="text-3xl font-bold text-blue-600"><?= htmlspecialchars($NumSurveyTaking, ENT_QUOTES, 'UTF-8') ?></p>
        </div>
        <div class="bg-white shadow-md rounded-lg p-6 text-center">
            <h2 class="text-lg font-semibold text-gray-900">Average Compliance Rate</h2>
            <p class="text-3xl font-bold text-green-600"><?= htmlspecialchars($PercentCorrect, ENT_QUOTES, 'UTF-8') ?></p>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="mt-8 grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Completion Rate Chart -->
        <div class="bg-white shadow-md rounded-lg p-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">Survey Completion Rate</h2>
            <div class="h-64">
                <canvas id="completionChart"></canvas>
            </div>
        </div>

        <!-- Survey Progress Chart -->
        <div class="bg-white shadow-md rounded-lg p-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">Survey Progress</h2>
            <div class="h-64">
                <canvas id="progressChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Recent Surveys Section -->
    <div class="mt-8 bg-white shadow-md rounded-lg p-6">
        <h2 class="text-lg font-semibold text-gray-900">Recent Surveys</h2>
        <ul class="mt-4 space-y-3">
            <?php if (!empty($recentSurveys)): ?>
                <?php foreach ($recentSurveys as $survey): ?>
                    <li class="flex items-center justify-between bg-gray-50 p-4 rounded-md">
                        <div>
                            <p class="text-gray-900 font-semibold"><?= htmlspecialchars($survey->title, ENT_QUOTES, 'UTF-8') ?></p>
                            <p class="text-gray-600 text-sm">Completed on: <?= htmlspecialchars($survey->completed_date, ENT_QUOTES, 'UTF-8') ?></p>
                        </div>
                        <a href="/reco?survey_id=<?= htmlspecialchars($survey->id, ENT_QUOTES, 'UTF-8') ?>" class="<?= $highlightColor; ?> px-3 py-1 rounded-md text-sm hover:bg-opacity-80">
                View Results
                </a>
                    </li>
                <?php endforeach; ?>
            <?php else: ?>
                <li class="text-gray-600">No completed surveys found.</li>
            <?php endif; ?>
        </ul>
    </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // --- Doughnut Chart: Survey Completion for a specific survey ---
    const surveyCompletion = <?php echo $surveyCompletion; ?>;
    const completed = surveyCompletion;
    const incomplete = 100 - surveyCompletion;

    const canvas1 = document.getElementById('completionChart');
    if (canvas1) {
        const ctx1 = canvas1.getContext('2d');
        new Chart(ctx1, {
            type: 'doughnut',
            data: {
                labels: ['Completed', 'Incomplete'],
                datasets: [{
                    data: [completed, incomplete],
                    backgroundColor: ['#4CAF50', '#E57373']
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false
            }
        });
    } else {
        console.error("Canvas 'completionChart' not found.");
    }

    // --- Bar Chart: Survey Completion for all surveys ---
    const surveyProgressData = <?php echo json_encode($allSurveyCompletions); ?>;
    const surveyLabels = Object.keys(surveyProgressData);
    const surveyPercentages = Object.values(surveyProgressData);

    const canvas2 = document.getElementById('progressChart');
    if (canvas2) {
        const ctx2 = canvas2.getContext('2d');
        new Chart(ctx2, {
            type: 'bar',
            data: {
                labels: surveyLabels,
                datasets: [{
                    label: 'Completion %',
                    data: surveyPercentages,
                    backgroundColor: 'rgba(54, 162, 235, 0.8)'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: { beginAtZero: true, max: 100 }
                }
            }
        });
    } else {
        console.error("Canvas 'progressChart' not found.");
    }
});
</script>

<div class="pb-6"></div>
<?php require_once __DIR__ . '/../partials/footer.php'; ?>

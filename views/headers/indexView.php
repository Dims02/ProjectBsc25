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
            <h2 class="text-lg font-semibold text-gray-900">Surveys to Complete</h2>
            <p class="text-3xl font-bold text-indigo-600"><?= htmlspecialchars($NumSurveyNotCompleted, ENT_QUOTES, 'UTF-8') ?></p>
        </div>
        <div class="bg-white shadow-md rounded-lg p-6 text-center">
            <h2 class="text-lg font-semibold text-gray-900">Average Compliance Rate</h2>
            <p class="text-3xl font-bold text-green-600"><?= htmlspecialchars($PercentCorrect, ENT_QUOTES, 'UTF-8') ?></p>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="mt-8 grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Survey Completion Ratio Chart -->
        <div class="bg-white shadow-md rounded-lg p-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">Survey Completion Ratio</h2>
            <div class="h-64">
                <canvas id="completionChart"></canvas>
            </div>
        </div>

        <!-- Survey Compliance Level Chart -->
        <div class="bg-white shadow-md rounded-lg p-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">Survey Compliance Levels</h2>
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
                    <li class="flex items-center justify-between bg-gray-200 p-4 rounded-md">
                        <div>
                            <p class="text-gray-900 font-semibold"><?= htmlspecialchars($survey->title, ENT_QUOTES, 'UTF-8') ?></p>
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
    // --- Doughnut Chart: Survey Completion Ratio for all surveys ---
    const completed = <?php echo $surveysRatio['completed']; ?>;
    const notCompleted = <?php echo $surveysRatio['not_completed']; ?>;
    
    const canvas1 = document.getElementById('completionChart');
    if (canvas1) {
        const ctx1 = canvas1.getContext('2d');
        new Chart(ctx1, {
            type: 'doughnut',
            data: {
                labels: ['Completed', 'Not Completed'],
                datasets: [{
                    data: [completed, notCompleted],
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

    // --- Bar Chart: Survey Compliance Levels for all surveys ---
    const surveyComplianceData = <?php echo json_encode($allSurveyComplianceLevels); ?>;
    const surveyLabels = Object.keys(surveyComplianceData);
    const surveyLevels = Object.values(surveyComplianceData);

    // Format long survey names to multi-line labels if needed.
    const formattedLabels = surveyLabels.map(label => {
        const threshold = 12; // Maximum characters per line
        if(label.length <= threshold) return label;
        const words = label.split(' ');
        let lines = [];
        let currentLine = "";
        words.forEach(word => {
            if((currentLine + word).length > threshold) {
                lines.push(currentLine.trim());
                currentLine = word + " ";
            } else {
                currentLine += word + " ";
            }
        });
        if(currentLine.trim() !== "") {
            lines.push(currentLine.trim());
        }
        return lines;
    });

    const levelLabels = {
        0: 'No compliance',
        1: 'Basic',
        2: 'Intermediate',
        3: 'Advanced'
    };

    const canvas2 = document.getElementById('progressChart');
    if (canvas2) {
        const ctx2 = canvas2.getContext('2d');
        new Chart(ctx2, {
            type: 'bar',
            data: {
                labels: formattedLabels,
                datasets: [{
                    label: 'Compliance Level',
                    data: surveyLevels,
                    backgroundColor: 'rgba(54, 162, 235, 0.8)'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        max: 3,
                        ticks: {
                            callback: function(value) {
                                return levelLabels[value] !== undefined ? levelLabels[value] : value;
                            },
                            stepSize: 1
                        }
                    }
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

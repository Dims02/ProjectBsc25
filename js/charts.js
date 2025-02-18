// js/charts.js
document.addEventListener("DOMContentLoaded", function () {
    if (typeof surveyResults !== "undefined") {
        // Use Chart.js to display a chart in the canvas with id "resultsChart"
        const ctx = document.getElementById('resultsChart').getContext('2d');
        // For demonstration, create a simple bar chart from surveyResults
        const labels = Object.keys(surveyResults).map(qid => `Q${qid}`);
        const data = Object.values(surveyResults);
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Survey Scores',
                    data: data,
                    backgroundColor: 'rgba(54, 162, 235, 0.6)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: { beginAtZero: true, max: 5 }
                }
            }
        });
    }
});

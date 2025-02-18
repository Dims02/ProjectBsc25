// js/export.js
document.getElementById('exportPDF')?.addEventListener('click', function () {
    // Implement PDF export using jsPDF (placeholder code)
    alert('Export to PDF functionality coming soon!');
});

document.getElementById('exportJSON')?.addEventListener('click', function () {
    // Convert surveyResults to JSON and download
    if (typeof surveyResults !== "undefined") {
        const dataStr = "data:text/json;charset=utf-8," + encodeURIComponent(JSON.stringify(surveyResults, null, 2));
        const downloadAnchorNode = document.createElement('a');
        downloadAnchorNode.setAttribute("href", dataStr);
        downloadAnchorNode.setAttribute("download", "survey_results.json");
        document.body.appendChild(downloadAnchorNode);
        downloadAnchorNode.click();
        downloadAnchorNode.remove();
    }
});

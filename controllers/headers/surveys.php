<?php
$heading = "Available Surveys";
$tabname = "Surveys";
$pos = "max-w-7xl";

$surveys = getAllSurveys();

// Define the mapping of language codes to flag icons.
$flagIcons = [
    'en' => '/media/uk2.png', 
    'pt' => '/media/pt1.png',
    // Add more languages as needed.
];

require "./views/headers/surveysView.php";
?>

<?php

$heading = "Available Surveys";
$tabname = "Surveys";
$bgcolor = "bg-gray-100";
$pos = "max-w-7xl";
require "./views/headers/surveysView.php";

$_SESSION['currentSurvey'] = null;
$_SESSION['groupIndex'] = 0;
$_SESSION['currentQuestion'] = 0;
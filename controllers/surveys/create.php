<?php

$user_id = getUserFromJWT()->id;

createSurvey($user_id);

$_SESSION['success_message'] = 'Survey created successfully.';
header('Location: /admin');
exit;

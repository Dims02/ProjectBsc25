<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Document</title>
</head>
<body>
<?php
session_start();

// Define a default set of questions.
$defaultQuestions = [
    1 => [
        'question' => "Do you have a firewall installed and properly configured?",
        'recommendation' => "Ensure your firewall has updated rules and policies to protect against unauthorized access."
    ],
    2 => [
        'question' => "Are your systems updated with the latest security patches?",
        'recommendation' => "Regular updates are crucial to protect against known vulnerabilities."
    ],
    3 => [
        'question' => "Do you conduct regular backups of your critical data?",
        'recommendation' => "Implement a robust backup strategy and test your backups regularly."
    ]
];

// Initialize questions in session if not already set.
if (!isset($_SESSION['questions'])) {
    $_SESSION['questions'] = $defaultQuestions;
}

// Determine the mode: survey (default) or admin.
$mode = isset($_GET['mode']) ? $_GET['mode'] : 'survey';

//----------------------------
// ADMIN MODE
//----------------------------
if ($mode === 'admin') {
    // Handle logout.
    if (isset($_GET['action']) && $_GET['action'] == 'logout') {
        unset($_SESSION['admin']);
        header("Location: index.php?mode=admin");
        exit;
    }
    
    // If the admin is not logged in, show the login form.
    if (!isset($_SESSION['admin']) || $_SESSION['admin'] !== true) {
        // Process login submission.
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['username'], $_POST['password'])) {
            $username = $_POST['username'];
            $password = $_POST['password'];
            // Hard-coded credentials (for demo purposes only).
            if ($username === 'admin' && $password === 'admin123') {
                $_SESSION['admin'] = true;
                header("Location: index.php?mode=admin");
                exit;
            } else {
                $loginError = "Invalid credentials. Please try again.";
            }
        }
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <title>Admin Login</title>
            <style>
                body { font-family: Arial, sans-serif; margin: 20px; }
                form { max-width: 300px; margin: auto; }
                input[type="text"], input[type="password"] {
                    width: 100%; padding: 8px; margin-bottom: 10px; border: 1px solid #ccc;
                }
                input[type="submit"] {
                    padding: 10px; background-color: #0288d1; color: white; border: none; width: 100%;
                }
                .error { color: red; }
            </style>
        </head>
        <body>
            <h2>Admin Login</h2>
            <?php if(isset($loginError)) { echo "<p class='error'>$loginError</p>"; } ?>
            <form method="POST" action="index.php?mode=admin">
                <label for="username">Username:</label>
                <input type="text" name="username" id="username" required>
                <label for="password">Password:</label>
                <input type="password" name="password" id="password" required>
                <input type="submit" value="Login">
            </form>
            <p><a href="index.php">Return to Survey</a></p>
        </body>
        </html>
        <?php
        exit;
    } else {
        // Admin is logged in; process admin actions.
        // Handle new question submission.
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['new_question']) && isset($_POST['new_recommendation'])) {
            $newId = count($_SESSION['questions']) + 1;
            $newQuestion = trim($_POST['new_question']);
            $newRecommendation = trim($_POST['new_recommendation']);
            if ($newQuestion !== "" && $newRecommendation !== "") {
                $_SESSION['questions'][$newId] = [
                    'question' => $newQuestion,
                    'recommendation' => $newRecommendation
                ];
                $message = "New question added successfully!";
            } else {
                $message = "Both fields are required.";
            }
        }
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <title>Admin Panel</title>
            <style>
                body { font-family: Arial, sans-serif; margin: 20px; }
                .question-list { margin-bottom: 30px; }
                .question-item { margin-bottom: 10px; padding: 10px; border: 1px solid #ccc; }
                form { margin-bottom: 30px; }
                input[type="text"] { width: 100%; padding: 8px; margin-bottom: 10px; border: 1px solid #ccc; }
                input[type="submit"] { padding: 10px; background-color: #0288d1; color: white; border: none; }
                a { text-decoration: none; color: #0288d1; }
            </style>
        </head>
        <body>
            <h1>Admin Panel</h1>
            <p>
                <a href="index.php?action=logout&mode=admin">Logout</a> | 
                <a href="index.php">Return to Survey</a>
            </p>
            <?php if(isset($message)) { echo "<p>$message</p>"; } ?>
            <h2>Current Survey Questions</h2>
            <div class="question-list">
                <?php foreach ($_SESSION['questions'] as $id => $q): ?>
                    <div class="question-item">
                        <strong>Question <?php echo $id; ?>:</strong> <?php echo htmlspecialchars($q['question']); ?><br>
                        <em>Recommendation:</em> <?php echo htmlspecialchars($q['recommendation']); ?>
                    </div>
                <?php endforeach; ?>
            </div>
            <h2>Add New Question</h2>
            <form method="POST" action="index.php?mode=admin">
                <label for="new_question">Question:</label>
                <input type="text" name="new_question" id="new_question" required>
                <label for="new_recommendation">Recommendation:</label>
                <input type="text" name="new_recommendation" id="new_recommendation" required>
                <input type="submit" value="Add Question">
            </form>
        </body>
        </html>
        <?php
        exit;
    }
}

//----------------------------
// SURVEY MODE
//----------------------------

// If the survey form is submitted, process the responses.
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $mode === 'survey') {
    $responses = [];
    foreach ($_SESSION['questions'] as $id => $q) {
        $response = isset($_POST["question_$id"]) ? trim($_POST["question_$id"]) : '';
        $responses[$id] = $response;
    }
    // For demonstration, we save responses in session (ideally, store them in a database).
    $_SESSION['responses'][] = $responses;
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Survey Responses Received</title>
        <style>
            body { font-family: Arial, sans-serif; margin: 20px; }
            .response { margin-bottom: 20px; padding: 10px; border: 1px solid #ccc; }
            a { text-decoration: none; color: #0288d1; }
        </style>
    </head>
    <body>
        <h1>Thank you for your responses!</h1>
        <h2>Your Responses</h2>
        <?php foreach ($responses as $id => $response): ?>
            <div class="response">
                <strong>Question <?php echo $id; ?>:</strong> <?php echo htmlspecialchars($_SESSION['questions'][$id]['question']); ?><br>
                <strong>Your Response:</strong> <?php echo htmlspecialchars($response); ?>
            </div>
        <?php endforeach; ?>
        <p><a href="index.php">Return to Survey</a></p>
    </body>
    </html>
    <?php
    exit;
}

//----------------------------
// SURVEY PAGE (Default Mode)
//----------------------------
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Cybersecurity Compliance Survey</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .question { margin-bottom: 20px; padding: 10px; border-bottom: 1px solid #ddd; }
        .recommendation { font-size: 0.9em; color: #555; }
        label { display: block; margin-bottom: 5px; font-weight: bold; }
        input[type="text"] { width: 100%; padding: 8px; margin-bottom: 10px; border: 1px solid #ccc; }
        input[type="submit"] { padding: 10px 20px; font-size: 1em; cursor: pointer; background-color: #0288d1; color: white; border: none; }
        input[type="submit"]:hover { background-color: #0277bd; }
        a { text-decoration: none; color: #0288d1; }
    </style>
</head>
<body>
    <h1>Cybersecurity Compliance Survey</h1>
    <p>Please answer the following questions to help us assess compliance with current cybersecurity legislation.</p>
    <p><a href="index.php?mode=admin">Go to Admin Mode</a></p>
    <form method="POST" action="index.php">
        <?php foreach ($_SESSION['questions'] as $id => $q): ?>
            <div class="question">
                <label for="question_<?php echo $id; ?>"><?php echo htmlspecialchars($q['question']); ?></label>
                <span class="recommendation"><?php echo htmlspecialchars($q['recommendation']); ?></span>
                <input type="text" id="question_<?php echo $id; ?>" name="question_<?php echo $id; ?>" placeholder="Enter your answer">
            </div>
        <?php endforeach; ?>
        <input type="submit" value="Submit Survey">
    </form>
</body>
</html>

</body>
</html>
<?php
function getUserFromJWT() {
    global $pdo;
    if (!isset($_COOKIE['jwt'])) {
        return null;
    }
    
    $jwt = $_COOKIE['jwt'];
    
    try {
        $decoded = \Firebase\JWT\JWT::decode($jwt, new \Firebase\JWT\Key(JWT_SECRET_KEY, 'HS256'));
        
        $userId = $decoded->sub;
        
        return getUserFromId($userId);
        
    } catch (Exception $e) {
        return null;
    }
}

function getUserFromId($id) {
    global $pdo;
    // Define a query com um placeholder para o ID do utilizador
    $stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
    // Executa a query, passando o ID do utilizador como parâmetro
    $stmt->execute([$id]);
    $userData = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($userData) {
        $user = new User(
            $userData['id'],
            $userData['email'],
            $userData['password'],
            $userData['role'],
            $userData['created_at']
        );
        $user->name    = $userData['name']    ?? null;
        $user->surname = $userData['surname'] ?? null;
        $user->entity  = $userData['entity']  ?? null;
        $user->country = $userData['country'] ?? null;
        
        return $user;
    } 
    return null;
}


function verifyUser($email = null, $password = null) {
    global $pdo;
    $statement = $pdo->prepare("SELECT id, password FROM users WHERE email = :email");
    $statement->execute(['email' => $email]);
    $user = $statement->fetch(PDO::FETCH_OBJ);
    if ($user && password_verify($password, $user->password)) {
        return $user->id;
    }
    return null;
}

function checkUserExists($email) {
    global $pdo;
    $statement = $pdo->prepare("SELECT id FROM users WHERE email = :email");
    $statement->execute(['email' => $email]);
    $user = $statement->fetch(PDO::FETCH_OBJ);
    return $user ? true : false;
}

function createUser(User $user) {
    global $pdo;
    $statement = $pdo->prepare("INSERT INTO users (name, email, password, country, role, created_at) VALUES (:name, :email, :password, :country, :role, :created_at)");
    $statement->execute([
        'name'       => $user->name,
        'email'      => $user->email,
        'password'   => $user->password,
        'country'    => $user->country,
        'role'       => $user->role,
        'created_at' => $user->created_at
    ]);
}

function createNewUser($email, $password) {
    global $pdo;
    $statement = $pdo->prepare("INSERT INTO users (email, password, role) VALUES (:email, :password, :role)");
    $statement->execute([
        'email'    => $email,
        'password' => password_hash($password, PASSWORD_DEFAULT),
        'role'     => 'user'
    ]);
}

function updateUser($user) {
    global $pdo;
    $statement = $pdo->prepare("UPDATE users SET name = :name, entity = :entity, surname = :surname, country = :country WHERE id = :id");
    $statement->execute([
        'id'      => $user->id,
        'entity'  => $user->entity,
        'name'    => $user->name,
        'surname' => $user->surname,
        'country' => $user->country,
    ]);
}

function getUserIdByEmail($email) {
    global $pdo;
    $statement = $pdo->prepare("SELECT id FROM users WHERE email = :email");
    $statement->execute(['email' => $email]);
    $result = $statement->fetch(PDO::FETCH_OBJ);
    return $result ? $result->id : null;
}

/**
 * Registers a new user.
 * - Checks if the email already exists.
 * - Creates a new user.
 * - Retrieves the new user's ID.
 * - Generates a JWT and stores it in an HTTP-only cookie.
 *
 * @param string $email
 * @param string $password
 * @return true|string Returns true if registration is successful,
 *                     or an error message if registration fails.
 */
function registerUser($email, $password) {
    global $pdo;
    
    // Check if the email is already registered.
    if (checkUserExists($email)) {
        return "Email already exists";
    }
    
    // Create the new user.
    createNewUser($email, $password);
    
    // Retrieve the new user's ID.
    $userId = getUserIdByEmail($email);
    $user = getUserFromId($userId);
    
    $_SESSION['user_id'] = $user->id;
    
    // Prepare JWT payload.
    $issuedAt   = time();
    $expiration = $issuedAt + 3600; // Token valid for 1 hour
    $payload = [
        'iat'   => $issuedAt,
        'exp'   => $expiration,
        'sub'   => $user->id,
        'email' => $user->email,
        'role'  => $user->role
    ];
    
    // Generate the JWT token using the payload.
    $jwt = generateJWT($payload);
    
    // Store the JWT in an HTTP-only cookie.
    setcookie('jwt', $jwt, [
        'expires'  => $expiration,
        'path'     => '/',
        'secure'   => false, // Change to true if using HTTPS.
        'httponly' => true,
        'samesite' => 'Strict'
    ]);
    
    return true;
}


function loginUser($email, $password) {
    global $pdo;
    
    // Verify user credentials using your existing function.
    $userId = verifyUser($email, $password);
    
    if ($userId) {
        $_SESSION['user_id'] = $userId;

        $user = getUserFromId($userId);
        
        // Prepare JWT payload.
        $issuedAt   = time();
        $expiration = $issuedAt + 3600; // Token valid for 1 hour
        $payload = [
            'iat'   => $issuedAt,
            'exp'   => $expiration,
            'sub'   => $userId,
            'email' => $email,
            'role' =>  $user->role
        ];
        
        // Generate the JWT token using your existing function.
        $jwt = generateJWT($payload);
        
        // Store the JWT in an HTTP-only cookie.
        setcookie('jwt', $jwt, [
            'expires'  => $expiration,
            'path'     => '/',
            'secure'   => false, // Change to true if using HTTPS
            'httponly' => true,
            'samesite' => 'Strict'
        ]);
        
        return true;
    } else {
        return "Invalid email or password";
    }
}

function logoutUser() {
    // Clear all session variables
    $_SESSION = [];
    
    // Destroy the session
    session_destroy();
    
    // Remove the session cookie if it exists
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(
            session_name(),
            '',
            time() - 42000,
            $params["path"],
            $params["domain"],
            $params["secure"],
            $params["httponly"]
        );
    }
    
    // Clear the JWT cookie (if used for authentication)
    setcookie('jwt', '', time() - 3600, '/');
}

function isLoggedIn() {
    if (!isset($_COOKIE['jwt'])) {
        return false;
    }
    
    // Verify the JWT token
    $decoded = verifyJWT($_COOKIE['jwt']);
    
    // If the token is valid, $decoded will be an object. Otherwise, verifyJWT() returns false.
    return $decoded !== false;
}

function isAdminFromJWT() {
    if (!isset($_COOKIE['jwt'])) {
        return false;
    }
    
    $decoded = verifyJWT($_COOKIE['jwt']);
    
    if ($decoded === false || !isset($decoded->role)) {
        return false;
    }
    
    return $decoded->role === 'admin';
}

function userAnsweredSurveyFully($userId, $surveyId) {
    global $pdo;
    
    // Count only answerable questions (those with at least one option)
    $stmt = $pdo->prepare("
        SELECT COUNT(*) AS total 
        FROM questions q
        INNER JOIN question_groups qg ON q.group_id = qg.id
        WHERE qg.survey_id = :survey_id
          AND EXISTS (SELECT 1 FROM options o WHERE o.question_id = q.id)
    ");
    $stmt->execute(['survey_id' => $surveyId]);
    $totalQuestions = (int)$stmt->fetch(PDO::FETCH_OBJ)->total;
    
    // Count the number of distinct answerable questions the user has answered
    $stmt = $pdo->prepare("
        SELECT COUNT(DISTINCT r.question_id) AS answered 
        FROM responses r
        INNER JOIN questions q ON r.question_id = q.id
        INNER JOIN question_groups qg ON q.group_id = qg.id
        WHERE r.user_id = :user_id 
          AND qg.survey_id = :survey_id
          AND EXISTS (SELECT 1 FROM options o WHERE o.question_id = q.id)
    ");
    $stmt->execute(['user_id' => $userId, 'survey_id' => $surveyId]);
    $answered = (int)$stmt->fetch(PDO::FETCH_OBJ)->answered;
    
    // The survey is fully answered if the user has provided answers
    // to every question that is answerable.
    return ($totalQuestions > 0 && $answered === $totalQuestions);
}


function getFullyAnsweredSurveyIds($userId) {
    // Assuming getAllSurveys() retrieves surveys with property 'id'
    $surveys = getAllSurveys();
    $fullyAnsweredIds = [];
    
    foreach ($surveys as $survey) {
        if (userAnsweredSurveyFully($userId, $survey->id)) {
            $fullyAnsweredIds[] = $survey->id;
        }
    }
    
    return $fullyAnsweredIds;
}


function getAllUsers() {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM users");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_OBJ);
}


function deleteUser($userId) {
    global $pdo;
    // Delete the user from the database
    $stmt = $pdo->prepare("DELETE FROM users WHERE id = :id");
    return $stmt->execute(['id' => $userId]);
}

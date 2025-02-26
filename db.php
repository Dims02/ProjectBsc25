<?php
$port = 3306;
$dbname = "surveydb";
$charset = "utf8mb4";
$dsn = "mysql:host=localhost;port=$port;dbname=$dbname;charset=$charset";
$pdo = new PDO($dsn, "root", "");

class User {
    public $id;
    public $entity;
    public $name;
    public $surname;
    public $email;
    public $password;
    public $country;
    public $role = "user"; 
    public $created_at;

    public function __construct($id, $name, $email, $password, $country, $role = "user") {
        $this->id = $id;
        $this->entity = $entity;
        $this->name = $name;
        $this->surname = $surname;
        $this->email = $email;
        $this->password = password_hash($password, PASSWORD_DEFAULT); 
        $this->country = $country;
        $this->role = $role;
        $this->created_at = date('Y-m-d H:i:s');
    }
}

class Survey {
    public $id;
    public $title;
    public $description;
    public $user_id; // Who created it?
    public $created_at;

    public function __construct($title, $description, $user_id) {
        $this->title = $title;
        $this->description = $description;
        $this->user_id = $user_id;
        $this->created_at = date('Y-m-d H:i:s');
    }
}

class QuestionGroup {
    public $id;
    public $survey_id;
    public $questions = [];
    public $recommendation;

    public function __construct($id, $survey_id) {
        $this->id = $id;
        $this->survey_id = $survey_id;
        $this->recommendation = $recommendation;
    }
}

class Question {
    public $id;
    public $group_id; // Which question group does it belong to?
    public $text;
    public $type; // 'text', 'multiple_choice', 'boolean'
    public $options = []; 
    public $answer;

    public function __construct($id, $group_id, $text, $type, $options = []) {
        $this->id = $id;
        $this->group_id = $group_id;
        $this->text = $text;
        $this->type = $type;
        $this->options = $options;
    }
}

class Answer {
    public $id;
    public $question_id;
    public $user_id;
    public $answer;

    public function __construct($id, $question_id, $user_id, $answer) {
        $this->id = $id;
        $this->question_id = $question_id;
        $this->user_id = $user_id;
        $this->answer = $answer;
    }
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

function isAdmin($id) {
	global $pdo;
	$statement = $pdo->prepare("SELECT role FROM users WHERE id = :id");
	$statement->execute(['id' => $id]);
	$user = $statement->fetch(PDO::FETCH_OBJ);
	return $user->role === 'admin';
}

function checkUserExists($email) {
	global $pdo;
	$statement = $pdo->prepare("SELECT id FROM users WHERE email = :email");
	$statement->execute(['email' => $email]);
	$user = $statement->fetch(PDO::FETCH_OBJ);
	return $user ? true : false;
}

function getUserNameByID ($id) {
    global $pdo;
    $statement = $pdo->prepare("SELECT name FROM users WHERE id = :id");
    $statement->execute(['id' => $id]);
    return $statement->fetch(PDO::FETCH_OBJ);
}

function createUser(User $user) {
	global $pdo;
	$statement = $pdo->prepare("INSERT INTO users (name, email, password, country, role, created_at) VALUES (:name, :email, :password, :country, :role, :created_at)");
	$statement->execute([
		'name' => $user->name,
		'email' => $user->email,
		'password' => $user->password,
		'country' => $user->country,
		'role' => $user->role,
		'created_at' => $user->created_at
	]);
}

function createNewUser($email, $password) {
	global $pdo;
	$statement = $pdo->prepare("INSERT INTO users (email, password) VALUES (:email, :password)");
	$statement->execute([
		'email' => $email,
		'password' => password_hash($password, PASSWORD_DEFAULT)
	]);
}

function updateUser ($user) {
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

function getUserInfoById($id) {
    global $pdo;
    $statement = $pdo->prepare("SELECT id, name, entity, surname, country FROM users WHERE id = :id");
    $statement->execute(['id' => $id]);
    return $statement->fetch(PDO::FETCH_OBJ);
}



function getAllSurveys() {
    global $pdo;
    $statement = $pdo->prepare("SELECT * FROM surveys ORDER BY created_at DESC");
    $statement->execute();
    return $statement->fetchAll(PDO::FETCH_OBJ);
}


function getSurvey ($id) {
	global $pdo;
	$statement = $pdo->prepare("SELECT * FROM surveys WHERE id = :id");
	$statement->execute(['id' => $id]);
	return $statement->fetch(PDO::FETCH_OBJ);
}

function createSurvey($user_id, $timestamp){
    global $pdo;
    $statement = $pdo->prepare("INSERT INTO surveys (title, description, user_id, created_at) VALUES (:title, :description, :user_id, :created_at)");
    $statement->execute([
        'title' => "New Survey",
        'description' => "This is a new survey, you should give me a description",
        'user_id' => $user_id,
        'created_at' => $timestamp
    ]);
}

function updateSurvey(Survey $survey) {
    global $pdo;
    $statement = $pdo->prepare("UPDATE surveys SET title = :title, description = :description WHERE id = :id");
    $statement->execute([
        'title'       => $survey->title,
        'description' => $survey->description,
        'id'          => $survey->id
    ]);
}

function deleteSurvey($id) {
    global $pdo;
    $statement = $pdo->prepare("DELETE FROM surveys WHERE id = :id");
    $statement->execute(['id' => $id]);
}


function getQuestionGroupsBySurveyId($survey_id) {
    global $pdo;
    $statement = $pdo->prepare("SELECT * FROM question_groups WHERE survey_id = :survey_id");
    $statement->execute(['survey_id' => $survey_id]);
    return $statement->fetchAll(PDO::FETCH_OBJ);
}

function getQuestionsByGroupId($group_id) {
    global $pdo;
    $statement = $pdo->prepare("SELECT * FROM questions WHERE group_id = :group_id");
    $statement->execute(['group_id' => $group_id]);
    return $statement->fetchAll(PDO::FETCH_OBJ);
}

function getNextUnansweredGroup($survey_id, $user_id) {
    global $pdo;
    $sql = "SELECT qg.id AS id 
            FROM question_groups qg WHERE qg.survey_id = :survey_id  AND qg.id NOT IN (
                SELECT q.id FROM questions q JOIN responses r ON q.id = r.question_id WHERE r.user_id = :user_id) LIMIT 1";
    $statement = $pdo->prepare($sql);
    $statement->execute(['survey_id' => $survey_id, 'user_id' => $user_id]);
    return $statement->fetch(PDO::FETCH_OBJ);
}


function getQuestionsByGroupIdAndSurveyId($group_id, $survey_id) {
    global $pdo;
    $sql = "SELECT q.* FROM questions q JOIN question_groups qg ON q.group_id = qg.id WHERE qg.id = :group_id AND qg.survey_id = :survey_id";
    $statement = $pdo->prepare($sql);
    $statement->execute(['group_id' => $group_id, 'survey_id' => $survey_id]);
    return $statement->fetchAll(PDO::FETCH_OBJ);
}

function saveAnswer($question_id, $user_id, $answer) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT id FROM responses WHERE question_id = :question_id AND user_id = :user_id");
    $stmt->execute([
        'question_id' => $question_id,
        'user_id'     => $user_id
    ]);
    $existing = $stmt->fetch(PDO::FETCH_OBJ);
    
    if ($existing) {
        $stmt = $pdo->prepare("UPDATE responses SET answer = :answer WHERE id = :id");
        $stmt->execute([
            'answer' => $answer,
            'id'     => $existing->id
        ]);
    } else {
        $stmt = $pdo->prepare("INSERT INTO responses (question_id, user_id, answer) VALUES (:question_id, :user_id, :answer)");
        $stmt->execute([
            'question_id' => $question_id,
            'user_id'     => $user_id,
            'answer'      => $answer
        ]);
    }
}

function surveyAnswered($survey_id, $user_id) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT COUNT(*) AS total FROM questions q JOIN responses r ON q.id = r.question_id WHERE q.survey_id = :survey_id AND r.user_id = :user_id");
    $stmt->execute([
        'survey_id' => $survey_id,
        'user_id'   => $user_id
    ]); 
    $result = $stmt->fetch(PDO::FETCH_OBJ);
    return $result->total > 0;
}

function surveyCountAnswers ($survey_id, $user_id) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT COUNT(*) AS total FROM questions q JOIN responses r ON q.id = r.question_id WHERE q.survey_id = :survey_id AND r.user_id = :user_id");
    $stmt->execute([
        'survey_id' => $survey_id,
        'user_id'   => $user_id
    ]);

}

function countTotalQuestions ($survey_id) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT COUNT(*) AS total FROM questions WHERE survey_id = :survey_id");
    $stmt->execute(['survey_id' => $survey_id]);
    $result = $stmt->fetch(PDO::FETCH_OBJ);
    return $result->total;
}

function getRecentSurveys($limit = 5) {
    global $pdo;
    $statement = $pdo->prepare("SELECT * FROM surveys ORDER BY created_at DESC LIMIT :limit");
    $statement->bindValue(':limit', $limit, PDO::PARAM_INT);
    $statement->execute();
    return $statement->fetchAll(PDO::FETCH_OBJ);
}

function getNumberOfGroups($survey_id) {
    global $pdo;
    $statement = $pdo->prepare("SELECT COUNT(*) AS total FROM question_groups WHERE survey_id = :survey_id");
    $statement->execute(['survey_id' => $survey_id]);
    $result = $statement->fetch(PDO::FETCH_OBJ);
    return $result->total;
}

function getRecommendationByGroupId($group_id) {
    global $pdo;
    $statement = $pdo->prepare("SELECT recommendation FROM question_groups WHERE id = :group_id");
    $statement->execute(['group_id' => $group_id]);
    $result = $statement->fetch(PDO::FETCH_OBJ);
    return $result->recommendation;
}

function getPossibleResponsesByQuestionId($question_id) {
    global $pdo;
    $statement = $pdo->prepare("SELECT * FROM responses WHERE question_id = :question_id");
    $statement->execute(['question_id' => $question_id]);
    return $statement->fetchAll(PDO::FETCH_OBJ);
}

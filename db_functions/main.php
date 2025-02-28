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
    public $group_id;
    public $text;

    public function __construct($id, $group_id, $text) {
		$this->id = $id;
        $this->group_id = $group_id;
        $this->text = $text;
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

class Options {
    public $id;
    public $question_id;
    public $text;

    public function __construct($question_id, $text) {
        $this->question_id = $question_id;
        $this->text = $text;
    }
}
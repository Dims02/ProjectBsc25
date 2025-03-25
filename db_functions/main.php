<?php
class User {
    public $id;
    public $email;
    public $password;
    public $role;
    public $created_at;
    // Optional properties
    public $name;
    public $surname;
    public $entity;
    public $country;

    // Constructor for mandatory fields
    public function __construct($id, $email, $password, $role, $created_at) {
        $this->id         = $id;
        $this->email      = $email;
        $this->password   = $password; 
        $this->role       = $role;
        $this->created_at = $created_at;
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

    // Now, we also declare a default for recommendation.
    public function __construct($id, $survey_id, $recommendation = '') {
        $this->id = $id;
        $this->survey_id = $survey_id;
        $this->recommendation = $recommendation;
    }
}

class Question {
    public $id;
    public $group_id;
    public $text;
    public $recommendation; // Added property to avoid dynamic creation

    // Updated constructor now accepts an optional recommendation parameter.
    public function __construct($id, $group_id, $text, $recommendation = '') {
        $this->id = $id;
        $this->group_id = $group_id;
        $this->text = $text;
        $this->recommendation = $recommendation;
    }
}

class Answer {
    public $id;
    public $question_id;
    public $user_id;

    public function __construct($id, $question_id, $user_id, $optionId) {
        $this->id = $id;
        $this->question_id = $question_id;
        $this->user_id = $user_id;
        $this->optionId = $optionId;
    }
}


class Option {
    public $id;
    public $question_id;
    public $text;
    // Level: 0 = no, 1 = basic, 2 = intermediate, 3 = advanced
    public $level;

    public function __construct($id, $question_id, $text, $level) {
        $this->id = $id;
        $this->question_id = $question_id;
        $this->text = $text;
        $this->level = (int) $level;
    }
}


?>

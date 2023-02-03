<?php

class InputValidator {
    protected $rules = [];
    protected $errors = [];
    protected $curField;

    public function addRules(array $rules) {
        $this->rules = $rules;
    }

    public function validate() {
        $this->errors = [];
        foreach ($this->rules as $field => $fieldRules) {
            $this->curField = $field;
            if (!isset($_POST[$field])) {
                $this->errors[$field] = 'Field not found in $_POST data.';
                continue;
            }
            $explodedStr = explode('|', $fieldRules);
            foreach ($explodedStr as $rule) {
                $ruleMethod = 'validate' . ucfirst($rule);
                if (!method_exists($this, $ruleMethod)) {
                    $this->errors[$field] = "Rule method '$ruleMethod' not found.";
                    continue;
                }
                $this->$ruleMethod($_POST[$field]);
            }
        }
        return !$this->hasErrors();
    }

    public function getErrors() {
        return $this->errors;
    }

    public function hasErrors() {
        return !empty($this->errors);
    }

    protected function setError($message) {
        $this->errors[$this->curField] = $message;
    }

    protected function validateInt($value) {
        if (!is_numeric($value)) {
            $this->setError('Value is not a number.');
        }
    }

    protected function validateEmail($value) {
        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            $this->setError('Value is not a valid email address.');
        }
    }

    protected function validateRequired($value) {
        if (empty($value)) {
            $this->setError('Value is required and cannot be empty.');
        }
    }
}

// Usage
$validator = new InputValidator();
$validator->addRules([
    'age' => 'int|required',
    'email' => 'email|required'
]);

if ($validator->validate()) {
    // All data validated
} else {
    foreach ($validator->getErrors() as $field => $error) {
        echo "$field: $error<br>";
    }
}

?>
<form action="" method="post">
    <input type="text" name="age" placeholder="Age"><br>
    <input type="text" name="email" placeholder="Email"><br>
    <input type="submit">
</form>

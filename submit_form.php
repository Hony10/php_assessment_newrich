<?php

if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {

    $validation_rules = array(
        "name" => "required",
        "email" => "required|email",
        "message" => "required",
        "gender" => "required",
        "subscribe" => "required"

    );

    $response = array();

    $errors = array();
    foreach ($validation_rules as $field_name => $rule) {
        if (strpos($rule, 'required') !== false && empty($_POST[$field_name])) {
            $errors[$field_name] = ucfirst($field_name) . ' is required';
        }

        if (strpos($rule, 'email') !== false && !filter_var($_POST[$field_name], FILTER_VALIDATE_EMAIL)) {
            $errors[$field_name] = 'Invalid email format';
        }
    }


    if (empty($errors)) {

        $db_host = 'localhost';
        $db_name = 'test_php';
        $db_user = 'root';
        $db_pass = '';

        try {
            $pdo = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_pass);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $pdo->prepare("INSERT INTO form_entries (name, email, message, gender, subscribe) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$_POST['name'], $_POST['email'], $_POST['message'], $_POST['gender'], isset($_POST['subscribe']) ? 1 : 0]);
            $pdo = null;

            $response['success'] = true;
            $response['message'] = 'Form submitted successfully!';
        } catch (PDOException $e) {

            $response['success'] = false;
            $response['message'] = 'Database error: ' . $e->getMessage();
        }
    } else {

        $response['success'] = false;
        $response['errors'] = $errors;
    }


    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
}
?>

<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $validationRules = array(
        'name' => 'required',
        'email' => 'required|email',
        'message' => 'required',
        'gender' => 'required',
        'subscribe' => 'required'
    );

    $response = array();

    $errors = array();
    foreach ($validationRules as $fieldName => $rules) {
        $value = $_POST[$fieldName] ?? null;
        $fieldErrors = validateField($value, $rules);
        if (!empty($fieldErrors)) {
            $errors[$fieldName] = $fieldErrors;
        }
    }

    if (empty($errors)) {
        $dbHost = 'localhost';
        $dbName = 'test_php';
        $dbUser = 'root';
        $dbPass = '';

        try {
            $pdo = new PDO("mysql:host=$dbHost;dbname=$dbName", $dbUser, $dbPass);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $stmt = $pdo->prepare("INSERT INTO form_entries (name, email, message, gender, subscribe) VALUES (?, ?, ?, ?, ?)");

            $stmt->execute(array($_POST['name'], $_POST['email'], $_POST['message'], $_POST['gender'], $_POST['subscribe']));

            $pdo = null;

            sendEmail($_POST['name'], $_POST['email'], $_POST['message'], $_POST['gender']);

            $response['success'] = true;
            $response['message'] = 'Form entry saved successfully and email sent!';
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
} else {
    header('HTTP/1.1 405 Method Not Allowed');
    header('Content-Type: application/json');
    echo json_encode(array('error' => 'Method Not Allowed'));
}

function validateField($value, $rules) {
    $errors = array();
    $ruleArray = explode('|', $rules);
    foreach ($ruleArray as $rule) {
        if ($rule === 'required' && empty($value)) {
            $errors[] = 'This field is required';
        } elseif ($rule === 'email' && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Invalid email format';
        }
    }
    return $errors;
}

function sendEmail($name, $email, $message, $gender) {

    $emailBody = '<html><body>';
    $emailBody .= '<h2>Form Entry Details</h2>';
    $emailBody .= '<p><strong>Name:</strong> ' . $name . '</p>';
    $emailBody .= '<p><strong>Email:</strong> ' . $email . '</p>';
    $emailBody .= '<p><strong>Message:</strong> ' . $message . '</p>';
    $emailBody .= '<p><strong>Gender:</strong> ' . $gender . '</p>';

    $emailBody .= '</body></html>';

    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    $headers .= 'From: hasni.ah10@gmail.com' . "\r\n";

    $subject = 'Form Entry Details';
    $to = 'recipient@example.com';
    mail($to, $subject, $emailBody, $headers);
}
?>

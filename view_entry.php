<?php

if (isset($_GET['entry_id'])) {
    $db_host = 'localhost';
    $db_name = 'test_php';
    $db_user = 'root';
    $db_pass = '';

    try {
        $pdo = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_pass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $pdo->prepare("SELECT * FROM form_entries WHERE id = ?");
        $stmt->execute([$_GET['entry_id']]);
        $entry = $stmt->fetch(PDO::FETCH_ASSOC);

        $pdo = null;

        echo '<h2>Entry Details</h2>';
        echo '<table class="table">';
        echo '<tbody>';
        echo '<tr><th>Name</th><td>' . $entry['name'] . '</td></tr>';
        echo '<tr><th>Email</th><td>' . $entry['email'] . '</td></tr>';
        echo '<tr><th>Message</th><td>' . $entry['message'] . '</td></tr>';
        echo '<tr><th>Gender</th><td>' . $entry['gender'] . '</td></tr>';
        echo '<tr><th>Subscribe</th><td>' . ($entry['subscribe'] ? 'Yes' : 'No') . '</td></tr>';
        echo '<tr><th>Submitted At</th><td>' . $entry['created_at'] . '</td></tr>';
        echo '</tbody>';
        echo '</table>';
    } catch (PDOException $e) {
        echo 'Database error: ' . $e->getMessage();
    }
} else {

    header('Location: list_entries.php');
    exit;
}
?>

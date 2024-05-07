<?php

$db_host = 'localhost';
$db_name = 'test_php';
$db_user = 'root';
$db_pass = '';

try {
    $pdo = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $pdo->query("SELECT * FROM form_entries ORDER BY created_at DESC");
    $entries = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $pdo = null;

    echo '<h2>List of Submitted Entries</h2>';
    echo '<ul>';
    foreach ($entries as $entry) {
        echo '<li><a href="view_entry.php?entry_id=' . $entry['id'] . '">' . $entry['name'] . '</a> - ' . $entry['created_at'] . '</li>';
    }
    echo '</ul>';
} catch (PDOException $e) {
    echo 'Database error: ' . $e->getMessage();
}
?>

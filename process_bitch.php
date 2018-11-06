<?php
include 'database.php';
$db = new Database();
session_start();

$name = $_POST['name'];

$stmt = $db->prepare("SELECT userid FROM users WHERE name = :name");
$stmt->bindValue(":name", $name, SQLITE3_TEXT);
$id = $stmt->execute()->fetchArray();

$stmt = $db->prepare("UPDATE users SET bitch = :id WHERE userid = :user");
$stmt->bindValue(":id", $id['userid'], SQLITE3_INTEGER);
$stmt->bindValue(":user", $_SESSION['user_id'], SQLITE3_INTEGER);
$results = $stmt->execute();

header("Location: accountSettings.php");
 ?>

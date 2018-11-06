<?php
session_start();
include 'database.php';
$db = new Database();

$email = strtolower($_POST['email']);
$password = $_POST['password'];

$stmt = $db->prepare("SELECT * FROM users WHERE email = :email");
$stmt->bindValue(':email', $email, SQLITE3_TEXT);
$user = $stmt->execute()->fetchArray();

$stored_salt = $user['salt'];
$inputted_password = sha1($stored_salt.$password);


if($inputted_password == $user['password']) {
  $_SESSION['user_id'] = $user['userid'];
  $_SESSION['group_id'] = $user['groupId'];
  $_SESSION['alert'] = 0;
  header('Location: home.php');
} else {
  header('Location: index.php');
}
?>

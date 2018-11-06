<?php
include 'database.php';
$db = new Database();
session_start();

$stmt = $db->prepare("SELECT * FROM users WHERE userid = :userid;");
$stmt->bindValue(':userid', $_SESSION['user_id'], SQLITE3_INTEGER);
$userData = $stmt->execute()->fetchArray();

$newEmail = strtolower($_POST['email']);
$newName = $_POST['name'];
$password = $_POST['oldpassword'];
$newPassword = $_POST['newpassword'];
$stored_salt = $userData['salt'];

$inputted_password = sha1($stored_salt.$password);

echo("test");
echo($inputted_password);
echo("<br>".$stored_salt);

if($inputted_password == $userData['password']) {
	echo ("test1");
	if ($newPassword != "") {
		$newPassword = sha1($stored_salt.$newPassword);
	}
	else {
		$newPassword = $userData['password'];
	}

	$stmt2 = $db->prepare("UPDATE users SET name = :name, email = :email, password = :password WHERE userid = :userid");
	$stmt2->bindValue(':name', $newName, SQLITE3_TEXT);
	$stmt2->bindValue(':email', $newEmail, SQLITE3_TEXT);
	$stmt2->bindValue(':password', $newPassword, SQLITE3_TEXT);
	$stmt2->bindValue(':userid', $_SESSION['user_id'], SQLITE3_INTEGER);
	$results = $stmt2->execute();

	header('Location: home.php');
}
?>

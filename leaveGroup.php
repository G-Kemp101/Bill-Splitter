<?php
include 'database.php';
$db = new Database();
session_start();

$newGroup = $_POST['newGroup'];
$currentGroup = 0;

$stmt = $db->prepare("SELECT groupId FROM users;");
$results = $stmt->execute();

while($row = $results->fetchArray()) {
	if ($newGroup == $row['groupId']) {
		$currentGroup = 1;
		break;
	}
}

if ($currentGroup != 0) {
	$stmt = $db->prepare("UPDATE users SET groupid =:groupid WHERE userid=:user");
	$stmt->bindValue(':groupid', $newGroup, SQLITE3_INTEGER);
	$stmt->bindValue(':user', $_SESSION['user_id'], SQLITE3_INTEGER);
	$results = $stmt->execute();

	$_SESSION['group_id'] = $newGroup;

	header("Location: home.php");
}

echo $currentGroup;
 ?>

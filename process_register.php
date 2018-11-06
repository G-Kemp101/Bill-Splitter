<?php
session_start();
include "database.php";
$db = new Database();

$name = $_POST['name'];
$email = strtolower($_POST['email']);
$password = $_POST['password'];
$group = $_POST['group'];
$groupid = $_POST['groupid'];

$groupExist = 0;
$emailExist = 0;
$header = $_SERVER[REQUEST_URI];
$header = str_replace("process_register.php", "register.php", $header);
$stmt = $db->prepare("SELECT groupId, email FROM users;");
$results = $stmt->execute();



while($row = $results->fetchArray()) {
	if (($groupid == $row['groupId'] || is_null($groupid))) {
		$groupExist = 1;
		$header = str_replace("register.php", "home.php", $header);
	}
	if ($email == $row['email']) {
		$emailExist = 1;
	} else {
		$header = str_replace("register.php", "home.php", $header);
	}
}

if ($group == "makeGroup") {
	$groupExist = 1;
	$header = str_replace("register.php", "home.php", $header);
}

$data = array("groupExist" => $groupExist, "emailExist" => $emailExist, "header" => $header);
	//Turn the associative array into JSON encoded data and return it.

echo json_encode($data);



if ($groupExist == 0 || $emailExist == 1){
	exit(0);
}

$salt = time();
$hashed_salt = sha1($salt);
$hashed_password = sha1($hashed_salt.$password);

$stmt = $db->prepare("INSERT INTO users VALUES(NULL, :name, :email, :hashed_salt, :hashed_password, :group, NULL)");
$stmt->bindValue(':name', $name, SQLITE3_TEXT);
$stmt->bindValue(':email', $email, SQLITE3_TEXT);
$stmt->bindValue(':hashed_salt', $hashed_salt, SQLITE3_TEXT);
$stmt->bindValue(':hashed_password', $hashed_password, SQLITE3_TEXT);
$stmt->bindValue(':group', $groupid, SQLITE3_INTEGER);
$results = $stmt->execute();


$stmt2 = $db->prepare("SELECT * FROM users WHERE email = :email;");
$stmt2->bindValue(':email', $email, SQLITE3_TEXT);
$user = $stmt2->execute()->fetchArray();

$_SESSION['user_id'] = $user['userid'];
$_SESSION['group_id'] = $groupid;


//populate relations table
include 'populateRelations.php';

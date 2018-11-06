<?php
include 'database.php';
$db = new Database();
session_start();

	$text = $_POST['text'];
	$title = $_POST['title'];
	$date = $_POST['date'];

	//echo $date." ".$title." ".$text;

	 $stmt = $db->prepare("INSERT INTO notes VALUES(NULL, :userid, :noteTitle, :note, :datec);");
	 $stmt->bindValue(':userid', $_SESSION['user_id'], SQLITE3_INTEGER);
	 $stmt->bindValue(':noteTitle', $title, SQLITE3_TEXT);
	 $stmt->bindValue(':note', $text, SQLITE3_TEXT);
	 $stmt->bindValue(':datec', $date, SQLITE3_TEXT);
	 $results = $stmt->execute();

	 $stmt2 = $db->prepare("SELECT name FROM users WHERE userid = :user_id;");
	 $stmt2->bindValue(':user_id', $_SESSION['user_id'], SQLITE3_INTEGER);
	 $results = $stmt2->execute()->fetchArray();


	$data = array("name" => $results['name'], "note" => $text, "date" => $date, "title" => $title);


	//Turn the associative array into JSON encoded data and return it.
	echo json_encode($data);
 ?>

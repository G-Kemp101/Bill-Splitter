<?php
include "database.php";
include "security.php";
$db = new Database();
session_start();
	// get the id of the posted stock;
	$bill_id = $_POST['billid'];
	$user_id = $_POST['userid'];

	$stmt = $db->prepare("SELECT amount FROM userBills WHERE bill_id = :billid AND user_id = :userid");
	$stmt->bindValue(":billid", $bill_id, SQLITE3_INTEGER);
	$stmt->bindValue(":userid", $user_id, SQLITE3_INTEGER);
	$prevamount = $stmt->execute()->fetchArray();

	$user1 = $_SESSION['user_id'];
	$user2 = $user_id;
	$toPay = $prevamount['amount'];

	$userA = $user1;
	$userB = $user2;

	if ($userA > $userB) {
		$temp = $userB;
		$userB = $userA;
		$userA = $temp;
		$toPay = -$toPay;
	}


	$stmt = $db->prepare("SELECT debt FROM relations WHERE user1 = :usera AND user2 = :userb");
	$stmt->bindValue(":usera", $userA, SQLITE3_INTEGER);
	$stmt->bindValue(":userb", $userB, SQLITE3_INTEGER);
	$debt = $stmt->execute()->fetchArray();

	$amount = $debt['debt'] - $toPay;

	$stmt = $db->prepare("UPDATE relations SET debt = :amount WHERE user1 = :usera AND user2 = :userb");
	$stmt->bindValue(":amount", $amount, SQLITE3_INTEGER);
	$stmt->bindValue(":usera", $userA, SQLITE3_INTEGER);
	$stmt->bindValue(":userb", $userB, SQLITE3_INTEGER);
	$results = $stmt->execute();


	$stmt = $db->prepare("UPDATE userBills SET status = 1 WHERE bill_id = :billid AND user_id = :userid");
	$stmt->bindValue(":billid", $bill_id, SQLITE3_INTEGER);
	$stmt->bindValue(":userid", $user_id, SQLITE3_INTEGER);
	$results = $stmt->execute();

	$stmt = $db->prepare("SELECT name FROM users WHERE userid=:id");
	$stmt->bindValue(":id", $user2, SQLITE3_INTEGER);
	$name = $stmt->execute()->fetchArray();

	$data = array("id" => $user_id.$bill_id, "debt" => $amount, "userB" => $name['name']);

	echo json_encode($data);
?>

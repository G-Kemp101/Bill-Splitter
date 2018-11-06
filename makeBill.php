<?php
include "database.php";
include "security.php";
$db = new Database();
session_start();

$user1 = $_SESSION['user_id'];
$firstTotal = abs($_POST['amount']);

//creates the relevant bill;
$stmt3 = $db->prepare("INSERT INTO bills VALUES(NULL, :paidby, :billdesc, :amount)"); //insert the new bill into bills table
$stmt3->bindValue(':paidby', $user1, SQLITE3_INTEGER);
$stmt3->bindValue(':billdesc', $_POST['billDesc'], SQLITE3_TEXT);
$stmt3->bindValue(':amount', $firstTotal, SQLITE3_INTEGER);
$results = $stmt3->execute();

$stmt4= $db->prepare("SELECT * FROM bills ORDER BY billid DESC LIMIT 1"); //set lastbill as bill just payed
$lastBill = $stmt4->execute()->fetchArray();

$stmt3 = $db->prepare("INSERT INTO userBills VALUES(:userid, :billid, NULL, 1)"); //insert into userbills yourself as payed
$stmt3->bindValue(':userid', $user1, SQLITE3_INTEGER);
$stmt3->bindValue(':billid', $lastBill['billid'], SQLITE3_INTEGER);
$results = $stmt3->execute();


$selectedUsers = array();
$count = 0;
$people = $_POST['people'];


foreach ($people as $name) { //gets userid of all selected users

	$stmt = $db->prepare("SELECT userid FROM users WHERE name = :name;");
	$stmt->bindValue(':name', $name, SQLITE3_TEXT);
	$results = $stmt->execute()->fetchArray();

	$selectedUsers[$count] = $results['userid'];
	$count++;
}

 //get amount owed by each person

$stmt = $db->prepare("SELECT bitch FROM users WHERE userid=:id");
$stmt->bindValue(':id', $_SESSION['user_id'], SQLITE3_INTEGER);
$bitch = $stmt->execute()->fetchArray();

$bitch = $bitch['bitch'];

$amount = ($firstTotal/(count($selectedUsers) + 1))*100;
$count = count($selectedUsers)+1;

foreach ($selectedUsers as $user) { //for every user selected


	$extra = $firstTotal*100;
	$extra2 = floor($firstTotal*100/$count);
	$extra = $extra - $count*$extra2;
	echo $extra;

	if ($bitch == $user) {
		echo "bitch";
		$amount = $amount + $extra;
	}

	$stmt3 = $db->prepare("INSERT INTO userBills VALUES(:userid, :billid, :amount, 0)"); //insert the bill into userbills with payed = no;
	$stmt3->bindValue(':userid', $user, SQLITE3_INTEGER);
	$stmt3->bindValue(':billid', $lastBill['billid'], SQLITE3_INTEGER);
	$stmt3->bindValue(':amount', $amount, SQLITE3_INTEGER);
	$results = $stmt3->execute();

	$stmt = $db->prepare("SELECT * FROM users JOIN bills ON bills.paidby = users.userid WHERE bills.billid = :billid;");
	$stmt->bindValue(':billid', $lastBill['billid'], SQLITE3_INTEGER);
	$email = $stmt->execute()->fetchArray();

	$stmt = $db->prepare("SELECT * FROM users WHERE userid = :id;");
	$stmt->bindValue(':id', $user, SQLITE3_INTEGER);
	$name = $stmt->execute()->fetchArray();

	$mailString = "Hi ".$name['name']."!\r\n\r\nYou have a new bill! It was paid by ".$email['name']." and the description is ".$_POST['billDesc'].". The total amount of this bill was £".abs($_POST['amount'])." and you need to pay ".$email['name']." £".($amount/100).".\r\n\r\nsent by billSplitter";

	mail ($name['email'] , "New bill", $mailString);

	$userA = $user1;
	$userB = $user;

	if ($user1 > $user) { //to easily update relations table
		$temp = $user;
		$userB = $user1;
		$userA = $temp;
		$amount = -$amount;
	}

	$total = abs($amount); //reset the amount if it was switched
	$query1 = "SELECT user_id, bill_id, userbills.amount, status FROM userbills JOIN bills ON userbills.bill_id=bills.billid WHERE status = 0 and user_id=:user1 and paidby=:user2 LIMIT 1;";
	$query2 = "UPDATE userbills SET status = 1 WHERE user_id=:userid AND bill_id=:billid;";
	$query3 = "UPDATE userbills SET amount = :amount, status = 0 WHERE user_id=:userid AND bill_id=:billid;";


	//echo "<br><br>first total: ".$total;
	while ($total > 0) {

		//echo "<br>total1: ".$total;
		$stmt = $db->prepare($query1);
		$stmt->bindValue(':user1', $user1, SQLITE3_INTEGER);
		$stmt->bindValue(':user2', $user, SQLITE3_INTEGER);
		$refresh = $stmt->execute()->fetchArray();
		$userid = $refresh['user_id'];
		$billid = $refresh['bill_id']; //gets billid of first unpaid bill paidby by user2
		$nAmount = $refresh['amount']; //get the amount of that bill

		//echo "<br>nAmount: ".$nAmount;
		//echo "<br> total: ".$total;

		if(is_null($nAmount)) {
			$stmt = $db->prepare($query3); //update that bill with the new total
			//echo "<br> null total: ".$total;
			//echo "<br> lastbill: ".$lastBill['billid'];
			$stmt->bindValue(':amount', $total, SQLITE3_INTEGER);
			$stmt->bindValue(':userid', $user, SQLITE3_INTEGER);
			$stmt->bindValue(':billid', $lastBill['billid'], SQLITE3_INTEGER);
			$results = $stmt->execute();
			break;
		}


		if ($nAmount <= $total) { //if checkedbill amount is less than total, mark that bill as payed and update relations to cancel that bill.

			//echo "<br>UserA: ".$userA;
			//echo "<br>UserB: ".$userB;

			$stmt = $db->prepare($query2);
			$stmt->bindValue(':userid', $userid, SQLITE3_INTEGER);
			$stmt->bindValue(':billid', $billid, SQLITE3_INTEGER);
			$results = $stmt->execute();

			$stmt = $db->prepare("SELECT debt FROM relations WHERE user1 = :usera AND user2 = :userb;");
			$stmt->bindValue(":usera", $userA, SQLITE3_INTEGER);
			$stmt->bindValue(":userb", $userB, SQLITE3_INTEGER);
			$debt = $stmt->execute()->fetchArray();

			//echo "<br>checked bill: ".$nAmount;
			//echo "<br>debt2: ".$debt['debt'];

			if ($user1 < $user)
			$insert = $debt['debt'] + $nAmount;
			else
			$insert = $debt['debt'] - $nAmount;

			//echo "<br>insert into relations: ".$insert;

			$stmt = $db->prepare("UPDATE relations SET debt = :amount WHERE user1 = :usera AND user2 = :userb");
			$stmt->bindValue(":amount", $insert, SQLITE3_INTEGER);
			$stmt->bindValue(":usera", $userA, SQLITE3_INTEGER);
			$stmt->bindValue(":userb", $userB, SQLITE3_INTEGER);
			$results = $stmt->execute();

			$total = $total - $nAmount;

		} else { //if the checked amount is greater than
			//echo "<br>else";
			$nAmount -= $total; //the amount of that bill = amount - total
			//echo "<br>insert: ".$nAmount." into database2";
			$stmt = $db->prepare($query3); //update that bill with the new total
			$stmt->bindValue(':amount', $nAmount, SQLITE3_INTEGER);
			$stmt->bindValue(':userid', $userid, SQLITE3_INTEGER);
			$stmt->bindValue(':billid', $billid, SQLITE3_INTEGER);
			$results = $stmt->execute();

			include 'updateRelations.php';

			$total = 0;
		}

	}

	if ($user1 < $user) {
		//echo "<br>test";
		//echo "<br>".$debt['debt'];
		if ($debt['debt'] >= 0) {
			//echo "<br>hello";
			include 'updateRelations.php';
		} else {
			$stmt = $db->prepare($query2);
			$stmt->bindValue(':userid', $user, SQLITE3_INTEGER);
			$stmt->bindValue(':billid', $lastBill['billid'], SQLITE3_INTEGER);
			$results = $stmt->execute();

		}
	} else {
		//echo "<br>test1";
		if ($debt['debt'] <= 0) {
			//echo "<br>goodbye";
			include 'updateRelations.php';
		} else {
			$stmt = $db->prepare($query2);
			$stmt->bindValue(':userid', $user, SQLITE3_INTEGER);
			$stmt->bindValue(':billid', $lastBill['billid'], SQLITE3_INTEGER);
			$results = $stmt->execute();

		}
	}

	$total = abs($amount);
	if ($bitch == $user) {
		$amount = $amount - $extra;
	}

}


header('Location: home.php');
?>

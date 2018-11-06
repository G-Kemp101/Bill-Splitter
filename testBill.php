<?php
include "database.php";
include "security.php";
$db = new Database();

$clear = "DELETE FROM bills;
DELETE FROM userBills;
UPDATE relations SET debt = 0;";

$db->exec($clear);

//creates the relevant bill;
for ($i = 0; $i < 4; $i++) {

$stmt3 = $db->prepare("INSERT INTO bills VALUES(NULL, :paidby, :billdesc, :amount)");
$stmt3->bindValue(':paidby', 1, SQLITE3_INTEGER);
$stmt3->bindValue(':billdesc', 'test'.$i, SQLITE3_TEXT);
$stmt3->bindValue(':amount', 20, SQLITE3_INTEGER);
$results = $stmt3->execute();

$stmt4= $db->prepare("SELECT * FROM bills ORDER BY billid DESC LIMIT 1");
$lastBill = $stmt4->execute()->fetchArray();

$stmt3 = $db->prepare("INSERT INTO userBills VALUES(:userid, :billid, NULL, NULL)");
$stmt3->bindValue(':userid', 1, SQLITE3_INTEGER);
$stmt3->bindValue(':billid', $lastBill['billid'], SQLITE3_INTEGER);
$results = $stmt3->execute();

$userA = 1;
$userB = 2;
$amount = 10*100;

$stmt3 = $db->prepare("INSERT INTO userBills VALUES(:userid, :billid, :amount, 0)");
$stmt3->bindValue(':userid', $userB, SQLITE3_INTEGER);
$stmt3->bindValue(':billid', $lastBill['billid'], SQLITE3_INTEGER);
$stmt3->bindValue(':amount', $amount, SQLITE3_INTEGER);
$results = $stmt3->execute();

$stmt = $db->prepare("SELECT debt FROM relations WHERE user1 = :usera and user2 = :userb;");
$stmt->bindValue(':usera', $userA, SQLITE3_INTEGER);
$stmt->bindValue(':userb', $userB, SQLITE3_INTEGER);
$results = $stmt->execute()->fetchArray();

$debt = $results['debt'];
$debt += $amount;


$stmt2 = $db->prepare("UPDATE relations SET debt = :debt WHERE user1 = :usera and user2 = :userb;");
$stmt2->bindValue(':debt', $debt, SQLITE3_INTEGER);
$stmt2->bindValue(':usera', $userA, SQLITE3_INTEGER);
$stmt2->bindValue(':userb', $userB, SQLITE3_INTEGER);
$results = $stmt2->execute();

}
header('Location: home.php');
?>

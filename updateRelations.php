<?php
$stmt = $db->prepare("SELECT debt FROM relations WHERE user1 = :usera AND user2 = :userb;");
$stmt->bindValue(":usera", $userA, SQLITE3_INTEGER);
$stmt->bindValue(":userb", $userB, SQLITE3_INTEGER);
$debt = $stmt->execute()->fetchArray();

echo "<br>checked bill: ".$nAmount;
echo "<br>debt2: ".$debt['debt'];

if ($user1 < $user)
  $insert = $debt['debt'] + $total;
else
  $insert = $debt['debt'] - $total;

echo "<br>insert into relations: ".$insert;

$stmt = $db->prepare("UPDATE relations SET debt = :amount WHERE user1 = :usera AND user2 = :userb");
$stmt->bindValue(":amount", $insert, SQLITE3_INTEGER);
$stmt->bindValue(":usera", $userA, SQLITE3_INTEGER);
$stmt->bindValue(":userb", $userB, SQLITE3_INTEGER);
$results = $stmt->execute();
?>

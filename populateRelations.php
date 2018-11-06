<?php
$stmt = $db->prepare("SELECT userid FROM users WHERE groupId = :groupid;");
$stmt->bindValue(':groupid', $_SESSION['group_id'], SQLITE3_INTEGER);
$results = $stmt->execute();

$allMember = array();
$i = 0;
while ($row = $results->fetchArray()) {
	$allMember[$i] = $row['userid'];
	$i++;
}

for ($i = 0; $i < count($allMember)-1; $i++) {
		$stmt = $db->prepare("INSERT INTO relations VALUES(:user1, :user2, :debt)");
		$stmt->bindValue(':user1', $allMember[$i], SQLITE3_INTEGER);
		$stmt->bindValue(':user2', $_SESSION['user_id'], SQLITE3_INTEGER);
		$stmt->bindValue(':debt', 0, SQLITE3_INTEGER);
		$results = $stmt->execute();
}

?>

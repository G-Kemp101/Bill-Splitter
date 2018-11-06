<?php
$stmt = $db->prepare("SELECT userid FROM users WHERE groupId = :group_id;"); //checks if you can access that url by checking against users in that group
$stmt->bindValue(':group_id', $_SESSION['group_id'], SQLITE3_INTEGER);
$allowedusers = $stmt->execute();

$authorised = FALSE;
while ($row = $allowedusers->fetchArray()) {
	if ($_GET['id'] == $row['userid']) {
		$authorised = TRUE;
		break;
	}
}

if (!$authorised) {
	echo "not allowed";
	header("Location: home.php");
	exit();
}

?>

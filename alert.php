<?php
include 'database.php';
$db = new Database();
session_start();

$alerts = 1;
$stmt = $db->prepare("SELECT status FROM userbills WHERE user_id=:user;");
$stmt->bindValue(':user', $_SESSION['user_id'], SQLITE3_INTEGER);
$alert = $stmt->execute();

$click = $_POST['click'];

if ($click == 1){
	$alerts = 1;
	exit(0);
}

while($row = $alert->fetchArray()){
	if($row['status'] == 0 && $_SESSION['alert'] == 0 && !is_null($row['status'])){ //only displays alert if first time logging in and if you avhe bills that need paying
		$alerts = 0;
		$_SESSION['alert'] = 1;
		break;
	}
}

echo $alerts;

?>

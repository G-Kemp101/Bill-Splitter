<?php
include "security.php";
session_start();
$stmt = $db->prepare("SELECT billDesc, billid FROM bills INNER JOIN userBills ON userbills.bill_id = billid WHERE user_id = :userid and bills.paidby = :paidby and userbills.status == 0 and userbills.amount IS NOT NULL;");
$stmt->bindValue(":userid", $_GET['id'], SQLITE3_INTEGER);
$stmt->bindValue(":paidby", $_SESSION['user_id'], SQLITE3_INTEGER);
$results = $stmt->execute();

while ($row = $results->fetchArray()) {
	echo '<label class="container" id="'.h($row['billid']).'">'.h($row['billDesc']).'
		<input type="checkbox">
		<span class="checkmark"></span>
	</label>';
}

?>

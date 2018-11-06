<?php
$stmt = $db->prepare("SELECT count(*) AS count, * FROM users WHERE groupId = :groupId");
$stmt->bindValue(':groupId', $_SESSION['group_id'], SQLITE3_INTEGER);
$groupusers = $stmt->execute()->fetchArray();

echo '<th colspan="'.$groupusers['count'].'">Relevant parties</th>
</tr>';
$stmt = $db->prepare("SELECT * FROM (SELECT * FROM bills JOIN users ON bills.paidby = users.userid WHERE groupId = :groupid ORDER BY billid DESC LIMIT 10) sub ORDER BY billid ASC;");
$stmt->bindValue(':groupid', $_SESSION['group_id'], SQLITE3_INTEGER);
$tableValues = $stmt->execute();

$billid = $billdesc = $paidbyName = $paidbyID = $amount = array();

while ($row = $tableValues->fetchArray()) {
	$billid[] = $row['billid'];
    $billdesc[] = $row['billDesc'];
    $paidby[] = $row['name'];
	$paidbyID[] = $row['userid'];
	$amount[] = $row['amount'];
}

for ($i = 0; $i < end($billid); $i++) {
	echo "<tr>";
	echo "<td>".h($billid[$i])."</td>";
	echo "<td>".h($billdesc[$i])."</td>";
	echo "<td>".h($amount[$i])."</td>";
	echo "<td>".h($paidby[$i])."</td>";

	$stmt = $db->prepare("SELECT userid, name, amount, bill_id, status FROM users JOIN userBills ON userBills.user_id = users.userid WHERE userbills.amount IS NOT NULL AND userbills.bill_id = :billid AND users.groupid = :group;");
	$stmt->bindValue(':billid', $i+1, SQLITE3_INTEGER);
	$stmt->bindValue(':group', $_SESSION['group_id'], SQLITE3_INTEGER);
	$relevantParties = $stmt->execute();

	while ($row = $relevantParties->fetchArray()) {
		if ($row['status'] == 1) {
			echo '<td style="background-color: rgb(115, 239, 115);" id="'.h($row['userid'].$row['bill_id']).'">'.h($row['name']).'</td>';
		} else
			echo '<td style="background-color: rgb(221, 130, 130);" id="'.h($row['userid'].$row['bill_id']).'">'.h($row['name']).'</td>';
	}
	echo "</tr>";
}


?>

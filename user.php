<?php
include "database.php";
include "security.php";
$db = new Database();
session_start();

class userclass {

	function getDebts() {
		global $db;
		$stmt = $db->prepare("SELECT * FROM relations WHERE user1 = :usera or user2 = :userb");
		$stmt->bindValue(':usera', $_SESSION['user_id'], SQLITE3_INTEGER);
		$stmt->bindValue(':userb', $_SESSION['user_id'], SQLITE3_INTEGER);
		$results = $stmt->execute();

		$allDebts = array();
		$i = 0;
		while ($row = $results->fetchArray()) {
			if ($row['user2'] == $_SESSION['user_id']) {
				$allDebts[$i] = number_format((-$row['debt'])/100, 2);
			}
			else $allDebts[$i] = number_format(($row['debt'])/100, 2);
			$i++;
		}

		return $allDebts;

	}

	function populateRelations() {
		global $db;
		$stmt = $db->prepare("SELECT * FROM users WHERE groupId = :groupid;");
		$stmt->bindValue(':groupid', $_SESSION['group_id'], SQLITE3_INTEGER);
		$results = $stmt->execute();

		$allMembers = array();
		$i = 0;
		while ($row = $results->fetchArray()) {
			$allMembers[$i] = $row['userid'];
			$i++;
		}


		for ($k = 0; $k < (count($allMembers)-1); $k++) {
			for ($j = $k+1; $j < count($allMembers); $j++) {
				$stmt2 = $db->prepare("INSERT INTO relations VALUES(:user1, :user2, :debt)");
				$stmt2->bindValue(':user1', $allMembers[$k], SQLITE3_INTEGER);
				$stmt2->bindValue(':user2', $allMembers[$j], SQLITE3_INTEGER);
				$stmt2->bindValue(':debt', 0, SQLITE3_INTEGER);
				$results = $stmt2->execute();
			}
		}

	}

	function getGroupMembers() {
		global $db;
		$stmt = $db->prepare("SELECT * FROM users WHERE groupId = :groupid;");
		$stmt->bindValue(':groupid', $_SESSION['group_id'], SQLITE3_INTEGER);
		$results = $stmt->execute();

		$stmt2 = $db->prepare("SELECT bitch FROM users WHERE userid = :id;");
		$stmt2->bindValue(':id', $_SESSION['user_id'], SQLITE3_INTEGER);
		$bitch = $stmt2->execute()->fetchArray();

		$lonelyArray[0] = "No one is in your group";

		$allMembers = array();
		while ($row = $results->fetchArray()) {
			if ($row['userid'] == $_SESSION['user_id'])
				continue;
			if ($row['userid'] == $bitch['bitch']) {
				$allMembers[$row['userid']] = $row['name']." (Paying their way)";
				continue;
			}
			$allMembers[$row['userid']] = $row['name'];
		}

		if (count($allMembers) == 0) {
			return $lonelyArray;
		}
		return $allMembers;
	}

	function getGroupId() {
		// global $db;
		// $stmt = $db->prepare("SELECT groupId FROM users WHERE userid = :userid;");
		// $stmt->bindValue(':userid', $_SESSION['user_id'], SQLITE3_INTEGER);
		// $groupid = $stmt->execute()->fetchArray();
        //
		// return h($groupid['groupId']);
		//
		return $_SESSION['group_id'];
	}

	function getName() {
		global $db;
		$stmt = $db->prepare("SELECT name FROM users WHERE userid = :userid;");
		$stmt->bindValue(':userid', $_SESSION['user_id'], SQLITE3_INTEGER);
		$name = $stmt->execute()->fetchArray();

		return h($name['name']);
	}

	function getDetails() {
		global $db;
		$stmt = $db->prepare("SELECT * FROM users WHERE userid = :userid;");
		$stmt->bindValue(':userid', $_SESSION['user_id'], SQLITE3_INTEGER);
		$userData = $stmt->execute()->fetchArray();
		return $userData;
	}
}
?>

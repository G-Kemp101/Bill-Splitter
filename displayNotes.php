<?php
include "security.php";

	 $stmt2 = $db->prepare("SELECT noteid, noteTitle, note, dateCreated, name FROM notes JOIN users on notes.user_id=users.userid WHERE groupid = :group_id ORDER BY noteid DESC;");
	 $stmt2->bindValue(':group_id', $_SESSION['group_id'], SQLITE3_INTEGER);
	 $results = $stmt2->execute();

	 while ($row = $results->fetchArray()) {
		 echo "<div class='note' id=".$row['noteid'].">
 			<h1> ".h($row['noteTitle'])." <h2>
 				<p>".h($row['note'])."</p>
 			<h3>Created by: ".h($row['name'])." on ".h($row['dateCreated'])." </h3>
 		</div>";
	 }
?>

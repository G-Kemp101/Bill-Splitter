<?php
session_start();
unset($_SESSION["user_id"]);
unset($_SESSION["group_id"]);
unset($_SESSION["alert"]);
session_destroy();

header("location:index.php");
exit();
 ?>

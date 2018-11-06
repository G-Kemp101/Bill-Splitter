<?php $PageTitle = "Account Settings"; include 'header.php'; ?>
<?php if(!isset($_SESSION['user_id'])) {
	header("Location: index.php");
}?>
<link rel="stylesheet" type="text/css" href="css/accountSettings.css">
<script src='js/accountSettings.js'></script>
</head>
<body>
	<?php include 'bannerAndHeader.php'; ?>
	<div class="wrapper">
		<div class="settings" id="changeDetails">
			<form action="pro.php" method="post">
					<?php $userData = $getData->getDetails();?>
					<label>Change Name:</label><input type="text" name="name" value="<?php echo h($userData['name']);?>" id="name"><br><br>
					<label>Change Email:</label><input type="text" name="email" value="<?php echo h($userData['email']);?>"><br><br>
					<label>Old Password:</label><input type="password" name="oldpassword"><br><br>
					<label>New Password:</label><input type="password" name="newpassword" id="pass"><br><br>
					<label>Repeat New Password:</label><input type="password" name="Rpassword" id="repPass" onChange="checkPasswordMatch();"><br><br>
					<div class="centrebuttons">
						<input type="submit" name="submit" value="Update">
						<br><a href="home.php">Home</a>
					</div>
				</form>
			</div>
			<div class="settings" id="chooseBitch">
				<h1>Who's Paying their way</h1>
				<h2>When paying bills the person you choose to pay their way will always cover the difference</h2>
				<h2>e.g £10 between three is £3.33 each and they pay £3.34</h2>
				<h2>if your chosen person is not relevant in one of your bills unfortunately you must cover the difference</h2>
				<form method="post" action = "process_bitch.php" id="bitchSelect">
					<label>Choose wisely</label><select name="name">
						<?php $array1 = $getData->getGroupMembers();
						foreach($array1 as $name){
							echo "<option value =".h($name).">".h($name)."</option>";
						}
						?>
					</select>
					<div class="centrebuttons">
						<input type="submit" name="submit" value="Choose Them">
					</div>
				</form>
			</div>
		</div>
	</body>
</html>

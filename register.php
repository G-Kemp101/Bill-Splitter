<?php $PageTitle = "Register"; ?>
<?php include 'header.php'; ?>
<link rel="stylesheet" type="text/css" href="css/register.css">
<script src="js/register.js"></script>
</head>
<body>
	<div class="banner">
		<img src="bill.png" height="150">
	</div>
	<div class="content">
		<div class="Register">
			<h1>Register</h1><br>
			<form id="register" method="post">
				<label>Name:</label><input type="text" name="name" id="name"><br><p id="pname">must enter a name</p><br>
				<label>Email:</label><input type="text" name="email" id="email"><br><p id="pemail">must enter an email</p><br>
				<label>Password:</label><input type="password" name="password" id="pass"><br><p>password must be over 8 characters</p><br>
				<label>Repeat Password:</label><input type="password" name="Rpassword" id="repPass"><br><br>
				<label>Group:</label><select name="group" id="selector">
					<option value="joinGroup" id="join" >Join an existing group</option>
					<option value="makeGroup" id="make">Create a new group</option>
				</select><br>
				<div class="joinGroup"><label >Enter Group ID:</label><input type="number" name="groupid" id="groupid"><br><p id="pgroup"></p></div>
				<div id="centrebuttons">
					<input type="submit" name="submit" value="Register" >
				</div>
			</form>
			<a href="index.php" id="back">Back</a>
		</div>
	</div>
</body>
</html>

<?php $PageTitle = "Login"; ?>
<?php include 'header.php'; ?>
<link rel="stylesheet" type="text/css" href="css/index.css">
</head>
<body>
	<div class="banner">
		<img src="bill.png" height="150">
	</div>
	<div class="content">
		<div class="Login">
			<h1>Login</h1><br>
			<form action="process_login.php" method="post">
					<label>Email</label><input type="text" name="email"><br><br>
					<label>Password</label><input type="password" name="password"><br>
					<div id="centrebuttons">
						<input type="submit" name="submit" value="Login">
					</div>
			</form>
			<br><a href="register.php" id="register">Register</a>
		</div>
	</div>
	<div id="footer"></div>
</body>
</html>

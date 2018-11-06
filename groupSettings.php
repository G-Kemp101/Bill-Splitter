<?php $PageTitle = "Group Settings"; include 'header.php'; ?>
<?php if(!isset($_SESSION['user_id'])) {
	header("Location: index.php");
}?>
<link rel="stylesheet" type="text/css" href="css/groupSettings.css">
<script src='js/groupSettings.js'></script>
</head>
<body>
	<?php include 'bannerAndHeader.php'; ?>
	<div class="wrapper">
		<div class="groupSettings">
			<form autocomplete="off" id="leaveGroup" method='post'>
				<label>Join different Group</label><input type="number" id="newGroupId"><br><br>
				<div id="centrebuttons">
				<button type="button" id="submit">Goodbye</button>
			</div>
			</form>
			<a href="home.php">Home</a>
		</div>
	</div>
</body>
</html>

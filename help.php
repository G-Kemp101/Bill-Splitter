<?php $PageTitle = "Help"; include 'header.php'; ?>
<?php if(!isset($_SESSION['user_id'])) {
	header("Location: index.php");
}?>
<link rel="stylesheet" type="text/css" href="css/help.css">
<script src="js/help.js"></script>
</head>
<body>
	<?php include 'bannerAndHeader.php'; ?>
	<div class="wrapper">
		<div id="howTo">
			<h1>How to use BillSplitter!</h1>
			<img src="help.jpg">
		</div>
	</div>
	</body>
</html>

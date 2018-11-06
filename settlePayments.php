<?php $PageTitle = "Settle Bills"; ?>
<?php include 'header.php';?>
<?php include 'Authorise.php';?>
<?php if(!isset($_SESSION['user_id'])) {
	header("Location: index.php");
}?>
<link rel="stylesheet" type="text/css" href="css/settlePayments.css">
<script src="js/home.js"></script>
<script src="js/pay.js"></script>
</head>
<body>
	<?php include 'bannerAndHeader.php';?>
	<div class="wrapper">
		<div class="settlePayments">
			<h2 id="billh2">Bill Description</h2><h2 id="payedh2">Payed?</h2><br>
			<form id="settlePayments">
				<?php include 'getPayments.php'; ?>
				<br><a href="home.php">Home</a>
			</form>
		</div>
			<div class="billtable">
			<?php include 'billTable.php'; ?>
			</div>
		</div>
	</body>
</html>

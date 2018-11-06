<?php $PageTitle = "Homepage"; ?>
<?php include 'header.php';?>
<?php if(!isset($_SESSION['user_id'])) {
	header("Location: index.php");
}?>
<link rel="stylesheet" type="text/css" href="css/homepage.css">
<script src="js/home.js"></script>
</head>
<body>
	<?php include 'bannerAndHeader.php';?>
	<div class="wrapper">
		<div class="payNewBill">
			<form action='makeBill.php' method="POST" autocomplete="off">
				<label>Bill Description</label> <input type="text" name="billDesc"><br><br>
				<label>Amount</label> <input type="number" name="amount" id="amount"><br><br>
				<div class="centrebuttons">
					<div id="people">
						Split Between
						<p style="font-size:15px">(hold control to select multiple users)</p>
						<select name="people[]" multiple>
							<?php foreach ($getData->getGroupMembers() as $value) {
								echo '<option value='.h($value).'>'.h($value).'</option>';
							} ?>
						</select>
						</div>
						<input type="submit" value="Submit Bill" id="submitBill">
					</div>
				</form>
			</div>
			<div class="billtable">
				<?php include 'billTable.php'; ?>
			</div>
		</div>
		<div id="alert" class="centrebuttons">
			<h1> You have unpaid bills!</h1>
			<button type="button" id="clearAlert">Clear</button>
		</div>
	</body>
	</html>

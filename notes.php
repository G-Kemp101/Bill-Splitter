<?php $PageTitle = "Notes"; ?>
<?php include 'header.php';?>
<?php if(!isset($_SESSION['user_id'])) {
	header("Location: index.php");
}?>
<link rel="stylesheet" type="text/css" href="css/notes.css">
<script src="js/notes.js"></script>
</head>
<body>
	<?php include 'bannerAndHeader.php';?>
	<div class="wrapper">
		<div class="note" id="createNew">
			<form id="createNote" method='post' autocomplete="off">
				<input type='text' name='title' id="title" placeholder="Add a New Note!">
				<textarea id="newnote" form="createNote" placeholder="Enter your note... 140 Character Limit"></textarea>
				<span id="count"></span><button type="button" id="submit" >Send Note</button>
			</form>
		</div>
			<?php include 'displayNotes.php';?>
</body>
</html>

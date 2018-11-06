<div class="banner">
  <a id="img" href="home.php">
    <img src="bill.png" height="150">
  </a>
  <h1> Hi <?php echo $getData->getName();?></h1>
  <div class="dropdown">
    <img src="settings.png" class="dropbtn">
    <div id="myDropdown" class="dropdown-content">
      <a href="accountSettings.php">Account Settings</a>
      <a href="groupSettings.php">Group Settings</a>
      <a href="logout.php" id="bottom">Logout</a>
    </div>
  </div>
  <a href="help.php"><img src="helpIcon.png" id="help"></a>
</div>
<div class="notifications">
  <h1>notifications</h1>
  <div class="notificationbox">
    <ul>
      <?php $array1 = $getData->getGroupMembers();
      $array2 = $getData->getDebts();
      $counter = 0;
       foreach ($array1 as $key => $value) {
		   echo '<a class=link href="settlePayments.php?id='.h($key).'"';
         	if ($array2[$counter] >= 0) {
        		echo ('<li class="personBox" id="user'.h($key).'"><h2>'.h($value).'</h2>They owe you £'.h($array2[$counter]).'</li></a>');
      		} else
      			echo ('<li class="personBox" id="user'.h($key).'"><h2>'.h($value).'</h2>You owe them £'.h(-$array2[$counter]).'</li></a>');
      	$counter++;
        //call script to change colour of box to red
      }
      ?>
    </ul>
  </div>
  <a href="notes.php"><div class="link" id="notelink">
    <h2>Notes</h2>
</div></a>
  <div id="groupbox">
    <h1>your group id is</h1>
    <h2><?php echo h($getData->getGroupId());?></h2>
  </div>
</div>

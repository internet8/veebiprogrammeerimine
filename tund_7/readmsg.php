<?php
  require("functions.php");
  $notice = readallmessages();
  if (isset($_SESSION["userId"])) {
	  getUserProfile($_SESSION["userId"]);
  }
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <style>
		<?php
			echo "body{background-color: " .$_SESSION['bgC'] .";color: " .$_SESSION['txtC'] .";}"; 
		?>
	</style>
  <title>Anonüümsed sõnumid</title>
</head>
<body>
  <h1>Sõnumid</h1>
  <p>Siin on minu <a href="http://www.tlu.ee">TLÜ</a> õppetöö raames valminud veebilehed. Need ei oma mingit sügavat sisu ja nende kopeerimine ei oma mõtet.</p>
  <hr>
  
  <?php echo $notice; ?>

</body>
</html>
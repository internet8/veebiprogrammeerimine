<?php
require("functions.php");
  //kui pole sisse loginud
  
  // kui pole sisse logitud
  if (!isset($_SESSION["userId"])) {
	  header("Location: indexX.php");
	  exit();
  }
  
  // välja logimine
  if (isset($_GET["logout"])) {
	  session_destroy();
	  header("Location: indexX.php");
	  exit();
  }
  
  $notice = readallunvalidatedmessages();
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Anonüümsed sõnumid</title>
</head>
<body>
  <h1>Sõnumid</h1>
  <a href="main.php">Mine tagasi</a>
  <p>Siin on minu <a href="http://www.tlu.ee">TLÜ</a> õppetöö raames valminud veebilehed. Need ei oma mingit sügavat sisu ja nende kopeerimine ei oma mõtet.</p>
  <hr>
  <ul>

  </ul>
  <hr>
  
  <?php echo $notice; ?>

</body>
</html>
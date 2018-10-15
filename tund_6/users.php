<?php
  require("functions.php");
  
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
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
	<title>Kasutajad</title>
  </head>
  <body>
    <h1>KAsutajad</h1>
	<p>See leht on valminud <a href="http://www.tlu.ee" target="_blank">TLÜ</a> õppetöö raames ja ei oma mingisugust, mõtestatud või muul moel väärtuslikku sisu.</p>
	<hr>
	<p><?php echo getAllUsers($_SESSION["userId"]); ?></p>
	
  </body>
</html>
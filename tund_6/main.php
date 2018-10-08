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
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
	<title>Pealeht</title>
  </head>
  <body>
    <h1>Pealeht</h1>
	<p>See leht on valminud <a href="http://www.tlu.ee" target="_blank">TLÜ</a> õppetöö raames ja ei oma mingisugust, mõtestatud või muul moel väärtuslikku sisu.</p>
	<hr>
	<p>Olete sisse loginud nimega: <?php echo $_SESSION["userFirstName"] ." " .$_SESSION["userLastName"]; ?>. <b><a href="?logout=1">Logi välja!</a></b></p>
	<ul>
		<li>Valideeri ananüümseid <a href="validatemsg.php">sõnumeid</a></li>
	</ul>
	
  </body>
</html>
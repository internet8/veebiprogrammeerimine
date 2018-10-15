<?php
  require("functions.php");
  
  // kui pole sisse logitud
  if (!isset($_SESSION["userId"])) {
	  header("Location: indexX.php");
	  exit();
  } else {
	  getUserProfile($_SESSION["userId"]);
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
	<style>
		<?php
			echo "body{background-color: " .$_SESSION['bgC'] .";color: " .$_SESSION['txtC'] .";}"; 
		?>
	</style>
	<title>Pealeht</title>
  </head>
  <body>
    <h1>Pealeht</h1>
	<p>See leht on valminud <a href="http://www.tlu.ee" target="_blank">TLÜ</a> õppetöö raames ja ei oma mingisugust, mõtestatud või muul moel väärtuslikku sisu.</p>
	<hr>
	<p>Olete sisse loginud nimega: <?php echo $_SESSION["userFirstName"] ." " .$_SESSION["userLastName"]; ?>. <b><a href="?logout=1">Logi välja!</a></b></p>
	<ul>
		<li>Valideeri ananüümseid <a href="validatemsg.php">sõnumeid</a></li>
		<li>Vaata valideerituid <a href="validatedmessages.php">sõnumid</a> kasutajate kaupa.</li>
		<li>Muuda <a href="userprofile.php">profiili</a>.</li>
	</ul>
	<p>Vaadake kõiki <a href="users.php">kasutajaid</a>.</p>
	
  </body>
</html>
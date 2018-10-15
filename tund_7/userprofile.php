<?php
  require("functions.php");

  // kui pole sisse logitud
  if (!isset($_SESSION["userId"])) {
	  header("Location: indexX.php");
	  exit();
  } else {
	  getUserProfile($_SESSION["userId"]);
  }
  
    if (isset($_SESSION["desc"]) or isset($_SESSION["bgC"]) or isset($_SESSION["txtC"])) {
		  $mydescription = $_SESSION["desc"];
		  $mytxtcolor = $_SESSION["txtC"];
		  $mybgcolor = $_SESSION["bgC"];
	} else {
		  $mydescription = "Pole iseloomustust lisanud.";
		  $mytxtcolor = "#FFFFFF";
		  $mybgcolor = "#000000";
	}
  
  // välja logimine
  if (isset($_GET["logout"])) {
	  session_destroy();
	  header("Location: indexX.php");
	  exit();
  }
  
  if (isset($_POST["changeProfile"])) {
	  if (isset($_SESSION["desc"]) or isset($_SESSION["bgC"]) or isset($_SESSION["txtC"])) {
		  echo updateUserProfile($_SESSION["userId"], $_POST["description"], $_POST["bgcolor"], $_POST["txtcolor"]);
	  } else {
		  echo insertUserProfile($_SESSION["userId"], $_POST["description"], $_POST["bgcolor"], $_POST["txtcolor"]);
	  }
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
	<title>Profiil</title>
  </head>
  <body>
    <h1>Profiil</h1>
	<p>See leht on valminud <a href="http://www.tlu.ee" target="_blank">TLÜ</a> õppetöö raames ja ei oma mingisugust, mõtestatud või muul moel väärtuslikku sisu.</p>
	<hr>
	<p>Olete sisse loginud nimega: <?php echo $_SESSION["userFirstName"] ." " .$_SESSION["userLastName"]; ?>. <b><a href="?logout=1">Logi välja!</a></b></p>
	<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
		<textarea rows="10" cols="80" name="description"><?php echo $mydescription; ?></textarea><br>
		<label>Minu valitud tekstivärv: </label><input name="txtcolor" type="color" value="<?php echo $mytxtcolor; ?>"><br>
		<label>Minu valitud taustavärv: </label><input name="bgcolor" type="color" value="<?php echo $mybgcolor; ?>"><br>
		<input name="changeProfile" type="submit" value="Muuda"><br>
	</form>
	<br>
	<a href="main.php">Mine tagasi</a>
	
  </body>
</html>
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
  
  if (isset($_GET["id"])) {
	  $msg = readmsgforvalidation($_GET["id"]);
  }
  
  if (isset($_POST["submitValidation"])) {
	  $msg = readmsgforvalidation($_POST["id"]);
	  echo validatemsg($_POST["id"], $_POST["validation"], $_SESSION["userId"]);
	  header("Location: validatemsg.php");
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
  <ul>

	<li><a href="validatemsg.php">Tagasi</a> sõnumite lehele!</li>
  </ul>
  <hr>
  <h2>Valideeri see sõnum:</h2>
  <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
		<input name="id" type="hidden" value="<?php echo $_GET["id"]; ?>">
		<p><?php echo $msg; ?></p>
		<input type="radio" name="validation" value="0" checked><label>Keela näitamine</label><br>
		<input type="radio" name="validation" value="1"><label>Luba näitamine</label><br>
		<input type="submit" value="Kinnita" name="submitValidation">
  </form>
  <hr>

</body>
</html>
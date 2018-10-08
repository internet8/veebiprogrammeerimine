<?php
	require("functions.php");

	if (isset($_POST['submitCatData'])) {
		if (!empty($_POST["catName"]) and !empty($_POST["catColor"]) and !empty($_POST["tailLength"])) {			
			echo addCats (test_input($_POST["catName"]), test_input($_POST["catColor"]), test_input($_POST["tailLength"]));
		} else {
			echo "Kõik lahtrid ei olnud täidetud!";
		}
	}
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Kassid</title>
</head>
<body>
	<h1>Kassid</h1>
	<p>See leht on valminud <a href="http://www.tlu.ee" target="_blank">TLÜ</a> õppetöö raames. Need ei oma mingit sügavat sisu ja nende kopeerimine ei oma mõtet.</p>
	<hr>
	<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
		<label>Kiisu nimi:</label>
		<input name="catName" type="text" value="">
		<label>Kiisu värvus:</label>
		<input name="catColor" type="text" value="">
		<label>Saba pikkus</label>
		<input name="tailLength", type="number", min="1" max="50" value="25">
		<br>
		<input name="submitCatData" type="submit" value="Saada andmed">
	</form>
	<hr>
	
	<?php
		echo readCats();
	?>
	
</body>
</html>
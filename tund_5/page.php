<?php
	//echo "Siin on minu esimene PHP!";
	$name = "Tundmatu";
	$surname = "inimene";	
	$fullName = $name ." " .$surname;
	$monthNamesET = ["jaanuar", "veebruar", "märts", "aprill", "mai", "juuni", "juuli", "august", "september", "oktoober", "november", "detsember"];
	$birthDay = date("d");
	$birthYear = date("Y") - 15;
	//var_dump($_POST);
	if (isset($_POST["firstName"])) {
		$name = test_input($_POST["firstName"]);
	}
	if (isset($_POST["surName"])) {
		$surname = test_input($_POST["surName"]);
	}
	
	function test_input($data) {
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	}
	
	function fullName() {
		$GLOBALS["fullName"] = $GLOBALS["name"] ." " .$GLOBALS["surname"];
	}
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>
		<?php
			echo $name;
			echo " ";
			echo $surname;
		?>
	</title>
</head>
<body>
	<h1>
		<?php
			echo $name ." " .$surname;
		?>
	</h1>
	<p>See leht on valminud <a href="http://www.tlu.ee" target="_blank">TLÜ</a> õppetöö raames valminud veebilehed. Need ei oma mingit sügavat sisu ja nende kopeerimine ei oma mõtet.</p>
	<p>Lisan veel ühe p tag-i järgmise tunni jaoks.</p>
	<hr>
	<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
		<label>Eesnimi:</label>
		<input name="firstName" type="text" value="">
		<label>Perekonnanimi:</label>
		<input name="surName" type="text" value="">
		<label>Sünnipäev: </label>
		<?php
			echo '<select name="birthDay">' ."\n";
			for ($i = 1; $i < 32; $i ++){
				echo '<option value="' .$i .'"';
				if ($i == $birthDay){
					echo " selected ";
				}
				echo ">" .$i ."</option> \n";
			}
			echo "</select> \n";
		  ?>
		<label>Sünnikuu</label>
		<select name="birthMonth">
			<?php
				for ($i = 1; $i <= 12; $i++) {
					if ($i == date("n")) {
						echo '<option value="' .$i .'" selected>' .$monthNamesET[$i-1] .'</option>' ."\n";
					} 
					else {
						echo '<option value="' .$i .'">' .$monthNamesET[$i-1] .'</option>' . "\n";
					}
				}
			?>
		</select>
		<label>Sünniaasta</label>
		<!--<input name="birthYear", type="number", min="1914" max="2003" value="1998">-->
		<?php
			echo '<select name="birthYear">' ."\n";
			for ($i = $birthYear; $i >= date("Y") - 100; $i --){
				echo '<option value="' .$i .'"';
				if ($i == $birthYear){
					echo " selected ";
				}
				echo ">" .$i ."</option> \n";
			}
			echo "</select> \n";
		?>
		<br>
		<input name="submitUserData" type="submit" value="Saada andmed">
	</form>
	
	<?php
		if (isset($_POST["submitUserData"])) {
			//demoks üks väike funktsioon (mõttetu)
			fullName();
			echo "<br><p>" .$fullName .". Olete elanud järgnevatel aastatel:</p>";
			echo "<ul> \n";
			for ($i = $_POST["birthYear"]; $i <= date("Y"); $i++) {
				echo "<li>" .$i ."</li> \n";
			}
			echo "</ul> \n";
			
			echo "<br><p>Ning käesoleval aastal järgmised kuud kuni sünnikuuni: </p>";
			echo "<ul> \n";
			for ($i = 1; $i <= $_POST["birthMonth"]; $i++) {
				echo "<li>" .$monthNamesET[$i-1] ."</li> \n";
			}
			echo "</ul> \n";
		}
	?>
	
	<!--<img src="http://greeny.cs.tlu.ee/~rinde/veebiprogrammeerimine2018s/tlu_terra_600x400_3.jpg" alt="TLÜ Terra õppehoone">-->
	
</body>
</html>
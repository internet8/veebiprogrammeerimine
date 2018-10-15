<?php
	require("functions.php");

	$name = "";
	$surname = "";
	$email = "";
	$gender = "";
	$birthMonth = null;
	$birthYear = null;
	$birthDay = null;
	$birthDate = null;
	$monthNamesET = ["jaanuar", "veebruar", "märts", "aprill", "mai", "juuni","juuli", "august", "september", "oktoober", "november", "detsember"];
	
	$nameError = "";
	$surnameError = "";
	$birthMonthError = "";
	$birthYearError = "";
	$birthDayError = "";
	$genderError = "";
	$emailError = "";
	$passwordError = "";
	
	if(isset($_POST["submitUserData"])){
  
		if (isset($_POST["firstName"]) and !empty($_POST["firstName"])){
			//$name = $_POST["firstName"];
			$name = test_input($_POST["firstName"]);
		} else {
			$nameError = "Palun sisesta eesnimi!";
		}
		  
		if (isset($_POST["surName"]) and !empty($_POST["surName"])){
			$surname = test_input($_POST["surName"]);
		} else {
			$surnameError = "Palun sisesta perekonnanimi!";
		}
		  
		if(isset($_POST["gender"])){
			$gender = intval($_POST["gender"]);
		} else {
			  $genderError = "Palun märgi sugu!";
		}
		  
		if(isset($_POST["birthDay"]) and $_POST["birthDay"] != "päev"){
			$birthDay = $_POST["birthDay"];
		} else {
			$birthDayError = "Palun lisage sünnikuupäev.";
		}
		  
		if(isset($_POST["birthMonth"]) and $_POST["birthDay"] != "kuu"){
			$birthMonth = $_POST["birthMonth"];
		} else {
			$birthMonthError = "Palun lisage sünnikuu.";
		}
		  
		if(isset($_POST["birthYear"]) and $_POST["birthDay"] != "aasta"){
			$birthYear = $_POST["birthYear"];
		} else {
			$birthYearError = "Palun lisage sünniaasta.";
		}
		
		if (isset($_POST["email"]) and !empty($_POST["email"])){
			$email = test_input($_POST["email"]);
		} else {
			$emailError = "Palun sisestage e-mail!";
		}
		
		if (isset($_POST["password"])){
			if (strlen($_POST["password"]) < 8) {
				$passwordError = "Parool peab olema vähemalt 8 tähemärki pikk!";
			}
		} else {
			$passwordError = "Palun sisestage parool!";
		}
		
		if (isset($_POST["confirmpassword"])){
			if ($_POST["password"] != $_POST["confirmpassword"]) {
				$passwordError = "Paroolid ei kattu!";
			}
		} else {
			$passwordError = "Palun korrake parooli!";
		}
		
		if(isset($_POST["birthDay"]) and isset($_POST["birthMonth"]) and isset($_POST["birthYear"])){
			//checkdate(päev, kuu, aasta)
			if(checkdate(intval($_POST["birthMonth"]), intval($_POST["birthDay"]), intval($_POST["birthYear"]))){
				$makebirthDate = date_create($_POST["birthMonth"] ."/" .$_POST["birthDay"] ."/" .$_POST["birthYear"]);
				$birthDate = date_format($makebirthDate, "Y-m-d");
				//echo $birthDate;
			} else {
				$birthYearError = "Kuupäev on vigane!";
			}
		}
		if(empty($nameError) and empty($surnameError) and empty($birthMonthError) and empty($birthYearError) and empty($birthDayError) and empty($genderError) and empty($emailError) and empty($passwordError)){
			$notice = signup($name, $surname, $email, $gender, $birthDate, $_POST["password"]);
			echo $notice;
		}
	}
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Katselise veebi uue kasutaja loomine</title>
	</head>
	<body>
		<h1>Loo endale kasutajakonto</h1>
		<p>See leht on valminud <a href="http://www.tlu.ee" target="_blank">TLÜ</a> õppetöö raames ja ei oma mingisugust, mõtestatud või muul moel väärtuslikku sisu.</p>
		<hr>
			
			<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
				<label>Eesnimi:</label><br>
				<input name="firstName" type="text" value="<?php echo $name; ?>"><span><?php echo $nameError; ?></span><br>
				<label>Perekonnanimi:</label><br>
				<input name="surName" type="text" value="<?php echo $surname; ?>"><span><?php echo $surnameError; ?></span><br>				  
				<input type="radio" name="gender" value="2" <?php if($gender == "2"){		echo " checked";} ?>><label>Naine</label>
				<input type="radio" name="gender" value="1" <?php if($gender == "1"){		echo " checked";} ?>><label>Mees</label><br>
				<span><?php echo $genderError; ?></span><br>
				  
				<label>Sünnipäev: </label>
					<?php
						echo '<select name="birthDay">' ."\n";
						echo '<option value="" selected disabled>päev</option>' ."\n";
						for ($i = 1; $i < 32; $i ++){
							echo '<option value="' .$i .'"';
							if ($i == $birthDay){
								echo " selected ";
							}
							echo ">" .$i ."</option> \n";
						}
						echo "</select> \n";
					?>
				<label>Sünnikuu: </label>
				<?php
					echo '<select name="birthMonth">' ."\n";
					echo '<option value="" selected disabled>kuu</option>' ."\n";
					for ($i = 1; $i < 13; $i ++){
						echo '<option value="' .$i .'"';
						if ($i == $birthMonth){
							echo " selected ";
						}
						echo ">" .$monthNamesET[$i - 1] ."</option> \n";
					}
					echo "</select> \n";
				?>
				<label>Sünniaasta: </label>
				<?php
					echo '<select name="birthYear">' ."\n";
					echo '<option value="" selected disabled>aasta</option>' ."\n";
					for ($i = date("Y") - 15; $i >= date("Y") - 100; $i --){
						echo '<option value="' .$i .'"';
						if ($i == $birthYear){
							echo " selected ";
						}
						echo ">" .$i ."</option> \n";
					}
					echo "</select> \n";
				?>
				<br>
				<p><?php echo $birthDayError ." "; echo $birthMonthError ." "; echo $birthYearError;?></p>
				<br>				  
				<label>E-mail (kasutajatunnus):</label><br>
				<input type="email" name="email" value="<?php echo $email; ?>"><span><?php echo $emailError; ?></span><br>	
				<label>Salasõna:</label><br>
				<input name="password" type="password"><span><?php echo $passwordError; ?></span><br>
				<label>Korda salasõna:</label><br>
				<input name="confirmpassword" type="password"><br>
				<input name="submitUserData" type="submit" value="Loo kasutaja">
			</form>
	</body>
</html>
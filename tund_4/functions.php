<?php
	require ("../../../config.php");
	//echo $GLOBALS["serverHost"];
	//echo $GLOBALS["serverUsername"];
	//echo $GLOBALS["serverPassword"];
	$database = "if18_kent_pi_1";

	function saveAMsg($msg) {
		//echo "Töötab!";
		$notice = ""; //see on teade, mis antakse salvestamise kohta
		//loome ühenduse andmebaasiserveriga
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		//valmistame ette SQL päringu
		$stmt = $mysqli->prepare("INSERT  INTO vpamsg (message) VALUES(?)");
		echo $mysqli->error;
		$stmt->bind_param("s", $msg);// s - string, i - integer, d - decimal
		if ($stmt->execute()) {
			$notice = 'Sõnum: "' .$msg .'" on salvestatud';
		} else {
			$notice = "Sõnumi salvestamisel tekkis tõrge: " .$stmt->error;
		}
		$stmt->close();
		$mysqli->close();
		return $notice;
	}
	
	// funktsioon kasside jaoks
	function addCats ($catName, $catColor, $tailLength) {
		$notice = "";
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("INSERT INTO kiisu (nimi, v2rvus, saba) VALUES(?, ?, ?)");
		echo $mysqli->error;
		$stmt->bind_param("ssi", $catName, $catColor, $tailLength);
		if ($stmt->execute()) {
			$notice = "Kass lisatud!";
		} else {
			$notice = "Tekkis tõrge: " .$stmt->error;
		}
		$stmt->close();
		$mysqli->close();
		return $notice;
	}
	
	// funkltsioon kasside lugemiseks
	function readCats () {
		$notice = "<ul>";;
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("SELECT nimi, v2rvus, saba FROM kiisu");
		echo $mysqli->error;
		$stmt->bind_result($readCatName, $readCatColor, $readTailLength);
		$stmt->execute();
		while($stmt->fetch()){
			$notice .= "<li>" .$readCatName .", " .$readCatColor .", " .$readTailLength ."</li> \n";
		}
		$notice .= "</ul>";
		$stmt->close();
		$mysqli->close();
		return $notice;
	}
	
	// funktsioon andmete kontrollimiseks
	function test_input($data) {
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	}
?>
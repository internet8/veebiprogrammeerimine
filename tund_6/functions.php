<?php
	require ("../../../config.php");
	//echo $GLOBALS["serverHost"];
	//echo $GLOBALS["serverUsername"];
	//echo $GLOBALS["serverPassword"];
	$database = "if18_kent_pi_1";
	
	//alustan sessiooni
	session_start();
	
	function readmsgforvalidation($editId){
		$notice = "";
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("SELECT message FROM vpamsg WHERE id = ?");
		$stmt->bind_param("i", $editId);
		$stmt->bind_result($msg);
		$stmt->execute();
		if($stmt->fetch()){
			$notice = $msg;
		}
		$stmt->close();
		$mysqli->close();
		return $notice;
	}
	
	function readallunvalidatedmessages(){
		$notice = "<ul> \n";
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("SELECT id, message FROM vpamsg WHERE valid IS NULL ORDER BY id DESC");
		echo $mysqli->error;
		$stmt->bind_result($id, $msg);
		$stmt->execute();
		
		while($stmt->fetch()){
			$notice .= "<li>" .$msg .'<br><a href="validatemessage.php?id=' .$id .'">Valideeri</a>' ."</li> \n";
		}
		$stmt->close();
		$mysqli->close();
		return $notice;
	}
	
	function signin ($email, $password) {
		$notice = "";
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("SELECT id, firstname, lastname, password FROM vpusers WHERE email=?");
		echo $mysqli->error;
		$stmt->bind_param("s", $email);
		$stmt->bind_result($idFromDb, $firstnameFromDb, $lastnameFromDb, $passwordFromDb);
		if ($stmt->execute()) {
			// kui päring õnnestus
			if ($stmt->fetch()) {
				// kasutaja on olemas
				if (password_verify($password, $passwordFromDb)) {
					// kui salasõna klapib
					$notice = "Logisite sisse!";
					// määran sessioonimuutujad
					$_SESSION["userId"] = $idFromDb;
					$_SESSION["userFirstName"] = $firstnameFromDb;
					$_SESSION["userLastName"] = $lastnameFromDb;
					$_SESSION["userEmail"] = $email;
					// liigume kohe vaid sisselogitutele mõeldud pealehele
					$stmt->close();
					$mysqli->close();
					header("Location: main.php");
					exit();
				} else {
					$notice = "Vale salasõna!";
				}
			} else {
				$notice = "Sellist kasutajat (" .$email .") ei leitud!";
			}
		} else {
			$notice = "Sisselogimisel tekkis tehniline viga!" .$stmt->error;
		}
		$stmt->close();
		$mysqli->close();
		return $notice;
	} // sisselogimine lõppeb

	function signup($name, $surname, $email, $gender, $birthDate, $password){
		$notice = "";
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("SELECT id FROM vpusers WHERE email='" .$email ."'");
		echo $mysqli->error;
		$stmt->bind_result($recEmail);
		$stmt->execute();
		if($stmt->fetch()) {
			$notice = "Sisestatud e-mail on juba kasutuses.";
		} else {
			$stmt->close();
			$stmt = $mysqli->prepare("INSERT INTO vpusers (firstname, lastname, birthdate, gender, email, password) VALUES(?,?,?,?,?,?)");
			//krüpteerin parooli, kasutades juhuslikku soolamisfraasi (salting string)
			$options = [
				"cost" => 12,
				"salt" => substr(sha1(rand()), 0, 22),
			];
			$pwdhash = password_hash($password, PASSWORD_BCRYPT, $options);
			//echo "Kuupäev: ".$birthDate;
			//viga oli järgmises reas - muutujate järjekord ei vastanud SQL käsus loetletud väljade andmejärjekorrale ning kuupäeva väljaleüritati e-maili kirjutada.
			//$stmt->bind_param("sssiss", $name, $surname, $email, $gender, $birthDate, $pwdhash);
			$stmt->bind_param("sssiss", $name, $surname, $birthDate, $gender, $email, $pwdhash);
			if($stmt->execute()){
				$notice = "Kasutaja loodud!";
			} else {
				$notice = "error" .$stmt->error;	
			}
		}
		$stmt->close();
		$mysqli->close();
		return $notice;
	}
	
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
	
	function readallmessages(){
		$notice = "";
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		//valmistame ette sõnumite lugemise SQL käsu
		$stmt = $mysqli->prepare("SELECT message FROM vpamsg");
		echo $mysqli->error;
		//seon loetavad andmed muutujatega, siin praegu iga kirjapandud sõnumi kohta küsisingi vaid sõnumit ennas ja seon selle muutujaga $msg
		$stmt->bind_result($msg);
		//täidan käsu
		$stmt->execute();
		//järgnevalt saab iga järgmise loetud sõnumi käsuga $stmt->fetch()
		//kasutan "while" tsüklit, mida täidetakse siinkohal kuni veel on midagi võtta ehk fetchida
		while($stmt->fetch()){
			//iga kord järjekordset sõnumit võttes panen selle eespool loodud muutuja $notice väärtusele juurde ( .= nagu arvudega oleks += )
			//siinkohal moodustan iga sõnumi jaoks html lõigu
			$notice .= "<p>" .$msg ."</p> \n";
		}
		//sulgen käsu
		$stmt->close();
		//sulgen andmebaasiühenduse
		$mysqli->close();
		//tagastan funktsiooni väljakutsujale kokku pandud html-koodi
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
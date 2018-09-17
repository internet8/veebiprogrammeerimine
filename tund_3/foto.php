<?php
	//echo "Siin on minu esimene PHP!";
	$name = "Kent";
	$surname = "Pirma";
	$dirToRead = "../../pics/";
	$allFiles = array_slice(scandir($dirToRead), 2);
	var_dump($allFiles);
	
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
	<!--<img src="http://greeny.cs.tlu.ee/~rinde/veebiprogrammeerimine2018s/tlu_terra_600x400_3.jpg" alt="TLÜ Terra õppehoone">-->
	
	<?php
		foreach ($allFiles as $currentFile) {
			echo '<img src="' .$dirToRead .$currentFile .'" alt="pilt"><br>';
		}
		for ($i = 0; $i < count($allFiles); $i++) {
			echo '<img src="' .$dirToRead .$allFiles[$i] .'" alt="pilt"><br>';
		}
		//echo '<img src="' .$dirToRead .$allFiles[1] .'" alt="pilt"><br>';
	?>
	
</body>
</html>
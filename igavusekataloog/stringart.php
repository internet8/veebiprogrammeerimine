<!DOCTYPE html>
<html>
<head>
<style>
	div.smallText {
		color: #000;
		font-size: 15%;
	}
	div.bold {
		font-weight: bold;
		display: inline;
		letter-spacing: 1.5px;
	}
	div.noBold {
		display: inline;
		letter-spacing: 1.5px;
	}
</style>
	<meta charset="utf-8">
	<title>StringArt</title>
</head>
<body>
	<h1>StringArt</h1>
	<p>Nokitsen siin ns igavuse peletamiseks.</p>
	<hr>
	<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
		<label>Sisestage pildi(jpg, max 256x256) url: </label>
		<!--<input name="image" type="file" accept="image/*" onchange="preview_image(event)">-->
		<!--<input name="link" type="text" value="">-->
		<input name="link" type="text" value="">
		<label>Lisa taust: </label>
		<input type="checkbox" name="colorBool" value="Boat" unchecked>
		<label>Lisa pikkus: </label>
		<input type="numbner" name="picWidth" max="256" value="256">
		<label>Lisa kõrgus: </label>
		<input type="numbner" name="picHeight" max="256" value="256">
		<input name="submitPic" type="submit" value="Saada pilt">
	</form>
	<!--<img id="output_image"/>-->
	<script type="text/javascript">
		/**function preview_image(event) 
		{
			var reader = new FileReader();
			reader.onload = function()
			{
				var output = document.getElementById('output_image');
				output.src = reader.result;
			}
			reader.readAsDataURL(event.target.files[0]);
		}**/
	</script>
	
	<?php
	if (isset($_POST["submitPic"])) {
		echo "<hr>";		
		echo checkImage($_POST["link"]);
	}
	
	function checkImage ($image) {
		if(exif_imagetype($image) != IMAGETYPE_JPEG){
			return "Valige jpg fail!";
		}
		$im = imagecreatefromjpeg($image);
		$stringArt = "";		
		list($width, $height) = getimagesize($image);
		if ($width <= $_POST["picWidth"] or $height <= $_POST["picHeight"]) {
			return "Pilt on väiksem kui soovitud suurus.";
		}
		$stepi = $height / $_POST["picHeight"];
		$stepj = $width / $_POST["picWidth"];	
		for ($i = 0; $i <= $height-1; $i+=$stepi) {
			$stringArt .= "<br>";
			for ($j = 0; $j <= $width-1; $j+=$stepi) {
				$rgb = imagecolorat($im, $j, $i);
				$r = ($rgb >> 16) & 0xFF;
				$g = ($rgb >> 8) & 0xFF;
				$b = $rgb & 0xFF;
				$colorHex = dechex(($r + $g + $b) / 3);
				//$stringArt .= '<div class="bold" style="background-color: rgb(' .$r ."," .$g ."," .$b .');">A</div>';
				if (($r + $g + $b) / 3 > 128) {
					if (isset($_POST["colorBool"])) {
						$stringArt .= '<div class="noBold" style="background-color: rgb(' .$r ."," .$g ."," .$b .');">U</div>';
					} else {
						$stringArt .= '<div class="noBold">U</div>';					
					}
				} else {
					if (isset($_POST["colorBool"])) {						
						$stringArt .= '<div class="bold" style="background-color: rgb(' .$r ."," .$g ."," .$b .');">A</div>';
					} else {
						$stringArt .= '<div class="bold">A</div>';
					}
				}
			}
		}
		
		echo '<img src="' .$image .'"/><br>';
		echo '<div class="smallText">' .$stringArt .'</div>';
		imagedestroy($im);
		return "Pilt töödeldud!";		
	}
?>
	
</body>
</html>
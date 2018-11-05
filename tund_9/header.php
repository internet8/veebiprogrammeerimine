<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
	<title><?php echo $pageTitle; ?></title>
	<style>
	  <?php
        echo "body{background-color: " .$_SESSION["bgColor"] ."; \n";
		echo "color: " .$_SESSION["txtColor"] ."} \n";
	  ?>
	</style>
  </head>
  <body>
    <div>
	  <a href="main.php">
	    <img src="../vp_picfiles/vp_logo_w135_h90.png" alt="vp logo">
	  </a>
	  <img src="../vp_picfiles/vp_banner.png" alt="vp bänner">
	  <?php getCurrentProfilePic(); echo '<img src="../userProfilePic/' .$_SESSION["profilePic"] .' "height="50px" width="50" alt="profile_pic">'; ?>
	</div>
	
    <h1><?php echo $pageTitle; ?></h1>
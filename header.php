<!DOCTYPE html>
<html lang="et">
<head>
	<meta charset="utf-8">
	<title>Annabel Väljaots programmeerib veebi</title>
	<style>
		body {
			background-color: <?php echo $_SESSION["user_bg_color"]; ?>;
			color: <?php echo $_SESSION["user_txt_color"]; ?>;
		}
	</style>
	<?php
		if(isset($style_sheets)){
			// <link rel="stylesheet" href="styles/gallery.css"
			echo '<link rel="stylesheet" href ="' .$style_sheets .'">' ."\n";
		}
		//require_once "user_profile.php";
	?>
</head>
<body>
<img src="pics/banner.png" alt="bänner">
<h1>Vinge veebisüsteem</h1>
<p>See leht on loodud õppetöö raames ja ei sisalda tõsiseltvõetavat sisu!</p>
<p>Õppetöö toimus <a href="https://www.tlu.ee" target="_blank">Tallinna Ülikoolis</a> Digitehnoloogiate instituudis.</p>
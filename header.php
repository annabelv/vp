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
		if(isset($style_sheets) and !empty($style_sheets)){
			//<link rel="stylesheet" href="styles/gallery.css">
			foreach($style_sheets as $style){
				echo '<link rel="stylesheet" href="' .$style .'">' ."\n";
			}
		}
		
		if(isset($javascripts) and !empty($javascripts)){
			//<script src="javascript.js" defer></script>
			foreach($javascripts as $js){
				echo '<script src="' .$js .'" defer></script>' ."\n";
			}
		}
	?>
</head>
<body>
<img src="pics/banner.png" alt="bänner">
<h1>Vinge veebisüsteem</h1>
<p>See leht on loodud õppetöö raames ja ei sisalda tõsiseltvõetavat sisu!</p>
<p>Õppetöö toimus <a href="https://www.tlu.ee" target="_blank">Tallinna Ülikoolis</a> Digitehnoloogiate instituudis.</p>
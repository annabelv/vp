<?php
	require_once"classes/SessionManager.class.php";
	SessionManager::sessionStart("vp", 0, "~valjanna/vp", "greeny.cs.tlu.ee");
	if(!isset($_SESSION["user_id"])){
		//jõuga viiakse page.php lehele
		header("Location: page.php");
		exit();
	}
	
	//logime välja
	if(isset($_GET["logout"])) {
		session_destroy();
		header("Location: page.php");
		exit();
	}
	
	//tegelen küpsistega
	$last_visitor = "Pole teada.";
	
	if(isset($_COOKIE["lastvisitor"]) and !empty($_COOKIE["lastvisitor"])) {
		$last_visitor = $_COOKIE["lastvisitor"];
	}
	
	//salvestan küpsised
	//nimi, väärtus, aegumistähtaeg, veebikataloog, domeen, https kasutamine, 
	//https    isset($_SERVER["https"])
	setcookie("lastvisitor", $_SESSION["firstname"] ."" .$_SESSION["lastname"], time() + (60 * 60 * 24 * 8), "~valjanna/vp/", "greeny.cs.tlu.ee", true, true);
	//küpsiste kustutamine: expire ehk aegumistähtaeg pannakse minevikus: time() - 3000
	
	require_once "header.php";
	
	echo "<p>Sisse loginud: " .$_SESSION["firstname"] ." " .$_SESSION["lastname"] .".<p> \n";
	
	if($last_visitor != $_SESSION["firstname"] ." " .$_SESSION["lastname"]) {
		echo"<p>Viimati oli sisse loginud: " .$last_visitor ."</p> \n";
	}
?>
<ul>
	<li>Logi <a href="?logout=1">välja</a></li>
	<li>Fotode galeriisse <a href="gallery_foto_upload.php">lisamine</a></li>
	<li><a href="gallery_public.php">Avalike fotode galerii</a></li>
	<li><a href="gallery_own.php">Minu fotod</a></li>
	<li><a href="user_profile.php">Muuda profiili</a></li>
</ul>
<?php require_once "footer.php"; ?>
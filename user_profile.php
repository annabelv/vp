<?php
	require_once "../../config.php";
	session_start();
	if(!isset($_SESSION["user_id"])){
		//jõuga viiakse page.php lehele
		header("Location: page.php");
		exit();
	}
	
	//logime välja
	if(isset($_GET["logout"])){
		session_destroy();
		header("Location: page.php");
		exit();
	}
	
	require_once "header.php";
	require_once "fnc_user.php";
	
	echo "<p>Sisse loginud: " .$_SESSION["firstname"] ." " .$_SESSION["lastname"] .".</p> \n";
	
	$bg_color = $_SESSION["user_bg_color"];
	$txt_color = $_SESSION["user_txt_color"];
	
	$description = null;
	
	$bg_color_error = null;
	$txt_color_error = null;
	$description_error = null;
	
	if(isset($_POST["color_submit"])){
		if(isset($_POST["bg_color_input"]) and !empty($_POST["bg_color_input"])){
			$_SESSION["user_bg_color"] = $_POST["bg_color_input"];
		} else {
			$bg_color_error = "Valige taustavärv";
		}
	}
	
	if(isset($_POST["color_submit"])){
		if(isset($_POST["txt_color_input"]) and !empty($_POST["txt_color_input"])){
			$_SESSION["user_txt_color"] = $_POST["txt_color_input"];
		} else {
			$txt_color_error = "Valige teksti värv";
		}
	}

	if(isset($_POST["color_submit"])){
		if(isset($_POST["description_input"]) and !empty($_POST["description_input"])){
			$description = $_POST["user_description"];
		} else {
			$description_error = "Lisage lühikirjeldus!";
		}
	}
	

	
	if(empty($txt_color_error and $bg_color_error)){

		//loome andmebaasi ühenduse
			$conn = new mysqli($server_host, $server_user_name, $server_password, $database);
			//määrame suhtlemisel kasutatava kooditabeli
			$conn->set_charset("utf8");
			//valmistame ette SQL keeles päringu
			$stmt = $conn->prepare("INSERT INTO vp_userprofiles (userid, description, bgcolor, txtcolor) VALUES(?,?,?,?)");
			echo $conn->error;
			//seome SQL päringu päris andmetega
			//määrata andmetüübid:   i = integer(täisarv),  d = decimel(murdarv),  s = string (tekst)
			$stmt->bind_param("isss", $_SESSION["user_id"], $description, $_SESSION["user_bg_color"], $_SESSION["user_txt_color"]);
			//sulgeme käsu/päringu
			$stmt->execute();
			echo $stmt->error;
			$stmt->close();
			//sulgeme andmebaasi tegevuse
			$conn->close(); 
	}

?>


<ul>
	<li><a href="?logout=1">Logi välja</a></li>
	<li><a href="home.php">Avalehele</a></li>
</ul>

<!DOCTYPE HTML>
<html>
<body>
	<form method = "POST">
	<label for="bg_color">Tausta värv</label>
	<input type="color" name="bg_color_input" id="bg_color_input" placeholder="tausta värv" value="<?php echo $_SESSION["user_bg_color"]; ?>">
	<br>
	<label for="txt_color">Teksti värv</label>
	<input type="color" name="txt_color_input" id="txt_color_input" placeholder="teksti värv" value="<?php echo $_SESSION["user_txt_color"]; ?>">
	<br>
	<textarea name="user_description" rows="5" cols="51" placeholder="Minu lühikirjeldus"></textarea>
	<br>
	<input type="submit" name="color_submit" value="Salvesta">
</body>
</html>

<?php
	require_once "footer.php";
?>
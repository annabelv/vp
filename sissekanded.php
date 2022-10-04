<?php
//loen sisse konfiguratiooni faili
	require_once "../config.php";
$year_now = date("Y");

$title_error = null;
$year_error = null;
$duration_error = null;
$genre_error = null;
$studio_error = null;
$director_error = null;

if(isset($_POST["film_submit"])){
  if(isset($_POST["title_input"]) and !empty($_POST["title_input"])){
    $pealkiri = $_POST["title_input"];
  } else {
    $title_error = "Pealkiri jäi lisamata!";
  }
  if(isset($_POST["year_input"]) and !empty($_POST["year_input"])){
    $aasta = $_POST["year_input"];
  } else {
    $year_error = "Aasta jäi lisamata!";
  }
  if(isset($_POST["duration_input"]) and !empty($_POST["duration_input"])){
    $kestus = $_POST["duration_input"];
  } else {
    $duration_error = "Kestus jäi lisamata!";
  }
  if(isset($_POST["genre_input"]) and !empty($_POST["genre_input"])){
    $zanr = $_POST["genre_input"];
  } else {
    $genre_error = "Žanr jäi lisamata!";
  }
  if(isset($_POST["studio_input"]) and !empty($_POST["studio_input"])){
    $tootja = $_POST["studio_input"];
  } else {
    $studio_error = "Tootja jäi lisamata!";
  }
  if(isset($_POST["director_input"]) and !empty($_POST["director_input"])){
    $lavastaja = $_POST["director_input"];
  } else {
    $director_error = "Režissöör jäi lisamata!";
  }

if(empty($title_error and $year_error and $duration_error and $genre_error and $studio_error and $director_error)){

//loome andmebaasi ühenduse
	$conn = new mysqli($server_host, $server_user_name, $server_password, $database);
	//määrame suhtlemisel kasutatava kooditabeli
	$conn->set_charset("utf8");
	//valmistame ette SQL keeles päringu
	$stmt = $conn->prepare("INSERT INTO film (pealkiri, aasta, kestus, zanr, tootja, lavastaja) VALUES(?,?,?,?,?,?)");
	echo $conn->error;
	//seome SQL päringu päris andmetega
	//määrata andmetüübid:   i = integer(täisarv),  d = decimel(murdarv),  s = string (tekst)
	$stmt->bind_param("siisss", $pealkiri, $aasta, $kestus, $zanr, $tootja, $lavastaja);
	//sulgeme käsu/päringu
	$stmt->execute();
	echo $stmt->error;
	$stmt->close();
	//sulgeme andmebaasi tegevuse
	$conn->close(); 
	}
}
?>
<!DOCTYPE HTML>
<html>
<body>
	<form method="POST">
		<label for="title_input">Filmi pealkiri</label>
		<input type="text" name="title_input" id="title_input" placeholder="filmi pealkiri">
		<span> <?php echo $title_error ?> </span>
		<br>
		<label for="year_input">Valmimisaasta</label>
		<input type="number" name="year_input" id="year_input" min="1912" max= <?php echo $year_now?> >
		<span> <?php echo $year_error ?> </span>
		<br>
		<label for="duration_input">Kestus</label>
		<input type="number" name="duration_input" id="duration_input" min="1" value="60" max="600">
		<span> <?php echo $duration_error ?> </span>
		<br>
		<label for="genre_input">Filmi žanr</label>
		<input type="text" name="genre_input" id="genre_input" placeholder="žanr">
		<span> <?php echo $genre_error ?> </span>
		<br>
		<label for="studio_input">Filmi tootja</label>
		<input type="text" name="studio_input" id="studio_input" placeholder="filmi tootja">
		<span> <?php echo $studio_error ?> </span>
		<br>
		<label for="director_input">Filmi režissöör</label>
		<input type="text" name="director_input" id="director_input" placeholder="filmi režissöör">
		<span> <?php echo $director_error ?> </span>
		<br>
		<input type="submit" name="film_submit" value="Salvesta">
	</form>
</body>
</html>
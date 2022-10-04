<?php
	//loen sisse konfiguratiooni faili
	require_once "../../config.php";
	//echo $server_user_name;
	
	$author_name = "Annabel Väljaots";
	//echo $author_name;
	$full_time_now = date("d.m.Y H:i:s");
	$weekday_names_et = ["esmaspäev","teisipäev","kolmapäev","neljapäev","reede","laupäev","pühapäev"];
	//echo $weekday_names_et[1];
	$weekday_now = date("N");
	$hour_now = date("H");
	$part_of_day = "suvaline hetk";
	// == on võrdne	!= pole võrdne 	< 	> 	<= 	>=
	if ($weekday_now < 5){
		if($hour_now <= 7 and $hour_now >23){
			$part_of_day = "uneaeg";
		}
		if($hour_now >= 8 and $hour_now < 18){
			$part_of_day = "koolipäev";
		}
		If($hour_now >= 18 and $hour_now < 20){
			$part_of_day = "kodutööd";
		}
		if($hour_now  >= 20 and $hour_now < 23){
			$part_of_day = "vaba aeg";
		}
	}
	if ($weekday_now >= 5){
		if ($hour_now >= 1 and $hour_now <9){
			$part_of_day = "uneaeg";
		}
		if ($hour_now >=9 and $hour_now <11){
			$part_of_day = "laisklemine";
		}
		if($hour_now >= 11 and $hour_now <14){
			$part_of_day = "aiatööd";
		}
		if ($hour_now >= 14 and $hour_now < 17){
			$part_of_day = "hobid";
		}
		if ($hour_now >= 17 and $hour_now <21){
			$part_of_day = "aeg perega";
		}
		if ($hour_now >= 21 and $hour_now < 1){
			$part_of_day = "misiganes";
		}
		
	}
	
	//vanasõnad
	$vanasonad = ["Aeg koolitab.","Hea sõna parem kui 100 rubla.","Jutt suurem kui asi.","Kel amet, sel leiba.","Rikkal raha, vaesel lapsed."];
	
	//vaatame semestri pikkust ja kulgemist
	$semester_begin = new DateTime("2022-09-05");
	$semester_end = new DateTime("2022-12-18");
	$semester_duration = $semester_begin->diff($semester_end);
	$semester_duration_days = $semester_duration -> format("%r%a");
	//echo $semester_duration_days;
	$from_semester_begin = $semester_begin -> diff(new DateTime("now"));
	$from_semester_begin_days = $from_semester_begin -> format("%r%a");
	
	//loendan massiivi (array) liikmeid
		//echo count ($weekday_names_et);
	//juhuslik arv
		//echo mt_rand(1,9);
	//juhuslik element massiivist
		//echo $weekday_names_et[mt_rand(0,count ($weekday_names_et)-1)];
		
	//loeme fotode kataloogi sisu
	$photo_dir = "photos/";
	//$all_files = scandir($photo_dir);
	//uus_massiiv = array_slice(mis massiiv, mis kohast alates);
	$all_files = array_slice(scandir($photo_dir),2);
	//echo $all_files;
	//var_dump ($all_files);
	
	// <img scr="kaust/fail" alt="tekst";
	$photo_html = null;
	
	//tsükkel
	//muutuja väärtuse suurendamine: $muutuja = $muutuja +5;
	//muutjua += 5 (ehk liida praegusele väärtusele otsa);
	// kui suureneb ühe võrra: $muutuja ++ ;
	// on ka -=  -- ;
	/*for($i = 0;$i < count($all_files); $i ++){
		echo $all_files[$i];
	}	*/
	/*foreach($all_files as $file_name){
		echo $file_name ." | ";
	}*/    //see oli, et panna püstkriipsud failide nimede vahele
	
	//loetlen lubatud failitüübi (jpg  png) et ei tuleks mingit muud faili
	$allowed_photo_types = ["image/jpeg", "image/png"];
	$photo_files = [];
	foreach($all_files as $file_name){
		$file_info = getimagesize($photo_dir . $file_name);
		if(isset($file_info["mime"])){
			if(in_array($file_info["mime"], $allowed_photo_types)){
				array_push ($photo_files, $file_name);
			}
		}
	}
	//var_dump($photo_files);
	$photo_html = '<img src="'.$photo_dir .$photo_files[mt_rand(0, count($photo_files)-1)].'" alt="Tallinna pilt">';
	//echo $photo_html;
	
	//loosin juhusliku foto jaoks numbri
	$photo_number = mt_rand(0, count($photo_files) - 1);
	
	//vormi info kasutamine
	// $_POST
	//var_dump($_POST);
	$adjective_html = null;
	if(isset($_POST["todays_adjective_input"]) and !empty ($_POST["todays_adjective_input"])){
		$adjective_html = "<p>Tänase kohta on arvatud: " .$_POST["todays_adjective_input"] .".</p>";
	}
	
	//kui kasutaja valib ise foto
	if(isset($_POST["photo_select"]) and $_POST["photo_select"] >= 0){
		//kõik, mis teha tahame...
		$photo_number = $_POST["photo_select"];
	}
	
	//teen fotode rippmenüü
	//	<option value="0">tln_40.JPG</option>
	$select_html = '<option value="" selected disabled>Vali pilt</option>';
	for($i = 0;$i < count($photo_files); $i ++){
		$select_html .= '<option value="' .$i .'"';
		if ($i == $photo_number) {
			$select_html .= " selected";
		}
		$select_html .= ">";
		$select_html .= $photo_files[$i];
		$select_html .= "</option>\n";
	}
	
	//kasutades loositud või kasutaja valitud numbrit, määran näidatava foto
	$photo_html = '<img src="' . $photo_dir . $photo_files[$photo_number] .'" alt ="Tallinna pilt">';
	
	$comment_error = null;
	//tegeleme päevale antud hinde ja kommentaariga       teine if, kui ei kirjutata kommentaari
	if (isset($_POST["comment_submit"])){
		if(isset($_POST["comment_input"]) and !empty($_POST["comment_input"])){
			$comment = $_POST["comment_input"];
		} else {
			$comment_error = "Kommentaar jäi lisamata.";
		}
		$grade = $_POST["grade_input"];
		
		if (empty($comment_error)){
			//loome andmebaasi ühenduse
			$conn = new mysqli($server_host, $server_user_name, $server_password, $database);
			//määrame suhtlemisel kasutatava kooditabeli
			$conn->set_charset("utf8");
			//valmistame ette SQL keeles päringu
			$stmt = $conn->prepare("INSERT INTO VP_daycomment (comment, grade) VALUES(?,?)");
			echo $conn->error;
			//seome SQL päringu päris andmetega
			//määrata andmetüübid:   i = integer(täisarv),  d = decimel(murdarv),  s = string (tekst)
			$stmt->bind_param("si", $comment, $grade);
			//täidame käsu
			if ($stmt->execute()){
				$grade = 7;
			}
			echo $stmt->error;
			//sulgeme käsu/päringu
			$stmt->close();
			//sulgeme andmebaasi tegevuse
			$conn->close();
		}
	}
	
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title><?php echo $author_name; ?>, veebiprogrammeerimine</title>
</head>
<body>
	<img src="veebiproge/banner" alt="Veebiprogrammeerimise banner">
	<h1><?php echo $author_name; ?>, veebiprogrammeerimine</h1>
	<p>See leht on loodud õppetöö raames ega sisalda tõsist infot.</p>
	<p>Õppetöö toimus <a href="https://www.tlu.ee">Tallinna Ülikoolis</a> Digitehnoloogiate Instituudis.</p>
	<p>Lehe avamise hetk: <?php echo $weekday_names_et[$weekday_now - 1]. ", ". $full_time_now; ?>.</p>
	<p>Praegu on <?php echo $part_of_day; ?>.</p>
	
	<!--päeva kommentaaride lisamise vorm -->
	<form method="POST">
		<label for="comment_input">Kommentaar tänase päeva kohta:</label>
		<br> 
		<textarea id="comment_input" name="comment_input" cols="70" rows="2" placeholder="kommentaar"></textarea>
		<br>
		<label for="garde_input">Hinne tänasele päevale (0 ... 10):</label>
		<input type="number" id="grade_input" name="grade_input" min="0" max="10" step="1" value="7">
		<br>
		<input type="submit" id="comment_submit" name="comment_submit" value="Salvesta">
		<span><?php echo $comment_error ?></span>
	</form>
	<hr>
	
	<?php echo $vanasonad[mt_rand(0, count ($vanasonad)-1)]; ?>
	<!-- Siin on väike omadussõnade vrom -->
	<form method="POST">
		<input type="text" id="todays_adjective_input" name="todays_adjective_input" placeholder = "omadussõna tänase kohta">
		<input type="submit" id="todays_adjective_submit" name="todays_adjective_submit" value="Saada omadussõna">
	</form>
	<?php echo $adjective_html; ?>
	<hr>
	<form method="POST">
		<select id="photo_select" name="photo_select">
			<?php echo $select_html; ?>
		</select>
		<input type="submit" id="photo_submit" name="photo_submit" value= "OK">
	</form>
	<?php echo $photo_html; ?>
	<hr>
	<p>Semester edeneb: <?php echo $from_semester_begin_days ."/" . $semester_duration_days; ?></p>
	<img src="pics/tlu_41.jpg" alt="Tallinna Ülikooli Astra õppehoone">
	<p>Üritamas kodus ka midagi lisada.</p>
</body>
</html>
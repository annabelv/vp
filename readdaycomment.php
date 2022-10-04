<?php
	require_once "../config.php";
	
	//loome andmebaasi ühenduse
	$conn = new mysqli($server_host, $server_user_name, $server_password, $database);
	//määrame suhtlemisel kasutatava kooditabeli
	$conn->set_charset("utf8");
	//valmistame ette SQL keeles päringu
	$stmt = $conn->prepare("SELECT comment, grade, added FROM VP_daycomment");
	echo $conn->error;
	//seome loetavad andmed muutujatega      db-database
	$stmt->bind_result($comment_from_db, $grade_from_db, $added_from_db);
	//täidame käsu
	$stmt->execute();
	echo $stmt->error;
	//võtan andmeid
	//kui on oodata vaid üks võimalik kirje
	//if $stmt->fetch(){
		//kõik mida teha
	//}
	$comments_html = null;
	//kui on oodata mitut, aga teadmata arv
	while($stmt->fetch()){
		// <p>Kommentaar, hinne päevale: x, lisatud yyyy.</p>
		$comments_html .= "<p>" .$comment_from_db .", hinne päevale: " .$grade_from_db .", lisatud " .$added_from_db .". </p> \n";
	}
	//sulgeme käsu/päringu
	$stmt->close();
	//sulgeme andmebaasi tegevuse
	$conn->close();
	
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Annabel Väljaots, veebiprogrammeerimine</title>
</head>
<body>
	<h1>Annabel Väljaots, veebiprogrammeerimine</h1>
	<p>See leht on loodud õppetöö raames ega sisalda tõsist infot.</p>
	<p>Õppetöö toimus <a href="https://www.tlu.ee">Tallinna Ülikoolis</a> Digitehnoloogiate Instituudis.</p>
	<img src="pics/tlu_41.jpg" alt="Tallinna Ülikooli Astra õppehoone">
	<p>Üritamas kodus ka midagi lisada.</p>
	<?php echo $comments_html; ?>
</body>
</html>
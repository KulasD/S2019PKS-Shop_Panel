<?php
	session_start();
	$dostawa = mysqli_connect("localhost","root","","administracja");
	mysqli_query($dostawa, "SET CHARSET utf8");
	mysqli_query($dostawa, "SET NAMES 'utf8' COLLATE 'utf8_polish_ci'");
	$ai_query = "SELECT `AUTO_INCREMENT`
				FROM INFORMATION_SCHEMA.TABLES
				WHERE TABLE_NAME = 'dostawy'";
	$ai_r = mysqli_query($dostawa,$ai_query);
	$id_dostawy = $ai_r->fetch_array(MYSQLI_ASSOC);
	$id_d = $id_dostawy['AUTO_INCREMENT'];
	$query = "SELECT * FROM produkty_do_dostawy";
	$result = mysqli_query($dostawa,$query);
	$dostawca = $_SESSION['dost'];
	while ($r = $result->fetch_array(MYSQLI_ASSOC)) {
		$id = $r['id_pdd'];
		if(isset($_POST['ilosc'.$id])){
			$ilosc = $_POST['ilosc'.$id];
			$query_dostawa = "INSERT INTO produkty_z_dostawy VALUES('', '$id_d', '$id', '$ilosc')";
			mysqli_query($dostawa,$query_dostawa);
		}
	}
	
	$query_dostawaa = "INSERT INTO dostawy VALUES('', '$dostawca', current_timestamp(), 'oczekiwanie na towary')";
	mysqli_query($dostawa,$query_dostawaa);
	
	$wyczysc = "DELETE FROM produkty_do_dostawy";
	mysqli_query($dostawa,$wyczysc);
	
	unset($_SESSION['dost']);
	
	header("Location: dostawy_lista.php");
	exit();
?>
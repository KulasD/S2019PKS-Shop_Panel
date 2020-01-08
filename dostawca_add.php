<?php
	session_start();
	$con = mysqli_connect("localhost","root","","administracja");
	mysqli_query($con, "SET CHARSET utf8");
	mysqli_query($con, "SET NAMES 'utf8' COLLATE 'utf8_polish_ci'");
	$id_d = $_POST['id_d'];
	$nazwa = $_POST['nazwa'];
	$nip = $_POST['nip']; 
	$regon = $_POST['regon']; 
	$telefon = $_POST['telefon']; 
	$email = $_POST['email']; 
	$adres = $_POST['adres']; 
	$kod = $_POST['kod_pocztowy']; 
	$miejscowosc = $_POST['miejscowosc'];
	$status = $_POST['status'];

	if ($id_d=='')
	{
		$con->query("INSERT INTO dostawcy VALUES (NULL, '$nazwa','$nip','$regon','$adres','$kod','$miejscowosc','$email','$telefon','$status')");
	}
	else
	{
		//To robi update, ale wtedy historia sie zepsuje
		//$con->query("UPDATE dostawcy SET nazwa='$nazwa', nip='$nip', regon='$regon', adres='$adres', kod_pocztowy='$kod', miejscowosc='$miejscowosc', email='$email', telefon='$telefon', status='$status'  WHERE id='$id_d'");
		
		//Edycja powoduje zmiane statusu edytowanego dostawcy na nieaktywny i tworzy nowego dostawce z podanych danych (zachowana historia dostaw)
		$con->query("UPDATE dostawcy SET status='nieaktywny'  WHERE id='$id_d'");
		$con->query("INSERT INTO dostawcy VALUES (NULL, '$nazwa','$nip','$regon','$adres','$kod','$miejscowosc','$email','$telefon','$status')");
	}
	header('Location: dostawcy_lista.php');
	exit();
?>

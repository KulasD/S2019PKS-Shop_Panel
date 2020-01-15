<?php
	session_start();
	$con = mysqli_connect("localhost","root","","administracja");
	mysqli_query($con, "SET CHARSET utf8");
	mysqli_query($con, "SET NAMES 'utf8' COLLATE 'utf8_polish_ci'");
	$id_p = $_POST['id_p'];
	$imie = $_POST['imie'];
	$nazwisko = $_POST['nazwisko']; 
	$login = $_POST['login']; 
	$telefon = $_POST['telefon']; 
	$uprawnienia = $_POST['uprawnienia'];
	
	$yes = false;
	if(isset( $_POST['nowe_haslo'] ) && !empty( $_POST['nowe_haslo'] )){
		$haslo = password_hash($_POST['nowe_haslo'], PASSWORD_DEFAULT);
		$yes = true;
	}

	if ($id_p=='')
	{
		$con->query("INSERT INTO kadra VALUES (NULL, '$login','$haslo','$imie','$nazwisko','$telefon','$uprawnienia')");
	}
	else
	{
		$con->query("UPDATE kadra SET login='$login', imie='$imie', nazwisko='$nazwisko', tel='$telefon', uprawnienia='$uprawnienia' WHERE id='$id_p'");
		if($yes){
			$con->query("UPDATE kadra SET haslo='$haslo' WHERE id='$id_p'");
		}
	}
	header('Location: pracownicy_lista.php');
	exit();
?>

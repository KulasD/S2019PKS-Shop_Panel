<?php
	session_start();
	if (!isset($_SESSION['zalogowany']))
	{
		header('Location: index.php');
		exit();
	}
?>
<?php

	if(isset( $_POST['nick'] ) && !empty( $_POST['nick'] )){
		$nick = $_POST['nick'];
		$yes = true;
	} else{
		$yes = false;
	}
	
	if(isset( $_POST['imie'] ) && !empty( $_POST['imie'] )){
		$imie = $_POST['imie'];
		$yes = true;
	} else{
		$yes = false;
	}
	
	if(isset( $_POST['nazwisko'] ) && !empty( $_POST['nazwisko'] )){
		$nazwisko = $_POST['nazwisko'];
		$yes = true;
	} else{
		$yes = false;
	}
	
	if(isset( $_POST['plec'] ) && !empty( $_POST['plec'] )){
		$plec = $_POST['plec'];
		$yes = true;
	} else{
		$yes = false;
	}
	
	if(isset( $_POST['email'] ) && !empty( $_POST['email'] )){
		$email = $_POST['email'];
		$yes = true;
	} else{
		$yes = false;
	}
	
	if(isset( $_POST['adres'] ) && !empty( $_POST['adres'] )){
		$adres = $_POST['adres'];
		$yes = true;
	} else{
		$yes = false;
	}
	
	if(isset( $_POST['kod'] ) && !empty( $_POST['kod'] )){
		$kod = $_POST['kod'];
		$yes = true;
	} else{
		$yes = false;
	}
	
	if(isset( $_POST['miejscowosc'] ) && !empty( $_POST['miejscowosc'] )){
		$miejscowosc = $_POST['miejscowosc'];
		$yes = true;
	} else{
		$yes = false;
	}
	
	if(isset( $_POST['telefon'] ) && !empty( $_POST['telefon'] )){
		$telefon = $_POST['telefon'];
		$yes = true;
	} else{
		$yes = false;
	}
	
	if(isset( $_POST['nowe_haslo'] ) && !empty( $_POST['nowe_haslo'] )){
		$nowe_haslo = password_hash($_POST['nowe_haslo'], PASSWORD_DEFAULT);
	} else{
		$nowe_haslo = $_SESSION['pass'];
	}
	
	$id_u = $_SESSION['id_u'];
	$ip_u = $_SESSION['ip_k'];
	$zar = $_SESSION['zarejestrowany'];
	$rej = $_SESSION['kod_rejestracji'];
	$zmian = $_SESSION['kod_zmiany_hasla'];
	if ($yes){
		$con = mysqli_connect("localhost","root","","user");
		mysqli_query($con, "SET CHARSET utf8");
		mysqli_query($con, "SET NAMES 'utf8' COLLATE 'utf8_polish_ci'");
		$con->query(
		"UPDATE uzytkownicy SET nick='$nick', name='$imie', surname='$nazwisko', sex='$plec', pass='$nowe_haslo', email='$email', ip='$ip_u', adres='$adres', kod_pocztowy='$kod', miejscowosc='$miejscowosc', nr_tel='$telefon', zarejestrowany='$zar', kod_rejestracji='$rej', kod_zmiany_hasla='$zmian' WHERE id_user='$id_u'");
		unset( $_SESSION['id_u'] );
		unset( $_SESSION['pass'] );
		unset( $_SESSION['ip_k'] );
		unset( $_SESSION['zarejestrowany'] );
		unset( $_SESSION['kod_rejestracji'] );
		unset( $_SESSION['kod_zmiany_hasla'] );
		echo "done";
		//header('Location: zgloszenie.php?a='.$id_zgloszenia);
		//exit();
	}
	
?>

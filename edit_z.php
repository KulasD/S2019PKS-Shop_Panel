<?php
	session_start();
	$con = mysqli_connect("localhost","root","","user");
	mysqli_query($con, "SET CHARSET utf8");
	mysqli_query($con, "SET NAMES 'utf8' COLLATE 'utf8_polish_ci'");
	$id_zamowienie= $_POST['i'];
	$id_pracownik= $_POST['p'];
	$status= $_POST['s'];
	$termin= $_POST['t'];
	$nr_paczki= $_POST['n'];
	$waga= $_POST['w'];
	$komentarz= $_POST['k'];
	$termin = htmlentities($termin, ENT_QUOTES, "UTF-8");
	$nr_paczki= htmlentities($nr_paczki, ENT_QUOTES, "UTF-8");
	$waga = htmlentities($waga, ENT_QUOTES, "UTF-8");
	$komentarz = htmlentities($komentarz, ENT_QUOTES, "UTF-8");
	$con->query("UPDATE zamowienie_informacje SET id_pracownik='$id_pracownik', status='$status', szacowana_data_dostawy='$termin', nr_paczki='$nr_paczki', waga_paczki='$waga', komentarz_pracownik='$komentarz' WHERE id_zamowienie='$id_zamowienie' ");
	
	if($status=='Zamówienie zrealizowane'){
		$con->query("UPDATE zamowienie_informacje SET data_dostarczenia=current_timestamp() WHERE id_zamowienie='$id_zamowienie' ");
	}
?>

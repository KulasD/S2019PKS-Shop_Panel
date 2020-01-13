<?php

	session_start();
	
	if (!isset($_SESSION['zalogowany']))
	{
		header('Location: index.php');
		exit();
	}
	
?>
<?php

	if (isset($_POST['id_zwr']))
	{
		$id_zwr = $_POST['id_zwr'];
	}
	if (isset($_POST['status']))
	{
		$status = $_POST['status'];
	}
	if (isset($_POST['id_pracownik']))
	{
		$id_pracownik = $_POST['id_pracownik'];
	}
	if (isset($_POST['komentarz']))
	{
		$komentarz = $_POST['komentarz'];
	}
	if (isset($_POST['wyposazenie']))
	{
		$wyposazenie = $_POST['wyposazenie'];
	}
	if (isset($_POST['zamowienie_id']))
	{
		$zamowienie_id = $_POST['zamowienie_id'];
	}
	if (isset($_POST['ile_produktow']))
	{
		$ile_produktow = $_POST['ile_produktow'];
	}

	$con = mysqli_connect("localhost","root","","user");
	mysqli_query($con, "SET CHARSET utf8");
	mysqli_query($con, "SET NAMES 'utf8' COLLATE 'utf8_polish_ci'");
	$query = "UPDATE zwroty SET status='$status' WHERE id_zwrot='$id_zwr'";
	$result = mysqli_query($con,$query);
	
	// wersja 1
	/*
	if (($status=='Zwrot dokonany') || ($status=='Zwrot anulowany')){
		$query = "UPDATE zamowienie_informacje SET status='Zamówienie zrealizowane po zwrocie' WHERE id_zamowienie='$zamowienie_id'";
		$result = mysqli_query($con,$query);
		
		for ($i = 0; $i < $ile_produktow ; $i++){
			$id_now = $_POST['id_zamow_p'.$i];
			$ilosc_now = $_POST['ilosc_zamow_p'.$i];
			$query = "UPDATE zamowienie_przedmiot SET zwrot_quantity=zwrot_quantity-$ilosc_now WHERE id_zamow_p='$id_now'";
			mysqli_query($con,$query);
		}
	}
	
	if ($status=='Zwrot dokonany'){
		$wartosc_now = 0;
		$q = "SELECT * FROM zamowienie_informacje WHERE id_zamowienie='$zamowienie_id'";
		$res = mysqli_query($con,$q);
		$r = $res->fetch_array(MYSQLI_ASSOC);
		for ($i = 0; $i < $ile_produktow ; $i++){
			$id_now = $_POST['id_zamow_p'.$i];
			$ilosc_now = $_POST['ilosc_zamow_p'.$i];
			$wartosc_now = $wartosc_now + $_POST['wartosc_zamow_p'.$i];
			$query = "UPDATE zamowienie_przedmiot SET quantity=quantity-$ilosc_now WHERE id_zamow_p='$id_now'";
			mysqli_query($con,$query);
		}
		$wartosc_now = $r['cena_zamowienia'] - $wartosc_now;
		$vat_now = $wartosc_now * 0.23;
		$qa = "UPDATE zamowienie_informacje SET vat23='$vat_now', cena_zamowienia='$wartosc_now' WHERE id_zamowienie='$zamowienie_id'";
		mysqli_query($con,$qa);
	}
	*/
	
	//wersja 2
	if (($status=='Zwrot dokonany') || ($status=='Zwrot anulowany')){
		$query = "UPDATE zamowienie_informacje SET status='Zamówienie zrealizowane po zwrocie' WHERE id_zamowienie='$zamowienie_id'";
		$result = mysqli_query($con,$query);
	}
	
	if ($status=='Zwrot anulowany'){
		for ($i = 0; $i < $ile_produktow ; $i++){
			$id_now = $_POST['id_zamow_p'.$i];
			$ilosc_now = $_POST['ilosc_zamow_p'.$i];
			$query = "UPDATE zamowienie_przedmiot SET zwrot_quantity=zwrot_quantity-$ilosc_now WHERE id_zamow_p='$id_now'";
			mysqli_query($con,$query);
		}
	}
	
	header('Location: dane_zwrot.php?id='.$id_zwr);
	exit();

?>
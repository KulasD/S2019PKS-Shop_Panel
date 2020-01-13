<?php

	session_start();
	
	if (!isset($_SESSION['zalogowany']))
	{
		header('Location: index.php');
		exit();
	}
	
?>
<?php

	if (isset($_POST['id_rekl']))
	{
		$id_rekl = $_POST['id_rekl'];
	}
	if (isset($_POST['status']))
	{
		$status = $_POST['status'];
	}
	if (isset($_POST['RMA_serwis']))
	{
		$RMA_serwis = $_POST['RMA_serwis'];
	}
	if (isset($_POST['id_pracownik']))
	{
		$id_pracownik = $_POST['id_pracownik'];
	}
	if (isset($_POST['opis_naprawy']))
	{
		$opis_naprawy = $_POST['opis_naprawy'];
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
	if (isset($_POST['produkt_id']))
	{
		$produkt_id = $_POST['produkt_id'];
	}
	if (isset($_POST['produkt_ilosc']))
	{
		$produkt_ilosc = $_POST['produkt_ilosc'];
	}
	if (isset($_POST['id_zamow_p']))
	{
		$id_zamow_p = $_POST['id_zamow_p'];
	}
	if (isset($_POST['produkt_wartosc']))
	{
		$produkt_wartosc = $_POST['produkt_wartosc'];
	}

	$con = mysqli_connect("localhost","root","","user");
	mysqli_query($con, "SET CHARSET utf8");
	mysqli_query($con, "SET NAMES 'utf8' COLLATE 'utf8_polish_ci'");
	$query = "UPDATE reklamacje SET status='$status', RMA_serwis='$RMA_serwis', id_pracownik='$id_pracownik', opis_naprawy='$opis_naprawy', komentarz='$komentarz', wyposazenie='$wyposazenie' WHERE id_rek='$id_rekl'";
	$result = mysqli_query($con,$query);
	
	//wersja 1
	/*
	if (($status=='Reklamacja zrealizowana, produkt po serwisie') || ($status=='Reklamacja zrealizowana, pieniądze zwrócone') || ($status=='Reklamacja anulowana')){
		$query = "UPDATE zamowienie_informacje SET status='Zamówienie zrealizowane po reklamacji' WHERE id_zamowienie='$zamowienie_id'";
		$result = mysqli_query($con,$query);
		$query = "UPDATE zamowienie_przedmiot SET reklamacja_quantity=reklamacja_quantity-$produkt_ilosc WHERE id_zamow_p='$id_zamow_p'";
		$result = mysqli_query($con,$query);
	}
	
	if ($status=='Reklamacja zrealizowana, pieniądze zwrócone'){
		$query = "UPDATE zamowienie_przedmiot SET quantity=quantity-$produkt_ilosc WHERE id_zamow_p='$id_zamow_p'";
		$result = mysqli_query($con,$query);
		
		$q = "SELECT * FROM zamowienie_informacje WHERE id_zamowienie='$zamowienie_id'";
		$res = mysqli_query($con,$q);
		$r = $res->fetch_array(MYSQLI_ASSOC);
		
		$wartosc_new = $r['cena_zamowienia']-($produkt_ilosc*$produkt_wartosc);
		$vat_new = $wartosc_new*0.23;
		
		$qa = "UPDATE zamowienie_informacje SET vat23='$vat_new', cena_zamowienia='$wartosc_new' WHERE id_zamowienie='$zamowienie_id'";
		mysqli_query($con,$qa);
	}
	*/
	
	//wersja 2
	if (($status=='Reklamacja zrealizowana, produkt po serwisie') || ($status=='Reklamacja zrealizowana, pieniądze zwrócone') || ($status=='Reklamacja anulowana')){
		$query = "UPDATE zamowienie_informacje SET status='Zamówienie zrealizowane po reklamacji' WHERE id_zamowienie='$zamowienie_id'";
		$result = mysqli_query($con,$query);
	}
	
	if (($status=='Reklamacja zrealizowana, produkt po serwisie') || ($status=='Reklamacja anulowana')){
		$query = "UPDATE zamowienie_przedmiot SET reklamacja_quantity=reklamacja_quantity-$produkt_ilosc WHERE id_zamow_p='$id_zamow_p'";
		$result = mysqli_query($con,$query);
	}
	
	header('Location: dane_reklamacja.php?id='.$id_rekl);
	exit();

?>
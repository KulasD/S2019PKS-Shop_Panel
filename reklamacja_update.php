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

	$con = mysqli_connect("localhost","root","","user");
	mysqli_query($con, "SET CHARSET utf8");
	mysqli_query($con, "SET NAMES 'utf8' COLLATE 'utf8_polish_ci'");
	$query = "UPDATE reklamacje SET status='$status', RMA_serwis='$RMA_serwis', id_pracownik='$id_pracownik', opis_naprawy='$opis_naprawy', komentarz='$komentarz', wyposazenie='$wyposazenie' WHERE id_rek='$id_rekl'";
	$result = mysqli_query($con,$query);
	
	header('Location: dane_reklamacja.php?id='.$id_rekl);
	exit();

?>
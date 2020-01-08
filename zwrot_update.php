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

	$con = mysqli_connect("localhost","root","","user");
	mysqli_query($con, "SET CHARSET utf8");
	mysqli_query($con, "SET NAMES 'utf8' COLLATE 'utf8_polish_ci'");
	$query = "UPDATE zwroty SET status='$status' WHERE id_zwrot='$id_zwr'";
	$result = mysqli_query($con,$query);
	
	header('Location: dane_zwrot.php?id='.$id_zwr);
	exit();

?>
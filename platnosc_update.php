<?php

	session_start();
	
	if (!isset($_SESSION['zalogowany']))
	{
		header('Location: index.php');
		exit();
	}
	
?>
<?php

	if (isset($_POST['id']))
	{
		$id = $_POST['id'];
	}

	$con = mysqli_connect("localhost","root","","user");
	mysqli_query($con, "SET CHARSET utf8");
	mysqli_query($con, "SET NAMES 'utf8' COLLATE 'utf8_polish_ci'");
	$query = "UPDATE zamowienie_informacje SET status_zaplaty='Zapłacono' WHERE id_zamowienie='$id'";
	$result = mysqli_query($con,$query);

?>
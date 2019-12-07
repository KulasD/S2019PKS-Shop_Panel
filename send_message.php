<?php
	session_start();
	if (!isset($_SESSION['zalogowany']))
	{
		header('Location: index.php');
		exit();
	}
?>
<?php
	if(isset( $_POST['tresc'] ) && !empty( $_POST['tresc'] )){
		$tresc= $_POST['tresc'];
		$my_id = $_SESSION['id'];
		$id_zgloszenia = $_SESSION['id_zgloszenia'];
		$con = mysqli_connect("localhost","root","","user");
		mysqli_query($con, "SET CHARSET utf8");
		mysqli_query($con, "SET NAMES 'utf8' COLLATE 'utf8_polish_ci'");
		$con->query("UPDATE zgloszenie_klienta SET status='Odpowiedź wysłana' WHERE id_zgloszenie='$id_zgloszenia'");
		$query_go = ("INSERT INTO korespondencja VALUES ('', '$my_id','0', '$id_zgloszenia', '$tresc', current_timestamp())");
		mysqli_query($con,$query_go);
		unset( $_POST['tresc'] );
		header('Location: zgloszenie.php?a='.$id_zgloszenia);
		exit();
	}
?>

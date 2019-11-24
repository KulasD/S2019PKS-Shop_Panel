<?php
	session_start();
	$con = mysqli_connect("localhost","root","","user");
	mysqli_query($con, "SET CHARSET utf8");
	mysqli_query($con, "SET NAMES 'utf8' COLLATE 'utf8_polish_ci'");
	$id_pracownik = $_SESSION['id'];
	$id_zamowienie= $_POST['n'];
	$query = "SELECT id_pracownik FROM zamowienie_informacje WHERE id_zamowienie='$id_zamowienie'";
	$result = mysqli_query($con,$query);
	while ($r = $result->fetch_array(MYSQLI_ASSOC)) {
		$check = $r['id_pracownik'];
	}
	if($check == '0') {
		$con->query("UPDATE zamowienie_informacje SET id_pracownik='$id_pracownik'  WHERE id_zamowienie='$id_zamowienie' ");
		echo json_encode("Ok");
	} else if($id_pracownik == $check) {
		echo json_encode("Ok");
	} else {
		echo json_encode("No");
	}
?>

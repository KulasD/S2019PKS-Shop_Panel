<?php
	session_start();
	$con = mysqli_connect("localhost","root","","user");
	mysqli_query($con, "SET CHARSET utf8");
	mysqli_query($con, "SET NAMES 'utf8' COLLATE 'utf8_polish_ci'");
	$kod = $_POST['k'];
	$status = $_POST['s'];
	$procent = $_POST['p'];
	$id= $_POST['i'];
	$kod = htmlentities($kod, ENT_QUOTES, "UTF-8");
	$procent= htmlentities($procent, ENT_QUOTES, "UTF-8");
	$id= htmlentities($id, ENT_QUOTES, "UTF-8");
	$query = "SELECT * FROM kod_rabatowy";
	$result = mysqli_query($con,$query);
	$check = false;
	$date = date('Y-m-d H:i:s');
	if($id != '') {$check = true;};
	while ($r = $result->fetch_array(MYSQLI_ASSOC)) {
		if($r['kod'] == $kod) { $check = true; }
	}
	if($check == false) {
		$con->query("INSERT INTO kod_rabatowy VALUES (NULL, '$kod','$procent','$status','$date')");
		echo json_encode("Ok");
	} else if($check == true){
		$con->query("UPDATE kod_rabatowy SET kod='$kod', rabat='$procent', status='$status', data_dodania='$date'  WHERE id_kod='$id'");
		echo json_encode("Update");
	}
?>

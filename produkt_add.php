<?php

	session_start();
	
	if (!isset($_SESSION['zalogowany']))
	{
		header('Location: index.php');
		exit();
	}
	

	$con = mysqli_connect("localhost","root","","przedmioty");
	mysqli_query($con, "SET CHARSET utf8");
	mysqli_query($con, "SET NAMES 'utf8' COLLATE 'utf8_polish_ci'");
	
	//------------------------------------------------------ PRZEDMIOTY_OGOLNE_INFORMACJE
	$id_query = "SELECT `AUTO_INCREMENT` 
				FROM `INFORMATION_SCHEMA`.`TABLES` 
				WHERE `TABLE_NAME`='przedmioty_ogolne_informacje';";
	$result_id = mysqli_query($con,$id_query);
	$r_id = $result_id->fetch_array(MYSQLI_ASSOC);
	$id = $r_id['AUTO_INCREMENT'];
	
	
	$nazwa = $_POST['nazwa_produktu'];
	//echo $nazwa;
	$pelna_nazwa = $_POST['nazwa_produktu_full'];
	//echo $pelna_nazwa;
	$cena = $_POST['cena_brutto'];
	//echo $cena;
	$sztuki = $_POST['sztuki'];
	//echo $sztuki;
	$parametr1 = $_POST['parametr1'];
	//echo $parametr1;
	$parametr2 = $_POST['parametr2'];
	//echo $parametr2;
	$parametr3 = $_POST['parametr3'];
	//echo $parametr3;
	$kategoria = $_SESSION['kat'];
	//echo $kategoria;
	$lokalizacja = $_SESSION['lok'];
	//echo $lokalizacja;
	$src = "img/".basename( $_FILES['main_zdj']['name']);
	
	$query_ogolne = ("INSERT INTO przedmioty_ogolne_informacje VALUES (NULL, '$nazwa','$pelna_nazwa', '$cena', '$sztuki', '0', '$src', '$parametr1', '$parametr2', '$parametr3', '0', '$kategoria', '$lokalizacja')");
	mysqli_query($con,$query_ogolne);
	
	//------------------------------------------------------ KATEGORIA_FULL
	
	/* echo $_SESSION['licznik_kat']."<br>";
	
	for($t=1;$t<=$_SESSION['licznik_kat'];$t++){
		echo $_POST['atr'.$t]."<br>";
	} */
	$atr = array();
	$table = $kategoria."_full";
	$sql = "INSERT INTO `$table` VALUES (NULL, '$id', ";
	for($t=1;$t<$_SESSION['licznik_kat'];$t++){
		$atr[] = $_POST['atr'.$t];
		$sql = $sql."'".$_POST['atr'.$t]."', ";
	}
	$sql = $sql."'".$_POST['atr'.$_SESSION['licznik_kat']]."')";
	mysqli_query($con,$sql);
	
	//------------------------------------------------------ OPIS_PRZEDMIOTU
	
	$n1 = $_POST['n1'];
	$o1 = $_POST['o1'];
	$n2 = $_POST['n2'];
	$o2 = $_POST['o2'];
	$n3 = $_POST['n3'];
	$o3 = $_POST['o3'];
	//echo $n1.$o1;
	//echo $n2.$o2;
	//echo $n3.$o3;
	$src1 = "img/".basename( $_FILES['zdj1']['name']);
	$query_opis1 = ("INSERT INTO opis_przedmiotu VALUES (NULL, '$id','$n1', '$o1', '$src1')");
	mysqli_query($con,$query_opis1);
	
	$src2 = "img/".basename( $_FILES['zdj2']['name']);
	$query_opis2 = ("INSERT INTO opis_przedmiotu VALUES (NULL, '$id','$n2', '$o2', '$src2')");
	mysqli_query($con,$query_opis2);
	
	$src3 = "img/".basename( $_FILES['zdj3']['name']);
	$query_opis3 = ("INSERT INTO opis_przedmiotu VALUES (NULL, '$id','$n3', '$o3', '$src3')");
	mysqli_query($con,$query_opis3);
	
	//------------------------------------------------------ ZDJECIA_PRZEDMIOTOW
	
	$query_zdjecie1 = ("INSERT INTO zdjecia_przedmiotow VALUES (NULL, '$id', '$src')");
	mysqli_query($con,$query_zdjecie1);
	
	$query_zdjecie2 = ("INSERT INTO zdjecia_przedmiotow VALUES (NULL, '$id', '$src1')");
	mysqli_query($con,$query_zdjecie2);
	
	$query_zdjecie3 = ("INSERT INTO zdjecia_przedmiotow VALUES (NULL, '$id', '$src2')");
	mysqli_query($con,$query_zdjecie3);
	
	$query_zdjecie4 = ("INSERT INTO zdjecia_przedmiotow VALUES (NULL, '$id', '$src3')");
	mysqli_query($con,$query_zdjecie4);
	
	//------------------------------------------------------ OBSLUGA DODAWANIA ZDJEC
	//------------------------------------------------------ PEWNIE SIE TO DA ZROBIC W FUNKCJI JAKIEJS ALE DODAJE SIE I TAK TYLKO 4 ZDJECIA MAX WIEC NIE PRZERABIAM
	//------------------------------------------------------ ZDJECIE GLOWNE
	
	$target_dir = "../lepsza/category/".$lokalizacja."/img/";
	$target_file = $target_dir . basename($_FILES['main_zdj']['name']);
	$uploadOk = 1;
	$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
	// Sprawdzenie czy to jest image
	$check = getimagesize($_FILES['main_zdj']['tmp_name']);
	if($check !== false) {
		echo "File is an image - " . $check['mime'] . ".";
		$uploadOk = 1;
	} else {
		echo "File is not an image.";
		$uploadOk = 0;
	}
	// sprawdz czy plik ma format JPG, JPEG, PNG, GIF
	if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"&& $imageFileType != "gif" ) {
		echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
		$uploadOk = 0;
	}
	//sprawdz czy juz jest taka fotka
	if (file_exists($target_file)) {
		echo "Sorry, file already exists.";
		$uploadOk = 0;
	}
	//jesli nie ma bledow to wysyla zdjecie
	if ($uploadOk == 0) {
		echo "Sorry, your file was not uploaded.";
	} else {
		if (move_uploaded_file($_FILES['main_zdj']['tmp_name'], $target_file)) {
			echo "The file ". basename( $_FILES['main_zdj']['name']). " has been uploaded.";
		} else {
			echo "Sorry, there was an error uploading your file.";
		}
	}
	
	//------------------------------------------------------ ZDJECIE DODATKOWE 1
	
	$target_file = $target_dir . basename($_FILES['zdj1']['name']);
	$uploadOk = 1;
	$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
	// Sprawdzenie czy to jest image
	$check = getimagesize($_FILES['zdj1']['tmp_name']);
	if($check !== false) {
		echo "File is an image - " . $check['mime'] . ".";
		$uploadOk = 1;
	} else {
		echo "File is not an image.";
		$uploadOk = 0;
	}
	// sprawdz czy plik ma format JPG, JPEG, PNG, GIF
	if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"&& $imageFileType != "gif" ) {
		echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
		$uploadOk = 0;
	}
	//sprawdz czy juz jest taka fotka
	if (file_exists($target_file)) {
		echo "Sorry, file already exists.";
		$uploadOk = 0;
	}
	//jesli nie ma bledow to wysyla zdjecie
	if ($uploadOk == 0) {
		echo "Sorry, your file was not uploaded.";
	} else {
		if (move_uploaded_file($_FILES['zdj1']['tmp_name'], $target_file)) {
			echo "The file ". basename( $_FILES['zdj1']['name']). " has been uploaded.";
		} else {
			echo "Sorry, there was an error uploading your file.";
		}
	}
	
	//------------------------------------------------------ ZDJECIE DODATKOWE 2
	
	$target_file = $target_dir . basename($_FILES['zdj2']['name']);
	$uploadOk = 1;
	$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
	// Sprawdzenie czy to jest image
	$check = getimagesize($_FILES['zdj2']['tmp_name']);
	if($check !== false) {
		echo "File is an image - " . $check['mime'] . ".";
		$uploadOk = 1;
	} else {
		echo "File is not an image.";
		$uploadOk = 0;
	}
	// sprawdz czy plik ma format JPG, JPEG, PNG, GIF
	if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"&& $imageFileType != "gif" ) {
		echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
		$uploadOk = 0;
	}
	//sprawdz czy juz jest taka fotka
	if (file_exists($target_file)) {
		echo "Sorry, file already exists.";
		$uploadOk = 0;
	}
	//jesli nie ma bledow to wysyla zdjecie
	if ($uploadOk == 0) {
		echo "Sorry, your file was not uploaded.";
	} else {
		if (move_uploaded_file($_FILES['zdj2']['tmp_name'], $target_file)) {
			echo "The file ". basename( $_FILES['zdj2']['name']). " has been uploaded.";
		} else {
			echo "Sorry, there was an error uploading your file.";
		}
	}
	
	//------------------------------------------------------ ZDJECIE DODATKOWE 3
	
	$target_file = $target_dir . basename($_FILES['zdj3']['name']);
	$uploadOk = 1;
	$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
	// Sprawdzenie czy to jest image
	$check = getimagesize($_FILES['zdj3']['tmp_name']);
	if($check !== false) {
		echo "File is an image - " . $check['mime'] . ".";
		$uploadOk = 1;
	} else {
		echo "File is not an image.";
		$uploadOk = 0;
	}
	// sprawdz czy plik ma format JPG, JPEG, PNG, GIF
	if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"&& $imageFileType != "gif" ) {
		echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
		$uploadOk = 0;
	}
	//sprawdz czy juz jest taka fotka
	if (file_exists($target_file)) {
		echo "Sorry, file already exists.";
		$uploadOk = 0;
	}
	//jesli nie ma bledow to wysyla zdjecie
	if ($uploadOk == 0) {
		echo "Sorry, your file was not uploaded.";
	} else {
		if (move_uploaded_file($_FILES['zdj3']['tmp_name'], $target_file)) {
			echo "The file ". basename( $_FILES['zdj3']['name']). " has been uploaded.";
		} else {
			echo "Sorry, there was an error uploading your file.";
		}
	}
	


?>
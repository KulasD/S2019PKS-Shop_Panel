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
	if(isset($_POST['parametr1'])) {$parametr1 = $_POST['parametr1']; } else {$parametr1 = '';};
	//echo $parametr1;
	if(isset($_POST['parametr2'])) {$parametr2 = $_POST['parametr2']; } else {$parametr2 = '';};
	//echo $parametr2;
	if(isset($_POST['parametr3'])) {$parametr3 = $_POST['parametr3']; } else {$parametr3 = '';};
	//echo $parametr3;
	$kategoria = $_SESSION['kat'];
	//echo $kategoria;
	$src = "img/".$kategoria."/".basename( $_FILES['main_zdj']['name']);
	
	$query_ogolne = ("INSERT INTO przedmioty_ogolne_informacje VALUES (NULL, '$nazwa','$pelna_nazwa', '$cena', '$sztuki', '0', '$src', '$parametr1', '$parametr2', '$parametr3', '0', '$kategoria')");
	mysqli_query($con,$query_ogolne);
	
	//------------------------------------------------------ KATEGORIA_FULL
	// Krótkie działanie. Specyfikacja_name (w produkty) pobiera się i ona ma 45 kolumn, czyli sesja licznik daje 45. Specyfikacja_full ma 46 kolumn, 1 to id, 2 to id specyfikacji z nazwami, 3 to id_produktu, i potem od s1 do s43. No wiec, dopisuje 3 rzeczy (czyli z 46 kolumn robi sie juz 43 więc trzeba odjąc od 45-2=43) i na dole robi sie twój for z art od art1 do art42, a niżej ifek który sprawdza czy jest ostatni czyli nr art43. Jeżeli jest to dopisze wartosc + ten nawias na koncu a jezeli nie ma to sam nawias. Dziala jbc testowane na akcesoria_komputerowe, tam jest 41, dopisane dwie i smiga, a potem usuniete
	$atr = array();
	$licznik = $_SESSION['licznik_kat']-2;
	$sql = "INSERT INTO specyfikacja_full VALUES (NULL,'".$_SESSION['id_specyfik']."', '$id', ";
	for($t=1;$t<$licznik;$t++){
		if(isset($_POST['atr'.$t])) {
		$sql = $sql."'".$_POST['atr'.$t]."', "; }
		else { $sql = $sql."'', ";}
	}
	if(isset($_POST['atr'.$licznik])) {$sql = $sql."'".$_POST['atr'.$licznik]."') ";} else {
		$sql = $sql."'')";
	}
	mysqli_query($con,$sql);
	unset($_SESSION['licznik_kat']);
	unset($_SESSION['id_specyfik']);
	//------------------------------------------------------ OPIS_PRZEDMIOTU
	$n1 = ''; $o1 = ''; $n2 =''; $o2 = '';$n3 =''; $o3 = '';
	$src1 = ''; $src2 = ''; $src3 = '';
	$n1 = $_POST['n1'];
	$o1 = $_POST['o1'];
	$n2 = $_POST['n2'];
	$o2 = $_POST['o2'];
	$n3 = $_POST['n3'];
	$o3 = $_POST['o3'];
	if($n1 == '' || $o1 == '') {$z1 = false;} else {
	$z1 = true;
	$src1 = "img/".$kategoria."/".basename( $_FILES['zdj1']['name']);
	$query_opis1 = ("INSERT INTO opis_przedmiotu VALUES (NULL, '$id','$n1', '$o1', '$src1')");
	mysqli_query($con,$query_opis1);}
	
	if($n2 == '' || $o2 == '') {$z2 = false;} else {
	$z2 = true;
	$src2 = "img/".$kategoria."/".basename( $_FILES['zdj2']['name']);
	$query_opis2 = ("INSERT INTO opis_przedmiotu VALUES (NULL, '$id','$n2', '$o2', '$src2')");
	mysqli_query($con,$query_opis2); }
	
	if($n3 == '' || $o3 == '') {$z3 = false;} else {
	$z3 = true;
	$src3 = "img/".$kategoria."/".basename( $_FILES['zdj3']['name']);
	$query_opis3 = ("INSERT INTO opis_przedmiotu VALUES (NULL, '$id','$n3', '$o3', '$src3')");
	mysqli_query($con,$query_opis3); }
	
	//------------------------------------------------------ ZDJECIA_PRZEDMIOTOW
	
	$query_zdjecie1 = ("INSERT INTO zdjecia_przedmiotow VALUES (NULL, '$id', '$src')");
	mysqli_query($con,$query_zdjecie1);
	if($src1 == '') {} else {
	$query_zdjecie2 = ("INSERT INTO zdjecia_przedmiotow VALUES (NULL, '$id', '$src1')");
	mysqli_query($con,$query_zdjecie2);}
	if($src2 == '') {} else {
	$query_zdjecie3 = ("INSERT INTO zdjecia_przedmiotow VALUES (NULL, '$id', '$src2')");
	mysqli_query($con,$query_zdjecie3);}
	if($src3 == '') {} else {
	$query_zdjecie4 = ("INSERT INTO zdjecia_przedmiotow VALUES (NULL, '$id', '$src3')");
	mysqli_query($con,$query_zdjecie4);}
	
	//------------------------------------------------------ OBSLUGA DODAWANIA ZDJEC
	//------------------------------------------------------ PEWNIE SIE TO DA ZROBIC W FUNKCJI JAKIEJS ALE DODAJE SIE I TAK TYLKO 4 ZDJECIA MAX WIEC NIE PRZERABIAM
	//------------------------------------------------------ ZDJECIE GLOWNE
	
	$target_dir = "../lepsza/category/produkty/img/".$kategoria."/";
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
	if($z1 == true) {
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
	}
	
	//------------------------------------------------------ ZDJECIE DODATKOWE 2
	if($z2 == true) {
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
	}
	//------------------------------------------------------ ZDJECIE DODATKOWE 3
	if($z3 == true) {
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
	}

	header("Location: dane_produkt.php?idp=".$id."");
	exit();
?>

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
	if(isset($_SESSION['produkt_id'])){
		$id = $_SESSION['produkt_id'];
		unset($_SESSION['produkt_id']);
	}
	
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
	if (isset($_FILES['main_zdj']['name']) && !empty( $_FILES['main_zdj']['name'] )){
		$src = "img/".$kategoria."/".basename( $_FILES['main_zdj']['name']);
		$z_main = true;
	}
	else {
		$src = $_SESSION['zdj_main'];
		$z_main = false;
	}

	$query_ogolne = ("UPDATE przedmioty_ogolne_informacje SET nazwa='$nazwa', pelna_nazwa='$pelna_nazwa', cena='$cena', sztuki='$sztuki', zdjecie='$src', parametr_1='$parametr1', parametr_2='$parametr2', parametr_3='$parametr3' WHERE id_produktu='$id'");
	mysqli_query($con,$query_ogolne);
	
	//------------------------------------------------------ KATEGORIA_FULL
	
	/* echo $_SESSION['licznik_kat']."<br>";
	
	for($t=1;$t<=$_SESSION['licznik_kat'];$t++){
		echo $_POST['atr'.$t]."<br>";
	} */
	
	if(isset($_SESSION['id_full'])){
		$full_id = $_SESSION['id_full'];
		unset($_SESSION['id_full']);
	}
	

	$table = $kategoria."_full";
	$sql = "UPDATE `$table` SET ";
	$query_atr = 	"SELECT `COLUMN_NAME` 
					FROM `INFORMATION_SCHEMA`.`COLUMNS` 
					WHERE `TABLE_NAME`='".$kategoria."_full' LIMIT 100 OFFSET 2;";
	$result_atr = mysqli_query($con,$query_atr);
	for($t=1;$t<$_SESSION['licznik_kat'];$t++){
		$r_atr = $result_atr->fetch_array(MYSQLI_ASSOC);
		$sql = $sql."`".$r_atr['COLUMN_NAME']."`='".$_POST['atr'.$t]."', ";
	}
	$r_atr = $result_atr->fetch_array(MYSQLI_ASSOC);
	$sql = $sql."`".$r_atr['COLUMN_NAME']."`='".$_POST['atr'.$_SESSION['licznik_kat']]."' WHERE id_full='$full_id'";
	mysqli_query($con,$sql);
	
	//------------------------------------------------------ OPIS_PRZEDMIOTU
	$n1 = ''; $o1 = ''; $n2 =''; $o2 = '';$n3 =''; $o3 = '';
	$src1 = ''; $src2 = ''; $src3 = '';
	$n1 = $_POST['n1'];
	$o1 = $_POST['o1'];
	$n2 = $_POST['n2'];
	$o2 = $_POST['o2'];
	$n3 = $_POST['n3'];
	$o3 = $_POST['o3'];
	//echo $n1.$o1;
	//echo $n2.$o2;
	//echo $n3.$o3;
	$query_opis_id = "SELECT * FROM opis_przedmiotu WHERE id_produktu='$id'";
	$result_opis_id = mysqli_query($con,$query_opis_id);
	$r_opis_id = $result_opis_id->fetch_array(MYSQLI_ASSOC);
	
	if($n1 == '' || $o1 == '') {$z1 = false;} 
	else {
		if (isset($_FILES['zdj1']['name']) && !empty( $_FILES['zdj1']['name'] )){
			$src1 = "img/".$kategoria."/".basename( $_FILES['zdj1']['name']);
			$z1 = true;
		}
		else {
			$src1 = $_SESSION['zdj1'];
			$z1 = false;
		}
		$query_opis1 = ("UPDATE opis_przedmiotu SET temat='$n1', opis='$o1', zdjecie='$src1' WHERE id_opis=".$r_opis_id['id_opis']."");
		mysqli_query($con,$query_opis1);
	}
	
	$r_opis_id = $result_opis_id->fetch_array(MYSQLI_ASSOC);
	
	if($n2 == '' || $o2 == '') {$z2 = false;} 
	else {
		if (isset($_FILES['zdj2']['name']) && !empty( $_FILES['zdj2']['name'] )){
			$src2 = "img/".$kategoria."/".basename( $_FILES['zdj2']['name']);
			$z2 = true;
		}
		else {
			$src2 = $_SESSION['zdj2'];
			$z2 = false;
		}
		$query_opis2 = ("UPDATE opis_przedmiotu SET temat='$n2', opis='$o2', zdjecie='$src2' WHERE id_opis=".$r_opis_id['id_opis']."");
		mysqli_query($con,$query_opis2);
	}
	
	$r_opis_id = $result_opis_id->fetch_array(MYSQLI_ASSOC);
	
	if($n3 == '' || $o3 == '') {$z3 = false;} 
	else {
		if (isset($_FILES['zdj3']['name']) && !empty( $_FILES['zdj3']['name'] )){
			$src3 = "img/".$kategoria."/".basename( $_FILES['zdj3']['name']);
			$z3 = true;
		}
		else {
			$src3 = $_SESSION['zdj3'];
			$z3 = false;
		}
		$query_opis3 = ("UPDATE opis_przedmiotu SET temat='$n3', opis='$o3', zdjecie='$src3' WHERE id_opis=".$r_opis_id['id_opis']."");
		mysqli_query($con,$query_opis3);
	}
	
	//------------------------------------------------------ ZDJECIA_PRZEDMIOTOW
	
	$query_zdj_id = "SELECT * FROM zdjecia_przedmiotow WHERE id_produktu='$id'";
	$result_zdj_id = mysqli_query($con,$query_zdj_id);
	$r_zdj_id = $result_zdj_id->fetch_array(MYSQLI_ASSOC);
	
	$query_zdjecie1 = ("UPDATE zdjecia_przedmiotow SET src='$src' WHERE zdjecie_id=".$r_zdj_id['zdjecie_id']."");
	mysqli_query($con,$query_zdjecie1);
	$r_zdj_id = $result_zdj_id->fetch_array(MYSQLI_ASSOC);
	if($src1 == '') {} else {
	$query_zdjecie2 = ("UPDATE zdjecia_przedmiotow SET src='$src1' WHERE zdjecie_id=".$r_zdj_id['zdjecie_id']."");
	mysqli_query($con,$query_zdjecie2);}
	$r_zdj_id = $result_zdj_id->fetch_array(MYSQLI_ASSOC);
	if($src2 == '') {} else {
	$query_zdjecie3 = ("UPDATE zdjecia_przedmiotow SET src='$src2' WHERE zdjecie_id=".$r_zdj_id['zdjecie_id']."");
	mysqli_query($con,$query_zdjecie3);}
	$r_zdj_id = $result_zdj_id->fetch_array(MYSQLI_ASSOC);
	if($src3 == '') {} else {
	$query_zdjecie4 = ("UPDATE zdjecia_przedmiotow SET src='$src3' WHERE zdjecie_id=".$r_zdj_id['zdjecie_id']."");
	mysqli_query($con,$query_zdjecie4);}
	
	
	//------------------------------------------------------ OBSLUGA DODAWANIA ZDJEC
	//------------------------------------------------------ PEWNIE SIE TO DA ZROBIC W FUNKCJI JAKIEJS ALE DODAJE SIE I TAK TYLKO 4 ZDJECIA MAX WIEC NIE PRZERABIAM
	//------------------------------------------------------ ZDJECIE GLOWNE
	
	if ($z_main){
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
	echo $id;
	header("Location: dane_produkt.php?idp=".$id."");
	exit();
	
?>

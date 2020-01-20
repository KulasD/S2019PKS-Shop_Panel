<?php

	session_start();
	
	if (!isset($_SESSION['zalogowany']))
	{
		header('Location: index.php');
		exit();
	}
	
?>

<?php 

	if ( isset( $_GET['id'] ) && !empty( $_GET['id'] ) )
	{
	$id_zamowienie = $_GET['id'];
	} else {
	header('Location: zamowienia_lista.php');exit();}
	$disabled = 'disabled';
	$adm_disabled = 'disabled';
	if($_SESSION['uprawnienia']=='administrator'){
		$adm_disabled = '';
	}
	$con = mysqli_connect("localhost","root","","user");
	mysqli_query($con, "SET CHARSET utf8");
	mysqli_query($con, "SET NAMES 'utf8' COLLATE 'utf8_polish_ci'");
	$conA = mysqli_connect("localhost","root","","administracja");
	mysqli_query($conA, "SET CHARSET utf8");
	mysqli_query($conA, "SET NAMES 'utf8' COLLATE 'utf8_polish_ci'");
	$query = "SELECT * FROM zamowienie_informacje WHERE id_zamowienie = '$id_zamowienie' ";
	$result = mysqli_query($con,$query);
	$zamowienie = array();
	$uzytkownik = array();
	$przedmioty = array();
	$pracownicy = array();
	$x = 0;
	$qu_pracownik = "SELECT * FROM kadra ORDER BY id ASC";
	$r_p= mysqli_query($conA,$qu_pracownik);
	while ($rp = $r_p->fetch_array(MYSQLI_ASSOC)) {
			$pracownicy[]=$rp;
	};
	$ile_ = $result ->num_rows;
	if($ile_ > 0) {

		while ($r = $result->fetch_array(MYSQLI_ASSOC)) {
			$id_zamowienie=$r['id_zamowienie'];
			$zamowienie[] = $r;
			if (($zamowienie[0]['status']=="W trakcie realizacji") || ($zamowienie[0]['status']=="Zamówienie gotowe do wysyłki") || ($zamowienie[0]['status']=="Zamówienie przekazane dostawcy")){
				$disabled = '';
			}
			$id_user=$r['id_user'];
			$id_pracownik_zamowienie = $r['id_pracownik'];
			if($id_pracownik_zamowienie  != $_SESSION['id'] && $_SESSION['id']  != '1') {
				header('Location: zamowienia_lista.php');exit();
			};
			$qu_u = "SELECT * FROM uzytkownicy WHERE id_user = '$id_user' ";
			$re_u = mysqli_query($con,$qu_u);
				while ($rr_u = $re_u->fetch_array(MYSQLI_ASSOC)) {
				$uzytkownik[] = $rr_u;
			}
			$qu = "SELECT * FROM zamowienie_przedmiot WHERE id_zamowienie = '$id_zamowienie' ";
			$re = mysqli_query($con,$qu);
			while ($rr = $re->fetch_array(MYSQLI_ASSOC)) {
				$przedmioty[$x][0] = $rr;
				$przed = mysqli_connect("localhost","root","","przedmioty");
				mysqli_query($przed, "SET CHARSET utf8");
				mysqli_query($przed, "SET NAMES 'utf8' COLLATE 'utf8_polish_ci'");	
				$id_produktu = $rr['id_produktu'];
				$q = "SELECT * FROM przedmioty_ogolne_informacje WHERE id_produktu = '$id_produktu' ";
				$res = mysqli_query($przed,$q);
				while ($rrr = $res->fetch_array(MYSQLI_ASSOC)) {
					$przedmioty[$x][1] = $rrr;
				}
				$x++;
			}
		}
	} else {
		header('Location: zamowienia_lista.php');
		exit();
	}
?>

<?php    
 if(isset($_POST["create_pdf"]))  {
	 $val =  $_POST['create_pdf'];
	 	$con = mysqli_connect("localhost","root","","user");
		mysqli_query($con, "SET CHARSET utf8");
		mysqli_query($con, "SET NAMES 'utf8' COLLATE 'utf8_polish_ci'");
		$output = '';
		$user_id = $uzytkownik[0]['id_user'];
		
		$imie = $uzytkownik[0]['name'];
		$nazwisko = $uzytkownik[0]['surname'];
		$miejscowosc = $uzytkownik[0]['miejscowosc'];
		$kod = $uzytkownik[0]['kod_pocztowy'];
		$adres = $uzytkownik[0]['adres'];
		$sex = $uzytkownik[0]['sex'];

		if($sex == "men") { $p = "Pan"; } else { $p = "Pani";};
		
		$data_z = $zamowienie[0]['data_zamowienia'];
		$rabat = $zamowienie[0]['rabat'];
		$cena_zamowienia = (float)$zamowienie[0]['cena_zamowienia'];
		$vat = (float)$zamowienie[0]['vat23'];

		$netto = $cena_zamowienia - $vat;

		if($rabat != "") {$rab = "Tak"; $rra = "Suma z dostawą i rabatem";} else { $rab = "Nie";$rra = "Suma z dostawą";};
			
		$nr_faktury = "$val$data_z$user_id";
		$query_x = "SELECT * FROM zamowienie_przedmiot WHERE id_zamowienie='$val'";
		$result_x = mysqli_query($con,$query_x);
		$x = 1;
		while($re = $result_x->fetch_array(MYSQLI_ASSOC)) {
			$id_produktu = $re['id_produktu'];
			$t = (float)$re['price_one_quan'] * (int)$re['quantity'];
			$t = number_format((float)$t, 2, '.', '');
			$pol = mysqli_connect("localhost","root","","przedmioty");
				mysqli_query($pol, "SET CHARSET utf8");
				mysqli_query($pol, "SET NAMES 'utf8' COLLATE 'utf8_polish_ci'");
				$getvalue="SELECT * FROM przedmioty_ogolne_informacje WHERE id_produktu='$id_produktu'";
				$rezul=mysqli_query($pol,$getvalue);
				
				while ($q = $rezul->fetch_array(MYSQLI_ASSOC)) {
					$pri = $re['price_one_quan'];
					$pri = number_format((float)$pri, 2, '.', '');
					$output .= '
					  <tr>
						<td width="30" align="left">'.$x.'</td>
						<td width="230" align="left">'.$q["pelna_nazwa"].'</td>
						<td width="60" align="center">'.$re["quantity"].'</td>
						<td width="60" align="right">'.$pri.'</td>
						<td width="60" align="right">23 %</td>
						<td width="60" align="right">'.$t.'</td>
					</tr>
                          ';  
					
				}
				$x++;
		}	
		$netto = number_format((float)$netto, 2, '.', '');
		$cena_zamowienia = number_format((float)$cena_zamowienia, 2, '.', '');
		$vat = number_format((float)$vat, 2, '.', '');
      require_once('tcpdf/tcpdf.php');  
	  ob_start();
      $obj_pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);  
      $obj_pdf->SetCreator(PDF_CREATOR);  
      $obj_pdf->SetTitle("Faktura Vat");  
      $obj_pdf->SetHeaderData('', '', PDF_HEADER_TITLE, PDF_HEADER_STRING);  
      $obj_pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));  
      $obj_pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));  
      $obj_pdf->SetDefaultMonospacedFont('dejavusans');  
      $obj_pdf->SetFooterMargin(PDF_MARGIN_FOOTER);  
      $obj_pdf->SetMargins(PDF_MARGIN_LEFT, '5', PDF_MARGIN_RIGHT);  
      $obj_pdf->setPrintHeader(false);  
      $obj_pdf->setPrintFooter(false);  
      $obj_pdf->SetAutoPageBreak(TRUE, 10);  
      $obj_pdf->SetFont('dejavusans', '', 12);  
      $obj_pdf->AddPage();  
$html = <<<EOF
<html>
<header>

<style>
	table {
		font-size: 9px;
	}
	  table.fri {
        font-size: 8pt;
        border: 1px solid black;
    }
	.logo {
		color: #0574FF; font-size: 40px;'
	}
	.x {
		font-size: 35px
	}
	.xx {
		font-size: 20px
	}
	.log {
		width:800px;
		text-align: left;
		background-color: red;
	}
	.fakt {
		width:350px;
		text-align: left;
		font-size: 30px;
		background-color: blue;
	}
	.tx { text-align: right !important;}
</style>
</header>
<body>




 <table  cellpadding="2" cellspacing="2">
 <tr>
  <td width="350" align="left"><span class="logo">KS</span><b class="x">-eshop</b></td>
  <td width="100" align="right"><b class="xx">Faktura</b></td>
 </tr>
</table>
 <table cellpadding="2" cellspacing="2">
 <tr>
  <td width="310" align="left">ks-eshop - adres firmy <br /> <br /><br /> $p $imie $nazwisko <br /> $adres <br /> $kod $miejscowosc<br /></td>
  <td width="100" align="left">Zamówienie z dnia:<br />  Numer zamówienia: <br /> Numer klienta:<br /> Numer Faktury:<br /></td>
  <td width="100" align="left">$data_z<br /> $val <br />$user_id <br /> $nr_faktury<br /></td>
 </tr>
</table>

<h3> Dziękujemy za złożone zamówienie </h3>
<br /> <br />
<table class="fri" cellpadding="2" cellspacing="2">
 <tr>
  <td width="30" align="left"><b>Nr.</b></td>
  <td width="230" align="left"><b>Nazwa towaru/usługi <br /> Numer artykułu</b></td>
  <td width="60" align="center"><b>Ilość (szt.)</b></td>
  <td width="60" align="right"><b>Cena jednostkowa brutto w PLN</b></td>
  <td width="60" align="right"><b>Stawka VAT(%) </b></td>
  <td width="60" align="right"><b>Wartość sprzedaży brutto w PLN</b></td>
 </tr>
</table>
<table class="fri" cellpadding="2" cellspacing="2">
 $output
</table>
<table class="fri" cellpadding="2" cellspacing="2">
 <tr>

  <td width="510" align="right"><b>Rabat: $rab </b></td>
 </tr>
</table>
<table class="fri" cellpadding="2" cellspacing="2">
 <tr>
  <td width="150" align="left"><b>$rra</b></td>
  <td width="358" align="right"><b>$cena_zamowienia zł</b></td>
 </tr>
</table>
<br /> <br /> <br />
<table class="fri" cellpadding="2" cellspacing="2">
 <tr>
  <td width="60" align="center"><b>Stawka VAT</b></td>
  <td width="60" align="center"><b>Netto PLN</b></td>
  <td width="60" align="center"><b>VAT PLN</b></td>
  <td width="60" align="center"><b>Brutto PLN</b></td>
 </tr>
</table>
<table class="fri" cellpadding="2" cellspacing="2">
  <tr>
  <td width="60" align="center">23 %</td>
  <td width="60" align="center">$netto</td>
  <td width="60" align="center">$vat</td>
  <td width="60" align="center">$cena_zamowienia</td>
 </tr>
</table>
<table class="fri" cellpadding="2" cellspacing="2">
   <tr>
  <td width="60" align="center">Razem</td>
  <td width="60" align="center">$netto</td>
  <td width="60" align="center">$vat</td>
  <td width="60" align="center">$cena_zamowienia</td>
 </tr>
</table>
EOF;
      $obj_pdf->writeHTML($html, true, false, true, false, '');
      $obj_pdf->Output('FakturaVat.pdf', 'D');  
 }
 ?>  

<!DOCTYPE HTML>
<html lang="pl">
<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<title>Panel administracyjny</title>
	<link rel="stylesheet" href="style.css" type="text/css" />
	<link href='http://fonts.googleapis.com/css?family=Lato:400,700&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
	<link href="css/fontello.css" rel="stylesheet" type="text/css" />
<script src="script.js"></script>
    </script>
</head>

<body>
	<div id="container">
		<div id="left_bar">
			<div id="top_left_bar">
				<div id="logo">
					<i class="icon-ravelry"></i>
					<span style="color: #0574FF">KS</span>-eshop
				</div>
				<div id="namer">
					<div id="user_icon">
						<i class="icon-user-circle"></i>
						<?php echo $_SESSION['login'];?>
					</div>
					<div id="log_out">
						<a href="logout.php"><i class="icon-logout"></i></a>
					</div>
					<div style="clear:both;"></div>
				</div>
				<?php
					//echo "Witaj ".$_SESSION['imie'].'! [ <a href="logout.php">Wyloguj się!</a> ]<br />';
					//echo "Jesteś zalogowany jako: ".$_SESSION['uprawnienia'];
				?>
			</div>
			<?php include('nav.php'); ?>
		</div>
		<div id="page">
			<div id="search_inputs">
				<?php include('search_bar.php'); ?>
			</div>
			<div id="main_content">
				<div id="panel_admin_border">
					<div id="panel_admin">
						<div class="flex_box_space">
							<div>
								Zamówienie nr <?php echo "".$id_zamowienie."";?>
							</div>
							<?php 
							$status_zaplaty = "".$zamowienie[0]['status_zaplaty']."";
							if($status_zaplaty == "Zapłacono") {
								echo "<div><button class='zaplataB'>Zapłacono</button></div>";
							} else {echo "<div><button class='zaplataBN'>Niezapłacono</button></div>";}
							?>
						</div>
					</div>
					<div style="clear:both;"></div>
				</div>
				<div class="half_width">
					<span class="info_span">Dane podstawowe</span>
					<div class="bordered_div_no_padding">
					<?php 
					$data_z = "".$zamowienie[0]['data_zamowienia']."";
					$dostawa  = "".$zamowienie[0]['dostawa']."";
					$dostawa_ = explode(",", $dostawa);
					$cena_zamowienia = "".$zamowienie[0]['cena_zamowienia']."";
					$cena_zamowienia = number_format((float)$cena_zamowienia, 2, '.', '');
					if($dostawa_[1] == '') {$dostawa_[1] = "0";};
					?>
						<div class="row"><div class="half_row">Data zamówienia:</div>				<div class="half_row_right"><span id="data"><?php echo "".$data_z."";?></span></div></div>
						
						<div class="row"><div class="half_row">Wartość zamówienia:</div>			<div class="half_row_right"><span id="wartosc"><?php echo "".$cena_zamowienia."";?> zł</span></div></div>
						
						<div class="row"><div class="half_row">Sposób płatności:</div>				<div class="half_row_right"><span id="platnosc"><?php echo "".$zamowienie[0]['platnosc']."";?></span></div></div>
						
						<div class="row"><div class="half_row">Sposób dostawy:</div>				<div class="half_row_right"><span id="dostawa"><?php echo "".$dostawa_[0]."";?></span></div></div>
						
						<div class="row"><div class="half_row">Koszt dostawy:</div>					<div class="half_row_right"><span id="koszt_dostawy"><?php echo "".$dostawa_[1]."";?> zł</span></div></div>
						
						<div class="row"><div class="half_row">Aktualny status zamówienia:</div>	<div class="half_row_right"><select <?php echo $disabled; ?> class="tx" id="status"><?php 
						
						//$table = ["W trakcie realizacji","Zamówienie gotowe do wysyłki","Zamówienie przekazane dostawcy","Zamówienie zrealizowane","Zamówienie zrealizowane (zwrot w toku)","Zamówienie zrealizowane po zwrocie","Zamówienie zrealizowane (reklamacja w toku)","Zamówienie zrealizowane po reklamacji","Zamówienie anulowane"];
						$table = ["W trakcie realizacji","Zamówienie gotowe do wysyłki","Zamówienie przekazane dostawcy","Zamówienie gotowe do odbioru","Zamówienie zrealizowane","Zamówienie anulowane"];
						for($a=0;$a<count($table);$a++)
						{
							$sta = "".$zamowienie[0]['status']."";
							if($sta == $table[$a]) {
								echo "<option selected value='".$sta."'>".$sta."</option> ";
							} else {
								echo "<option value='".$table[$a]."'>".$table[$a]."</option> ";
							}
						}
						?>
						
						</select></div></div>
						
						<div class="row"><div class="half_row">Opiekun zamówienia:</div>		<div class="half_row_right"><select <?php echo $disabled; ?> <?php echo $adm_disabled; ?> class="tx" id="opiekun"><?php
						
						if($_SESSION['id'] == '1') { 
						for($s=0;$s<count($pracownicy);$s++)
							{
								$pracownik = "".$pracownicy[$s]['id']."";
								if($pracownik == $id_pracownik_zamowienie) 
								{
									echo "<option selected value='".$pracownicy[$s]['id']."'>".$pracownicy[$s]['login']."</option>";
								} else {
									echo "<option value='".$pracownicy[$s]['id']."'>".$pracownicy[$s]['login']."</option>";
								}
							}
						} else {
							for($s=0;$s<count($pracownicy);$s++)
								{
									$pracownik = "".$pracownicy[$s]['id']."";
									if($pracownik == $id_pracownik_zamowienie) 
									{
										echo "<option selected value='".$pracownicy[$s]['id']."'>".$pracownicy[$s]['login']."</option>";
									}
								}
						}
						
						?></select></div></div>
						
						<div class="row"><div class="half_row">Termin dostawy:</div>			<div class="half_row_right"><input <?php echo $disabled; ?> class="tx" type="text" id="termin" value="<?php echo "".$zamowienie[0]['szacowana_data_dostawy']."";?>"/></div></div>
						
						<div class="row"><div class="half_row">Numer paczki:</div>				<div class="half_row_right"><input <?php echo $disabled; ?> class="tx" type="text" id="nr_paczki"value="<?php echo "".$zamowienie[0]['nr_paczki']."";?>"/></div></div>
						
						<div class="row"><div class="half_row">Waga przesyłki:</div>			<div class="half_row_right"><input <?php echo $disabled; ?> class="tx" type="text" id="waga_paczki"value="<?php echo "".$zamowienie[0]['waga_paczki']."";?>"/></div></div>
						
					</div>
				</div>
				
						<?php 
						$faktura  = "".$zamowienie[0]['faktura']."";
						$klient = "Klient INDYWIDUALNY:";
						if($faktura != '') {
							$faktura_ = explode(",", $faktura); $fa = true;
							if(strlen($faktura_[1]) == 10)
							{
								$nazwa_p = "".$faktura_[0]."";
								$nip_p = "".$faktura_[1]."";
								$klient = "Klient FIRMA:";
							} else {
								$nazwa_p = "".$faktura_[0]." ".$faktura_[1]."";
								$nip_p = "";
								$klient = "Klient INDYWIDUALNY:";
							}
						} else {
							for($f=0;$f<5;$f++) {$faktura_[$f] = '';} $fa=false;
						};
						$dane  = "".$zamowienie[0]['dane_odbiorcy']."";
						$dane_ = explode(",", $dane);
						?>
						
				<div class="half_width">
					<span class="info_span">Dane klienta</span>
					<div class="bordered_div_no_padding">
						<div class="row"><div class="half_row"><?php echo"".$klient."";?></div>								<div class="half_row_right"><span id="klient"><b>Nick: </b><?php echo "".$uzytkownik[0]['nick'].",  <b>Imię i nazwisko: </b>".$uzytkownik[0]['name']." ".$uzytkownik[0]['surname']."";?></span></div></div>
						<?php 
						$adres  = "".$zamowienie[0]['adres']."";
						$adres_ = explode(",", $adres);
						?>
						<div class="row" style="border:0px"><div class="half_row">Dane do dostawy:</div>	<div class="half_row_right"><input <?php echo $disabled; ?> class="tx" type="text" name="imienazwisko" value="<?php echo "".$adres_[0]." ".$adres_[1]."";?>"/></div></div>
						
						<div class="row" style="border:0px"><div class="half_row"></div>					<div class="half_row_right"><input <?php echo $disabled; ?> class="tx" type="text" name="telefon" value="<?php echo "".$adres_[6]."";?>"/></div></div>
						
						<div class="row" style="border:0px"><div class="half_row"></div>					<div class="half_row_right"><input <?php echo $disabled; ?> class="tx" type="text" name="adres" value="<?php echo "".$adres_[3]."";?>"/></div></div>
						
						<div class="row"><div class="half_row"></div>										<div class="half_row_right"><input <?php echo $disabled; ?> class="tx" style="width:29%; margin-right:1%;" type="text" name="kod_pocztowy" value="<?php echo "".$adres_[4]."";?>"/><input <?php echo $disabled; ?> class="tx" style="width:70%" type="text" name="miejscowosc" value="<?php echo "".$adres_[5]."";?>"/></div></div>
						

						<div class="row" style="border:0px"><div class="half_row">Dane do faktury:</div>	<div class="half_row_right"><input <?php echo $disabled; ?> class="tx" type="text" name="faktura_imie" value="<?php echo "".$nazwa_p."";?>" /></div></div>
						
						<div class="row" style="border:0px"><div class="half_row"></div>					<div class="half_row_right"><input <?php echo $disabled; ?> class="tx" type="text" name="faktura_nazwa_adres" value="<?php echo "".$faktura_[2]."";?>"/></div></div>
						
						<div class="row" style="border:0px"><div class="half_row"></div>										<div class="half_row_right"><input <?php echo $disabled; ?> class="tx" style="width:29%; margin-right:1%;" type="text" name="faktura_kod_pocztowy" value="<?php echo "".$faktura_[3]."";?>"/><input <?php echo $disabled; ?> class="tx" style="width:70%" type="text" name="faktura_miejscowosc" value="<?php echo "".$faktura_[4]."";?>"/></div></div>
						
						<div class="row"><div class="half_row"></div>										<div class="half_row_right">NIP:<input <?php echo $disabled; ?> class="tx" style="width:70%; margin-left:5px;" type="text" name="faktura_nip" value="<?php echo "".$nip_p."";?>"/></div></div>
						
						<div class="row" style="border:0px"><div class="half_row">Kontakt:</div>			<div class="half_row_right kontakt"><div class="kontakt_h_l">Telefon:</div><input <?php echo $disabled; ?> class="tx" style="width:60%;" type="text" name="telefon" value="<?php echo "".$dane_[2]."";?>"/></div></div>
						
						<div class="row"><div class="half_row"></div>										<div class="half_row_right kontakt"><div class="kontakt_h_l">E-mail:</div><input <?php echo $disabled; ?> class="tx" style="width:60%;" type="text" name="email"  value="<?php echo "".$dane_[3]."";?>"/></div></div>
						
						<div class="row"><div class="half_row">Wybrany dokument:</div>						<div class="half_row_right"><input <?php echo $disabled; ?> type="radio" value="paragon" name="dokument" <?php if($fa == false) {echo "checked";}?>>paragon <input <?php echo $disabled; ?> type="radio" value="faktura" name="dokument" <?php if($fa == true) {echo "checked";}?>>faktura </div></div>
						
						<?php 
						$rabat =  "".$zamowienie[0]['rabat']."";
						if($rabat != '') {
							$rrab = true;
							$quer = "SELECT * FROM kod_rabatowy WHERE kod='$rabat' ";
							$resu = mysqli_query($con,$quer);
							while ($r = $resu->fetch_array(MYSQLI_ASSOC)) {
								$procent = $r['rabat'];
							}
						} else {$procent = 'Brak rabatu'; $rrab = false;};
						?>
						<div class="row"><div class="half_row">Naliczony rabat [%]:</div>						<div class="half_row_right"><span id="rabat"><?php echo "".$procent."";?></span></div></div>
						
						<div class="row"><div class="half_row">Komentarz klienta:</div>						<div class="half_row_right"><span id="komentarz_klienta"><?php echo "".$zamowienie[0]['info_sprzedawca']."";?></span></div></div>
						<!--
						<div class="row" style="border:0px;"><div class="half_row">Komentarz wysyłany do klienta:</div>			<div class="half_row_right"><textarea class="areatx tx" rows="4" id="komentarz_pracownika"><?php //echo "".$zamowienie[0]['komentarz_pracownik']."";?></textarea></div></div>
						<div class="flex_box_space" style="border:0px; margin-bottom:10px; margin-right:10px;">
							<div></div>
							<div><a href='#'><button type="button" class="button_green">Wyślij</button></a></div>
						</div>
						-->
					</div>
				</div>
				<div style="clear:both;"></div>
					<div class='center_holder_no_padding' style='min-height:100px; position:relative;'>
						<div class="iwtbic flex_box">
							<button <?php echo $disabled; ?> type="button" class="button" onclick="save('<?php echo "".$id_zamowienie.""; ?>','<?php echo "".$status_zaplaty.""; ?>')">Zapisz zmiany</button>
							<form method="post">
								<button type="submit" class="button_green" name="create_pdf" value="<?php echo "".$id_zamowienie.""; ?>">Faktura</button>
							</form>
						</div>
					</div>
					<div id="produkty_start">
						<div class="bordered_div_no_padding">
							<div class="row">
								<div class="hru1">
									LP
								</div>	
								<div class="hru2">
									ZDJĘCIE
								</div> 	
								<div class="hru3">
									NAZWA
								</div>	
								<div class="hru4">
									ILOŚĆ
								</div>	
								<div class="hru5">
									CENA JEDN.
								</div>	
								<div class="hru6">
									WARTOŚĆ
								</div>
							</div>
							<?php 
							$h=0;
							$suma_p = 0;
							$dostawa_c =$dostawa_[1];
							$dostawa_c = number_format((float)$dostawa_c, 2, '.', '');
							for($t=0;$t<count($przedmioty);$t++)
							{
								$src = "".$przedmioty[$t][1]['zdjecie']."";
								$nazwa = "".$przedmioty[$t][1]['pelna_nazwa']."";
								$ilosc = "".$przedmioty[$t][0]['quantity']."";
								$cena = "".$przedmioty[$t][0]['price_one_quan']."";
								$sum = (int)$ilosc * (int)$cena;
								$sum = number_format((float)$sum, 2, '.', '');
								$suma_p = $suma_p + $sum;
								$suma_ = number_format((float)$suma_p, 2, '.', '');
							echo "<div class='row'>
								<div class='hru1'>".$h."</div>	<div class='hru2'><img src='../kseshop/category/produkty/".$src."'/></div> 	<div class='hru3'>".$nazwa."</div>	<div class='hru4'><span >".$ilosc."</span></div>	<div class='hru5'><span >".$cena." zł</span></div>	<div class='hru6'><span >".$sum." zł</span></div>
							</div>";
							$h++;
							}
							?>
							<div class="row">
								<div class="hr2">Wartość produktów:				</div><div class="hr3"><span id="wartosc"><?php echo "".$suma_p.""?> zł</span></div>
							</div>
							<div class="row">
								<div class="hr2">Koszt dostawy:				</div><div class="hr3"><span id="koszt_dostawy"><?php echo "".$dostawa_c."";?> zł</span></div>
							</div>
							<?php 
							$suma = (int)$dostawa + $suma_p;
							$vat = "".$zamowienie[0]['vat23']."";
							$vat = number_format((float)$vat, 2, '.', '');
							if($rrab == true) {
								$suma_rabat = $suma * ((int)$procent * 0.01);
								$suma_rabat = number_format((float)$suma_rabat, 2, '.', '');
								echo"<div class='row'>
								<div class='hr2'>Rabat				</div><div class='hr3'><span id='rabat'>".$suma_rabat." zł</span></div>
							</div>";}
							?>
							<div class="row">
								<div class="hr2">VAT:				</div><div class="hr3"><span id="VAT"><?php echo "".$vat."";?> zł</span></div>
							</div>
							<div class="row">
								<div class="hr2">Razem:				</div><div class="hr3"><span id="do_zaplaty"><?php echo "".$cena_zamowienia."";?> zł</span></div>
							</div>
						</div>
					</div>
			</div>
		</div>
		<div style="clear:both;"></div>
	</div>
<script src="http://code.jquery.com/jquery-1.12.4.js"></script>
</body>
</html>

<?php

	session_start();
	
	if (!isset($_SESSION['zalogowany']))
	{
		header('Location: index.php');
		exit();
	}
	
?>
<?php
	$con = mysqli_connect("localhost","root","","user");
	mysqli_query($con, "SET CHARSET utf8");
	mysqli_query($con, "SET NAMES 'utf8' COLLATE 'utf8_polish_ci'");
	$query = "SELECT * FROM zamowienie_informacje WHERE status NOT LIKE 'zamówienie zrealizowane%' AND status NOT LIKE 'zamówienie anulowane' ORDER BY id_zamowienie DESC ";
	$result = mysqli_query($con,$query);













// ZABLOKOWAC PRZEJSCIE DO EDYCJI GDY ZAMOWIENIE ZOSTALO ZREALIZOWANE!
// ZROBIONE W $query -> SELECT wyswietla tylko te zamowienia ktore zostaly zakonczone
// JESLI UZYTKOWNIK CHCE WYSWIETLIC ZAMOWIENIE KTORE ZOSTALO JUZ ZAMKNIETE TO MOZE UZYC WYSZUKIWARKI









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
						Zamówienia
					</div>
				</div>
					<div id="produkty_start">
						<div class="bordered_div_no_padding">
							<div class="row">
								<div class="hr_z1">NUMER I STATUS ZAMÓWIENIA</div>	<div class="hr_z2">DATA</div> 	<div class="hr_z3">KLIENT</div>	<div class="hr_z4">PRODUKTY</div>	<div class="hr_z5">WARTOŚĆ</div>	<div class="hr_z6">INFORMACJE DODATKOWE</div><div class="hr_z7">DZIAŁANIA</div>
							</div>				
							<?php
									while ($r = $result->fetch_array(MYSQLI_ASSOC)) {
										$id_zamowienie=$r['id_zamowienie'];
										$data_z = $r['data_zamowienia'];
										$status = $r['status'];
										$status_zaplaty = $r['status_zaplaty'];
										$id_pracownik = $r['id_pracownik'];
										if($id_pracownik == '0') {$color = '#BBBBBB';} else {$color = '';};
									if($status == 'Zamówienie zrealizowane' || $status == 'Zamówienie zrealizowane po zwrocie' || $status == 'Zamówienie zrealizowane po reklamacji') {
										$z = "color: #04A1EE !important";
									} else if ($status == 'W trakcie realizacji' || $status == 'Zamówienie zrealizowane (zwrot w toku)' || $status == 'Zamówienie zrealizowane (reklamacja w toku)' ||$status == 'Zamówienie gotowe do wysyłki' || $status == 'Zamówienie przekazane dostawcy') {
										$z = "color: gray !important";
									} else if($status == 'Zamówienie anulowane') {
										$z = "color: #CC0000 !important";
									}
										else if($status == 'W trakcie realizacji') {
										$z = "color: #CC0000 !important";
									}
										echo "<div class='row' style='background-color:".$color."';>
								<div class='hr_z1'>
									<span id='id_1'>Nr. ".$id_zamowienie."</span>
									<div>";
										if($status_zaplaty == "Zapłacono") {echo "<button class='zaplataB zbnp' >Zapłacono</button>";} else {echo "<button class='zaplataBN zbnp' >Niezapłacono</button>"; } 
									echo "</div>
									<span id='status_1' style='".$z."'>".$r['status']."</span>
								</div>	
								<div class='hr_z2'>".$data_z."</div>";
								
								$id_user=$r['id_user'];
								$qu_u = "SELECT * FROM uzytkownicy WHERE id_user = '$id_user' ";
								$re_u = mysqli_query($con,$qu_u);
								while ($rr_u = $re_u->fetch_array(MYSQLI_ASSOC)) {
										$name = $rr_u['name'];	
										$surname = $rr_u['surname'];	
								}
								echo "
								<div class='hr_z3'>".$name." ".$surname."</div>	
								<div class='hr_z4'>";
								$qu = "SELECT * FROM zamowienie_przedmiot WHERE id_zamowienie = '$id_zamowienie' ";
										$re = mysqli_query($con,$qu);
										while ($rr = $re->fetch_array(MYSQLI_ASSOC)) {
											$przed = mysqli_connect("localhost","root","","przedmioty");
											mysqli_query($przed, "SET CHARSET utf8");
											mysqli_query($przed, "SET NAMES 'utf8' COLLATE 'utf8_polish_ci'");	
											$id_produktu = $rr['id_produktu'];
											$q = "SELECT * FROM przedmioty_ogolne_informacje WHERE id_produktu = '$id_produktu' ";
											$res = mysqli_query($przed,$q);
											while ($rrr = $res->fetch_array(MYSQLI_ASSOC)) {
												$src = $rrr['zdjecie'];
												echo "<div class='flex_box'>
														<div class='f_z'>
														<img src='../lepsza/category/produkty/".$src."'/>
														</div>
														<div id='produkt_1' class='n_z'>
														".$rrr['pelna_nazwa']."
														</div>
														</div>";
											}
										}
									$cena = (int)$r['cena_zamowienia'];
									$cena = number_format((float)$cena, 2, '.', '');
									echo "
								</div>
								<div class='hr_z5'>
									".$cena." zł
								</div>	
								<div class='hr_z6'>
									<div id='dostawa'>".$r['dostawa']." zł</div>
									<div id='platnosc'>".$r['platnosc']."</div>";
									if($r['faktura'] != '') { 
									echo "<div id='dokument'>Dokument sprzedaży: faktura</div>"; } else {
										echo "<div id='dokument'>Dokument sprzedaży: paragon</div>";
									}
									echo "
								</div>
								<div class='hr_z7'>
									<div><button type='button' class='button' onclick='go(".$id_zamowienie.")'>EDYTUJ</button></div>";
								
								echo "
								</div>
							</div>";

									}

							?>
						</div>
					</div>
			</div>
		</div>
		<div style="clear:both;"></div>
	</div>
<script src="http://code.jquery.com/jquery-1.12.4.js"></script>
<script type="text/javascript" src="script.js"></script>
<script type="text/javascript">
/* function go(nr)
{
	$.ajax({
		url: 'select_p.php',
		type: 'POST',
		dataType: 'json', 
		data: {n:nr},
		success: function(data) {
			if(data == "Ok") {window.location.href = "dane_zamowienie.php?id="+nr; } else {alert("Inny pracownik już zajmuje się tym zamówieniem"); }
		}
	});	
} */
</script>
</body>
</html>

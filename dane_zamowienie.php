<?php

	session_start();
	
	if (!isset($_SESSION['zalogowany']))
	{
		header('Location: index.php');
		exit();
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
			<div id="nav">
				<div class="nav_border"><div class="nav"><a href="main_page.php" class="nav_link">start</a></div></div>
				<div class="nav_border"><div class="nav"><a href="#" class="nav_link">sprzedaż</a></div></div>
				<div class="nav_border"><div class="nav"><a href="#" class="nav_link">asortyment</a></div></div>
				<div class="nav_border"><div class="nav"><a href="#" class="nav_link">narzędzia</a></div></div>
			</div>
		</div>
		<div id="page">
			<div id="search_inputs">
				<input class="search_input" type="search" name="search_product" placeholder="szukaj produktu" onfocus="this.placeholder=''" onblur="this.placeholder='szukaj produktu'" />
				<input class="search_button" type="submit" value="&#xe801" />
				<input class="search_input" type="search" name="search_req" placeholder="szukaj zamówienia" onfocus="this.placeholder=''" onblur="this.placeholder='szukaj zamówienia'" />
				<input class="search_button" type="submit" value="&#xe801" />
				<input class="search_input" type="search" name="search_user" placeholder="szukaj klienta" onfocus="this.placeholder=''" onblur="this.placeholder='szukaj klienta'" />
				<input class="search_button" type="submit" value="&#xe801" />
			</div>
			<div id="main_content">
				<div id="panel_admin_border">
					<div id="panel_admin">
						Zamówienie **/****
					</div>
				</div>
				<div class="half_width">
					<span class="info_span">Dane podstawowe</span>
					<div class="bordered_div_no_padding">
						<div class="row"><div class="half_row">Data zamówienia:</div>				<div class="half_row_right"><span id="data">Data</span></div></div>
						
						<div class="row"><div class="half_row">Wartość zamówienia:</div>			<div class="half_row_right"><span id="wartosc">Wartość</span></div></div>
						
						<div class="row"><div class="half_row">Sposób płatności:</div>				<div class="half_row_right"><select class="tx" id="platnosc"></select></div></div>
						
						<div class="row"><div class="half_row">Sposób dostawy:</div>				<div class="half_row_right"><select class="tx" id="dostawa"></select></div></div>
						
						<div class="row"><div class="half_row">Koszt dostawy:</div>					<div class="half_row_right"><span id="koszt_dostawy">Koszt dostawy</span></div></div>
						
						<div class="row"><div class="half_row">Aktualny status zamówienia:</div>	<div class="half_row_right"><span id="status">Status</span></div></div>
						
						<div class="row"><div class="half_row">Opiekun zamówienia:</div>		<div class="half_row_right"><select class="tx" id="opiekun"></select></div></div>
						
						<div class="row"><div class="half_row">Termin dostawy:</div>			<div class="half_row_right"><input class="tx" type="text" name="termin"/></div></div>
						
						<div class="row"><div class="half_row">Numer paczki:</div>				<div class="half_row_right"><input class="tx" type="text" name="nr_paczki"/></div></div>
						
						<div class="row"><div class="half_row">Waga przesyłki:</div>			<div class="half_row_right"><input class="tx" type="text" name="waga_paczki"/></div></div>
						
					</div>
				</div>
				<div class="half_width">
					<span class="info_span">Dane klienta</span>
					<div class="bordered_div_no_padding">
						<div class="row"><div class="half_row">Klient:</div>								<div class="half_row_right"><span id="klient">Klient_nick</span></div></div>
						
						<div class="row" style="border:0px"><div class="half_row">Dane do dostawy:</div>	<div class="half_row_right"><input class="tx" type="text" name="ulica"/></div></div>
						
						<div class="row" style="border:0px"><div class="half_row"></div>					<div class="half_row_right"><input class="tx" type="text" name="nr_domu"/></div></div>
						
						<div class="row"><div class="half_row"></div>										<div class="half_row_right"><input class="tx" style="width:29%; margin-right:1%;" type="text" name="kod_pocztowy"/><input class="tx" style="width:70%" type="text" name="miejscowosc"/></div></div>
						
						<div class="row" style="border:0px"><div class="half_row">Dane do faktury:</div>	<div class="half_row_right"><input class="tx" type="text" name="faktura_ulica"/></div></div>
						
						<div class="row" style="border:0px"><div class="half_row"></div>					<div class="half_row_right"><input class="tx" type="text" name="faktura_nr_domu"/></div></div>
						
						<div class="row" style="border:0px"><div class="half_row"></div>										<div class="half_row_right"><input class="tx" style="width:29%; margin-right:1%;" type="text" name="faktura_kod_pocztowy"/><input class="tx" style="width:70%" type="text" name="faktura_miejscowosc"/></div></div>
						
						<div class="row"><div class="half_row"></div>										<div class="half_row_right">NIP:<input class="tx" style="width:70%; margin-left:5px;" type="text" name="faktura_nip"/></div></div>
						
						<div class="row" style="border:0px"><div class="half_row">Kontakt:</div>			<div class="half_row_right kontakt"><div class="kontakt_h_l">Telefon:</div><input class="tx" style="width:60%;" type="text" name="telefon"/></div></div>
						
						<div class="row"><div class="half_row"></div>										<div class="half_row_right kontakt"><div class="kontakt_h_l">E-mail:</div><input class="tx" style="width:60%;" type="text" name="email"/></div></div>
						
						<div class="row"><div class="half_row">Wybrany dokument:</div>						<div class="half_row_right"><input type="radio" value="paragon" name="dokument">paragon <input type="radio" value="faktura" name="dokument" checked>faktura </div></div>
						
						<div class="row"><div class="half_row">Zapłacono:</div>								<div class="half_row_right"><input class="tx" style="width:30%;" type="number" name="zaplacono"/></div></div>
						
						<div class="row"><div class="half_row">Naliczony rabat:</div>						<div class="half_row_right"><span id="rabat">[rabat]</span></div></div>
						
						<div class="row"><div class="half_row">Komentarz klienta:</div>						<div class="half_row_right"><span id="komentarz_klienta">[komentarz klienta]</span></div></div>
						
						<div class="row"><div class="half_row">Komentarz wysyłany do klienta:</div>			<div class="half_row_right"><textarea class="areatx tx" rows="4"></textarea></div></div>
						
					</div>
				</div>
				<div style="clear:both;"></div>
					<div class="center_holder">
						<button type="button" class="button">Zapisz zmiany</button>
					</div>
					<div id="produkty_start">
						<div class="bordered_div_no_padding">
							<div class="row">
								<div class="hr1">LP</div>	<div class="hr2">ZDJĘCIE</div> 	<div class="hr3">NAZWA</div>	<div class="hr4">ILOŚĆ</div>	<div class="hr5">WARTOŚĆ</div>
							</div>
							<div class="row">
								<div class="hr1">1</div>	<div class="hr2"><img src="./img/oops.png"/></div> 	<div class="hr3">Gostek który strzela się w łeb ! HIT ! PROC ĆWIERĆ RDZENIA !</div>	<div class="hr4"><input class="tx" style="width:100%;" type="number" name="cena1"/></div>	<div class="hr5"><span id="wartosc1">100zł</span></div>
							</div>
							<div class="row">
								<div class="hr1">2</div>	<div class="hr2"><img src="./img/oops.png"/></div> 	<div class="hr3">Gostek który strzela się w łeb ! HIT ! PROC PÓŁ RDZENIA !</div>	<div class="hr4"><input class="tx" style="width:100%;" type="number" name="cena2"/></div>	<div class="hr5"><span id="wartosc2">1000zł</span></div>
							</div>
							<div class="row">
								<div class="hr2">Wartość produktów:				</div><div class="hr3"><span id="wartosc">40000zł</span></div>
							</div>
							<div class="row">
								<div class="hr2">Koszt dostawy:				</div><div class="hr3"><span id="koszt_dostawy">40zł</span></div>
							</div>
							<div class="row">
								<div class="hr2">Razem:				</div><div class="hr3"><span id="do_zaplaty">40040zł</span></div>
							</div>
						</div>
					</div>
			</div>
		</div>
		<div style="clear:both;"></div>
	</div>
</body>
</html>
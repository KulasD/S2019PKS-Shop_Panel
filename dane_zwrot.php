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
						Zwrot **/****
					</div>
				</div>
				<div class="half_width">
					<span class="info_span">Dane zwracającego</span>
					<div class="bordered_div_no_padding">
						<div class="row">
							<div class="half_row">
								Imię i nazwisko:
							</div>				
							<div class="half_row_right">
								<span id="imie_i_nazwisko">aaaa</span>
							</div>
						</div>
						<div class="row">
							<div class="half_row">
								Dane adresowe:
							</div>				
							<div class="half_row_right">
								<div class="flex-box">
									<span id="ul" class="one_line_span">
										ul. Blaaadsdasa 202
									</span>
									<span id="kod">
										30-100
									</span>
									<span id="miejscowosc">
										aaaa
									</span>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="half_row">
								Dane kontaktowe:
							</div>				
							<div class="half_row_right">
								<div class="flex-box">
									<span id="tel" class="one_line_span">
										600 600 600
									</span>
									<span id="email">
										to_jest@email.org
									</span>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="half_row">
								ID użytkownika:
							</div>				
							<div class="half_row_right">
								<span id="id_usera">
									ID
								</span>
							</div>
						</div>
						
					</div>
					<span class="info_span" style="margin-top:10px;">Dane zgłoszenia</span>
					<div class="bordered_div_no_padding">
						<div class="row">
							<div class="half_row">
								Data zgłoszenia zwrotu:
							</div>				
							<div class="half_row_right">
								<span id="data_zwrotu">DATA</span>
							</div>
						</div>
						<div class="row">
							<div class="half_row">
								Powód (opcjonalnie):
							</div>				
							<div class="half_row_right">
								<span id="powod">
									powód zwrotu produktu
								</span>
							</div>
						</div>
						<div class="row">
							<div class="half_row">
								Podany nr konta klienta:
							</div>				
							<div class="half_row_right">
								<span id="konto">
									NR
								</span>
							</div>
						</div>
						
						
					</div>
				</div>
				<div class="half_width">
					<span class="info_span">Dane odczytane na podstawie zamówienia</span>
					<div class="bordered_div_no_padding">
						<div class="row">
							<div class="half_row">
								Nr zamówienia:
							</div>				
							<div class="half_row_right">
								<span id="id_zamowienia">ID</span>
							</div>
						</div>
						<div class="row">
							<div class="half_row">
								Data zamówienia:
							</div>				
							<div class="half_row_right">
								<span id="data_zamowienia">
									DATA
								</span>
							</div>
						</div>
						<div class="row">
							<div class="half_row">
								Dane adresowe:
							</div>				
							<div class="half_row_right">
								<div class="flex-box">
									<span id="ul" class="one_line_span">
										ul. Blaaadsdasa 202
									</span>
									<span id="kod">
										30-100
									</span>
									<span id="miejscowosc">
										aaaa
									</span>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="half_row">
								Dane kontaktowe:
							</div>				
							<div class="half_row_right">
								<div class="flex-box">
									<span id="tel" class="one_line_span">
										600 600 600
									</span>
									<span id="email">
										to_jest@email.org
									</span>
								</div>
							</div>
						</div>
						
						
					</div>
				</div>
				<div style="clear:both;"></div>
					<div id="produkty_start">
						<span class="info_span">Obsługa zwrotu</span>
						<div class="bordered_div_no_padding">
							<div class="half_width">
								<div class="flex_box_padding">
									<div class="half_row">
										Status zwrotu:
									</div>				
									<div class="half_row_right2">
										<select id="status_zwrotu" class="tx"></select>
									</div>
								</div>
								<div class="margin_box_left">
									<span class="one_line_span">Wyposarzenie otrzymanego towaru</span>
									<textarea class="areatx tx" rows="4"></textarea>
								</div>
								
							</div>
							<div class="half_width">
								<div class="flex_box_padding">
									<div class="half_row2">
										Przyporządkowany pracownik:
									</div>				
									<div class="half_row_right">
										<select id="pracownik" class="tx"></select>
									</div>
								</div>
								<div class="margin_box_right">
									<span class="one_line_span">Komentarz do klienta</span>
									<textarea class="areatx tx" rows="4"></textarea>
								</div>
								<div class="margin_box_right" style="padding-bottom:5px;">
									<div class="flex_box_space">
										<div></div>
										<div><a href='#'><button type="button" class="button_green">Wyślij</button></a></div>
									</div>
								</div>
							</div>
							<div style="clear:both;"></div>
						</div>
					</div>
					<div class="center_holder">
						<button type="button" class="button">Zapisz zmiany</button>
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
							<div class="row">
								<div class="hru1">
									1
								</div>	
								<div class="hru2">
									<img src="./img/oops.png"/>
								</div> 	
								<div class="hru3">
									Gostek który strzela się w łeb ! HIT ! PROC ĆWIERĆ RDZENIA !
								</div>	
								<div class="hru4">
									<span id="ilosc">ilosc</span>
								</div>
								<div class="hru5">
									<span id="cena">cena za sztukę zł</span>
								</div>								
								<div class="hru6">
									<span id="wartosc1">cena za sztukę razy ilość zł</span>
								</div>
							</div>
							<div class="row">
								<div class="hru1">
									1
								</div>	
								<div class="hru2">
									<img src="./img/oops.png"/>
								</div> 	
								<div class="hru3">
									Gostek który strzela się w łeb ! HIT ! PROC ĆWIERĆ RDZENIA !
								</div>	
								<div class="hru4">
									<span id="ilosc">ilosc</span>
								</div>
								<div class="hru5">
									<span id="cena">cena za sztukę zł</span>
								</div>								
								<div class="hru6">
									<span id="wartosc1">cena za sztukę razy ilość zł</span>
								</div>
							</div>
							<div class="row">
								<div class="hr2">Wartość produktów:				</div><div class="hr3"><span id="wartosc">40000zł</span></div>
							</div>
							<div class="row">
								<div class="hr2">Koszt dostawy:				</div><div class="hr3"><span id="koszt_dostawy">40zł</span></div>
							</div>
							<div class="row">
								<div class="hr2">Razem do zwrotu:				</div><div class="hr3"><span id="do_zaplaty">40040zł</span></div>
							</div>
						</div>
					</div>
			</div>
		</div>
		<div style="clear:both;"></div>
	</div>
</body>
</html>
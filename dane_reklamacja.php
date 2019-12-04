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
						Reklamacja **/****
					</div>
				</div>
				<div class="half_width">
					<span class="info_span">Dane reklamującego</span>
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
				</div>
				<div class="half_width">
					<span class="info_span">Dane produktu</span>
					<div class="bordered_div_no_padding">
						<div class="row">
							<div class="half_row">
								Produkt:
							</div>				
							<div class="half_row_right">
								<span id="nazwa_produktu">jestem produkt</span>
							</div>
						</div>
						<div class="row">
							<div class="half_row">
								Producent:
							</div>				
							<div class="half_row_right">
								<span id="producent_produktu">jestem producentem produktu</span>
							</div>
						</div>
						<div class="row">
							<div class="half_row">
								ID produktu:
							</div>				
							<div class="half_row_right">
								<span id="id_produktu">ID</span>
							</div>
						</div>
						<div class="row">
							<div class="half_row">
								Ilość:
							</div>				
							<div class="half_row_right">
								<span id="quantity">quantity</span>
							</div>
						</div>
					</div>
				</div>
				<div style="clear:both;"></div>
				<div class="half_width">
					<span class="info_span">Dane klienta odczytane na podstawie zamówienia</span>
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
				
				<div class="half_width">
					<span class="info_span">Dane zgłoszenia</span>
					<div class="bordered_div_no_padding">
						<div class="row">
							<div class="half_row">
								Data zgłoszenia reklamacji:
							</div>				
							<div class="half_row_right">
								<span id="data_reklamacji">DATA</span>
							</div>
						</div>
						<div class="row">
							<div class="half_row">
								Sposób reklamacji:
							</div>				
							<div class="half_row_right">
								<span id="way">
									WAY
								</span>
							</div>
						</div>
						<div class="row">
							<div class="half_row">
								Opis klienta:
							</div>				
							<div class="half_row_right">
								<span id="opis_uszkodzenia_klient">
									opis_uszkodzenia_klient
								</span>
							</div>
						</div>
						
						
					</div>
				</div>
				<div style="clear:both;"></div>
					<div id="produkty_start">
						<span class="info_span">Obsługa reklamacji</span>
						<div class="bordered_div_no_padding">
							<div class="half_width">
								<div class="flex_box_padding">
									<div class="half_row">
										Status reklamacji:
									</div>				
									<div class="half_row_right2">
										<select id="status_reklamacji" class="tx"></select>
									</div>
								</div>
								<div class="flex_box_padding">
									<div class="half_row">
										Sposób odbioru po reklamacji:
									</div>				
									<div class="half_row_right2">
										<select id="odbior" class="tx"></select>
									</div>
								</div>
								<div class="margin_box_left">
									<span class="one_line_span">Wyposarzenie otrzymanego towaru</span>
									<textarea class="areatx tx" rows="4"></textarea>
								</div>
								<div class="margin_box_left">
									<span class="one_line_span">Komentarz do reklamującego</span>
									<textarea class="areatx tx" rows="4"></textarea>
								</div>
								<div class="margin_box_left" style="padding-bottom:5px;">
									<div class="flex_box_space">
										<div></div>
										<div><a href='#'><button type="button" class="button_green">Wyślij</button></a></div>
									</div>
								</div>
							</div>
							<div class="half_width">
								<div class="flex_box_padding">
									<div class="half_row2">
										RMA serwisu:
									</div>				
									<div class="half_row_right">
										<input class="tx" type="text" name="id_reklamacji"/>
									</div>
								</div>
								<div class="flex_box_padding">
									<div class="half_row2">
										Przyporządkowany pracownik:
									</div>				
									<div class="half_row_right">
										<select id="pracownik" class="tx"></select>
									</div>
								</div>
								<div class="margin_box_right">
									<span class="one_line_span">Opis naprawy</span>
									<textarea class="areatx tx" rows="4"></textarea>
								</div>
							</div>
							<div style="clear:both;"></div>
						</div>
					</div>
					<div class="center_holder">
						<button type="button" class="button">Zapisz zmiany</button>
					</div>
			</div>
		</div>
		<div style="clear:both;"></div>
	</div>
</body>
</html>
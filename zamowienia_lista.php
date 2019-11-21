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
						Zamówienia
					</div>
				</div>
					<div id="produkty_start">
						<div class="bordered_div_no_padding">
							<div class="row">
								<div class="hr_z1">NUMER I STATUS ZAMÓWIENIA</div>	<div class="hr_z2">DATA</div> 	<div class="hr_z3">KLIENT</div>	<div class="hr_z4">PRODUKTY</div>	<div class="hr_z5">WARTOŚĆ</div>	<div class="hr_z6">INFORMACJE DODATKOWE</div>
							</div>
							<div class="row">
								<div class="hr_z1">
									<span id="id_1">31/2019</span>
									<div><button type="button" class="button">EDYTUJ</button></div>
									<span id="status_1">status</span>
								</div>	
								<div class="hr_z2">29/10/2019</div> 	
								<div class="hr_z3">Janusz23</div>	
								<div class="hr_z4">
									<div class="flex_box">
										<div class="f_z">
											<img src="./img/oops.png"/>
										</div>
										<div id="produkt_1" class="n_z">
											Gostek który strzela się w łeb ! HIT ! PROC PÓŁ RDZENIA !
										</div>
									</div>
									<div class="flex_box">
										<div class="f_z">
											<img src="./img/oops.png"/>
										</div>
										<div id="produkt_1" class="n_z">
											Gostek który strzela się w łeb ! HIT ! PROC ĆWIERĆ RDZENIA !
										</div>
									</div>
								</div>
								<div class="hr_z5">
									1000zł
								</div>	
								<div class="hr_z6">
									<div id="dostawa">Kurier dpd</div>
									<div id="platnosc">Płatność elektroniczna</div>
									<div id="dokument">Dokument sprzedaży: faktura</div>
								</div>
							</div>
							
							<div class="row">
								<div class="hr_z1">
									<span id="id_1">31/2019</span>
									<div><button type="button" class="button">EDYTUJ</button></div>
									<span id="status_1">status</span>
								</div>	
								<div class="hr_z2">29/10/2019</div> 	
								<div class="hr_z3">Janusz23</div>	
								<div class="hr_z4">
									<div class="flex_box">
										<div class="f_z">
											<img src="./img/oops.png"/>
										</div>
										<div id="produkt_1" class="n_z">
											Gostek który strzela się w łeb ! HIT ! PROC PÓŁ RDZENIA !
										</div>
									</div>
									<div class="flex_box">
										<div class="f_z">
											<img src="./img/oops.png"/>
										</div>
										<div id="produkt_1" class="n_z">
											Gostek który strzela się w łeb ! HIT ! PROC ĆWIERĆ RDZENIA !
										</div>
									</div>
									<div class="flex_box">
										<div class="f_z">
											<img src="./img/oops.png"/>
										</div>
										<div id="produkt_1" class="n_z">
											Gostek który strzela się w łeb ! HIT ! PROC ĆWIERĆ RDZENIA !
										</div>
									</div>
								</div>
								<div class="hr_z5">
									1000zł
								</div>	
								<div class="hr_z6">
									<div id="dostawa">Kurier dpd</div>
									<div id="platnosc">Płatność elektroniczna</div>
									<div id="dokument">Dokument sprzedaży: faktura</div>
								</div>
							</div>
						</div>
					</div>
			</div>
		</div>
		<div style="clear:both;"></div>
	</div>
</body>
</html>
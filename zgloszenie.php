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
					<div class="topic">
						<span id="temat">TEMAT ZGŁOSZENIA</span>
					</div>
				</div>
					<div id="produkty_start">
						<div class="n_b_d m_b_m"> <!-- wiadomość -->
							<div class="flex_box">
								<div class="avatar_box">
									<img src="./img/men.png"/>
								</div>
								<div class="message_box">
									<div class="upper_message_box flex_box_space">
										<span id="imie_i_nazwisko" class="user_message">
											Domestos S
										</span>
										<div class="relative">
										<span id="message_date" class="absolute">
											2/2/2
										</span>
										</div>
									</div>
									<span id="message" class="message">
										Lorem Ipsum jest tekstem stosowanym jako przykładowy wypełniacz w przemyśle poligraficznym. Został po raz pierwszy użyty w XV w. przez nieznanego drukarza do wypełnienia tekstem pr&oacute;bnej książki. Pięć wiek&oacute;w p&oacute;źniej zaczął być używany przemyśle elektronicznym, pozostając praktycznie niezmienionym. Spopularyzował się w latach 60. XX w. wraz z publikacją arkuszy Letrasetu, zawierających fragmenty Lorem Ipsum, a ostatnio z zawierającym r&oacute;żne wersje Lorem Ipsum oprogramowaniem przeznaczonym do realizacji druk&oacute;w na komputerach osobistych, jak Aldus PageMaker
									</span>
								</div>
							</div>
						</div>
						<div class="n_b_d m_b_m"> <!-- wiadomość -->
							<div class="flex_box">
								<div class="avatar_box">
									<img src="./img/kseshop-kontakt.png"/>
								</div>
								<div class="message_box">
									<div class="upper_message_box flex_box_space">
										<span id="imie_i_nazwisko" class="user_message">
											ADMIN
										</span>
										<div class="relative">
										<span id="message_date" class="absolute">
											2/2/2
										</span>
										</div>
									</div>
									<span id="message" class="message">
										Lorem Ipsum jest tekstem stosowanym jako przykładowy wypełniacz w przemyśle poligraficznym. Został po raz pierwszy użyty w XV w. przez nieznanego drukarza do wypełnienia tekstem pr&oacute;bnej książki. Pięć wiek&oacute;w p&oacute;źniej zaczął być używany przemyśle elektronicznym, pozostając praktycznie niezmienionym. Spopularyzował się w latach 60. XX w. wraz z publikacją arkuszy Letrasetu, zawierających fragmenty Lorem Ipsum, a ostatnio z zawierającym r&oacute;żne wersje Lorem Ipsum oprogramowaniem przeznaczonym do realizacji druk&oacute;w na komputerach osobistych, jak Aldus PageMaker
									</span>
								</div>
							</div>
						</div>
						<div class="n_b_d m_b_m">				<!-- div od wiadomości do wysłania i przycisku wyślij -->
							<div class="flex_box">
								<div class="avatar_box"></div> 	<!-- ta linijka to tylko placeholder -->
								<div class="message_box">
									<textarea class="areatx tx" rows="6"></textarea>
								</div>
							</div>
							<div class="flex_box">
								<div class="avatar_box"></div> 	<!-- ta linijka to tylko placeholder -->
								<div class="message_box">
									<button type="button" class="button_green" style="margin-left:45%;">Wyślij</button>
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
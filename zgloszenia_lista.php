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
						Pytania od użytkowników
					</div>
				</div>
					<div id="produkty_start">
						<div class="bordered_div_full">
							<div class="row">
								<div class="zgl_list1">
									<span class="one_line_span">ID</span>
									<span class="one_line_span">STATUS</span>
									<span class="one_line_span">DATA ODPOWIEDZI</span>
								</div>	
								<div class="zgl_list2">
									<span class="one_line_span">IMIĘ I NAZWISKO</span>
									<span class="one_line_span">NAZWA FIRMY</span>
									<span class="one_line_span">ADRES E-MAIL</span>
									<span class="one_line_span">TELEFON</span>
								</div> 	
								<div class="zgl_list3">KATEGORIA</div>
								<div class="zgl_list4">TEMAT</div>
								<div class="zgl_list5">DATA ZGŁOSZENIA</div>	
								<div class="zgl_list6">DZIAŁANIA</div>
							</div>
							<div class="row">
								<div class="zgl_list1">
									<span class="one_line_span">1</span>
									<span class="one_line_span">nowy/przeczytany/odpowiedź wysłana</span>
									<span class="one_line_span">data ostatniej wiadomości</span>
								</div>	
								<div class="zgl_list2">
									<span class="one_line_span click_me_span">Teodory Kopra</span>
									<span class="one_line_span click_me_span">tajny_email@firma.com</span>
									<span class="one_line_span click_me_span">600 600 600</span>
								</div> 	
								<div class="zgl_list3">
									KATEGORIA
								</div>	
								<div class="zgl_list4">
									TEMAT
								</div>
								<div class="zgl_list5">
									2019-09-17 21:32:47
								</div>	
								<div class="zgl_list6">
									<div class="s_d_b"><button type="button" class="button">CZYTAJ</button></div>
									<div class="s_d_b"><button type="button" class="red_button">USUŃ</button></div>
									<div class="s_d_b"><button type="button" class="red_button">ZABLOKUJ SPAM</button></div>
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
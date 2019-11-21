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
						<div class="flex_box_space">
							<div>KODY RABATOWE</div>
							<div><button type="button" class="button_green">NOWY KOD RABATOWY</button></div>
						</div>
					</div>
				</div>
					<div id="produkty_start">
						<div class="bordered_div_no_padding">
							<div class="row">
								<div class="hr_k1">
									<span class="one_line_span">ID</span>
								</div>	
								<div class="hr_k2">
									<span class="one_line_span">KOD RABATOWY</span>
								</div> 	
								<div class="hr_k3">STATUS</div>	
								<div class="hr_k4">WYGASA</div>	
								<div class="hr_k5">DZIAŁANIA</div>	
							</div>
							<div class="row">
								<div class="hr_k1">
									<span class="one_line_span">1</span>
								</div>	
								<div class="hr_k2">
									<span class="one_line_span">BlAcK-FrIdAy-SaLe</span>
								</div> 	
								<div class="hr_k3">
									aktywny
								</div>		
								<div class="hr_k4">20.20.20</div>
								<div class="hr_k5">
									<div class="s_d_b"><button type="button" class="button">EDYTUJ</button></div>
									<div class="s_d_b"><button type="button" class="red_button">USUŃ</button></div>
								</div>
							</div>
							<div class="row">
								<div class="hr_k1">
									<span class="one_line_span">2</span>
								</div>	
								<div class="hr_k2">
									<span class="one_line_span">ŚwIęTy-MiKoŁaJ-2K20</span>
								</div> 	
								<div class="hr_k3">
									aktywny
								</div>		
								<div class="hr_k4">20.20.20</div>
								<div class="hr_k5">
									<div class="s_d_b"><button type="button" class="button">EDYTUJ</button></div>
									<div class="s_d_b"><button type="button" class="red_button">USUŃ</button></div>
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
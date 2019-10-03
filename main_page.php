<?php

	session_start();
	
	if (!isset($_SESSION['zalogowany']))
	{
		header('Location: index.php');
		exit();
	}
	
	require_once "connect.php";
	//polaczenie z user
	//ile zamowień, zarejestrowanych użytkowników
	$polaczenie = @new mysqli($host, $db_user, $db_password, $db_users);
	
	if ($polaczenie->connect_errno!=0)
	{
		echo "Error: ".$polaczenie->connect_errno;
	}
	else
	{
		if ($rezultat = @$polaczenie->query(
		sprintf("SELECT id_zamowienie FROM zamowienie_info")))
		{
			$ile_zamowien = $rezultat->num_rows;
		}
		if ($rezultat = @$polaczenie->query(
		sprintf("SELECT id_user FROM uzytkownicy")))
		{
			$ilu_uzytkownikow = $rezultat->num_rows;
		}
		$polaczenie->close();
	}
	//licz produkty
	$bazy = array($db_gry, $db_komputery, $db_laptopy, $db_podzespoly, $db_telefony);
	$ile_produktow = 0;
	while($element = current($bazy))
	{
		$polaczenie = @new mysqli($host, $db_user, $db_password, $element);
		if ($polaczenie->connect_errno!=0)
		{
			echo "Error: ".$polaczenie->connect_errno;
		}
		else
		{
			$polaczenie->query("SET CHARSET utf8");
			$polaczenie->query("SET NAMES 'utf8' COLLATE 'utf8_polish_ci'");
			if ($rezultat = @$polaczenie->query("SHOW TABLES LIKE '%_ogolne'"))
			{
				while($temp = $rezultat->fetch_array())
				{
						if ($rezul = @$polaczenie->query("SELECT * FROM $temp[0]"))
					{
						$ile_produktow = $ile_produktow + $rezul->num_rows;
					}
				}
			}
			$polaczenie->close();
		}
		next($bazy);
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
				<div class="nav"><a href="#" class="nav_link">start</a></div>
				<div class="nav"><a href="#" class="nav_link">asortyment</a></div>
				<div class="nav"><a href="#" class="nav_link">narzędzia</a></div>
			</div>
		</div>
		<div id="page">
			<div id="search_inputs">
				<input class="search_input" type="text" name="search_product" placeholder="szukaj produktu" onfocus="this.placeholder=''" onblur="this.placeholder='szukaj produktu'" />
				<input class="search_button" type="submit" value="&#xe801" />
				<input class="search_input" type="text" name="search_req" placeholder="szukaj zamówienia" onfocus="this.placeholder=''" onblur="this.placeholder='szukaj zamówienia'" />
				<input class="search_button" type="submit" value="&#xe801" />
				<input class="search_input" type="text" name="search_user" placeholder="szukaj klienta" onfocus="this.placeholder=''" onblur="this.placeholder='szukaj klienta'" />
				<input class="search_button" type="submit" value="&#xe801" />
			</div>
			<div id="main_content">
				Ilość złożonych zamówień: <?php echo $ile_zamowien ?><br />
				Ilość zarejestrowanych użytkowników: <?php echo $ilu_uzytkownikow ?><br />
				Ilość produktów w sklepie: <?php echo $ile_produktow ?>
			</div>
		</div>
		<div style="clear:both;"></div>
	</div>
</body>
</html>
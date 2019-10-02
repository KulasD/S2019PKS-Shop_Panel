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
</head>

<body>
	<div id="container">
		<div id="left_bar">
			<div id="top_left_bar">
				<?php

					echo "Witaj ".$_SESSION['imie'].'! [ <a href="logout.php">Wyloguj się!</a> ]<br />';
					echo "Jesteś zalogowany jako: ".$_SESSION['uprawnienia'];
					
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
				<input type="text" name="search_product" placeholder="szukaj produktu" onfocus="this.placeholder=''" onblur="this.placeholder='szukaj produktu'" />
				<input type="text" name="search_req" placeholder="szukaj zamówienia" onfocus="this.placeholder=''" onblur="this.placeholder='szukaj zamówienia'" />
				<input type="text" name="search_user" placeholder="szukaj klienta" onfocus="this.placeholder=''" onblur="this.placeholder='szukaj klienta'" />
			</div>
			<div id="main_content">
				aaa
			</div>
		</div>
		<div style="clear:both;"></div>
	</div>
</body>
</html>
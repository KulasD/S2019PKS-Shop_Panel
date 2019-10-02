<?php

	session_start();
	
	if ((isset($_SESSION['zalogowany'])) && ($_SESSION['zalogowany']==true))
	{
		header('Location: main_page.php');
		exit();
	}

?>

<!DOCTYPE HTML>
<html lang="pl">
<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<title>Panel administracyjny - logowanie</title>
	<link rel="stylesheet" href="log_in_style.css" type="text/css" />
</head>

<body>

	<div id="box">
	
		<span id="login_text">Panel logowania sklepu.</span>
		
		<form action="zaloguj.php" method="post">
		
			<input type="text" name="login" placeholder="login" onfocus="this.placeholder=''" onblur="this.placeholder='login'" />
			<input type="password" name="haslo" placeholder="hasło" onfocus="this.placeholder=''" onblur="this.placeholder='hasło'" />
			<input type="submit" value="Zaloguj się" />
		
		</form>
	
		<?php
			if(isset($_SESSION['blad']))	echo $_SESSION['blad'];
		?>
		
	</div>
	
</body>
</html>
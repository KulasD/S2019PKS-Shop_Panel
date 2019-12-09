<?php

	session_start();
	
	if (!isset($_SESSION['zalogowany']))
	{
		header('Location: index.php');
		exit();
	}
	
?>
<?php
	$con = mysqli_connect("localhost","root","","user");
	mysqli_query($con, "SET CHARSET utf8");
	mysqli_query($con, "SET NAMES 'utf8' COLLATE 'utf8_polish_ci'");
	$query = "SELECT * FROM kod_rabatowy ORDER BY id_kod ASC ";
	$result = mysqli_query($con,$query);
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
	<script src="script.js"></script>
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
			<?php include('nav.php'); ?>
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
							<div><a href='rabat.php'><button type="button" class="button_green">NOWY KOD RABATOWY</button></a></div>
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
								<div class="hr_k4">DATA DODANIA</div>	
								<div class="hr_k5">DZIAŁANIA</div>	
							</div>
							
							
							
							
							ZABLOKOWAĆ EDYTOWANIE PROCENTÓW, czemu? bo jak ktoś zamówi powiedzmy za 1000 zł z rabatem 20% czyli 800zł, pracownik zmieni na 10% i klient będzie chciał zwrócic przedmiot z rabatem, a rabat się zmienił i trzebabędzie mu zwróicić 900 a nie 800.
							
							
							
							
							<?php
								while ($r = $result->fetch_array(MYSQLI_ASSOC)) {
								echo "<div class='row'>
								<div class='hr_k1'>
									<span class='one_line_span'>".$r['id_kod']."</span>
								</div>	
								<div class='hr_k2'>
									<span class='one_line_span'>".$r['kod'].", ".$r['rabat']."%</span>
								</div> 	
								<div class='hr_k3'>
									".$r['status']."
								</div>		
								<div class='hr_k4'>".$r['data_dodania']."</div>
								<div class='hr_k5'>
									<div class='s_d_b'><button class='button' onclick='g(".$r['id_kod'].")'>EDYTUJ</button></div>
									<div class='s_d_b'><button class='red_button' onclick='deletekod(".$r['id_kod'].")'>USUŃ</button></div>
								</div>
							</div>";
								}
							?>
						</div>
					</div>
			</div>
		</div>
		<div style="clear:both;"></div>
	</div>
<script src="http://code.jquery.com/jquery-1.12.4.js"></script>
<script>
function g(nr)
{
	window.location.href = "rabat.php?id="+nr;
}
</script>
</body>
</html>

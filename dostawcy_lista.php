<?php

	session_start();
	
	if (!isset($_SESSION['zalogowany']))
	{
		header('Location: index.php');
		exit();
	}
	
?>
<?php
	$con = mysqli_connect("localhost","root","","administracja");
	mysqli_query($con, "SET CHARSET utf8");
	mysqli_query($con, "SET NAMES 'utf8' COLLATE 'utf8_polish_ci'");
	$query = "SELECT * FROM dostawcy ORDER BY status ";
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
				<?php include('search_bar.php'); ?>
			</div>
			<div id="main_content">
				<div id="panel_admin_border">
					<div id="panel_admin">
						<div class="flex_box_space">
							<div>DOSTAWCY TOWARÓW</div>
							<div><a href='dostawca.php'><button type="button" class="button_green">NOWY DOSTAWCA</button></a></div>
						</div>
					</div>
				</div>
					<div id="produkty_start">
						<div class="bordered_div_no_padding">
							<div class="row">
								<div class="hr_k1">
									<span class="one_line_span">ID</span>
									<span class="one_line_span">STATUS</span>
								</div>	
								<div class="hr_k2">
									<span class="one_line_span">NAZWA</span>
									<span class="one_line_span">NIP</span>
									<span class="one_line_span">REGON</span>
								</div> 	
								<div class="hr_k3">DANE KONTAKTOWE</div>	
								<div class="hr_k4">ADRES</div>	
								<div class="hr_k5">DZIAŁANIA</div>	
							</div>
							<?php
								while ($r = $result->fetch_array(MYSQLI_ASSOC)) {
								echo "<div class='row'>
								<div class='hr_k1'>
									<span class='one_line_span'>".$r['id']."</span>
									<span class='one_line_span'>".$r['status']."</span>
								</div>	
								<div class='hr_k2'>
									<span class='one_line_span'>".$r['nazwa']."</span>
									<span class='one_line_span'>".$r['nip']."</span>
									<span class='one_line_span'>".$r['regon']."</span>
								</div> 	
								<div class='hr_k3'>
									<span class='one_line_span'>".$r['email']."</span>
									<span class='one_line_span'>".$r['telefon']."</span>
								</div>		
								<div class='hr_k4'>
									<span class='one_line_span'>".$r['adres']."</span>
									<span class='one_line_span'>".$r['miejscowosc']." ".$r['kod_pocztowy']."</span>
								</div>
								<div class='hr_k5'>
									<div class='s_d_b'><a href='dostawca.php?idd=".$r['id']."'><button type='button' class='button'>EDYTUJ</button></a></div>
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
</body>
</html>

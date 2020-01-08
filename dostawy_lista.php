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
	$query = "SELECT * FROM dostawy WHERE status NOT IN ('zakończona', 'anulowana') ORDER BY id_dostawy DESC";
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
							<div>LISTA DOSTAW DO SKLEPU</div>
							<div><a href='dostawa_new.php'><button type="button" class="button_green">NOWA DOSTAWA</button></a></div>
						</div>
					</div>
				</div>
					<div id="produkty_start">
						<div class="bordered_div_no_padding">
							<div class="row">
								<div class="d1">NUMER DOSTAWY</div>	
								<div class="d2">DATA ZGŁOSZENIA DOSTAWY</div>
								<div class="d3">DOSTAWCA</div>
								<div class="d4 center_holder_no_padding">STATUS</div>
								<div class="d5 center_holder_no_padding">DZIAŁANIA</div>
							</div>				
							<?php
								while($r = $result->fetch_array(MYSQLI_ASSOC)){
									$query_dostawca = "SELECT * FROM dostawcy WHERE id LIKE '".$r['id_dostawcy']."'";
									$result_dostawca = mysqli_query($con,$query_dostawca);
									$r_dostawca = $result_dostawca->fetch_array(MYSQLI_ASSOC);
									echo "
									<div class='row'>
										<div class='d1'>".$r['id_dostawy']."</div>
										<div class='d2'>".$r['data']."</div>
										<div class='d3'>
											<span class='one_line_span'>".$r_dostawca['nazwa']."</span>
											<span class='one_line_span'>tel: ".$r_dostawca['telefon']."</span>
										</div>
										<div class='d4 center_holder_no_padding'>".$r['status']."</div>
										<div class='d5 center_holder_no_padding'>
											<div class='s_d_b'><a href='dostawa_edit.php?id=".$r['id_dostawy']."'><button type='button' class='button'>EDYTUJ</button></a></div>
										</div>
									</div>
									";
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

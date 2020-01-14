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
	$query = "SELECT * FROM zamowienie_informacje WHERE status_zaplaty LIKE 'niezapłacono' ORDER BY id_zamowienie DESC";
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
						Lista płatności klientów
					</div>
				</div>
					<div id="produkty_start">
						<div class="bordered_div_no_padding platnosc_div">
							<div class="row">
								<div class="p1">NUMER ZAMÓWIENIA</div>	
								<div class="p2">DATA ZAMÓWIENIA</div>
								<div class="p3">WARTOŚĆ ZAMÓWIENIA</div>
								<div class="p4">STATUS ZAPŁATY</div>
							</div>				
							<?php
								while($r = $result->fetch_array(MYSQLI_ASSOC)){
									echo "
									<div class='row'>
										<div class='p1'>".$r['id_zamowienie']."</div>
										<div class='p2'>".$r['data_zamowienia']."</div>
										<div class='p3'>".$r['cena_zamowienia']." zł</div>
										<div class='p4'>
											<button class='red_button' onclick='zaplacono(".$r['id_zamowienie'].")'>Niezapłacono</button>
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
<script src="http://code.jquery.com/jquery-1.12.4.js"></script>
<script type="text/javascript">
	function zaplacono(id){
		$.ajax({
			url: 'platnosc_update.php',
			type: 'POST',
			data: {id},
		});
		setTimeout(function() {
			window.location.reload(true);
		}, 1000)
		return false; 
	}
</script>
</body>
</html>

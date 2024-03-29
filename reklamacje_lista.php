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
	$query = "SELECT * FROM reklamacje WHERE status NOT LIKE 'reklamacja%' ORDER BY id_rek DESC ";
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
							Reklamacje
							<div><button type="button" class="button" onclick="rekl_hist()">REKLAMACJE ZAKOŃCZONE</button></div>
						</div>
					</div>
				</div>
					<div id="produkty_start">
						<div class="bordered_div_no_padding">
							<div class="row">
								<div class="hr_k1">
									<span class="one_line_span">ID</span>
									<span class="one_line_span">STATUS</span>
									<span class="one_line_span">ID ZAMÓWIENIA</span>
								</div>	
								<div class="hr_k2">
									<span class="one_line_span">IMIĘ I NAZWISKO</span>
									<span class="one_line_span">NAZWA FIRMY</span>
									<span class="one_line_span">ADRES E-MAIL</span>
								</div> 	
								<div class="hr_k3">REKLAMOWANY PRODUKT</div>	
								<div class="hr_k4">DATA ZGŁOSZENIA</div>	
								<div class="hr_k5">DZIAŁANIA</div>
							</div>
							<?php
								while ($r = $result->fetch_array(MYSQLI_ASSOC)) {
									$data_z = $r['data_reklamacji'];
									echo "<div class='row'>
								<div class='hr_k1'>
									<span class='one_line_span'>".$r['id_rek']."</span>
									<span class='one_line_span'>".$r['status']."</span>
									<span class='one_line_span'>".$r['id_zamowienie']."</span>
								</div>	
								<div class='hr_k2'>
									<span class='one_line_span'>".$r['name_surname']."</span>
									<span class='one_line_span'>".$r['email']."</span>
								</div> 	
								<div class='hr_k3'>
									<div class='flex_box'>";
									$id_zamow_p = $r['id_zamow_p'];
									$q = "SELECT id_produktu FROM zamowienie_przedmiot WHERE id_zamow_p = '$id_zamow_p' ";
									$res = mysqli_query($con,$q);
									while ($rrr = $res->fetch_array(MYSQLI_ASSOC)) {
										$id_produktu = $rrr['id_produktu'];
									}
									
									$przed = mysqli_connect("localhost","root","","przedmioty");
									mysqli_query($przed, "SET CHARSET utf8");
									mysqli_query($przed, "SET NAMES 'utf8' COLLATE 'utf8_polish_ci'");	
									$qu = "SELECT * FROM przedmioty_ogolne_informacje WHERE id_produktu = '$id_produktu' ";
									$res = mysqli_query($przed,$qu);
									while ($re = $res->fetch_array(MYSQLI_ASSOC)) {
										$src = $re['zdjecie'];
												echo "<div class='f_z'>
															<img src='../kseshop/category/produkty/".$src."'/>
														</div>";
									}
										echo "
										<div id='produkt_1' class='n_z'>
											".$r['name_product']."
										</div>
									</div>
								</div>	
								<div class='hr_k4'>".$data_z."</div>	
								<div class='hr_k5'>
									<div class='s_d_b'><button type='button' class='button' onclick='go_rek(".$r['id_rek'].")'>EDYTUJ</button></div>
									
								</div>
							</div>";
								};
								//<div class='s_d_b'><button type='button' class='red_button'>USUŃ</button></div>
							?>
						</div>
					</div>
			</div>
		</div>
		<div style="clear:both;"></div>
	</div>
<script type="text/javascript" src="script.js"></script>
<script>
function rekl_hist()
{
	window.location.href = "reklamacje_lista_hist.php"; 
}
</script>
</body>
</html>

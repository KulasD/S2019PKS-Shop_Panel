<?php

	session_start();
	
	if (!isset($_SESSION['zalogowany']))
	{
		header('Location: index.php');
		exit();
	}
	
?>

<?php
	if (isset($_SESSION['id_u'])){
		$yes = true;
		$wybraniec = $_SESSION['id_u'];

	$con = mysqli_connect("localhost","root","","user");
	mysqli_query($con, "SET CHARSET utf8");
	mysqli_query($con, "SET NAMES 'utf8' COLLATE 'utf8_polish_ci'");
	
	$query_user = "SELECT * FROM uzytkownicy WHERE id_user='$wybraniec'";
	$result_user = mysqli_query($con,$query_user);
	$r_user = $result_user->fetch_array(MYSQLI_ASSOC);
	
	$query_rekl = "SELECT * FROM reklamacje WHERE id_user='$wybraniec' ORDER BY id_rek DESC";
	$result_rekl = mysqli_query($con,$query_rekl);
	
	}
	else {
		header('Location: main_page.php');
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
						<?php echo "Historia reklamacji klienta: ".$r_user['id_user']." ".$r_user['name']." ".$r_user['surname']; ?>
					</div>
				</div>
				<?php
						echo "
				<span class='info_span_bigger'> </span>
						<div class='bordered_div_no_padding'>
							<div class='row'>
								<div class='kd1'>
									<span class='one_line_span'>ID REKLAMACJI</span>
									<span class='one_line_span'>ID ZAMÓWIENIA</span>
								</div>		
								<div class='kd2'>STATUS</div>	
								<div class='kd3'>REKLAMOWANY PRODUKT</div>	
								<div class='kd4'>DATA ZGŁOSZENIA</div>	
								<div class='kd5'>DZIAŁANIA</div>
							</div>";

								while ($r = $result_rekl->fetch_array(MYSQLI_ASSOC)) {
									$data_z = $r['data_reklamacji'];
									echo "<div class='row'>
								<div class='kd1'>
									<span class='one_line_span'>".$r['id_rek']."</span>
									<span class='one_line_span'>".$r['id_zamowienie']."</span>
								</div>	
								<div class='kd2'>
									<span class='one_line_span'>".$r['status']."</span>
								</div>	
								<div class='kd3'>
									<span class='one_line_span'>".$r['name_product']."</span>
								</div>	
								<div class='kd4'>".$data_z."</div>	
								<div class='kd5'>
									<div class='s_d_b'><button type='button' class='button' onclick='go_rek(".$r['id_rek'].")'>EDYTUJ</button></div>
									<div class='s_d_b'><button type='button' class='red_button'>USUŃ</button></div>
								</div>
							</div>";
								};	
								
						echo "</div>";
							?>
			</div>
		</div>
		<div style="clear:both;"></div>
	</div>
<script src="http://code.jquery.com/jquery-1.12.4.js"></script>
<script type="text/javascript" src="script.js"></script>
<script type="text/javascript">
	function zmiana_hasla(){
		$('#nowe_haslo').prop("disabled", false);
	}
	
	function zam_hist(){
		window.location.href = "zam_hist.php";
	}
	
	function rekl_hist(){
		window.location.href = "rekl_hist.php";
	}
	
	function zwroty_hist(){
		window.location.href = "zwroty_hist.php";
	}
	
</script>
</body>
</html>

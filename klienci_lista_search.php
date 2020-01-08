<?php

	session_start();
	
	if (!isset($_SESSION['zalogowany']))
	{
		header('Location: index.php');
		exit();
	}
	
?>
<?php
	if (!isset($_POST['search_user']))
	{
		header('Location: klienci_lista.php');
		exit();
	}
	else{
		$klient = $_POST['search_user'];
		$yes = false;
		$con = mysqli_connect("localhost","root","","user");
		mysqli_query($con, "SET CHARSET utf8");
		mysqli_query($con, "SET NAMES 'utf8' COLLATE 'utf8_polish_ci'");
		
		// SPRAWDZAMY ID
		$query = "SELECT * FROM uzytkownicy WHERE id_user LIKE '$klient' ORDER BY id_user ASC ";
		$result_id = mysqli_query($con,$query);
		if($result_id->num_rows>0){
			$result = $result_id;
			$yes = true;
		}
		else{
			
			//NIE MA TAKIEGO ID TO IMIE
			$query = "SELECT * FROM uzytkownicy WHERE name LIKE '%$klient%' ORDER BY id_user ASC ";
			$result_imie = mysqli_query($con,$query);
			if($result_imie->num_rows>0){
				$result = $result_imie;
				$yes = true;
			}
			else{
				
				//NIE MA PODOBNEGO IMIENIA WIEC SPRAWDZAMY NAZWISKO
				$query = "SELECT * FROM uzytkownicy WHERE surname LIKE '%$klient%' ORDER BY id_user ASC ";
				$result_nazwisko = mysqli_query($con,$query);
				if($result_nazwisko->num_rows>0){
					$result = $result_nazwisko;
					$yes = true;
				}
			}
		}
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
				<?php include('search_bar.php'); ?>
			</div>
			<div id="main_content">
				<div id="panel_admin_border">
					<div id="panel_admin">
						Klienci
					</div>
				</div>
					<div id="produkty_start">
						<div class="bordered_div_no_padding">
							<?php 
							if($yes){
							echo "
							<div class='row'>
								<div class='hr_k1'>
									<span class='one_line_span'>ID</span>
									<span class='one_line_span'>STATUS</span>
								</div>	
								<div class='hr_k2'>
									<span class='one_line_span'>IMIĘ I NAZWISKO</span>
									<span class='one_line_span'>MIEJSCOWOŚĆ</span>
									<span class='one_line_span'>FIRMA NIP</span>
								</div> 	
								<div class='hr_k3'>E-MAIL</div>	
								<div class='hr_k4'>OSTATNIE LOGOWANIE</div>	
								<div class='hr_k5'>DZIAŁANIA</div>
							</div>";
							
							
								while ($r = $result->fetch_array(MYSQLI_ASSOC)) {
									echo "<div class='row'>
								<div class='hr_k1'>
									<span class='one_line_span'>".$r['id_user']."</span>
									<span class='one_line_span'>aktywne</span>
								</div>	
								<div class='hr_k2'>
									<span class='one_line_span'>".$r['name']." ".$r['surname']."</span>
									<span class='one_line_span'>".$r['adres']." ".$r['kod_pocztowy']." ".$r['miejscowosc']."</span>
								</div> 	
								<div class='hr_k3'>".$r['email']."</div>	
								<div class='hr_k4'>No info</div>	
								<div class='hr_k5'>
									<span class='one_line_span click_me_span' onclick='go_to_klient(".$r['id_user'].")'>szczegóły i edycja danych</span>
									
								</div>
							</div>";
								}
								//<span class='one_line_span red_click_me_span'>zablokuj konto</span>
							}
							else{
								echo "Brak wyników do wyświetlenia.";
							}
							?>
						</div>
					</div>
			</div>
		</div>
		<div style="clear:both;"></div>
	</div>
<script type="text/javascript" src="script.js"></script>
</body>
</html>

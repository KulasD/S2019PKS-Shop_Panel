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
	$id_d = '';
	$nazwa = ''; 
	$nip = ''; 
	$regon = ''; 
	$telefon = ''; 
	$email = ''; 
	$adres = ''; 
	$kod = ''; 
	$miejscowosc = ''; 
	$status = 'aktywny';
	
	$yes=false;
	
	if ( isset( $_GET['idd'] ) && !empty( $_GET['idd'] ) )
	{
		$yes=true;
		$id_d = $_GET['idd'];
		$query = "SELECT * FROM dostawcy WHERE id='$id_d'";
		$result = mysqli_query($con,$query);
		
		// JAK NIE MA TAKIEGO ID TO WRÓCI DO LISTY DOSTAWCÓW
		
		if (!$result)
		{
			header('Location: dostawcy_lista.php');
			exit();
		}
		$r = $result->fetch_array(MYSQLI_ASSOC);
		$nazwa = $r['nazwa'];
		$nip = $r['nip']; 
		$regon = $r['regon']; 
		$telefon = $r['telefon']; 
		$email = $r['email']; 
		$adres = $r['adres']; 
		$kod = $r['kod_pocztowy']; 
		$miejscowosc = $r['miejscowosc'];
		$status = $r['status'];
		
		
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
						DOSTAWCA
					</div>
				</div>
					<div id="produkty_start">
						<div class="half_width">
							<div class="bordered_div_no_padding">
							<form action="dostawca_add.php" method="post">
								<div class="row">
									<div class="half_row">
										<span class="one_line_span">NAZWA:</span>
									</div> 	
									<div class="half_row_right">
										<input class="tx" type="text" name="nazwa" value="<?php echo $nazwa; ?>"/>
									</div>	
								</div>
								<div class="row">
									<div class="half_row">
										<span class="one_line_span">NIP:</span>
									</div> 	
									<div class="half_row_right">
										<input class="tx" type="text" name="nip" value="<?php echo $nip; ?>"/>
									</div>	
								</div>
								<div class="row">
									<div class="half_row">
										<span class="one_line_span">REGON:</span>
									</div> 	
									<div class="half_row_right">
										<input class="tx" type="text" name="regon" value="<?php echo $regon; ?>"/>
									</div>	
								</div>
								<div class="row">
									<div class="half_row">
										<span class="one_line_span">TELEFON:</span>
									</div> 	
									<div class="half_row_right">
										<input class="tx" type="text" name="telefon" value="<?php echo $telefon; ?>"/>
									</div>	
								</div>
								<div class="row">
									<div class="half_row">
										<span class="one_line_span">E-MAIL:</span>
									</div> 	
									<div class="half_row_right">
										<input class="tx" type="text" name="email" value="<?php echo $email; ?>"/>
									</div>	
								</div>
								<div class="row">
									<div class="half_row">
										<span class="one_line_span">ADRES:</span>
									</div> 	
									<div class="half_row_right">
										<input class="tx" type="text" name="adres" value="<?php echo $adres; ?>"/>

										<input class="tx" type="text" name="kod_pocztowy" value="<?php echo $kod; ?>"  style="width:29%; margin-right:1%;"/><input class="tx" type="text" name="miejscowosc" value="<?php echo $miejscowosc; ?>"  style="width:70%"/>
									</div>										
								</div>
								<div class="row">
									<div class="half_row">
										<span class="one_line_span">STATUS:</span>
									</div> 	
									<div class="half_row_right">
										<select class="tx" name="status">
											<?php 
												if($status=="nieaktywny")
												{
													echo "
													<option value='aktywny'>aktywny</option>
													<option selected value='nieaktywny'>nieaktywny</option>
													";
												}
												else
												{
													echo "
													<option selected value='aktywny'>aktywny</option>
													<option value='nieaktywny'>nieaktywny</option>
													";
												}
											?>
										</select>
									</div>	
								</div>
								<div class="flex_box_space" style="margin:5px;">
									<div></div>
									<div><button type="submit" class="button_green" name="id_d" value="<?php echo $id_d; ?>">ZAPISZ</button></div>
								</div>
							</form>
							</div>
						</div>
					</div>
			</div>
		</div>
		<div style="clear:both;"></div>
	</div>
</body>
</html>
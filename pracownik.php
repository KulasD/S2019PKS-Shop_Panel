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
	$id_p = '';
	$imie = ''; 
	$nazwisko = ''; 
	$login = ''; 
	$haslo = ''; 
	$telefon = ''; 
	$uprawnienia = ''; 
	
	$yes=false;
	
	if ( isset( $_GET['id'] ) && !empty( $_GET['id'] ) )
	{
		$yes=true;
		$id_p = $_GET['id'];
		$query = "SELECT * FROM kadra WHERE id='$id_p'";
		$result = mysqli_query($con,$query);
		
		// JAK NIE MA TAKIEGO ID TO WRÓCI DO LISTY PRACOWNIKÓW
		
		if (!$result)
		{
			header('Location: pracownicy_lista.php');
			exit();
		}
		$r = $result->fetch_array(MYSQLI_ASSOC);
		$imie = $r['imie'];
		$nazwisko = $r['nazwisko']; 
		$login = $r['login']; 
		$haslo = $r['haslo']; 
		$telefon = $r['tel']; 
		$uprawnienia = $r['uprawnienia'];
		
		
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
						Pracownik <?php echo $imie." ".$nazwisko;?>
					</div>
				</div>
				<form action="pracownik_add.php" method="post">
				<div class="half_width">
					<span class="info_span">Dane klienta</span>
					<div class="bordered_div_no_padding">
						<div class="row">
							<div class="half_row">
								Imię:
							</div>				
							<div class="half_row_right">
								<input type="text" class="tx" name="imie" value="<?php echo $imie;?>"/>
							</div>
						</div>
						<div class="row">
							<div class="half_row">
								Nazwisko:
							</div>				
							<div class="half_row_right">
								<input type="text" class="tx" name="nazwisko" value="<?php echo $nazwisko;?>"/>
							</div>
						</div>	
						<div class="row">
							<div class="half_row">
								Login:
							</div>				
							<div class="half_row_right">
								<input type="text" class="tx" name="login" value="<?php echo $login;?>"/>
							</div>
						</div>	
						<div class="row">
							<div class="half_row">
								Hasło:
							</div>				
							<div class="half_row_right">
								<input type="text" style="width:73%;" class="tx" name="nowe_haslo" id="nowe_haslo" disabled/><button type="button" class="button" name="nowe_haslo" onclick="zmiana_hasla()">Edytuj hasło</button>
							</div>
						</div>
						<div class="row">
							<div class="half_row">
								Nr telefonu:
							</div>				
							<div class="half_row_right">
								<input type="text" class="tx" name="telefon" value="<?php echo $telefon;?>"/>
							</div>
						</div>
						<div class="row">
							<div class="half_row">
								<span class="one_line_span">Uprawnienia:</span>
							</div> 	
							<div class="half_row_right">
								<select class="tx" name="uprawnienia">
									<?php 
										$table = ["administrator","pracownik","ksiegowosc"];
										for($a=0;$a<count($table);$a++)
										{
											
											if($uprawnienia == $table[$a]) {
												echo "<option selected value='".$uprawnienia."'>".$uprawnienia."</option> ";
											} else {
												echo "<option value='".$table[$a]."'>".$table[$a]."</option> ";
											}
										}
									?>
								</select>
							</div>	
						</div>
					</div>
					<div class="center_holder">
						<button type="submit" class="button" name="id_p" value="<?php echo $id_p;?>">Aktualizuj</button>
					</div>
				</form>
				</div>	
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
	
</script>
</body>
</html>

$table = ["W trakcie realizacji","Zamówienie gotowe do wysyłki","Zamówienie przekazane dostawcy","Zamówienie zrealizowane","Zamówienie anulowane"];
						for($a=0;$a<count($table);$a++)
						{
							$sta = "".$zamowienie[0]['status']."";
							if($sta == $table[$a]) {
								echo "<option selected value='".$sta."'>".$sta."</option> ";
							} else {
								echo "<option value='".$table[$a]."'>".$table[$a]."</option> ";
							}
						}
						?>

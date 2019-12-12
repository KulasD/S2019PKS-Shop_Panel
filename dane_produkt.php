<?php

	session_start();
	
	if (!isset($_SESSION['zalogowany']))
	{
		header('Location: index.php');
		exit();
	}
	
?>

<?php
	if ( isset( $_GET['idp'] ) && !empty( $_GET['idp'] ) )
	{
		$produkt = $_GET['idp'];
		$_SESSION['produkt_id'] = $produkt;
	} 
	else {
		header('Location: main_page.php');
		exit();
	}
?>

<?php

	$con = mysqli_connect("localhost","root","","przedmioty");
	mysqli_query($con, "SET CHARSET utf8");
	mysqli_query($con, "SET NAMES 'utf8' COLLATE 'utf8_polish_ci'");
	$query = "SELECT * FROM przedmioty_ogolne_informacje WHERE id_produktu='$produkt'";
	$result = mysqli_query($con,$query);
	$r_o = $result->fetch_array(MYSQLI_ASSOC);
	$kat = $r_o['kategoria'];
	$_SESSION['kat'] = $kat;
	$_SESSION['zdj_main'] = $r_o['zdjecie'];

	$query = "SELECT * FROM ".$kat."_full WHERE id_produktu='$produkt'";
	$result = mysqli_query($con,$query);
	$r_f = $result->fetch_array();
	$_SESSION['id_full'] = $r_f['id_full'];
	
	$query_op = "SELECT * FROM opis_przedmiotu WHERE id_produktu='$produkt'";
	$result_op = mysqli_query($con,$query_op);

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
						Produkt
					</div>
				</div>
				<form action="produkt_update.php" method="post" enctype="multipart/form-data">
				<div class="half_width">
					<span class="info_span">Podstawowe dane produktu</span>
					<div class="bordered_div_no_padding">
						<div class="row">
							<div class="half_row">
								Kategoria:
							</div>				
							<div class="half_row_right">
								<input type="text" class="tx" name="kategoria" disabled value="<?php echo $kat; ?>"/>
							</div>
						</div>
						<div class="row">
							<div class="half_row">
								Nazwa produktu:
							</div>				
							<div class="half_row_right">
								<input type="text" class="tx" name="nazwa_produktu" value="<?php echo $r_o['nazwa']; ?>"/>
							</div>
						</div>
						<div class="row">
							<div class="half_row">
								Pełna nazwa produktu:
							</div>				
							<div class="half_row_right">
								<input type="text" class="tx" name="nazwa_produktu_full" value="<?php echo $r_o['pelna_nazwa']; ?>"/>
							</div>
						</div>
						<div class="row">
							<div class="half_row">
								Cena:
							</div>				
							<div class="half_row_right">
								<div class="flex_box relative">
									<div class="margin_right center_form">brutto: </div>
									<div><input type="number" class="tx" name="cena_brutto" step="0.01" value="<?php echo $r_o['cena']; ?>"/></div>  
									<div class="margin_left center_form">zł</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="half_row">
								Sztuki:
							</div>				
							<div class="half_row_right">
								<input type="number" class="tx" name="sztuki" value="<?php echo $r_o['sztuki']; ?>"/>
							</div>
						</div>
						<?php								
								$query = "SELECT * FROM nazwy_filtrow WHERE kategoria='$kat'";
								$result = mysqli_query($con,$query);
								$filtry = array();
								$filtry_full = array();
								while($r = $result->fetch_array(MYSQLI_ASSOC)){
									$filtry[] = $r;
									$x = array_keys($r);
									$id_f = $r['id_filtr'];
									$query_fi = "SELECT * FROM filtry WHERE id_filtru='$id_f' ORDER BY id_f ASC";
									$result_fi = mysqli_query($con,$query_fi);
									while ($r_fi = $result_fi->fetch_array(MYSQLI_ASSOC)) {
										$filtry_full[] = $r_fi;
									};	
								};
								$qq = 1;
								for($q=2;$q<count($x);$q++)
								{
									if($x[$q] == "p".$q) {} else {
									echo "<div class='row'>
								<div class='half_row'>
									".$filtry[0][$x[$q]]."
								</div>				
								<div class='half_row_right'>
									<select id='parametr".$qq."' name='parametr".$qq."' class='tx'>";
									for($t=0; $t < count($filtry_full); $t++)
									{
										if($filtry_full[$t][$x[$q]] == '') {} 
										else {
											$check = false; // Pomocnicza zmienna
											for($j=1;$j<sizeof($filtry_full)-1;$j++) // Filtry_full mają dlugosc (aktualnie) 5, id,id_filtru, i trzy parametry. Potrzeba liczy tylko trzech parametrów a musi sie zaczynać od 1 bo nizej uzupełnia parametry_1, _2 ,_3 tak jak w bazie przedmioty_ogolne_informacje. No to trzeba start od 1 i end przy 4. 
											{
												$par = "parametr_$j";
												if(($filtry_full[$t][$x[$q]] ==$r_o[$par])) // i tu twoje stare trzy ify robi się czyli jezeli się równa to selected
												{
													echo "<option selected value='".$filtry_full[$t][$x[$q]]."'>".$filtry_full[$t][$x[$q]]."</option>";
													$check = true; // jeżeli sie zaznaczy daje pomocnicza na true zeby to nizej sie nie wykonało a jak bedzie false to sie wykona 
												};
											}
											if($check == false ) { 
												echo "<option value='".$filtry_full[$t][$x[$q]]."'>".$filtry_full[$t][$x[$q]]."</option>";
											}
										};
										
									}
									echo" </select>
								</div>
									</div>"; }
									$qq++;
								}
						?>						
						<div class="row">
							<div class="half_row">
								Zdjęcie główne:
							</div>				
							<div class="half_row_right">
								<input type="file" name="main_zdj" id="main_zdj"/>
							</div>
						</div>
						
					</div>
					<span class="info_span" style="margin-top:10px;">Opisy dodatkowe</span>
					<div class="bordered_div_no_padding">
					<?php
					$licze = 1;
					while ($r_op = $result_op->fetch_array(MYSQLI_ASSOC)){
						$_SESSION['zdj'.$licze] = $r_op['zdjecie'];
						echo "
						<div class='row_no_border'>
							<div class='half_row'>
								Nagłówek ".$licze." (temat ".$licze." w bazie):
							</div>				
							<div class='half_row_right'>
								<input type='text' class='tx' name='n".$licze."' value='".$r_op['temat']."'/>
							</div>
						</div>
						<div class='row_no_border'>
							<div class='half_row'>
								Opis ".$licze." (opis ".$licze." w bazie):
							</div>				
							<div class='half_row_right'>
								<textarea class='areatx tx' rows='6' name='o".$licze."'>".$r_op['opis']."</textarea>
							</div>
						</div>
						<div class='row'>
							<div class='half_row'>
								Zdjęcie ".$licze.":
							</div>				
							<div class='half_row_right'>
								<input type='file' name='zdj".$licze."' id='zdj".$licze."'/>
							</div>
						</div>";
						$licze++;
					}
					?>
					</div>
				</div>
				<?php
						$query_atr = 	"SELECT `COLUMN_NAME` 
										FROM `INFORMATION_SCHEMA`.`COLUMNS` 
										WHERE `TABLE_NAME`='".$kat."_full' LIMIT 100 OFFSET 2;";
						$result_atr = mysqli_query($con,$query_atr);
						
						echo 	"<div class='half_width'>
									<span class='info_span'>Szczegółowe dane produktu</span>
										<div class='bordered_div_no_padding'>";
						$licznik = 1;
						$_SESSION['licznik_kat'] = $result_atr->num_rows;
						while($r_atr = $result_atr->fetch_array(MYSQLI_ASSOC)){	
							echo 	"<div class='row'>
										<div class='half_row'>
											".$r_atr['COLUMN_NAME']."
										</div>				
										<div class='half_row_right'>
											<input type='text' class='tx' name='atr".$licznik."' value='".$r_f[$licznik+1]."'/>
										</div>
									</div>";
									$licznik++;
						}
						
						echo	"</div>
								</div>";
				?>
				<div style="clear:both;"></div>
					<div class="center_holder">
						<button type="submit" class="button" name="update">Aktualizuj</button>
					</div>
				</form>
			</div>
		</div>
		<div style="clear:both;"></div>
	</div>
</body>
</html>

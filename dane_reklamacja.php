<?php

	session_start();
	
	if (!isset($_SESSION['zalogowany']))
	{
		header('Location: index.php');
		exit();
	}
	
?>

<?php
if ( isset( $_GET['id'] ) && !empty( $_GET['id'] ) )
	{
	$id_r = $_GET['id'];
	} else {
	header('Location: zwroty_lista.php');exit();};
	$con = mysqli_connect("localhost","root","","user");
	mysqli_query($con, "SET CHARSET utf8");
	mysqli_query($con, "SET NAMES 'utf8' COLLATE 'utf8_polish_ci'");
	$conA = mysqli_connect("localhost","root","","administracja");
	mysqli_query($conA, "SET CHARSET utf8");
	mysqli_query($conA, "SET NAMES 'utf8' COLLATE 'utf8_polish_ci'");
	$rows_reklamacja = array();
	$rows_product_r = array();
	$rows_info_r = array();
	$qu = "SELECT * FROM reklamacje WHERE id_rek='$id_r'";
	$resu = mysqli_query($con,$qu);
	$user = array();
	$pracownik = array();
	$zamowienie = array();
	while ($ry = $resu->fetch_array(MYSQLI_ASSOC)) {
		$rows_reklamacja[] = $ry;
		$id_reklamacja = $ry['id_zamow_p'];
		$id_zamowienie = $ry['id_zamowienie'];
		$query_z = "SELECT * FROM zamowienie_informacje WHERE id_zamowienie='$id_zamowienie'";
		$result_z = mysqli_query($con,$query_z);
		while($rez = $result_z->fetch_array(MYSQLI_ASSOC)) {
			$zamowienie[] = $rez;
			$id_pracownik = $rez['id_pracownik'];
			$query_r = "SELECT * FROM kadra WHERE id='$id_pracownik'";
			$result_r = mysqli_query($conA,$query_r);
			while($rer = $result_r->fetch_array(MYSQLI_ASSOC)) {
				$pracownik[] = $rer;
			};	
		};	
		$query_r = "SELECT * FROM zamowienie_przedmiot WHERE id_zamow_p='$id_reklamacja'";
		$result_r = mysqli_query($con,$query_r);
			while($re_r = $result_r->fetch_array(MYSQLI_ASSOC)) {
				$rows_product_r[] = $re_r;
				$id_produktu = $re_r['id_produktu'];
				$pol = mysqli_connect("localhost","root","","przedmioty");
				mysqli_query($pol, "SET CHARSET utf8");
				mysqli_query($pol, "SET NAMES 'utf8' COLLATE 'utf8_polish_ci'");
				$getvalue_rr="SELECT * FROM przedmioty_ogolne_informacje WHERE id_produktu='$id_produktu'";
				$rezul_rr=mysqli_query($pol,$getvalue_rr);
				while ($q_rr = $rezul_rr->fetch_array(MYSQLI_ASSOC)) {
					$rows_info_r[] = $q_rr;
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
						Reklamacja <?php echo"".$rows_reklamacja[0]['id_rek']."";?>
					</div>
				</div>
				<div class="half_width">
					<span class="info_span">Dane reklamującego</span>
					<div class="bordered_div_no_padding">
						<div class="row">
							<div class="half_row">
								Imię i nazwisko:
							</div>				
							<div class="half_row_right">
								<span id="imie_i_nazwisko"><?php echo"".$rows_reklamacja[0]['name_surname']."";?></span>
							</div>
						</div>
						<div class="row">
							<div class="half_row">
								Dane adresowe:
							</div>				
							<div class="half_row_right">
								<div class="flex-box">
									<span id="ul" >
										<?php echo"".$rows_reklamacja[0]['adres']."";?>
									</span>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="half_row">
								Dane kontaktowe:
							</div>				
							<div class="half_row_right">
								<div class="flex-box">
									<span id="tel" class="one_line_span">
										<?php echo"".$rows_reklamacja[0]['nr_tel']."";?>
									</span>
									<span id="email">
										<?php echo"".$rows_reklamacja[0]['email']."";?>
									</span>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="half_row">
								ID użytkownika:
							</div>				
							<div class="half_row_right">
								<span id="id_usera">
									<?php echo"".$rows_reklamacja[0]['id_user']."";?>
								</span>
							</div>
						</div>
						
					</div>
				</div>
				<div class="half_width">
					<span class="info_span">Dane produktu</span>
					<div class="bordered_div_no_padding">
						<div class="row">
							<div class="half_row">
								Produkt:
							</div>				
							<div class="half_row_right">
								<span id="nazwa_produktu"><?php echo"".$rows_info_r[0]['pelna_nazwa']."";?></span>
							</div>
						</div>
						<div class="row">
							<div class="half_row">
								Producent:
							</div>				
							<div class="half_row_right">
								<span id="producent_produktu"><?php echo"".$rows_info_r[0]['parametr_1']."";?></span>
							</div>
						</div>
						<div class="row">
							<div class="half_row">
								ID produktu:
							</div>				
							<div class="half_row_right">
								<span id="id_produktu"><?php echo"".$rows_info_r[0]['id_produktu']."";?></span>
							</div>
						</div>
						<div class="row">
							<div class="half_row">
								Ilość:
							</div>				
							<div class="half_row_right">
								<span id="quantity"><?php echo"".$rows_reklamacja[0]['quantity']."";?></span>
							</div>
						</div>
					</div>
				</div>
				<div style="clear:both;"></div>
				<?php
					$adres = explode(",", $zamowienie[0]['adres']);
					$dane_odbiorcy= explode(",", $zamowienie[0]['dane_odbiorcy']);
					$dane_zamawiajacego= explode(",", $zamowienie[0]['dane_zamawiajacego']);
					$user_or_firma = '';
					if(((int)$dane_zamawiajacego[1] / 1 == (int)$dane_zamawiajacego[1]) && (int)$dane_zamawiajacego[1] != 0) {
						$user_or_firma = 'Firma';
						$adres = "".$adres[0]."".$adres[1]."<br />".$adres[2]." <br />".$adres[3]."".$adres[4]."";
						$dane_kontaktowe = "".$dane_odbiorcy[2]." <br />".$dane_odbiorcy[3]."";
					} else {
						$user_or_firma = 'Klient indywidualny'; 
						$adres = "".$adres[0]."".$adres[1]."<br />".$adres[3]."".$adres[4]."";
						$dane_kontaktowe = "".$dane_odbiorcy[2]." <br />".$dane_odbiorcy[3]."";
					};
				?>
				<div class="half_width">
					<span class="info_span">Dane klienta odczytane na podstawie zamówienia</span>
					<div class="bordered_div_no_padding">
						<div class="row">
							<div class="half_row">
								Nr zamówienia:
							</div>				
							<div class="half_row_right">
								<span id="id_zamowienia"><?php echo"".$rows_reklamacja[0]['id_zamowienie']."";?></span>
							</div>
						</div>
						<div class='row'>
							<div class='half_row'>
								Informacje o kliencie:
							</div>				
							<div class='half_row_right'>
								<?php echo"".$user_or_firma."";?>
							</div>
						</div>
						<div class="row">
							<div class="half_row">
								Data zamówienia:
							</div>				
							<div class="half_row_right">
								<span id="data_zamowienia">
									<?php echo"".$zamowienie[0]['data_zamowienia']."";?>
								</span>
							</div>
						</div>
						<div class="row">
							<div class="half_row">
								Dane adresowe:
							</div>				
							<div class="half_row_right">
								<div class="flex-box">
									<span id="ul" class="one_line_span">
										<?php echo"".$adres."";?>
									</span>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="half_row">
								Dane kontaktowe:
							</div>				
							<div class="half_row_right">
								<div class="flex-box">
									<span id="tel" class="one_line_span">
										<?php echo"".$dane_kontaktowe."";?>
									</span>
								</div>
							</div>
						</div>
						
						
					</div>
				</div>
				
				<div class="half_width">
					<span class="info_span">Dane zgłoszenia</span>
					<div class="bordered_div_no_padding">
						<div class="row">
							<div class="half_row">
								Data zgłoszenia reklamacji:
							</div>				
							<div class="half_row_right">
								<span id="data_reklamacji"><?php echo"".$rows_reklamacja[0]['data_reklamacji']."";?></span>
							</div>
						</div>
						<div class="row">
							<div class="half_row">
								Sposób reklamacji:
							</div>				
							<div class="half_row_right">
								<span id="way">
									<?php echo"".$rows_reklamacja[0]['way']."";?>
								</span>
							</div>
						</div>
						<div class="row">
							<div class="half_row">
								Opis klienta:
							</div>				
							<div class="half_row_right">
								<span id="opis_uszkodzenia_klient">
									<?php echo"".$rows_reklamacja[0]['description']."";?>
								</span>
							</div>
						</div>
						
						
					</div>
				</div>
				<div style="clear:both;"></div>
				<form action="reklamacja_update.php" method="post">
					<div id="produkty_start">
						<span class="info_span">Obsługa reklamacji</span>
						<div class="bordered_div_no_padding">
							<div class="half_width">
								<div class="flex_box_padding">
									<div class="half_row">
										Status reklamacji:
									</div>				
									<div class="half_row_right2">
										<select id="status_reklamacji" class="tx" name="status">
										<?php
										$table_status = ['Sklep czeka na produkt','W trakcie sprawdzania przez pracownika','Produkt dostarczony','W trakcie reklamacji','Reklamacja zrealizowana','Reklamacja odrzucona', 'Reklamacja zrealizowana, towar odesłany do klienta','Reklamacja odrzucona, towar odesłany do klienta'];
											for($q = 0; $q<count($table_status);$q++)
											{
												if($table_status[$q] == $rows_reklamacja[0]['status']) {
													echo "<option value='".$rows_reklamacja[0]['status']."' selected>".$rows_reklamacja[0]['status']."</option>'";
												} else {
													echo "<option value='".$table_status[$q]."'>".$table_status[$q]."</option>'";
												}
											}
										?>
										</select>
									</div>
								</div>
								<div class="flex_box_padding">
									<div class="half_row">
									<?php 
									$a = "".$rows_reklamacja[0]['nr_konta']."";
									if($a != '') { 
									echo "Nr konta bankowego</div>				
									<div class='half_row_right2'>
										<div class='half_row_right'>
											<span class='one_line_span'>".$rows_reklamacja[0]['nr_konta']."</span><br />
										</div>
									</div>";
									} else {
										echo "Sposób odbioru po reklamacji:</div>				
									<div class='half_row_right2'>
										<span class='one_line_span'>".$rows_reklamacja[0]['sposób_odbioru']."</span> <br />
									</div>";
									}
									?>
									
								</div>
								<div class="margin_box_left">
									<span class="one_line_span">Wyposażenie otrzymanego towaru</span>
									<textarea class="areatx tx" rows="4" name="wyposazenie"></textarea>
								</div>
								<div class="margin_box_left">
									<span class="one_line_span">Komentarz do reklamującego</span>
									<textarea class="areatx tx" rows="4" name="komentarz"></textarea>
								</div>
								<div class="margin_box_left" style="padding-bottom:5px;">
									<div class="flex_box_space">
										<div></div>
										<div>
										<a href='#'><button type="button" class="button_green">Wyślij e-mail</button></a><!-- Automatyczny email do uzytkownika, aby spakował przedmiot i wysłał na adres-->
										</div>
									</div>
								</div>
							</div>
							<div class="half_width">
								<div class="flex_box_padding">
									<div class="half_row2">
										RMA serwisu:
									</div>				
									<div class="half_row_right">
										<input class="tx" type="text" name="RMA_serwis"/>
									</div>
								</div>
								<div class="flex_box_padding">
									<div class="half_row2">
										Przyporządkowany pracownik:
									</div>				
									<div class="half_row_right">
										<select id="pracownik" class="tx" name="id_pracownik">
										<option> Pracownik do zwrotów nr 1 </option>
										</select>
									</div>
								</div>
								<div class="margin_box_right">
									<span class="one_line_span">Opis naprawy</span>
									<textarea class="areatx tx" rows="4" name="opis_naprawy"></textarea>
								</div>
							</div>
							<div style="clear:both;"></div>
						</div>
						<div class="center_holder">
							<button type="submit" class="button" name="id_rekl" value="<?php echo"".$rows_reklamacja[0]['id_rek']."";?>">Zapisz zmiany</button>
						</div>
					</form>
					</div>
			</div>
		</div>
		<div style="clear:both;"></div>
	</div>
</body>
</html>

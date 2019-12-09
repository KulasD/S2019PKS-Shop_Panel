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
	$id_zwrotu = $_GET['id'];
	} else {
	header('Location: zwroty_lista.php');exit();};
	$con = mysqli_connect("localhost","root","","user");
	mysqli_query($con, "SET CHARSET utf8");
	mysqli_query($con, "SET NAMES 'utf8' COLLATE 'utf8_polish_ci'");
	$conA = mysqli_connect("localhost","root","","administracja");
	mysqli_query($conA, "SET CHARSET utf8");
	mysqli_query($conA, "SET NAMES 'utf8' COLLATE 'utf8_polish_ci'");
	$rows = array();
	$rows_info = array();
	$ids = array();
	$user = array();
	$zamowienie = array();
	$pracownik = array();
	$query = "SELECT * FROM zwroty WHERE id_zwrot='$id_zwrotu'";
	$result = mysqli_query($con,$query);
	while ($r = $result->fetch_array(MYSQLI_ASSOC)) {
		$rows[] = $r;
		$ids[] = explode("|", $r['produkty']);
		$id_user = $r['id_user'];
		$id_zamowienie = $r['id_zamowienie'];
		$query_u = "SELECT * FROM uzytkownicy WHERE id_user='$id_user'";
		$result_u = mysqli_query($con,$query_u);
		while($reu = $result_u->fetch_array(MYSQLI_ASSOC)) {
			$user[] = $reu;
		};	
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
		
	}	
	$j = -1;
	for($i = 0; $i < count($ids) ; $i++)
		{
			for($k = 0; $k < count($ids[$i]); $k++)
			{
				$j++;
				$id = explode(",", $ids[$i][$k]);
				if($id[0] == '')
				{} else {
					$query_x = "SELECT * FROM zamowienie_przedmiot WHERE id_zamow_p='$id[0]'";
					$result_x = mysqli_query($con,$query_x);
					while($re = $result_x->fetch_array(MYSQLI_ASSOC)) {
						$rows_product[$j] = $re;
						$rows_product[$j]['ilosc']	= $id[1];
						$id_produktu = $re['id_produktu'];
						$pol = mysqli_connect("localhost","root","","przedmioty");
						mysqli_query($pol, "SET CHARSET utf8");
						mysqli_query($pol, "SET NAMES 'utf8' COLLATE 'utf8_polish_ci'");
						$getvalue="SELECT * FROM przedmioty_ogolne_informacje WHERE id_produktu='$id_produktu'";
						$rezul=mysqli_query($pol,$getvalue);
						while ($q = $rezul->fetch_array(MYSQLI_ASSOC)) {
							$rows_info[$j] = $q;				
							}						
						}	
					}
			}
		};
	$order_all = array();
	$hel = 0;
	$ind = 0;
	for($r=0;$r<count($rows_info);$r++)
		{
			$order_all[$hel][$ind]=$rows_info[$r];
			$order_all[$hel][$ind]["info"] =$rows_product[$r];
			$ind++;
	};



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
						Zwrot <?php echo "".$rows[0]['id_zwrot']."";?>
					</div>
				</div>
				<div class="half_width">
					<span class="info_span">Dane zwracającego</span>
					
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
					echo "<div class='bordered_div_no_padding'>
						<div class='row'>
							<div class='half_row'>
								Imie i nazwisko:
							</div>				
							<div class='half_row_right'>
								<span id='imie_i_nazwisko'>".$user[0]['name']." ".$user[0]['surname']."</span>
							</div>
						</div>
						<div class='row'>
							<div class='half_row'>
								Dane adresowe:
							</div>				
							<div class='half_row_right'>
								<div class='flex-box'>
									<span id='ul' class='one_line_span'>
										".$user[0]['adres']."
									</span>
									<span id='kod'>
										".$user[0]['kod_pocztowy']."
									</span>
									<span id='miejscowosc'>
										".$user[0]['miejscowosc']."
									</span>
								</div>
							</div>
						</div>
						<div class='row'>
							<div class='half_row'>
								Dane kontaktowe:
							</div>				
							<div class='half_row_right'>
								<div class='flex-box'>
									<span id='tel' class='one_line_span'>
										".$user[0]['nr_tel']."
									</span>
									<span id='email'>
										".$user[0]['email']."
									</span>
								</div>
							</div>
						</div>
						<div class='row'>
							<div class='half_row'>
								ID użytkownika:
							</div>				
							<div class='half_row_right'>
								<span id='id_usera'>
									".$user[0]['id_user']."
								</span>
							</div>
						</div>
					</div>
					<span class='info_span' style='margin-top:10px;'>Dane zgłoszenia</span>
					<div class='bordered_div_no_padding'>
						<div class='row'>
							<div class='half_row'>
								Data zgłoszenia zwrotu:
							</div>				
							<div class='half_row_right'>
								<span id='data_zwrotu'>".$rows[0]['data_zwrotu']."</span>
							</div>
						</div>
						<div class='row'>
							<div class='half_row'>
								Powód (opcjonalnie):
							</div>				
							<div class='half_row_right'>
								<span id='powod'>
									".$rows[0]['powod']."
								</span>
							</div>
						</div>
						<div class='row'>
							<div class='half_row'>
								Podany nr konta klienta:
							</div>				
							<div class='half_row_right'>
								<span id='konto'>
									".$rows[0]['nr_konta']."
								</span>
							</div>
						</div>

					</div>
				</div>
				<div class='half_width'>
					<span class='info_span'>Dane odczytane na podstawie zamówienia</span>
					<div class='bordered_div_no_padding'>
						<div class='row'>
							<div class='half_row'>
								Informacje o kliencie:
							</div>				
							<div class='half_row_right'>
								<span>".$user_or_firma."</span>
							</div>
						</div>
						<div class='row'>
							<div class='half_row'>
								Nr zamówienia:
							</div>				
							<div class='half_row_right'>
								<span id='id_zamowienia'>".$rows[0]['id_zamowienie']."</span>
							</div>
						</div>
						<div class='row'>
							<div class='half_row'>
								Data zamówienia:
							</div>				
							<div class='half_row_right'>
								<span id='data_zamowienia'>
									".$zamowienie[0]['data_zamowienia']."
								</span>
							</div>
						</div>
						<div class='row'>
							<div class='half_row'>
								Dane adresowe:
							</div>				
							<div class='half_row_right'>
								<div class='flex-box'>
									<span class='one_line_span'>
										".$adres."
									</span>
								</div>
							</div>
						</div>
						<div class='row'>
							<div class='half_row'>
								Dane kontaktowe:
							</div>				
							<div class='half_row_right'>
								<div class='flex-box'>
									<span class='one_line_span'>
										".$dane_kontaktowe."
									</span>
								</div>
							</div>
						</div>
						<div class='row'>
							<div class='half_row'>
								Opiekun zamówienia:
							</div>				
							<div class='half_row_right'>
								<div class='flex-box'>
									<span class='one_line_span'>
										".$pracownik[0]['imie']." ".$pracownik[0]['nazwisko']." <br />
										ID: ".$pracownik[0]['id']." 
									</span>
								</div>
							</div>
						</div>
						
					</div>
				</div>";
					?>


				<div style="clear:both;"></div>
					<div id="produkty_start">
						<span class="info_span">Obsługa zwrotu</span>
						<div class="bordered_div_no_padding">
							<div class="half_width">
								<div class="flex_box_padding">
									<div class="half_row">
										Status zwrotu:
									</div>				
									<div class="half_row_right2">
										<select id="status_zwrotu" class="tx"><?php 
										$table_status = ['Sklep czeka na produkt','W trakcie realizacji','Produkt otrzymany, w trakcie sprawdzania','Zwrot dokonany','Zwrot anulowany','Zwrot anulowany, towar odesłany do klienta'];
											for($q = 0; $q<count($table_status);$q++)
											{
												if($table_status[$q] == $rows[0]['status']) {
													echo "<option value='".$rows[0]['status']."' selected>".$rows[0]['status']."</option>'";
												} else {
													echo "<option value='".$table_status[$q]."'>".$table_status[$q]."</option>'";
												}
											}
										?></select>
									</div>
								</div>
								<div class="margin_box_left">
									<span class="one_line_span">Wyposażenie otrzymanego towaru</span>
									<textarea class="areatx tx" rows="4"></textarea>
								</div>
								
							</div>
							<div class="half_width">
								<div class="flex_box_padding">
									<div class="half_row2">
										Przyporządkowany pracownik:
									</div>				
									<div class="half_row_right">
										<select id="pracownik" class="tx">
										<option> Pracownik do zwrotów nr 1 </option>
										</select>
									</div>
								</div>
								<div class="margin_box_right">
									<span class="one_line_span">Komentarz do klienta</span>
									<textarea class="areatx tx" rows="4"></textarea>
								</div>
								<div class="margin_box_right" style="padding-bottom:5px;">
									<div class="flex_box_space">
										<div></div>
										<div><a href='#'><button type="button" class="button_green">Wyślij</button></a></div>
									</div>
								</div>
							</div>
							<div style="clear:both;"></div>
						</div>
					</div>
					<div class="center_holder">
						<button type="button" class="button">Zapisz zmiany</button>
					</div>
					<div id="produkty_start">
						<div class="bordered_div_no_padding">
							<div class="row">
								<div class="hru1">
									ID
								</div>	
								<div class="hru2">
									ZDJĘCIE
								</div> 	
								<div class="hru3">
									NAZWA
								</div>	
								<div class="hru4">
									ILOŚĆ
								</div>	
								<div class="hru5">
									CENA JEDN.
								</div>	
								<div class="hru6">
									WARTOŚĆ
								</div>
							</div>
							
							<?php 
							$dostawa  = "".$zamowienie[0]['dostawa']."";
							$dostawa_ = explode(",", $dostawa);
							$cena_zamowienia = "".$zamowienie[0]['cena_zamowienia']."";
							$cena_zamowienia = number_format((float)$cena_zamowienia, 2, '.', '');
							if($dostawa_[1] == '') {$dostawa_[1] = "0";};
							$h=0;
							$suma_p = 0;
							$dostawa_c =$dostawa_[1];
							$dostawa_c = number_format((float)$dostawa_c, 2, '.', '');
							$rabat =  "".$zamowienie[0]['rabat']."";
							if($rabat != '') {
								$rrab = true;
								$quer = "SELECT * FROM kod_rabatowy WHERE kod='$rabat' ";
								$resu = mysqli_query($con,$quer);
								while ($r = $resu->fetch_array(MYSQLI_ASSOC)) {
									$procent = $r['rabat'];
								}
							} else {$procent = 'Brak rabatu'; $rrab = false;};
						
							for($t=0;$t<count($order_all[0]);$t++)
							{
								$id_przedmiot = "".$order_all[0][$t]['id_produktu']."";
								$localization = "".$order_all[0][$t]['lokalizacja']."";
								$src = "".$order_all[0][$t]['zdjecie']."";
								$nazwa = "".$order_all[0][$t]['pelna_nazwa']."";
								$ilosc = "".$order_all[0][$t]['info']['ilosc']."";
								$cena = "".$order_all[0][$t]['info']['price_one_quan']."";
								$cena = number_format((float)$cena, 2, '.', '');
								$sum = (int)$ilosc * (int)$cena;
								$sum = number_format((float)$sum, 2, '.', '');
								$suma_p = $suma_p + $sum;
								$suma_ = number_format((float)$suma_p, 2, '.', '');
							echo "<div class='row'>
								<div class='hru1'>".$h."</div>	<div class='hru2'><img src='../lepsza/category/".$localization."/".$src."'/></div> 	<div class='hru3'>".$nazwa."</div>	<div class='hru4'><span >".$ilosc."</span></div>	<div class='hru5'><span >".$cena." zł</span></div>	<div class='hru6'><span >".$sum." zł</span></div>
							</div>";
							$h++;
							}
							?>
							<div class="row">
								<div class="hr2">Wartość produktów:				</div><div class="hr3"><span id="wartosc"><?php echo "".$suma_." zł"?></span></div>
							</div>
							<div class="row">
								<div class="hr2">Koszt dostawy:				</div><div class="hr3"><span id="koszt_dostawy"><?php echo "".$dostawa_c." zł"?></span></div>
							</div>
							<?php
							if($rrab == true ) {
								echo "<div class='row'>
									<div class='hr2'>Rabat:				</div><div class='hr3'><span id='wartosc'>".$procent." %</span></div>
							</div>";
							$suma_p = (int)$suma_p * (1-((int)$procent * 0.01));
							$suma_ = number_format((float)$suma_p, 2, '.', '');
							};
							?>
							<div class="row">
								<div class="hr2">Razem do zwrotu:				</div><div class="hr3"><span id="do_zaplaty"><?php echo "".$suma_." zł"?></span></div></span>
							</div>
					</div>
				</div>
			</div>
		</div>
		<div style="clear:both;"></div>
	</div>
</body>
</html>

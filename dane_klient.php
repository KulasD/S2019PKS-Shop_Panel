<?php

	session_start();
	
	if (!isset($_SESSION['zalogowany']))
	{
		header('Location: index.php');
		exit();
	}
	
?>

<?php
	if (isset($_GET['kent'])){
		$yes = true;
		$wybraniec = $_GET['kent'];
		
		$yes_zam = false;
		$yes_rekl = false;
		$yes_zwr = false;
		$yes_zgl = false;

	$con = mysqli_connect("localhost","root","","user");
	mysqli_query($con, "SET CHARSET utf8");
	mysqli_query($con, "SET NAMES 'utf8' COLLATE 'utf8_polish_ci'");
	
	$query_user = "SELECT * FROM uzytkownicy WHERE id_user='$wybraniec'";
	$result_user = mysqli_query($con,$query_user);
	$r_user = $result_user->fetch_array(MYSQLI_ASSOC);
	$_SESSION['id_u'] = $r_user['id_user'];
	$_SESSION['pass'] = $r_user['pass'];
	$_SESSION['zarejestrowany'] = $r_user['zarejestrowany'];
	$_SESSION['kod_rejestracji'] = $r_user['kod_rejestracji'];
	$_SESSION['kod_zmiany_hasla'] = $r_user['kod_zmiany_hasla'];
	$_SESSION['ip_k'] = $r_user['ip'];
	
	$query_zgl = "SELECT * FROM zgloszenie_klienta WHERE id_user='$wybraniec' ORDER BY data DESC LIMIT 5";
	$result_zgl = mysqli_query($con,$query_zgl);
	if ($result_zgl->num_rows){$yes_zgl = true;}
	
	$query_zam = "SELECT * FROM zamowienie_informacje WHERE id_user='$wybraniec' ORDER BY id_zamowienie DESC LIMIT 2";
	$result_zam = mysqli_query($con,$query_zam);
	if ($result_zam->num_rows){$yes_zam = true;}
	
	$query_rekl = "SELECT * FROM reklamacje WHERE id_user='$wybraniec' ORDER BY id_rek DESC LIMIT 2";
	$result_rekl = mysqli_query($con,$query_rekl);
	if ($result_rekl->num_rows){$yes_rekl = true;}
	
	$rows = array();
	$rows_info = array();
	$ids = array();
	$user = array();
	$query = "SELECT * FROM zwroty WHERE id_user='$wybraniec'  ORDER BY id_zwrot DESC LIMIT 2";
	$result = mysqli_query($con,$query);
	if ($result->num_rows){$yes_zwr = true;}
	while ($r = $result->fetch_array(MYSQLI_ASSOC)) {
		$rows[] = $r;
		$ids[] = explode("|", $r['produkty']);
		$id_user = $r['id_user'];
		$query_u = "SELECT * FROM uzytkownicy WHERE id_user='$id_user'";
		$result_u = mysqli_query($con,$query_u);
		while($reu = $result_u->fetch_array(MYSQLI_ASSOC)) {
			$user[] = $reu;
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
			$rows_product[$j] = "pause";
			$rows_info[$j] = "pause";
		};
	$order_all = array();
	$hel = 0;
	$ind = 0;
	for($r=0;$r<count($rows_info);$r++)
		{
			if($rows_info[$r] == "pause")
			{$hel++; $ind=0;} else {
				$order_all[$hel][$ind]=$rows_info[$r];
				$order_all[$hel][$ind]["info"] =$rows_product[$r];
				$ind++;
			}
	};
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
				<?php include('search_bar.php'); ?>
			</div>
			<div id="main_content">
				<div id="panel_admin_border">
					<div id="panel_admin">
						Klient
					</div>
				</div>
				<form action="update_klient.php" method="post">
				<div class="half_width">
					<span class="info_span">Dane klienta</span>
					<div class="bordered_div_no_padding">
						<div class="row">
							<div class="half_row">
								Numer klienta:
							</div>				
							<div class="half_row_right">
								<input type="text" class="tx" name="id_klienta" value="<?php echo $r_user['id_user'];?>" disabled/>
							</div>
						</div>
						<div class="row">
							<div class="half_row">
								Nick klienta:
							</div>				
							<div class="half_row_right">
								<input type="text" class="tx" name="nick" value="<?php echo $r_user['nick'];?>"/>
							</div>
						</div>
						<div class="row">
							<div class="half_row">
								Imię:
							</div>				
							<div class="half_row_right">
								<input type="text" class="tx" name="imie" value="<?php echo $r_user['name'];?>"/>
							</div>
						</div>
						<div class="row">
							<div class="half_row">
								Nazwisko:
							</div>				
							<div class="half_row_right">
								<input type="text" class="tx" name="nazwisko" value="<?php echo $r_user['surname'];?>"/>
							</div>
						</div>	
						<div class="row">
							<div class="half_row">
								Płeć:
							</div>				
							<div class="half_row_right">
								<input type="text" class="tx" name="plec" value="<?php echo $r_user['sex'];?>"/>
							</div>
						</div>	
						<div class="row">
							<div class="half_row">
								Zmień hasło:
							</div>				
							<div class="half_row_right">
								<input type="text" style="width:75%;" class="tx" name="nowe_haslo" id="nowe_haslo" disabled/><button type="button" class="button" name="nowe_haslo" onclick="zmiana_hasla()">Zmień hasło</button>
							</div>
						</div>
						<div class="row">
							<div class="half_row">
								Email:
							</div>				
							<div class="half_row_right">
								<input type="text" class="tx" name="email" value="<?php echo $r_user['email'];?>"/>
							</div>
						</div>
						<div class="row">
							<div class="half_row">
								Adres IP z którego było zarejestrowane konto:
							</div>				
							<div class="half_row_right">
								<span id="ip"><?php echo $r_user['ip'];?></span>
							</div>
						</div>
						<div class="row">
							<div class="half_row">
								Adres:
							</div>				
							<div class="half_row_right">
								<input type="text" class="tx" name="adres" value="<?php echo $r_user['adres'];?>"/>
								<div class="flex_box">
									<div style="width:29%;"><input type="text" class="tx" name="kod" value="<?php echo $r_user['kod_pocztowy'];?>"/></div>
									<input type="text" class="tx" name="miejscowosc" value="<?php echo $r_user['miejscowosc'];?>"/>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="half_row">
								Nr telefonu:
							</div>				
							<div class="half_row_right">
								<input type="text" class="tx" name="telefon" value="<?php echo $r_user['nr_tel'];?>"/>
							</div>
						</div>
					</div>
					<div class="center_holder">
						<button type="submit" class="button" name="update">Aktualizuj</button>
					</div>
				</form>
				</div>
				<div class="half_width">
					<?php
					if ($yes_zgl){
					echo "
					<span class='info_span'>Ostatnie zgłoszenia od tego klienta</span>
						<div class='bordered_div_no_padding'> ";
							while ($r = $result_zgl->fetch_array(MYSQLI_ASSOC)) {
								$blokada = $r['blokada'];
								$status = $r['status'];
								if($blokada == '') {
								if($status == 'Nieprzeczytane') {$color = '#BBBBBB'; } else if($status == 'Przeczytane') {$color=''; } else {$color='#ABEFB3';};
								} else {$color = "#F59696";};
								$id_zgloszenie = $r['id_zgloszenie'];
								$query_korespondencja = "SELECT * FROM korespondencja WHERE id_zgloszenie='$id_zgloszenie'";
								$result_korespondencja = mysqli_query($con,$query_korespondencja);
								$r_korespondencja = $result_korespondencja->fetch_array(MYSQLI_ASSOC);
								echo "
									<div class='row' style='background-color:".$color."';>
										<div class='zgl_k1'>
											<span class='one_line_span'>".$id_zgloszenie."</span>
											<span class='one_line_span'>".$r['status']."</span>
											<span class='one_line_span green_span'>".$r_korespondencja['data']."</span>
										</div>	
										<div class='zgl_k2'>
											".$r['kategoria']."
										</div>	
										<div class='zgl_k3'>
											".$r['temat']."
										</div>
										<div class='zgl_k4'>
											".$r['data']."
										</div>	
										<div class='zgl_k5'>
											<div class='s_d_b'><button type='button' class='button' onclick='zgloszenie(".$id_zgloszenie.")'>CZYTAJ</button></div>
											
											<div class='s_d_b'><button type='button' class='red_button' onclick='add_block(".$id_zgloszenie.")'>ZABLOKUJ SPAM</button></div>
										</div>
									</div>
								";
								//<div class='s_d_b'><button type='button' class='red_button' onclick='delete_z(".$id_zgloszenie.")'>USUŃ</button></div>
							}
						echo "</div>";
					}
					?>
				</div>
				<div style="clear:both;"></div>
				<?php
								if ($yes_zam){
									echo "
				<div class='flex_box'><span class='info_span_bigger'>2 ostatnie zamówienia</span> <div><button type='button' class='button' onclick='zam_hist()' style='margin-top: 10px; margin-left: 5px;'>WIĘCEJ</button></div></div>
					<div class='bordered_div_no_padding'>
							<div class='row'>
								<div class='kd1'>NUMER ZAMÓWIENIA</div>	
								<div class='kd2'>STATUS</div> 	
								<div class='kd3'>PRODUKTY</div>	
								<div class='kd4'>DATA</div>	
								<div class='kd5'>DZIAŁANIA</div>	
							</div>	";			
							
									while ($r = $result_zam->fetch_array(MYSQLI_ASSOC)) {
										$id_zamowienie=$r['id_zamowienie'];
										$data_z = $r['data_zamowienia'];
										$status = $r['status'];
										$status_zaplaty = $r['status_zaplaty'];
										$id_pracownik = $r['id_pracownik'];
										if($id_pracownik == '0') {$color = '#BBBBBB';} else {$color = '';};
									if($status == 'Zamówienie zrealizowane' || $status == 'Zamówienie zrealizowane po zwrocie' || $status == 'Zamówienie zrealizowane po reklamacji') {
										$z = "color: #04A1EE !important";
									} else if ($status == 'W trakcie realizacji' || $status == 'Zamówienie zrealizowane (zwrot w toku)' || $status == 'Zamówienie zrealizowane (reklamacja w toku)' ||$status == 'Zamówienie gotowe do wysyłki' || $status == 'Zamówienie przekazane dostawcy') {
										$z = "color: gray !important";
									} else if($status == 'Zamówienie anulowane') {
										$z = "color: #CC0000 !important";
									}
										else if($status == 'W trakcie realizacji') {
										$z = "color: #CC0000 !important";
									}
										echo "<div class='row' style='background-color:".$color."';>
								<div class='kd1'>
									<span id='id_1'>Nr. ".$id_zamowienie."</span>
									
								</div>	
								<div class='kd2'>
									<div><span id='status_1' style='".$z."'>".$r['status']."</span></div>";
									if($status_zaplaty == "Zapłacono") {echo "<button class='zaplataB zbnp' >Zapłacono</button>";} else {echo "<button class='zaplataBN zbnp' >Niezapłacono</button>"; } 
								echo "</div>
								<div class='kd3'>";
								$qu = "SELECT * FROM zamowienie_przedmiot WHERE id_zamowienie = '$id_zamowienie' ";
										$re = mysqli_query($con,$qu);
										while ($rr = $re->fetch_array(MYSQLI_ASSOC)) {
											$przed = mysqli_connect("localhost","root","","przedmioty");
											mysqli_query($przed, "SET CHARSET utf8");
											mysqli_query($przed, "SET NAMES 'utf8' COLLATE 'utf8_polish_ci'");	
											$id_produktu = $rr['id_produktu'];
											$q = "SELECT * FROM przedmioty_ogolne_informacje WHERE id_produktu = '$id_produktu' ";
											$res = mysqli_query($przed,$q);
											while ($rrr = $res->fetch_array(MYSQLI_ASSOC)) {
												echo "<span class='one_line_span'>".$rrr['pelna_nazwa']."</span>";
											}
										}
								echo "
								</div>	
								<div class='kd4'>".$data_z."</div>
								<div class='kd5'>
									<button type='button' class='button' onclick='go(".$id_zamowienie.")'>EDYTUJ</button>
								</div>
							</div>";

									}
								
							
								echo "</div>";
								}
								?>
				<?php
					if ($yes_rekl){
						echo "
				<div class='flex_box'><span class='info_span_bigger'>2 ostatnie reklamacje</span> <div><button type='button' class='button' onclick='rekl_hist()' style='margin-top: 10px; margin-left: 5px;'>WIĘCEJ</button></div></div>
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

								</div>
							</div>";
								};	
								
						echo "</div>";
						}
							?>
							<?php
							if ($yes_zwr){
								echo "
				<div class='flex_box'><span class='info_span_bigger'>2 ostatnie zwroty</span> <div><button type='button' class='button' onclick='zwroty_hist()' style='margin-top: 10px; margin-left: 5px;'>WIĘCEJ</button></div></div>
						<div class='bordered_div_no_padding'>
							<div class='row'>
								<div class='kd1'>
									<span class='one_line_span'>ID ZWROTU</span>
								</div>	
								<div class='kd2'>STATUS</div>	
								<div class='kd3'>ZWRACANY PRODUKT</div>
								<div class='kd4'>DATA ZGŁOSZENIA</div>	
								<div class='kd5'>DZIAŁANIA</div>
							</div>";
						
							for($d=0;$d<count($rows);$d++)
							{
								echo "<div class='row'>
									<div class='kd1'>
										<span class='one_line_span '>".$rows[$d]['id_zwrot']."</span>
									</div>	
									<div class='kd2'>
										<span class=one_line_span>".$rows[$d]['status']."</span>
									</div>	
									<div class='kd3'>";
									for($s=0;$s<count($order_all[$d]);$s++)
									{
										echo "
										<div class='flex_box'>
											<span class='one_line_span'>
												<b>".$order_all[$d][$s]['info']['ilosc']."x</b> ".$order_all[$d][$s]['pelna_nazwa']."
											</span>
										</div>
										";
									};
									echo "</div>
									<div class='kd4'>".$rows[$d]['data_zwrotu']."</div>	
									<div class='kd5'>
										<div class='s_d_b'><button type='button' class='button' onclick='zwrot_go(".$rows[$d]['id_zwrot'].")'>EDYTUJ</button></div>

									</div>
								</div>";
							};
							
						echo "</div>";
						}	
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
		window.location.href = "klient_zam_hist.php";
	}
	
	function rekl_hist(){
		window.location.href = "klient_rekl_hist.php";
	}
	
	function zwroty_hist(){
		window.location.href = "klient_zwroty_hist.php";
	}
	
</script>
</body>
</html>

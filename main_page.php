<?php

	session_start();
	
	if (!isset($_SESSION['zalogowany']))
	{
		header('Location: index.php');
		exit();
	}
	
	require_once "connect.php";
	//polaczenie z user
	//ile zamowień, zarejestrowanych użytkowników
	$polaczenie = @new mysqli($host, $db_user, $db_password, $db_users);
	
	if ($polaczenie->connect_errno!=0)
	{
		echo "Error: ".$polaczenie->connect_errno;
	}
	else
	{
		$polaczenie->query("SET CHARSET utf8");
		$polaczenie->query("SET NAMES 'utf8' COLLATE 'utf8_polish_ci'");
		if ($rezultat = @$polaczenie->query(
		sprintf("SELECT id_zamowienie FROM zamowienie_informacje")))
		{
			$ile_zamowien = $rezultat->num_rows;
		}
		if ($rezultat = @$polaczenie->query(
		sprintf("SELECT id_user FROM uzytkownicy WHERE zarejestrowany='tak'")))
		{
			$ilu_uzytkownikow = $rezultat->num_rows;
		}
		$polaczenie->close();
	}
	//licz produkty
	$polaczenie = @new mysqli($host, $db_user, $db_password, $db_items);
	if ($polaczenie->connect_errno!=0)
	{
		echo "Error: ".$polaczenie->connect_errno;
	}
	else
	{
		$polaczenie->query("SET CHARSET utf8");
		$polaczenie->query("SET NAMES 'utf8' COLLATE 'utf8_polish_ci'");
		if ($rezultat = @$polaczenie->query(
		sprintf("SELECT id_produktu FROM przedmioty_ogolne_informacje")))
		{
			$ile_produktow = $rezultat->num_rows;
		}
		if ($rezultat = @$polaczenie->query(
		sprintf("SELECT id_produktu FROM przedmioty_ogolne_informacje WHERE sztuki>0")))
		{
			$ile_produktow_dostepnych = $rezultat->num_rows;
		}
	}

	// Wszystkie produkty wykres
		$con = mysqli_connect("localhost","root","","user");
		mysqli_query($con, "SET CHARSET utf8");
		mysqli_query($con, "SET NAMES 'utf8' COLLATE 'utf8_polish_ci'");
		$d_a = date('Y/m/d', strtotime('-30 days')); // dzisiejsza data minus 30 dni
		$d_aa = date('Y/m/d'); // dzisiejsza data
		$query = "SELECT * FROM zamowienie_informacje WHERE data_zamowienia BETWEEN '$d_a 00:00:00' and '$d_aa 23:59:59'"; // pobieranie danych od tej daty -30 dni do dzisiaj
		$result = mysqli_query($con,$query);
		$rows = array();
		while ($r = $result->fetch_array(MYSQLI_ASSOC)) {
			$rows[] = $r;
		}	
		$data_aktualna = date('d-m-Y', strtotime('-30 days'));
		$data_aktualna = strtotime($data_aktualna);
		$zamowienia_under_30 = array();
		$zamowienia_suma = array();
		$h=0;
		for($q=30;$q>=0;$q--)
		{
			$zamowienia_suma[$h][0] = date('d-m-Y', strtotime('-'.$q.' days'));
			$zamowienia_suma[$h][1] = 0;
			$h++;
		};
		$j=0;
		for($i=0;$i<count($rows);$i++)
		{
			$jakas_data = "".$rows[$i]['data_zamowienia']."";
			$data = \DateTime::createFromFormat('Y-m-d H:i:s', $jakas_data);
			$data = $data->format('d-m-Y');
			$rows[$i]['data_zamowienia'] = $data;
			$data_check = strtotime($data);
			if($data_aktualna <= $data_check) {
				$zamowienia_under_30[$j] = $rows[$i];
				$j++;
			}; 
		}
		for($t=0;$t<count($zamowienia_under_30);$t++)
		{
			for($r=0;$r<count($zamowienia_suma);$r++)
			{
				$xx = "".$zamowienia_under_30[$t]['data_zamowienia']."";
				$yy = "".$zamowienia_suma[$r][0]."";
				$x = strtotime($xx);
				$y = strtotime($yy);
				if( $x == $y )
				{
					$zamowienia_suma[$r][1]++;
				}
			}
		}
	$polaczenie->close();


?>
<?php
	$con = mysqli_connect("localhost","root","","user");
	mysqli_query($con, "SET CHARSET utf8");
	mysqli_query($con, "SET NAMES 'utf8' COLLATE 'utf8_polish_ci'");
	$query = "SELECT * FROM zamowienie_informacje ORDER BY id_zamowienie DESC LIMIT 10";
	$result = mysqli_query($con,$query);
	
?>
<?php
	$con_p = mysqli_connect("localhost","root","","przedmioty");
	mysqli_query($con_p, "SET CHARSET utf8");
	mysqli_query($con_p, "SET NAMES 'utf8' COLLATE 'utf8_polish_ci'");
	
	$con_pd = mysqli_connect("localhost","root","","administracja");
	mysqli_query($con_pd, "SET CHARSET utf8");
	mysqli_query($con_pd, "SET NAMES 'utf8' COLLATE 'utf8_polish_ci'");
	
	// OSTATNIO DODANE PRODUKTY -------------------------------------------------------------------------
	
	$query_p = "SELECT * FROM przedmioty_ogolne_informacje ORDER BY id_produktu DESC LIMIT 5";
	$result_p = mysqli_query($con_p,$query_p);
	$od = '';
	while ($r_p = $result_p->fetch_array(MYSQLI_ASSOC)) {
		$src = $r_p['zdjecie'];
		$od .= 
			"<div class='row'>
				<div class='text_UP mp_od1'>
					<img src='../kseshop/category/produkty/".$src."'/>
				</div>
				<div class='text_UP mp_od2 center_holder_no_padding'>
					".$r_p['id_produktu']."								
				</div>
				<div class='text_UP mp_od3'>
					".$r_p['pelna_nazwa']."		
				</div>
				<div class='text_UP mp_od4'>
					".$r_p['cena']." zł		
				</div>
				<div class='text_UP mp_od5'>
					OCENA		
				</div>
				<div class='text_UP mp_od6 center_holder_no_padding'>
					".$r_p['ilosc_odwiedzin']."
				</div>
				<div class='text_UP mp_od7 center_holder_no_padding'>
					".$r_p['ilosc_zakupien']."
				</div>
				<div class='text_UP mp_od8 center_holder_no_padding'>
					".$r_p['sztuki']."
				</div>
				<div class='text_UP mp_od9 center_holder_no_padding'>
					<a href='dane_produkt.php?idp=".$r_p['id_produktu']."'><button type='button' class='button'>EDYTUJ</button></a>
				</div>
			</div>";
	}
	
	// NAJCZĘŚCIEJ OGLĄDANE PRODUKTY --------------------------------------------------------------------
	
	$query_p = "SELECT * FROM przedmioty_ogolne_informacje ORDER BY ilosc_odwiedzin DESC LIMIT 5";
	$result_p = mysqli_query($con_p,$query_p);
	$nd = '';
	while ($r_p = $result_p->fetch_array(MYSQLI_ASSOC)) {
		$src = $r_p['zdjecie'];
		$nd .= 
			"<div class='row'>
				<div class='text_UP mp_od1'>
					<img src='../kseshop/category/produkty/".$src."'/>
				</div>
				<div class='text_UP mp_od2 center_holder_no_padding'>
					".$r_p['id_produktu']."								
				</div>
				<div class='text_UP mp_od3'>
					".$r_p['pelna_nazwa']."		
				</div>
				<div class='text_UP mp_od4'>
					".$r_p['cena']." zł		
				</div>
				<div class='text_UP mp_od5'>
					OCENA		
				</div>
				<div class='text_UP mp_od6 center_holder_no_padding'>
					".$r_p['ilosc_odwiedzin']."
				</div>
				<div class='text_UP mp_od7 center_holder_no_padding'>
					".$r_p['ilosc_zakupien']."
				</div>
				<div class='text_UP mp_od8 center_holder_no_padding'>
					".$r_p['sztuki']."
				</div>
				<div class='text_UP mp_od9 center_holder_no_padding'>
					<a href='dane_produkt.php?idp=".$r_p['id_produktu']."'><button type='button' class='button'>EDYTUJ</button></a>
				</div>
			</div>";
	}
	
	// PRODUKTY DO ZAMÓWIENIA ---------------------------------------------------------------------------
	
	$query_p = "SELECT * FROM przedmioty_ogolne_informacje WHERE sztuki<=5 ORDER BY sztuki ASC LIMIT 5";
	$result_p = mysqli_query($con_p,$query_p);
	$dz = '';
	$yes_or_no = "no";
	if($result_p->num_rows==0){
		$dz .= 
		"<div class='center_holder_no_padding' style='min-height:100px; position:relative;'>
			<div class='iwtbic'>
				BRAK PRODUKTÓW Z NISKIM STANEM MAGAZYNOWYM (5 lub mniej sztuk).
			</div>
		</div>";
		$yes_or_no = "yes";
	}
	else{
		$yes_or_no = "no";
		while ($r_p = $result_p->fetch_array(MYSQLI_ASSOC)) {
			$display='inline';
			if($r_p['sztuki']>5){$color = '#eeeeee';}
			else{$color = '#F59696';}
			$query_pd = "SELECT id_pdd FROM produkty_do_dostawy WHERE id_pdd='".$r_p['id_produktu']."'";
			$result_pd = mysqli_query($con_pd,$query_pd);
			$r_pd = $result_pd->fetch_array(MYSQLI_ASSOC);
			if($r_pd['id_pdd']==$r_p['id_produktu']){
				$display='none';
			}
			$src = $r_p['zdjecie'];
			$dz .= 
				"<div class='row'  style='background-color:".$color."';>
					<div class='text_UP mp_od1'>
						<img src='../kseshop/category/produkty/".$src."'/>
					</div>
					<div class='text_UP mp_od2 center_holder_no_padding'>
						".$r_p['id_produktu']."								
					</div>
					<div class='text_UP mp_od3'>
						".$r_p['pelna_nazwa']."		
					</div>
					<div class='text_UP mp_od4'>
						".$r_p['cena']." zł		
					</div>
					<div class='text_UP mp_od5'>
						OCENA		
					</div>
					<div class='text_UP mp_od6 center_holder_no_padding'>
						".$r_p['ilosc_odwiedzin']."
					</div>
					<div class='text_UP mp_od7 center_holder_no_padding'>
						".$r_p['ilosc_zakupien']."
					</div>
					<div class='text_UP mp_od8 center_holder_no_padding'>
						".$r_p['sztuki']."
					</div>
					<div class='text_UP mp_od9 center_holder_no_padding'>
						<div class='s_d_b'><a href='dane_produkt.php?idp=".$r_p['id_produktu']."'><button type='button' class='button'>EDYTUJ</button></a></div>
						<div class='s_d_b'><button style='display:".$display.";' id='".$r_p['id_produktu']."' type='button' class='button' onclick='do_dostawy(".$r_p['id_produktu'].")'>DO DOSTAWY</button></div>
					</div>
				</div>";
		}
	}
	
	// OSTATNIE OPINIE ----------------------------------------------------------------------------------
	
	$query_p = "SELECT * FROM opinie_produktu ORDER BY id_opinia DESC LIMIT 5";
	$result_p = mysqli_query($con_p,$query_p);
	$oo = '';
	while ($r_p = $result_p->fetch_array(MYSQLI_ASSOC)) {
		$id_produkt_opinia = $r_p['id_produktu'];
		$query_p_o = "SELECT * FROM przedmioty_ogolne_informacje WHERE id_produktu='$id_produkt_opinia'";
		$result_p_o = mysqli_query($con_p,$query_p_o);
		$r_p_o = $result_p_o->fetch_array(MYSQLI_ASSOC);
		$src = $r_p_o['zdjecie'];
		$oo .= 
			"<div class='row'>
				<div class='text_UP mp_oo1'>
					<img src='../kseshop/category/produkty/".$src."'/>
				</div>
				<div class='text_UP mp_oo2 center_holder_no_padding'>
					".$r_p['id_produktu']."							
				</div>
				<div class='text_UP mp_oo3'>
					".$r_p_o['pelna_nazwa']."
				</div>
				<div class='text_UP mp_oo4'>
					".$r_p['imie_uzytkownika']."	
				</div>
				<div class='text_UP mp_oo5'>
					".$r_p['ocena']."		
				</div>
				<div class='text_UP mp_oo6'>
					".$r_p['opinia']."
				</div>
				<div class='text_UP mp_oo7 center_holder_no_padding'>
					<a href='dane_produkt.php?idp=".$r_p['id_produktu']."'><button type='button' class='button'>EDYTUJ</button></a>
				</div>
			</div>";
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
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
	<script src="https://code.highcharts.com/highcharts.js"></script>
	<script src="script.js"></script>
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
			<!--<div id="nav">
				<div class="nav_border"><div class="nav"><a href="#" class="nav_link">start</a></div></div>
				<div class="nav_border"><div class="nav"><a href="#" class="nav_link">sprzedaż</a></div></div>
				<div class="nav_border"><div class="nav"><a href="#" class="nav_link">asortyment</a></div></div>
				<div class="nav_border"><div class="nav"><a href="#" class="nav_link">narzędzia</a></div></div>
			</div>-->
		</div>
		<div id="page">
			<div id="search_inputs">
				<?php include('search_bar.php'); ?>
			</div>
			<div id="main_content">
				<div id="panel_admin_border">
					<div id="panel_admin">
						Panel administracyjny
					</div>
				</div>
				<div class="half_width">
					<span class="info_span">Sprzedaż i statystyki</span>
					<div class="bordered_div">
						<div id="wykres_box">
							<div id="wykres"><div id="chart-"></div></div>
							<!--TU MA BYĆ WYKRES SPRZEDAŻY!-->
						</div>
						Ilość złożonych zamówień: <?php echo $ile_zamowien ?><br />
						Ilość zarejestrowanych użytkowników: <?php echo $ilu_uzytkownikow ?><br />
						Ilość produktów w sklepie: <?php echo $ile_produktow ?><br />
						Ilość dostępnych produktów w sklepie: <?php echo $ile_produktow_dostepnych ?>
					</div>
				</div>
				<div class="half_width">
					<span class="info_span">Najnowsze zamówienia</span>
					<div class="bordered_div">
						<div style="min-height:485px;">
							<div class="row">
								<div class="mp_z1">ID</div>
								<div class="mp_z2">Nazwa</div>
								<div class="mp_z3">Wartość</div>
								<div class="mp_z4">Data</div>
								<div class="mp_z5">Status_zamówienia</div>
								<div class="mp_z6">Idź</div>
							</div>
							<?php
								while ($r = $result->fetch_array(MYSQLI_ASSOC)) {
									$id_zamowienie=$r['id_zamowienie'];
									$data_z = $r['data_zamowienia'];
									$status = $r['status'];
									$status_zaplaty = $r['status_zaplaty'];
									if($status == 'Zamówienie zrealizowane' || $status == 'Zamówienie zrealizowane po zwrocie') {
										$z = "color: #04A1EE !important";
									} else if ($status == 'W trakcie realizacji' || $status == 'Zamówienie zrealizowane (zwrot w toku)' || $status == 'Zamówienie gotowe do wysyłki' || $status == 'Zamówienie przekazane dostawcy' || $status == 'Zamówienie zrealizowane (reklamacja w toku)') {
										$z = "color: gray !important";
									} else if($status == 'Zamówienie anulowane') {
										$z = "color: #CC0000 !important";
									}
										else if($status == 'W trakcie realizacji') {
										$z = "color: #CC0000 !important";
									}
									echo 
									"<div class='row'>
										<div class='mp_z1'>
											Nr. ".$id_zamowienie."
										</div>";
										$id_user=$r['id_user'];
										$qu_u = "SELECT * FROM uzytkownicy WHERE id_user = '$id_user' ";
										$re_u = mysqli_query($con,$qu_u);
										while ($rr_u = $re_u->fetch_array(MYSQLI_ASSOC)) {
											$name = $rr_u['name'];	
											$surname = $rr_u['surname'];	
										}
									echo 
										"<div class='mp_z2'>
											".$name." ".$surname."
										</div>
										<div class='mp_z3'>
											".$r['cena_zamowienia']." zł
										</div>
										<div class='mp_z4'>
											".$r['data_zamowienia']."
										</div>
										<div class='mp_z5'>
											<span style='".$z."'>".$r['status']."</span>
										</div>
										<div class='mp_z6'>
											<button type='button' class='button' onclick='go_old_req(".$r['id_zamowienie'].")'><i class='icon-logout'></i></button>
										</div>
									</div>";
								}
							$con->close();
							?>
						</div>
					</div>
				</div>
				<div style="clear:both;"></div>
				<div id="produkty_start">
					<span class="info_span">Produkty</span>
					<div class="bordered_div_full">
						<div id="buttons_div">
							<button id="1" type="button" class="button_clicked" onclick="change(1)">Ostatnio dodane</button>
							<button id="2" type="button" class="button" onclick="change(2)">Najczęściej oglądane</button>
							<button id="3" type="button" class="button" onclick="change(3)">Do zamówienia</button>
							<button id="4" type="button" class="button" onclick="change(4)">Ostatnie opinie</button>
						</div>
						<div id="produkty_naglowek">
							<div class="row">
								<div class="text_UP mp_od1">
									Obrazek
								</div>
								<div class="text_UP mp_od2 center_holder_no_padding">
									ID_produktu								
								</div>
								<div class="text_UP mp_od3">
									Nazwa_produktu		
								</div>
								<div class="text_UP mp_od4">
									cena		
								</div>
								<div class="text_UP mp_od5">
									ocena		
								</div>
								<div class="text_UP mp_od6 center_holder_no_padding">
									wejść
								</div>
								<div class="text_UP mp_od7 center_holder_no_padding">
									zakupień
								</div>
								<div class="text_UP mp_od8 center_holder_no_padding">
									magazyn
								</div>
								<div class="text_UP mp_od9 center_holder_no_padding">
									działania
								</div>
							</div>
						</div>
						<div id="produkty_box">
							<?php
								echo $od;
							?>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div style="clear:both;"></div>
	</div>
<script>
var chartT = new Highcharts.Chart({
  chart:{ renderTo : 'chart-' },
  title: { text: 'Ilość zamówień w ciągu ostatnich 30 dni.' },
  series: [{
    showInLegend: false,
    data: []
  }],
  plotOptions: {
    line: { animation: false,
      dataLabels: { enabled: true }
    },
    series: { color: '#059e8a' }
  },
  xAxis: { 
   title: { text: 'Dzień' },
    dateTimeLabelFormats: { second: '%D' }
  },
  yAxis: {
    title: { text: 'ilość' }
  },
  credits: { enabled: false }
});
 $(document).ready(function() {
var table = <?php echo json_encode($zamowienia_suma); ?>;
for(t=0;t<table.length;t++)
	{
		var x = table[t][0];
		var y = Number(table[t][1]);
		chartT.series[0].addPoint([x, y], true, false, true);
		chartT.series[0].update({name:"Ilość zamówień"}, false);
		chartT.redraw();
	}
});
</script>
<script src="http://code.jquery.com/jquery-1.12.4.js"></script>
<script type="text/javascript">
var naglowek_123 = '<div class="row"><div class="text_UP mp_od1">Obrazek</div><div class="text_UP mp_od2 center_holder_no_padding">ID_produktu								</div><div class="text_UP mp_od3">Nazwa_produktu</div><div class="text_UP mp_od4">cena</div><div class="text_UP mp_od5">ocena</div><div class="text_UP mp_od6 center_holder_no_padding">wejść</div><div class="text_UP mp_od7 center_holder_no_padding">zakupień</div><div class="text_UP mp_od8 center_holder_no_padding">magazyn</div><div class="text_UP mp_od9 center_holder_no_padding">DZIAŁANIA</div></div>';
var ostatnio_dodane = <?php echo json_encode($od); ?>;
var najczesciej_ogladane = <?php echo json_encode($nd); ?>;
var do_zamowienia = <?php echo json_encode($dz); ?>;
var yes_or_no = <?php echo json_encode($yes_or_no); ?>;
var ostatnie_opinie = <?php echo json_encode($oo); ?>;
var naglowek_4 = "<div class='row'><div class='text_UP mp_oo1'>OBRAZEK</div><div class='text_UP mp_oo2 center_holder_no_padding'>ID PRODUKTU</div><div class='text_UP mp_oo3'>NAZWA PRODUKTU</div><div class='text_UP mp_oo4'>OCENIAJĄCY</div><div class='text_UP mp_oo5'>OCENA</div><div class='text_UP mp_oo6'>TREŚĆ OPINII</div><div class='text_UP mp_oo7  center_holder_no_padding'>DZIAŁANIA</div></div>";
function change(id)
{
	document.getElementsByClassName('button_clicked')[0].classList.add('button');
	document.getElementsByClassName('button_clicked')[0].classList.remove('button_clicked');
    document.getElementById(id).classList.add('button_clicked');
    document.getElementById(id).classList.remove('button');
	if(id==1){
		document.getElementById("produkty_naglowek").innerHTML = naglowek_123;
		document.getElementById("produkty_box").innerHTML = ostatnio_dodane;
	}
	else if(id==2){
		document.getElementById("produkty_naglowek").innerHTML = naglowek_123;
		document.getElementById("produkty_box").innerHTML = najczesciej_ogladane;
	}
	else if(id==3){
		if(yes_or_no=="no"){
			document.getElementById("produkty_naglowek").innerHTML = naglowek_123;
		}
		else{
			document.getElementById("produkty_naglowek").innerHTML = "";
		}
		document.getElementById("produkty_box").innerHTML = do_zamowienia;
	}
	else if(id==4){
		document.getElementById("produkty_naglowek").innerHTML = naglowek_4;
		document.getElementById("produkty_box").innerHTML = ostatnie_opinie;
	}
}
	function do_dostawy(nr){
		$.ajax({
			url: "do_dostawy.php",
			method: "POST",
			dataType: 'json',
			data: {n: nr},
		});
		document.getElementById(nr).style.display="none";
	}
</script>
</body>
</html>

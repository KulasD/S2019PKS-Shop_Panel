<?php

	session_start();
	
	if (!isset($_SESSION['zalogowany']))
	{
		header('Location: index.php');
		exit();
	}
	
?>

<?php

	if (!isset($_POST['search_product']))
	{
		header('Location: produkty_lista.php');
		exit();
	}
	else{
		$product = $_POST['search_product'];
		$con_p = mysqli_connect("localhost","root","","przedmioty");
		mysqli_query($con_p, "SET CHARSET utf8");
		mysqli_query($con_p, "SET NAMES 'utf8' COLLATE 'utf8_polish_ci'");
		
		// SZUKAM CZY WPISANE TO ID
		
		$od = '
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
		</div>';
		
		$con_pd = mysqli_connect("localhost","root","","administracja");
		mysqli_query($con_pd, "SET CHARSET utf8");
		mysqli_query($con_pd, "SET NAMES 'utf8' COLLATE 'utf8_polish_ci'");
		$katego='%';
		if(isset($_SESSION['kate'])){
			$katego = $_SESSION['kate'];
		}
		
		$query_p = "SELECT * FROM przedmioty_ogolne_informacje WHERE id_produktu LIKE '$product' ORDER BY id_produktu DESC";
		$result_p = mysqli_query($con_p,$query_p);
		if($result_p->num_rows>0){
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
				$od .= 
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
		else{
			
			//JESLI TO NIE ID TO MOZE NAZWA
			
			$query_p = "SELECT * FROM przedmioty_ogolne_informacje WHERE pelna_nazwa LIKE '%$product%' ORDER BY id_produktu DESC";
			$result_p = mysqli_query($con_p,$query_p);
			if($result_p->num_rows>0){
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
					$od .= 
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
			else{
				
				//JEDNAK NIE MA U NAS NIC TAKIEGO :/
				
				$od = "Brak wyników do wyświetlenia.";
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
						PRODUKTY
					</div>
				</div>
					<div id="produkty_start">
						<div class="bordered_div_full">
						<?php
							echo $od;
						?>
						</div>
					</div>
			</div>
		</div>
		<div style="clear:both;"></div>
	</div>
<script src="http://code.jquery.com/jquery-1.12.4.js"></script>
<script src="script.js"></script>
<script type="text/javascript">
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

<?php

	session_start();
	
	if (!isset($_SESSION['zalogowany']))
	{
		header('Location: index.php');
		exit();
	}
	
?>
<?php
	if ( isset( $_POST['dost'] ) && !empty( $_POST['dost'] ) )
	{
		$_SESSION['dost'] = $_POST['dost'];
	}
?>
<?php 
	$con = mysqli_connect("localhost","root","","administracja");
	mysqli_query($con, "SET CHARSET utf8");
	mysqli_query($con, "SET NAMES 'utf8' COLLATE 'utf8_polish_ci'");
	$query_d = "SELECT * FROM dostawcy WHERE status LIKE 'aktywny'";
	$result_d = mysqli_query($con,$query_d);
	
	$id_d = '';
	$nazwa = ''; 
	$nip = ''; 
	$regon = ''; 
	$telefon = ''; 
	$email = ''; 
	$adres = ''; 
	$kod = ''; 
	$miejscowosc = ''; 
	
	$yes=false;
	
	if (isset( $_GET['id'])){
		$yes=true;
		$id_d = $_GET['id'];
		$query = "SELECT * FROM dostawy WHERE id_dostawy='$id_d'";
		$result = mysqli_query($con,$query);
		
		// $rd <- dostawa
		$rd = $result->fetch_array(MYSQLI_ASSOC);
		$id_dostawcy = $rd['id_dostawcy'];
		$id_dostawy = $rd['id_dostawy'];
		$disabled = '';
		if($rd['status']=='towary dostarczone' || $rd['status']=='dostawa anulowana'){$disabled = 'disabled';}
		$query = "SELECT * FROM dostawcy WHERE id='$id_dostawcy'";
		$result = mysqli_query($con,$query);
		
		// $r <- dostawca
		$r = $result->fetch_array(MYSQLI_ASSOC);
		$nazwa = $r['nazwa'];
		$nip = $r['nip']; 
		$regon = $r['regon']; 
		$telefon = $r['telefon']; 
		$email = $r['email']; 
		$adres = $r['adres']; 
		$kod = $r['kod_pocztowy']; 
		$miejscowosc = $r['miejscowosc'];
		
		$con_p = mysqli_connect("localhost","root","","przedmioty");
		mysqli_query($con_p, "SET CHARSET utf8");
		mysqli_query($con_p, "SET NAMES 'utf8' COLLATE 'utf8_polish_ci'");
		
		$query_pd = "SELECT * FROM produkty_z_dostawy WHERE id_dostawy = '$id_dostawy'";
		$result_pd = mysqli_query($con,$query_pd);
		if(($result_pd->num_rows)>0){
		$od = '
			<div class="row">
				<div class="text_UP dp1">
					Obrazek
				</div>
				<div class="text_UP dp2 center_holder_no_padding">
					ID_produktu								
				</div>
				<div class="text_UP dp3">
					Nazwa_produktu		
				</div>
				<div class="text_UP dp4">
					cena		
				</div>
				<div class="text_UP dp5 center_holder_no_padding">
					magazyn
				</div>
				<div class="text_UP dp6 center_holder_no_padding">
					ilość do zamówienia
				</div>
				<div class="text_UP dp7 center_holder_no_padding">
					działania
				</div>
			</div>
		';
			while ($r_pd = $result_pd->fetch_array(MYSQLI_ASSOC)) {
				
				$query_p = "SELECT * FROM przedmioty_ogolne_informacje WHERE id_produktu='".$r_pd['id_pzd']."'";
				$result_p = mysqli_query($con_p,$query_p);
				$r_p = $result_p->fetch_array(MYSQLI_ASSOC);
				if($r_p['sztuki']>5){$color = '#eeeeee';}
				else{$color = '#F59696';}
				$src = $r_p['zdjecie'];
				$od .= 
					"<div class='row'  style='background-color:".$color."';>
						<div class='text_UP dp1'>
							<img src='../kseshop/category/produkty/".$src."'/>
						</div>
						<div class='text_UP dp2 center_holder_no_padding'>
							".$r_p['id_produktu']."								
						</div>
						<div class='text_UP dp3'>
							".$r_p['pelna_nazwa']."		
						</div>
						<div class='text_UP dp4'>
							".$r_p['cena']." zł		
						</div>
						<div class='text_UP dp5 center_holder_no_padding'>
							".$r_p['sztuki']."
						</div>
						<div class='text_UP dp6 center_holder_no_padding'>
							<input $disabled class='tx' type='number' min='0' name='ilosc".$r_p['id_produktu']."' value='".$r_pd['ilosc']."'/>
						</div>
						<div class='text_UP dp7 center_holder_no_padding'>
							<div class='s_d_b'><a href='dane_produkt.php?idp=".$r_p['id_produktu']."'><button type='button' class='button'>EDYTUJ PRODUKT</button></a></div>
						</div>
					</div>";
				
			}
		}
	}
	else{
		header('Location: dostawy_lista.php');
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
			<form action="dostawa_edit_action.php" method="post" enctype="multipart/form-data">
				<div id="panel_admin_border">
					<div id="panel_admin">
						<div class="flex_box_space">
							<div>EDYCJA DOSTAWY <?php echo "#".$rd['id_dostawy']; ?></div>
							<div><button <?php echo $disabled; ?> name="up_dostawy" value="<?php echo $rd['id_dostawy']; ?>" type="submit" class="button_green">ZAPISZ</button></div>
						</div>
					</div>
				</div>
					<div class="produkty_start">
						<div class="half_width">
							<span class="info_span">Dane dostawcy</span>
							<div class="bordered_div_no_padding">
							<?php 
							if($yes){
							echo "
								<div class='row'>
									<div class='half_row'>
										<span class='one_line_span'>NAZWA:</span>
									</div> 	
									<div class='half_row_right'>
										<input disabled class='tx' type='text' name='nazwa' value='$nazwa'/>
									</div>	
								</div>
								<div class='row'>
									<div class='half_row'>
										<span class='one_line_span'>NIP:</span>
									</div> 	
									<div class='half_row_right'>
										<input disabled class='tx' type='text' name='nip' value='$nip'/>
									</div>	
								</div>
								<div class='row'>
									<div class='half_row'>
										<span class='one_line_span'>REGON:</span>
									</div> 	
									<div class='half_row_right'>
										<input disabled class='tx' type='text' name='regon' value='$regon'/>
									</div>	
								</div>
								<div class='row'>
									<div class='half_row'>
										<span class='one_line_span'>TELEFON:</span>
									</div> 	
									<div class='half_row_right'>
										<input disabled class='tx' type='text' name='telefon' value='$telefon'/>
									</div>	
								</div>
								<div class='row'>
									<div class='half_row'>
										<span class='one_line_span'>E-MAIL:</span>
									</div> 	
									<div class='half_row_right'>
										<input disabled class='tx' type='text' name='email' value='$email'/>
									</div>	
								</div>
								<div class='row'>
									<div class='half_row'>
										<span class='one_line_span'>ADRES:</span>
									</div> 	
									<div class='half_row_right'>
										<input disabled class='tx' type='text' name='adres' value='$adres'/>

										<input disabled class='tx' type='text' name='kod_pocztowy' value='$kod'  style='width:29%; margin-right:1%;'/><input disabled class='tx' type='text' name='miejscowosc' value='$miejscowosc'  style='width:70%'/>
									</div>										
								</div>
							";
								echo "
									<div class='row'>
										<div class='half_row'>
											<span class='one_line_span'>STATUS:</span>
										</div> 	
										<div class='half_row_right'>
											<select $disabled class='tx' name='status'>";
												$table_status = ['oczekiwanie na towary','towary dostarczone','dostawa anulowana'];
													for($q = 0; $q<count($table_status);$q++)
													{
														if($rd['status']==$table_status[$q]){
															echo "<option selected value='".$table_status[$q]."'>".$table_status[$q]."</option>";
														}
														else{
															echo "<option value='".$table_status[$q]."'>".$table_status[$q]."</option>";
														}
													}
								echo "
											</select>
										</div>	
									</div>
								";
							}
							?>
							</div>
						</div>
						<div style="clear:both;"></div>
					</div>
					<div class="produkty_start">
						<span class="info_span">Produkty do dostawy</span>
						<div class="bordered_div_full">
							<?php
								echo $od;
							?>
						</div>
					</div>
			</form>
			</div>
		</div>
		<div style="clear:both;"></div>
	</div>
<script src="http://code.jquery.com/jquery-1.12.4.js"></script>
</body>
</html>
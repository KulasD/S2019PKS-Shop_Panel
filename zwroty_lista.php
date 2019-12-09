<?php

	session_start();
	
	if (!isset($_SESSION['zalogowany']))
	{
		header('Location: index.php');
		exit();
	}
	
?>

<?php
	$con = mysqli_connect("localhost","root","","user");
	mysqli_query($con, "SET CHARSET utf8");
	mysqli_query($con, "SET NAMES 'utf8' COLLATE 'utf8_polish_ci'");
	$rows = array();
	$rows_info = array();
	$ids = array();
	$user = array();
	$query = "SELECT * FROM zwroty  ORDER BY id_zwrot ASC";
	$result = mysqli_query($con,$query);
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
			<div id="nav">
				<div class="nav_border"><div class="nav"><a href="main_page.php" class="nav_link">start</a></div></div>
				<div class="nav_border"><div class="nav"><a href="#" class="nav_link">sprzedaż</a></div></div>
				<div class="nav_border"><div class="nav"><a href="#" class="nav_link">asortyment</a></div></div>
				<div class="nav_border"><div class="nav"><a href="#" class="nav_link">narzędzia</a></div></div>
			</div>
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
						Zwroty
					</div>
				</div>
					<div id="produkty_start">
						<div class="bordered_div_no_padding">
							<div class="row">
								<div class="hr_k1">
									<span class="one_line_span">STATUS</span>
									<span class="one_line_span">ID ZWROTU</span>
								</div>	
								<div class="hr_k2">
									<span class="one_line_span">IMIĘ I NAZWISKO</span>
									<span class="one_line_span">NAZWA FIRMY</span>
									<span class="one_line_span">ADRES E-MAIL</span>
								</div> 	
								<div class="hr_k3">ZWRACANY PRODUKT</div>
								<div class="hr_k4">DATA ZGŁOSZENIA</div>	
								<div class="hr_k5">DZIAŁANIA</div>
							</div>
						<?php
							for($d=0;$d<count($rows);$d++)
							{
								echo "<div class='row'>
									<div class='hr_k1'>
										<span class=one_line_span>".$rows[$d]['status']."</span>
										<span class='one_line_span '>".$rows[$d]['id_zwrot']."</span>
									</div>	
									<div class='hr_k2'>
										<span class='one_line_span '>".$user[$d]['name']." ".$user[$d]['surname']."</span>
										<span class='one_line_span'>".$user[$d]['email']."</span>
									</div><div class='hr_k3'>";
									for($s=0;$s<count($order_all[$d]);$s++)
									{
										$localization = "".$order_all[$d][$s]['lokalizacja']."";
										$src = "".$order_all[$d][$s]['zdjecie']."";
										echo "
										<div class='flex_box'>
											<div class='f_z'>
												<img src='../lepsza/category/".$localization."/".$src."'/>
											</div>
											<div id='produkt_1' class='n_z'>
												".$order_all[$d][$s]['pelna_nazwa']." <br />
												<b>Sztuk: ".$order_all[$d][$s]['info']['ilosc']."</b>
											</div>
										</div>
										";
									};
									echo "</div>
									<div class='hr_k4'>".$rows[$d]['data_zwrotu']."</div>	
									<div class='hr_k5'>
										<div class='s_d_b'><button type='button' class='button' onclick='zwrot_go(".$rows[$d]['id_zwrot'].")'>EDYTUJ</button></div>
										<div class='s_d_b'><button type='button' class='red_button'>USUŃ</button></div>
									</div>
								</div>";
							};				
						?>
						</div>
					</div>
			</div>
		</div>
		<div style="clear:both;"></div>
	</div>
<script src="http://code.jquery.com/jquery-1.12.4.js"></script>
<script type="text/javascript" src="script.js"></script>
<script type="text/javascript">
/* function zwrot_go(nr)
{
	window.location.href = "dane_zwrot.php?id="+nr; 
} */
</script>
</body>
</html>

<?php

	session_start();
	
	if (!isset($_SESSION['zalogowany']))
	{
		header('Location: index.php');
		exit();
	}
	
?>

<?php
	if (isset($_SESSION['id_u'])){
		$yes = true;
		$wybraniec = $_SESSION['id_u'];

	$con = mysqli_connect("localhost","root","","user");
	mysqli_query($con, "SET CHARSET utf8");
	mysqli_query($con, "SET NAMES 'utf8' COLLATE 'utf8_polish_ci'");
	
	$query_user = "SELECT * FROM uzytkownicy WHERE id_user='$wybraniec'";
	$result_user = mysqli_query($con,$query_user);
	$r_user = $result_user->fetch_array(MYSQLI_ASSOC);
	
	$rows = array();
	$rows_info = array();
	$ids = array();
	$user = array();
	$query = "SELECT * FROM zwroty WHERE id_user='$wybraniec'  ORDER BY id_zwrot DESC";
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
						<?php echo "Historia zwrotów klienta: ".$r_user['id_user']." ".$r_user['name']." ".$r_user['surname']; ?>
					</div>
				</div>
				<?php
								echo "
				<span class='info_span_bigger'> </span>
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
										<div class='s_d_b'><button type='button' class='red_button'>USUŃ</button></div>
									</div>
								</div>";
							};
							
						echo "</div>";	
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
		window.location.href = "zam_hist.php";
	}
	
	function rekl_hist(){
		window.location.href = "rekl_hist.php";
	}
	
	function zwroty_hist(){
		window.location.href = "zwroty_hist.php";
	}
	
</script>
</body>
</html>

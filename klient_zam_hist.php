<?php

	session_start();
	
	if (!isset($_SESSION['zalogowany']))
	{
		header('Location: index.php');
		exit();
	}
	
?>

<?php
	if (isset($_GET['move_next'])){
		$skipper = $_GET['move_next'];
	}
	else {
		$skipper = 0;
	}
	$limiter = 10;
	if (isset($_SESSION['id_u'])){
		$yes = true;
		$wybraniec = $_SESSION['id_u'];

	$con = mysqli_connect("localhost","root","","user");
	mysqli_query($con, "SET CHARSET utf8");
	mysqli_query($con, "SET NAMES 'utf8' COLLATE 'utf8_polish_ci'");
	
	$query_user = "SELECT * FROM uzytkownicy WHERE id_user='$wybraniec'";
	$result_user = mysqli_query($con,$query_user);
	$r_user = $result_user->fetch_array(MYSQLI_ASSOC);
	
	$query_zam = "SELECT * FROM zamowienie_informacje WHERE id_user=".$wybraniec." ORDER BY id_zamowienie DESC LIMIT ".$limiter." OFFSET ".$skipper."";
	$result_zam = mysqli_query($con,$query_zam);
	
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
						<?php echo "Historia zamówień klienta: ".$r_user['id_user']." ".$r_user['name']." ".$r_user['surname']; ?>
					</div>
				</div>
				<?php
									echo "
				<span class='info_span_bigger'> </span>
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
									if($status_zaplaty == "Zapłacono") {echo "<button class='zaplataB zbnp' >Zapłacono</button>";} else {echo "<button class='zaplataBN zbnp' >Nie zapłacono</button>"; } 
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
								
								?>
								<div class="center_holder">
									<button type="button" class="button" name="wstecz" onclick="back()">WSTECZ</button>
									<button type="button" class="button" name="dalej" onclick="next()">DALEJ</button>
								</div>
			</div>
		</div>
		<div style="clear:both;"></div>
	</div>
<script src="http://code.jquery.com/jquery-1.12.4.js"></script>
<script type="text/javascript" src="script.js"></script>
<script type="text/javascript">
var page=0;
var current = <?php echo json_encode($skipper); ?>/1;
function next(){
	page = current + 10;
	window.location.href = 'klient_zam_hist.php?move_next='+page;
}

function back(){
	page = current - 10;
	if(page<0){page=0;}
	window.location.href = 'klient_zam_hist.php?move_next='+page;
}
</script>
</body>
</html>

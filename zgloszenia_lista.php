<?php

	session_start();
	
	if (!isset($_SESSION['zalogowany']))
	{
		header('Location: index.php');
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
		</div>
		<div id="page">
			<div id="search_inputs">
				<?php include('search_bar.php'); ?>
			</div>
			<div id="main_content">
				<div id="panel_admin_border">
					<div id="panel_admin">
						Pytania od użytkowników
					</div>
				</div>
					<div id="produkty_start">
						<div class="bordered_div_full">
							<div class="row">
								<div class="zgl_list1">
									<span class="one_line_span">ID</span>
									<span class="one_line_span">STATUS</span>
									<span class="one_line_span">DATA PIERWSZEJ ODPOWIEDZI</span>
								</div>	
								<div class="zgl_list2">
									<span class="one_line_span">IMIĘ I NAZWISKO</span>
									<span class="one_line_span">NAZWA FIRMY</span>
									<span class="one_line_span">ADRES E-MAIL</span>
									<span class="one_line_span">TELEFON</span>
								</div> 	
								<div class="zgl_list3">KATEGORIA</div>
								<div class="zgl_list4">TEMAT</div>
								<div class="zgl_list5">DATA ZGŁOSZENIA</div>	
								<div class="zgl_list6">DZIAŁANIA</div>
							</div>
							<?php
							$con = mysqli_connect("localhost","root","","user");
							mysqli_query($con, "SET CHARSET utf8");
							mysqli_query($con, "SET NAMES 'utf8' COLLATE 'utf8_polish_ci'");
							$query = "SELECT * FROM zgloszenie_klienta WHERE blokada NOT LIKE 'zablokowane' ORDER BY data DESC";
							$result = mysqli_query($con,$query);
							while ($r = $result->fetch_array(MYSQLI_ASSOC)) {
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
										<div class='zgl_list1'>
											<span class='one_line_span'>".$id_zgloszenie."</span>
											<span class='one_line_span'>".$r['status']."</span>
											<span class='one_line_span green_span'>".$r_korespondencja['data']."</span>
										</div>	
										<div class='zgl_list2'>
											<span class='one_line_span '>".$r['imie']." ".$r['nazwisko']."</span>
											<span class='one_line_span '>".$r['email']."</span>
											<span class='one_line_span '>".$r['nr_telefonu']."</span>
										</div> 	
										<div class='zgl_list3'>
											".$r['kategoria']."
										</div>	
										<div class='zgl_list4'>
											".$r['temat']."
										</div>
										<div class='zgl_list5'>
											".$r['data']."
										</div>	
										<div class='zgl_list6'>
											<div class='s_d_b'><button type='button' class='button' onclick='zgloszenie(".$id_zgloszenie.")'>CZYTAJ</button></div>
											<div class='s_d_b'><button type='button' class='red_button' onclick='delete_z(".$id_zgloszenie.")'>USUŃ</button></div>
											<div class='s_d_b'><button type='button' class='red_button' onclick='add_block(".$id_zgloszenie.")'>ZABLOKUJ SPAM</button></div>
										</div>
									</div>
								";
							}
							?>
							
						</div>
					</div>
			</div>
		</div>
		<div style="clear:both;"></div>
	</div>
<script src="http://code.jquery.com/jquery-1.12.4.js"></script>
<script type="text/javascript">
function zgloszenie(nr)
{
	window.location.href = "zgloszenie.php?a="+nr; 
}
</script>
</body>
</html>

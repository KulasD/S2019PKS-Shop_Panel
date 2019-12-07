<?php

	session_start();
	
	if (!isset($_SESSION['zalogowany']))
	{
		header('Location: index.php');
		exit();
	}
	
?>

<?php
if ( isset( $_GET['a'] ) && !empty( $_GET['a'] ) )
	{
	$id_zgloszenia = $_GET['a'];
	} else {
	header('Location: zgloszenia_lista.php');exit();};
	$con = mysqli_connect("localhost","root","","user");
	mysqli_query($con, "SET CHARSET utf8");
	mysqli_query($con, "SET NAMES 'utf8' COLLATE 'utf8_polish_ci'");
	$query = "SELECT * FROM zgloszenie_klienta WHERE id_zgloszenie='$id_zgloszenia'";
	$result = mysqli_query($con,$query);
	$r = $result->fetch_array(MYSQLI_ASSOC);
	$status = $r['status'];
	if($status == 'Nieprzeczytane')
	{
		$con->query("UPDATE zgloszenie_klienta SET status='Przeczytane' WHERE id_zgloszenie='$id_zgloszenia'");
	}
	$topic = $r['temat'];
	$opis = $r['opis'];
	$_SESSION['id_zgloszenia'] = $id_zgloszenia;
	
	$query_korespondencja = "SELECT * FROM korespondencja WHERE id_zgloszenie='$id_zgloszenia'";
	$result_korespondencja = mysqli_query($con,$query_korespondencja);
	
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
					<div class="topic">
						<span id="temat"><?php echo $topic; ?></span>
					</div>
				</div>
					<div id="produkty_start">
						<div class="n_b_d m_b_m"> <!-- wiadomość -->
							<div class="flex_box">
								<div class="avatar_box">
									<img src="./img/men.png"/>
								</div>
								<div class="message_box">
									<div class="upper_message_box flex_box_space">
										<span id="imie_i_nazwisko" class="user_message">
											<?php echo $r['imie']." ".$r['nazwisko']; ?>
										</span>
										<div class="relative">
										<span id="message_date" class="absolute">
											<?php echo $r['data']; ?>
										</span>
										</div>
									</div>
									<span id="message" class="message">
										<?php echo $r['opis']; ?>
									</span>
								</div>
							</div>
						</div>
						<?php
							while ($r_kores = $result_korespondencja->fetch_array(MYSQLI_ASSOC)) {
								if ($r_kores['id_pracownik']>0){
									$pracownik = $r_kores['id_pracownik'];
									$avatar = "kseshop-kontakt";
									$con_admin = mysqli_connect("localhost","root","","administracja");
									mysqli_query($con_admin, "SET CHARSET utf8");
									mysqli_query($con_admin, "SET NAMES 'utf8' COLLATE 'utf8_polish_ci'");
									$query_admin = "SELECT * FROM kadra WHERE id='$pracownik'";
									$result_admin = mysqli_query($con_admin,$query_admin);
									$r_admin = $result_admin->fetch_array(MYSQLI_ASSOC);
									$name = $r_admin['imie']." ".$r_admin['nazwisko'];
								}
								else {
									$avatar = "men";
									$name = $r['imie']." ".$r['nazwisko'];
								};
								echo "
									<div class='n_b_d m_b_m'> <!-- wiadomość -->
										<div class='flex_box'>
											<div class='avatar_box'>
												<img src='./img/".$avatar.".png'/>
											</div>
											<div class='message_box'>
												<div class='upper_message_box flex_box_space'>
													<span id='imie_i_nazwisko' class='user_message'>
														".$name."
													</span>
													<div class='relative'>
													<span id='message_date' class='absolute'>
														".$r_kores['data']."
													</span>
													</div>
												</div>
												<span id='message' class='message'>
													".$r_kores['wiadomosc']."
												</span>
											</div>
										</div>
									</div>
								";
							}
						?>
						<form action="send_message.php" method="post">
						<div class="n_b_d m_b_m">				<!-- div od wiadomości do wysłania i przycisku wyślij -->
							<div class="flex_box">
								<div class="avatar_box"></div> 	<!-- ta linijka to tylko placeholder -->
								<div class="message_box">
									<textarea class="areatx tx" rows="6" name="tresc"></textarea>
								</div>
							</div>
							<div class="flex_box">
								<div class="avatar_box"></div> 	<!-- ta linijka to tylko placeholder -->
								<div class="message_box">
									<button type="submit" class="button_green" style="margin-left:45%;">Wyślij</button>
								</div>
							</div>
						</div>
						</form>
					</div>
			</div>
		</div>
		<div style="clear:both;"></div>
	</div>
</body>
</html>

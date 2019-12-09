<?php

	session_start();
	
	if (!isset($_SESSION['zalogowany']))
	{
		header('Location: index.php');
		exit();
	}
	
?>

<?php

	$con = mysqli_connect("localhost","root","","przedmioty");
	mysqli_query($con, "SET CHARSET utf8");
	mysqli_query($con, "SET NAMES 'utf8' COLLATE 'utf8_polish_ci'");

?>

<?php
	if ( isset( $_POST['kat'] ) && !empty( $_POST['kat'] ) )
	{
		$_SESSION['kat'] = $_POST['kat'];
	};
	if ( isset( $_POST['lok'] ) && !empty( $_POST['lok'] ) )
	{
		$_SESSION['lok'] = $_POST['lok'];
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
						Produkt
					</div>
				</div>
				<form action="produkt_add.php" method="post" enctype="multipart/form-data">
				<div class="half_width">
					<span class="info_span">Podstawowe dane produktu</span>
					<div class="bordered_div_no_padding">
						<div class="row">
							<div class="half_row">
								Kategoria:
							</div>				
							<div class="half_row_right">
								<select class="tx" id="kategoria" name="kategoria" onchange="wybrano_kategorie(value);">
									<option value="-1">wybierz kategorie</option>
									<?php
										$query = "SELECT DISTINCT kategoria FROM przedmioty_ogolne_informacje";
										$result = mysqli_query($con,$query);
										while($r = $result->fetch_array(MYSQLI_ASSOC)){
											if ((isset($_SESSION['kat'])) && ($_SESSION['kat']==$r['kategoria'])){
												echo "<option selected='selected' value='".$r['kategoria']."'>".$r['kategoria']."</option>";
											}
											else {
												echo "<option value='".$r['kategoria']."'>".$r['kategoria']."</option>";
											}
										}
									?>
								</select>
							</div>
						</div>
						<div class="row">
							<div class="half_row">
								Nazwa produktu:
							</div>				
							<div class="half_row_right">
								<input type="text" class="tx" name="nazwa_produktu"/>
							</div>
						</div>
						<div class="row">
							<div class="half_row">
								Pełna nazwa produktu:
							</div>				
							<div class="half_row_right">
								<input type="text" class="tx" name="nazwa_produktu_full"/>
							</div>
						</div>
						<div class="row">
							<div class="half_row">
								Cena:
							</div>				
							<div class="half_row_right">
								<div class="flex_box relative">
									<div class="margin_right center_form">brutto: </div>
									<div><input type="number" class="tx" name="cena_brutto" step="0.01"/></div>  
									<div class="margin_left center_form">zł</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="half_row">
								Sztuki:
							</div>				
							<div class="half_row_right">
								<input type="number" class="tx" name="sztuki"/>
							</div>
						</div>
						<?php
							if((isset($_SESSION['kat'])))
							{
								if($_SESSION['kat'] == 'pc' || $_SESSION['kat'] == 'playstation3' || $_SESSION['kat'] == 'playstation4' || $_SESSION['kat'] == 'xboxone') {
									$g = "gry_filtry";
								} else {
									$g = "".$_SESSION['kat']."_filtry";
								}								
								$query = "SELECT * FROM $g";
								$result = mysqli_query($con,$query);
								$filtry = array();
								while($r = $result->fetch_array(MYSQLI_ASSOC)){
									$filtry[] = $r;
									$x = array_keys($r);
								}
								for($q=1;$q<count($x);$q++)
								{
									if($x[$q] == "p".$q) {} else {
									echo "<div class='row'>
								<div class='half_row'>
									".$x[$q]."
								</div>				
								<div class='half_row_right'>
									<select id='parametr".$q."' name='parametr".$q."' class='tx'>";
									for($t=0; $t < count($filtry); $t++)
									{
										if($filtry[$t][$x[$q]] == '') {} else {
										echo "<option>".$filtry[$t][$x[$q]]."</option>";}
									}
									echo" </select>
								</div>
									</div>"; }
								}
							}
						?>						
						<div class="row">
							<div class="half_row">
								Zdjęcie główne:
							</div>				
							<div class="half_row_right">
								<input type="file" name="main_zdj" id="main_zdj"/>
							</div>
						</div>
						
					</div>
					<span class="info_span" style="margin-top:10px;">Opisy dodatkowe</span>
					<div class="bordered_div_no_padding">
						<div class="row_no_border">
							<div class="half_row">
								Nagłówek 1 (temat 1 w bazie):
							</div>				
							<div class="half_row_right">
								<input type="text" class="tx" name="n1"/>
							</div>
						</div>
						<div class="row_no_border">
							<div class="half_row">
								Opis 1 (opis 1 w bazie):
							</div>				
							<div class="half_row_right">
								<textarea class="areatx tx" rows="6" name="o1"></textarea>
							</div>
						</div>
						<div class="row">
							<div class="half_row">
								Zdjęcie 1:
							</div>				
							<div class="half_row_right">
								<input type="file" name="zdj1" id="zdj1"/>
							</div>
						</div>
						<div class="row_no_border">
							<div class="half_row">
								Nagłówek 2 (temat 2 w bazie):
							</div>				
							<div class="half_row_right">
								<input type="text" class="tx" name="n2"/>
							</div>
						</div>
						<div class="row_no_border">
							<div class="half_row">
								Opis 2 (opis 2 w bazie):
							</div>				
							<div class="half_row_right">
								<textarea class="areatx tx" rows="6" name="o2"></textarea>
							</div>
						</div>
						<div class="row">
							<div class="half_row">
								Zdjęcie 2:
							</div>				
							<div class="half_row_right">
								<input type="file" name="zdj2" id="zdj2"/>
							</div>
						</div>
						<div class="row_no_border">
							<div class="half_row">
								Nagłówek 3 (temat 3 w bazie):
							</div>				
							<div class="half_row_right">
								<input type="text" class="tx" name="n3"/>
							</div>
						</div>
						<div class="row_no_border">
							<div class="half_row">
								Opis 3 (opis 3 w bazie):
							</div>				
							<div class="half_row_right">
								<textarea class="areatx tx" rows="6" name="o3"></textarea>
							</div>
						</div>
						<div class="row">
							<div class="half_row">
								Zdjęcie 3:
							</div>				
							<div class="half_row_right">
								<input type="file" name="zdj3" id="zdj3"/>
							</div>
						</div>
					</div>
				</div>
				<?php
					if (isset($_SESSION['kat'])){
						$query_atr = 	"SELECT `COLUMN_NAME` 
										FROM `INFORMATION_SCHEMA`.`COLUMNS` 
										WHERE `TABLE_NAME`='".$_SESSION['kat']."_full' LIMIT 100 OFFSET 2;";
						$result_atr = mysqli_query($con,$query_atr);
						
						echo 	"<div class='half_width'>
									<span class='info_span'>Szczegółowe dane produktu</span>
										<div class='bordered_div_no_padding'>";
						$licznik = 1;
						$_SESSION['licznik_kat'] = $result_atr->num_rows;
						while($r_atr = $result_atr->fetch_array(MYSQLI_ASSOC)){	
							echo 	"<div class='row'>
										<div class='half_row'>
											".$r_atr['COLUMN_NAME']."
										</div>				
										<div class='half_row_right'>
											<input type='text' class='tx' name='atr".$licznik++."'/>
										</div>
									</div>";
						}
						
						echo	"</div>
								</div>";
					}
				?>
				<!--<div class="half_width">
					<span class="info_span">Szczegółowe dane produktu</span>
					<div class="bordered_div_no_padding">
						<div class="row">
							<div class="half_row">
								Nazwa kolumny N:
							</div>				
							<div class="half_row_right">
								<input type="text" class="tx" name="nazwa_kolumny_N"/>
							</div>
						</div>
					</div>
				</div>-->
				<div style="clear:both;"></div>
					<!--<div id="produkty_start">
						<span class="info_span">Obsługa zwrotu</span>
						<div class="bordered_div_no_padding">
							<div class="half_width">
								<div class="flex_box_padding">
									<div class="half_row">
										Status zwrotu:
									</div>				
									<div class="half_row_right2">
										<select id="status_zwrotu" class="tx"></select>
									</div>
								</div>
								<div class="margin_box_left">
									<span class="one_line_span">Wyposarzenie otrzymanego towaru</span>
									<textarea class="areatx tx" rows="4"></textarea>
								</div>
								
							</div>
							<div class="half_width">
								<div class="flex_box_padding">
									<div class="half_row2">
										Przyporządkowany pracownik:
									</div>				
									<div class="half_row_right">
										<select id="pracownik" class="tx"></select>
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
					</div>-->
					<div class="center_holder">
						<button type="submit" class="button" name="add">Dodaj produkt</button>
					</div>
				</form>
			</div>
		</div>
		<div style="clear:both;"></div>
	</div>
<script src="http://code.jquery.com/jquery-1.12.4.js"></script>
<script type="text/javascript">
	function wybrano_kategorie(kat){
		if(kat!=(-1)){
			$.ajax({
				url: 'produkt.php',
				type: 'POST',
				data: {kat},
			});
			setTimeout(function() {
				window.location.reload(true);
			}, 1000)
			return false; 
		}
	}
</script>
</body>
</html>

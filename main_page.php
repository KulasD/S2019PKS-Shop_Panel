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
	$polaczenie->close();


?>

<?php
	// tworzenie wykresu
	$tabelson = array();
	$tabelson['cols'] = array(
		array(
			'label' => 'dzień',
			'type' => 'string'
		),
		array(
			'label' => 'sprzedano',
			'type' => 'number'
		)
	);
	$a=0;
	while ($a<30){
		$a=$a+1;
		$rowssss = array();
		$rowssss[] = array ( "v" => '2019.10.'.$a); 	// powinna się wpisywać data
		$rowssss[] = array ( "v" => $a*100);	// powinna się wpisywać liczba zamowień
		$rows[] = array ( "c" => $rowssss);	// push takiego jednego wpisu do tabeli
	}
	$tabelson['rows'] = $rows;
	$jsonTable = json_encode($tabelson);

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
	<!--Load the AJAX API-->
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    <script type="text/javascript">
   
    // Load the Visualization API.
    google.load('visualization', '1', {'packages':['corechart']});
     
    // Set a callback to run when the Google Visualization API is loaded.
    google.setOnLoadCallback(drawChart);
     
    function drawChart() {
         
      // Create our data table out of JSON data loaded from server.
      var data = new google.visualization.DataTable(<?php echo $jsonTable; ?>);
	  var options = {
			legend: {position: 'none'},
			//width: 363,
			//height: 290,
			chartArea: {left: 40, top: 10, right: 0, width: '90%', height: '80%'},
			backgroundColor: '#eeeeee',
	  };

      // Instantiate and draw our chart, passing in some options.
      var chart = new google.visualization.LineChart(document.getElementById('wykres'));
      chart.draw(data, options);
    }

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
				<div class="nav_border"><div class="nav"><a href="#" class="nav_link">start</a></div></div>
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
						Panel administracyjny
					</div>
				</div>
				<div class="half_width">
					<span class="info_span">Sprzedaż i statystyki</span>
					<div class="bordered_div">
						<div id="wykres_box">
							<span id="wykres_span">Ilość zamówień w ciągu ostatnich 30 dni.</span>
							<div id="wykres"></div>
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
						<div>ID_zamowienia		Użytkownik		wartość		status_zamowienia		str</div>
						<div>ID_zamowienia		Użytkownik		wartość		status_zamowienia		str</div>
						<div>ID_zamowienia		Użytkownik		wartość		status_zamowienia		str</div>
						<div>ID_zamowienia		Użytkownik		wartość		status_zamowienia		str</div>
						<div>ID_zamowienia		Użytkownik		wartość		status_zamowienia		str</div>
						<div>ID_zamowienia		Użytkownik		wartość		status_zamowienia		str</div>
						<div>ID_zamowienia		Użytkownik		wartość		status_zamowienia		str</div>
						<div>ID_zamowienia		Użytkownik		wartość		status_zamowienia		str</div>
						<div>ID_zamowienia		Użytkownik		wartość		status_zamowienia		str</div>
						<div>ID_zamowienia		Użytkownik		wartość		status_zamowienia		str</div>
						<div>ID_zamowienia		Użytkownik		wartość		status_zamowienia		str</div>
						<div>ID_zamowienia		Użytkownik		wartość		status_zamowienia		str</div>
						<div>ID_zamowienia		Użytkownik		wartość		status_zamowienia		str</div>
						<div>ID_zamowienia		Użytkownik		wartość		status_zamowienia		str</div>
						<div>ID_zamowienia		Użytkownik		wartość		status_zamowienia		str</div>
						<div>ID_zamowienia		Użytkownik		wartość		status_zamowienia		str</div>
						<div>ID_zamowienia		Użytkownik		wartość		status_zamowienia		str</div>
						<div>ID_zamowienia		Użytkownik		wartość		status_zamowienia		str</div>
						<div>ID_zamowienia		Użytkownik		wartość		status_zamowienia		str</div>
						<div>ID_zamowienia		Użytkownik		wartość		status_zamowienia		str</div>
						<div>ID_zamowienia		Użytkownik		wartość		status_zamowienia		str</div>
						<div>ID_zamowienia		Użytkownik		wartość		status_zamowienia		str</div>
					</div>
				</div>
				<div style="clear:both;"></div>
				<div id="produkty_start">
					<span class="info_span">Produkty</span>
					<div class="bordered_div_full">
					<div id="buttons_div">
						<button type="button" class="button_clicked">Ostatnio dodane</button>
						<button type="button" class="button">Najczęściej oglądane</button>
						<button type="button" class="button">Do zamówienia</button>
						<button type="button" class="button">Ostatnie opinie</button>
					</div>
					<div>Obrazek		ID_produktu		Nazwa_produktu		cena		ilość_na_magazynie</div>
					<div>Obrazek		ID_produktu		Nazwa_produktu		cena		ilość_na_magazynie</div>
					<div>Obrazek		ID_produktu		Nazwa_produktu		cena		ilość_na_magazynie</div>
					<div>Obrazek		ID_produktu		Nazwa_produktu		cena		ilość_na_magazynie</div>
					<div>Obrazek		ID_produktu		Nazwa_produktu		cena		ilość_na_magazynie</div>
					<div>Obrazek		ID_produktu		Nazwa_produktu		cena		ilość_na_magazynie</div>
					<div>Obrazek		ID_produktu		Nazwa_produktu		cena		ilość_na_magazynie</div>
					<div>Obrazek		ID_produktu		Nazwa_produktu		cena		ilość_na_magazynie</div>
					<div>Obrazek		ID_produktu		Nazwa_produktu		cena		ilość_na_magazynie</div>
					<div>Obrazek		ID_produktu		Nazwa_produktu		cena		ilość_na_magazynie</div>
					</div>
				</div>
			</div>
		</div>
		<div style="clear:both;"></div>
	</div>
</body>
</html>
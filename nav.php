<?php
	@session_start();
	$jestem = $_SESSION['uprawnienia'];
	
	$nav_con = mysqli_connect("localhost","root","","user");
	mysqli_query($nav_con, "SET CHARSET utf8");
	mysqli_query($nav_con, "SET NAMES 'utf8' COLLATE 'utf8_polish_ci'");
	$nav_query_zgloszenie = "SELECT * FROM zgloszenie_klienta WHERE status LIKE 'nieprzeczytane' AND blokada NOT LIKE 'Zablokowane'";
	$nav_result_zgloszenie = mysqli_query($nav_con,$nav_query_zgloszenie);
	$ile_nowych_zgloszen = $nav_result_zgloszenie->num_rows;
	
	$nav_query_zamowienie = "SELECT * FROM zamowienie_informacje WHERE status LIKE 'W trakcie realizacji'";
	$nav_result_zamowienie = mysqli_query($nav_con,$nav_query_zamowienie);
	$ile_nowych_zamowien = $nav_result_zamowienie->num_rows;
	
	$nav_query_reklamacja = "SELECT * FROM reklamacje WHERE status LIKE 'Sklep czeka na produkt'";
	$nav_result_reklamacja = mysqli_query($nav_con,$nav_query_reklamacja);
	$ile_nowych_reklamacji = $nav_result_reklamacja->num_rows;
	
	$nav_query_zwrot = "SELECT * FROM zwroty WHERE status LIKE 'Sklep czeka na produkt'";
	$nav_result_zwrot = mysqli_query($nav_con,$nav_query_zwrot);
	$ile_nowych_zwrotow = $nav_result_zwrot->num_rows;
	
	$con_prod = mysqli_connect("localhost","root","","przedmioty");
	mysqli_query($con_prod, "SET CHARSET utf8");
	mysqli_query($con_prod, "SET NAMES 'utf8' COLLATE 'utf8_polish_ci'");
	
	
	$query_prod = "SELECT * FROM przedmioty_ogolne_informacje WHERE sztuki < 6 ORDER BY sztuki ASC";
	$result_prod = mysqli_query($con_prod,$query_prod);
	$malo_w_magazynie = $result_prod->num_rows;
	
	
echo "
<div id='nav'>";
	if(($jestem=="administrator") || ($jestem=="pracownik")){
	echo "
	<div class='nav_border'><div class='nav'><a href='main_page.php' class='nav_link'>start</a></div></div>
	";
	if ($ile_nowych_zamowien>0)
	{
		echo "<div class='nav_border'><div class='nav_red'><a href='zamowienia_lista.php' class='nav_link_red'>zamówienia (".$ile_nowych_zamowien.")</a></div></div>";
	}
	else 
	{
		echo "<div class='nav_border'><div class='nav'><a href='zamowienia_lista.php' class='nav_link'>zamówienia</a></div></div>";
	}
	if ($ile_nowych_reklamacji>0)
	{
		echo "<div class='nav_border'><div class='nav_red'><a href='reklamacje_lista.php' class='nav_link_red'>reklamacje (".$ile_nowych_reklamacji.")</a></div></div>";
	}
	else 
	{
		echo "<div class='nav_border'><div class='nav'><a href='reklamacje_lista.php' class='nav_link'>reklamacje</a></div></div>";
	}
	if ($ile_nowych_zwrotow>0)
	{
		echo "<div class='nav_border'><div class='nav_red'><a href='zwroty_lista.php' class='nav_link_red'>zwroty (".$ile_nowych_zwrotow.")</a></div></div>";
	}
	else 
	{
		echo "<div class='nav_border'><div class='nav'><a href='zwroty_lista.php' class='nav_link'>zwroty</a></div></div>";
	}

	if ($ile_nowych_zgloszen>0)
	{
		echo "<div class='nav_border'><div class='nav_red'><a href='zgloszenia_lista.php' class='nav_link_red'>zgłoszenia (".$ile_nowych_zgloszen.")</a></div></div>";
	}
	else 
	{
		echo "<div class='nav_border'><div class='nav'><a href='zgloszenia_lista.php' class='nav_link'>zgłoszenia</a></div></div>";
	}
echo "
	<div class='nav_border'><div class='nav'><a href='klienci_lista.php' class='nav_link'>klienci</a></div></div>
	";
	if ($ile_nowych_zgloszen>0)
	{
		echo "<div class='nav_border'><div class='nav_red'><a href='produkty_lista.php' class='nav_link_red'>produkty (".$malo_w_magazynie.")</a></div></div>";
	}
	else 
	{
		echo "<div class='nav_border'><div class='nav'><a href='produkty_lista.php' class='nav_link'>produkty</a></div></div>";
	}
echo "
	<div class='nav_border'><div class='nav'><a href='rabaty_lista.php' class='nav_link'>rabaty</a></div></div>
	<div class='nav_border'><div class='nav'><a href='dostawy_lista.php' class='nav_link'>dostawy</a></div></div>
	";
	}
	if ($jestem=="administrator")
	{
		echo "<div class='nav_border'><div class='nav'><a href='pracownicy_lista.php' class='nav_link'>pracownicy</a></div></div>";
		echo "<div class='nav_border'><div class='nav'><a href='platnosc_lista.php' class='nav_link'>płatność</a></div></div>";
	}
	if ($jestem=="ksiegowosc")
	{
		echo "<div class='nav_border'><div class='nav'><a href='platnosc_lista.php' class='nav_link'>płatność</a></div></div>";
	}
echo "</div>";
?>
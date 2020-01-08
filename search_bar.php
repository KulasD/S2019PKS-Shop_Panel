<?php
	
	echo "
	<form action='produkty_lista_search.php' method='POST'>
		<input class='search_input' type='search' name='search_product' placeholder='szukaj produktu' onfocus='this.placeholder=''' onblur='this.placeholder='szukaj produktu'' />
		<input class='search_button' type='submit' value='&#xe801' />
	</form>
	<form action='zamowienia_lista_search.php' method='POST'>
		<input class='search_input' type='search' name='search_req' placeholder='szukaj zamówienia' onfocus='this.placeholder=''' onblur='this.placeholder='szukaj zamówienia'' />
		<input class='search_button' type='submit' value='&#xe801' />
	</form>
	<form action='klienci_lista_search.php' method='POST'>
		<input class='search_input' type='search' name='search_user' placeholder='szukaj klienta' onfocus='this.placeholder=''' onblur='this.placeholder='szukaj klienta'' />
		<input class='search_button' type='submit' value='&#xe801' />
	</form>
	";
	
?>
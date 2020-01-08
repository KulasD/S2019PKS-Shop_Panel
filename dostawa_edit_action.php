<?php
	session_start();
	$dostawa = mysqli_connect("localhost","root","","administracja");
	mysqli_query($dostawa, "SET CHARSET utf8");
	mysqli_query($dostawa, "SET NAMES 'utf8' COLLATE 'utf8_polish_ci'");
	
	$produkt = mysqli_connect("localhost","root","","przedmioty");
	mysqli_query($dostawa, "SET CHARSET utf8");
	mysqli_query($dostawa, "SET NAMES 'utf8' COLLATE 'utf8_polish_ci'");
	
	if(isset($_POST['up_dostawy'])){
		$id_dostawy = $_POST['up_dostawy'];
		$status = $_POST['status'];
		
		// Update statusu dostawy w dostawie
		$query = "UPDATE dostawy SET status='$status' WHERE id_dostawy='$id_dostawy'";
		mysqli_query($dostawa,$query);
		
		$query_dp = "SELECT * FROM produkty_z_dostawy WHERE id_dostawy='$id_dostawy'";
		$result_dp = mysqli_query($dostawa,$query_dp);
		while($r_dp = $result_dp->fetch_array(MYSQLI_ASSOC)){
			$id_pzd = $r_dp['id_pzd'];
			$ilosc_update = $_POST['ilosc'.$id_pzd];
			$query_dpu = "UPDATE produkty_z_dostawy SET ilosc='$ilosc_update' WHERE id_pzd='$id_pzd' AND id_dostawy='$id_dostawy'";
			mysqli_query($dostawa,$query_dpu);
		}
		// Update ilosci magazynowych przedmiotow
		// Status towary dostarczone oznacza ze dostawa powiodła się i można zaktualizowac stan magazynu
		// Status dostawa anulowana oznacza ze z jakiegos powodu dostawa nie doszla do skutku i nie można zaktualizować stanu magazynu bo sklep nie dostal tych przedmiotow
		
		if($status=='towary dostarczone'){
			// dp -> dostawa produkt
			$query_dp = "SELECT * FROM produkty_z_dostawy WHERE id_dostawy='$id_dostawy'";
			$result_dp = mysqli_query($dostawa,$query_dp);
			// Przedmioty z tej dostawy
			while($r_dp = $result_dp->fetch_array(MYSQLI_ASSOC)){
				$id_produktu = $r_dp['id_pzd'];
				$ilosc = $r_dp['ilosc'];
				// Przedmiot z tym samym id z przedmioty_ogolne_informacje (musze uzyskac info o aktualnym stanie magazynowym, aby dodać do nich ilosci)
				// pl -> product list
				$query_pl = "SELECT * FROM przedmioty_ogolne_informacje WHERE id_produktu='$id_produktu'";
				$result_pl = mysqli_query($produkt,$query_pl);
				$r_pl = $result_pl->fetch_array(MYSQLI_ASSOC);
				$suma = $ilosc + $r_pl['sztuki'];
				// pu -> product update
				$query_pu = "UPDATE przedmioty_ogolne_informacje SET sztuki='$suma' WHERE id_produktu='$id_produktu'";
				mysqli_query($produkt,$query_pu);
			}
		}
		
	}
	else{
		header("Location: dostawy_lista.php");
		exit();
	}
	
	header("Location: dostawy_lista.php");
	exit();
?>
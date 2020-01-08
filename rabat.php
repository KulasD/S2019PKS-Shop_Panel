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
	$kod = ''; $status = ''; $procent = ''; $id_kod = ''; $yes=false;
	if ( isset( $_GET['id'] ) && !empty( $_GET['id'] ) )
	{
		$yes=true;
		$id_kod = $_GET['id'];
		$query = "SELECT * FROM kod_rabatowy WHERE id_kod='$id_kod'";
		$result = mysqli_query($con,$query);
		$ile = $result->num_rows;
		if($ile > 0 )
		{
			while ($r = $result->fetch_array(MYSQLI_ASSOC)) {
				$kod = $r['kod'];
				$status = $r['status'];
				$procent= $r['rabat'];
				$id_kod = $r['id_kod'];
			}
		}
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
						KOD RABATOWY
					</div>
				</div>
					<div id="produkty_start">
						<div class="bordered_div_no_padding">
							<div class="row">
								<div class="hr_k2">
									<span class="one_line_span">KOD RABATOWY (min 10 znaków)</span>
								</div> 	
								<div class="hr_k3">STATUS</div>		
								<div class="hr_k4">PROCENT</div>	
								<div class="hr_k5">DZIAŁANIA</div>	
							</div>
							<div class="row">
								<div class="hr_k2">
									<input class="tx" type="text" id="rabat_in" value="<?php echo "".$kod.""; ?>"/>
								</div> 	
								<div class="hr_k3">
									<select class="tx" id="status_in">
									<?php 
									if($status == "aktywny" || $status == '') { echo "<option value='aktywny' selected>Aktywny</option><option value='nieaktywny'>Wygasł</option>";} else {echo "<option value='aktywny'>Aktywny</option><option value='nieaktywny' selected>Wygasł</option>";
									}
									?>
									</select>
								</div>		
								<div class="hr_k4">
									<?php
										if($yes)
										{
											echo "<input disabled class='tx' type='text' id='procent_in' maxlength='2' value='$procent'/>";
										}
										else
										{
											echo "<input class='tx' type='text' id='procent_in' maxlength='2' value='$procent'/>";
										}
									?>
								</div> 	
								<div class="hr_k5">
									<div class="s_d_b"><button class="button" onclick="add('<?php echo "".$id_kod.""; ?>')">ZAPISZ</button></div>
								</div>
							</div>
						</div>
					</div>
			</div>
		</div>
		<div style="clear:both;"></div>
	</div>
<script src="http://code.jquery.com/jquery-1.12.4.js"></script>
<script type="text/javascript">
function add(nr)
{
	var st = document.getElementById("status_in");
	var s = st.options[st.selectedIndex].value;
	var k = document.getElementById("rabat_in").value;
	var p = document.getElementById("procent_in").value;
	p = Number(p);
	console.log(k.length);
	if((k.length <= 9) || ((p/1) != p) ) {alert('Popraw kod rabatowy lub Procent.');} else {
		$.ajax({
			url: 'add_r.php',
			type: 'POST',
			dataType: 'json', 
			data: {s:s,k:k,p:p,i:nr},
			success: function(data) {
				if(data == "Ok") {alert("Kod rabatowy został dodany");} else {alert("Kod rabatowy został zedytowany.");}
				window.location.href = "rabaty_lista.php";
			}
		});	
	}
}
</script>
</body>
</html>

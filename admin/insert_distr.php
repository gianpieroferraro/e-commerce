<?php 
	include("database.php");

	include("head.php");
	include("menu.php");
	include("side_bar.php");
	
	$query = $con->query("SELECT * FROM distr");
?>
	<div id="grid_right_insart">
		
			<span style="position: relative;">
				<?php
					$distr = "";
					$email = "";
					$tel = 0;
					$ind = "";
					$p_iva = "";
					if(isset($_POST['distr'])) {$distr = $_POST['distr'];}
					if(isset($_POST['email'])) {$email = $_POST['email'];}
					if(isset($_POST['tel'])) {$tel = $_POST['tel'];}
					if(isset($_POST['indirizzo'])) {$ind = $_POST['indirizzo'];}
					if(isset($_POST['p_iva'])) {$p_iva = $_POST['p_iva'];}
					
					$sql = "INSERT INTO distr (nome_distr, email, tel, indirizzo, p_iva) VALUE ('$distr', '$email ', '$tel', '$ind', '$p_iva');";
					
					?><div class="divInserMex"><?php
						if($_SERVER['REQUEST_METHOD'] === "POST") {
							if($con->query($sql) === true) {
								echo "Dati inseriti correttamente";
							}else {
								echo "Errore di connessione" . $con->error;
							}
						}	
					?></div>
				
				<span class="brid">
					<a onclick="location.href='gest_distr.php'">Gestione Distributori</a>/<b>Inserisci Distributore</b>
				</span>
				<form class="formInser" name="insDistr" action="insert_distr.php" method="POST">
					<table class="table_art_ins">
						<tbody>
							<tr>
								<th scope="col">Distributore</th>
								<td><input class="inserInput" type="text" name="distr"></td>
							</tr>	
							<tr>
								<th scope="col">Email</th>
								<td><input class="inserInput" type="text" name="email"></td>
							</tr>
							<tr>
								<th scope="col">Telefono</th>
								<td><input class="inserInput" type="number" name="tel"></td>
							</tr>
							<tr>
								<th scope="col">Indirizzo</th>
								<td><input class="inserInput" type="text" name="indirizzo"></td>
							</tr>
							<tr>
								<th scope="col">P.IVA</th>
								<td><input class="inserInput" type="text" name="p_iva"></td>
							</tr>
						</tbody>
					</table>
					<input class="inpConf" type="submit" value="Conferma">
				</form>
			</span>
		
	</div>	
<?php include("footer.php"); ?>
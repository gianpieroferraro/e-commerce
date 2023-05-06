<?php 
	include("database.php");

	include("head.php");
	include("menu.php");
	include("side_bar.php");
	
	$query = $con->query("SELECT * FROM sconto");
?>
	<div id="grid_right_insart">
		
			<span style="position: relative;">
				<?php
					$id_articoli = "";
					$tipo_sc = "";
					$inizio = "";
					$fine = "";
					$val_sconto = 0;
					if(isset($_POST['id_articoli'])) {$id_articoli = $_POST['id_articoli'];}
					if(isset($_POST['tipo_sconto'])) {$tipo_sc = $_POST['tipo_sconto'];}
					if(isset($_POST['inizio'])) {$inizio = $_POST['inizio'];}
					if(isset($_POST['fine'])) {$fine = $_POST['fine'];}
					if(isset($_POST['val_sconto'])) {$val_sconto = $_POST['val_sconto'];}
					
					$sql = "insert into sconto (id_articoli, tipo_sconto, data_inizio, data_fine, valore_sconto) 
					values ('$id_articoli', '$tipo_sc', '$inizio', '$fine', '$val_sconto');";
					
					?><div class="divInserMex"><?php
						if($_SERVER['REQUEST_METHOD'] === "POST") {
							if($con->query($sql) === true) {
								echo "Dati inseriti correttamente";
							}else {
								echo "Errore di connessione" . $con->error;
							}
						}	
						$artResult = $con->query("SELECT * FROM articoli");
					?></div>
				
				<span class="brid">
					<a onclick="location.href='gest_sconti.php'">Gestione Sconti</a>/<b>Inserisci Sconto</b>
				</span>
				<form class="formInser" name="insFor" action="insert_sconto.php" method="POST">
					<table class="table_art_ins">
						<tbody>
							<tr>
								<th scope="col">Valore Sconto</th>
								<td><input class="inserInput" type="number" name="val_sconto"></td>
							</tr>
							<tr>
								<th scope="col">Tipo Sconto</th>
								<td><input class="inserInput" type="text" name="tipo_sconto"></td>
							</tr>
							<tr>
								<th scope="col">Data Inizio</th>
								<td><input class="inserInput" type="date" name="inizio"></td>
							</tr>
							<tr>
								<th scope="col">Data Fine</th>
								<td><input class="inserInput" type="date" name="fine"></td>
							</tr>
							<tr>
								<th scope="col">Articolo</th>
								<td><select class="inserInput" name="id_articoli">
										<?php while($p = mysqli_fetch_assoc($artResult)) {echo "<option value='".$p['id_art']."'>".$p['nome']."</option>";} ?>
									</select>
								</td>
							</tr>
						</tbody>
					</table>
					<input class="inpConf" type="submit" value="Conferma">					
				</form>
			</span>
		
	</div>	
<?php include("footer.php"); ?>
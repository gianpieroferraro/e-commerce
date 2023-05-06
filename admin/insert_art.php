<?php 
	include("database.php");

	include("head.php");
	include("menu.php");
	include("side_bar.php");
	
	$query = $con->query("SELECT * FROM articoli");
?>
	<div id="grid_right_insart">
		<span style="position: relative;">
			<?php
				$nome = "";
				$marca = 0;
				$tipo = 0;
				$taglia = "";
				$pezzi = 0;
				$prezzo= 0;
				$distr = 0;
				$target_file = "";
				
				if(isset($_POST['nome'])) {$nome = $_POST['nome'];}
				if(isset($_POST['marca'])) {$marca = $_POST['marca'];}
				if(isset($_POST['tipo'])) {$tipo = $_POST['tipo'];}
				if(isset($_POST['taglia'])) {$taglia = $_POST['taglia'];}
				if(isset($_POST['pezzi'])) {$pezzi = $_POST['pezzi'];}
				if(isset($_POST['prezzo'])) {$prezzo = $_POST['prezzo'];}
				if(isset($_POST['distr'])) {$distr = $_POST['distr'];}
				
				if(isset($_POST['submit'])) {
						$target_dir = "art_img/";
						$target_file = $target_dir . basename($_FILES["file_to_upload"]["name"]);
						print_r($target_file);
						$upoad_ok = 1;
						$image_file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
					
						$check = getimagesize($_FILES['file_to_upload']['tmp_name']);
						if($check !== false) {
							echo "Il file è un'immagine - " . $check["mime"] . ".";
							$upload_ok  = 1;
						} else {
							echo "Il file non è un'immagine.";
							$upload_ok = 0;
						}
						
						if($upload_ok == 0) {
							echo "Errore di caricamento, riprova.";
						}else {
							if(move_uploaded_file($_FILES['file_to_upload']['tmp_name'], $target_file)) {
								echo "Il file " . htmlspecialchars(basename($_FILES['file_to_upload']['name'])) . " E' stato caricato.";
								
							}else {
								echo "Ci scusiamo, è stato riscontrato un errore duranete il caricamento.";
							}
						}
					}
				
				$sql = "INSERT INTO articoli (nome, prezzo, pezzi, taglia, id_marca, id_categoria, id_distr, immagine) VALUE ('$nome', '$prezzo', '$pezzi',
				'$taglia ', '$marca', '$tipo', '$distr', '$target_file');";
				
				?><div class="divInserMex"><?php
					if($_SERVER['REQUEST_METHOD'] === "POST") {
						if($con->query($sql) === true) {
							echo "Dati inseriti correttamente";
							?>
								<script>
									let tID = setTimeout(function() {
										window.location.href = "gestione_art.php"
										window.clearTimeout(tID)
									},2000)
								</script>
								<?php
						}else {
							echo "Errore di connessione" . $con->error;
						}
					}
				?></div>
				
				<?php						
				
				$marResult = $con->query("SELECT * FROM marca");
				$catResult = $con->query("SELECT * FROM categorie");
				$distrResult = $con->query("SELECT * FROM distr");
			?>
			
			<span class="brid">
				<a onclick="location.href='gestione_art.php'">Gestione articoli</a>/<b>Inserisci Articolo</b>
			</span>
			
			<form class="formInser" name="insArt" action="insert_art.php" method="POST" enctype="multipart/form-data">
				<div  class="table_art_ins">
					<table>
						<tbody>
							<tr>
								<th scope="col">Nome articolo</th>
								<td><input class="inserInput" type="text" name="nome"></td>
							</tr>
							<tr>
								<th scope="col">Marca</th>
								<td><select class="inserInput" name="marca">
										<?php while($p = mysqli_fetch_assoc($marResult)) {echo "<option value='".$p['id_mar']."'>".$p['nome_marca']."</option>";} ?>
									</select>
								</td>
							</tr>
							<tr>
								<th scope="col">Tipologia</th>
								<td><select class="inserInput" name="tipo">
										<?php while($p = mysqli_fetch_assoc($catResult)) {echo "<option value='".$p['id']."'>".$p['tipo']."</option>";} ?>
									</select>
								</td>
							</tr>
							<tr>
								<th scope="col">Taglia</th>
								<td><input class="inserInput" type="text" name="taglia"></td>
							</tr>
							<tr>								
								<th scope="col">N. Pezzi</th>
								<td><input class="inserInput" type="number" name="pezzi"></td>
							</tr>
							<tr>
								<th scope="col">Prezzo</th>
								<td><input class="inserInput" type="number" name="prezzo"></td>
							</tr>	
							<tr>
								<th scope="col">Distributore</th>
								<td>
									<select class="inserInput" name="distr">
										<?php while($p = mysqli_fetch_assoc($distrResult)) {echo "<option value='".$p['id']."'>".$p['nome_distr']."</option>";} ?>
									</select><br>
								</td>
							</tr>	
							<tr>
								<th scope="col">Immagine</th>
								<td><input class="choose_file" type="file" name="file_to_upload"></td>
							</tr>
						</tbody>
					</table>
					<input class="inpConf" type="submit" name="submit" value="Conferma">
				</div>	
			</form>
			
		</span>
		
	</div>	
<?php include("footer.php"); ?>
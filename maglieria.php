<?php 
	include("database.php");
	include("front_head.php");
	include("front_menu.php");
	
	
?>

	<div id="hero_maglieria" >
			<h4>Collezione Moda 2022</h4>
			<h2>I dettagli che fanno la differenza</h2>
			<h1>Il pantalone giusto, per un'estate perfetta!</h1>
			<p>Risparmia di più con i coupons, fino al 70% di sconto!</p>
			<button>Acquista ora</button>
	</div>	
	<div id="shoeHead" >
		<span class="brid">
			<a href='/shop/front_index.php'>Home</a> / <b>Scarpe</b>
		</span>
		<i><h1>SCARPE</h1></i>
		<div class="filters">
			<form id="searchFilter" action="scarpe.php" method="POST">
				<div class="distrSel">
					<input class="shoeSearch" name="nome_art" type="text" placeholder="Cerca per nome">
					<input class="shoeSearch" name="marca" type="text" placeholder="Cerca per Marca">
					
					<button class="shoeCerca" type="submit">
						<i class="uil uil-search-alt"></i>
					</button>
				</div>	
			</form>
		</div>
	</div>
	<?php 
	
		if(!isset($_POST['nome_art'])) {
			$nome_art = "";
		}else{
			$nome_art = $_POST['nome_art'];
		}
		
		if(!isset($_POST['marca'])) {
			$marca = "";
		}else{
			$marca = $_POST['marca'];
		}
		
		
		if($nome_art OR $marca) {
			$query = "SELECT * FROM articoli (INNER JOIN marca ON articoli.id_marca = marca.id_mar) INNER JOIN categorie ON articoli.id_categoria = 
			categoria.id WHERE id_padre IS null AND nome LIKE '%".$nome_art."%' AND nome_marca LIKE '%".$marca."%'";
			$result = mysqli_query($con, $query);
		}else{
			$query = "SELECT * FROM articoli INNER JOIN marca ON articoli.id_marca = marca.id_mar INNER JOIN categorie ON articoli.id_categoria = 
			categorie.id WHERE id_padre = 11;";
			$result = mysqli_query($con, $query);
		}
		if (!$result) {
			echo 'Could not run query: ' . mysqli_error($con);
			exit;
		}
		
	?>	
		<section id="feature" class="sectionP1">
	<?php	
		while($row = $result->fetch_assoc()){
	?>
		<div class="imgShoeContainer">
			<img src="/shop/admin/<?php echo $row['immagine']; ?>"> <!--/shop/admin/art_img/scarpe/adi_superstars.jpg-->
			<h4><?php echo $row['nome']; ?></h4>
			<h5><?php echo $row['nome_marca']; ?></h5>
			<div class="shoePrice">
				<b><?php echo $row['prezzo']; ?> €</b>
			</div>
		</div>
	<?php }  ?>
	</section>	
	
	
<?php include("front_footer.php"); ?>
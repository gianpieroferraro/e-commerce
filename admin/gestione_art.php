<?php //include('cookie.php');
	
	$results_per_page =  6;

	if (!isset ($_GET['page']) ) {  
		$page = 1;  
	} else {  
		$page = $_GET['page'];  
	}  
	$page_first_result = ($page-1) * $results_per_page; 
	
	
	include("database.php");
	
	include("head.php");
	include("menu.php");
	include("side_bar.php");
	
	$query = "SELECT * FROM (database_shop.articoli INNER JOIN marca ON articoli.id_marca = marca.id_mar) INNER JOIN categorie ON articoli.id_categoria = categorie.id 
	INNER JOIN distr ON articoli.id_distr = distr.id";
	$result = mysqli_query($con, $query);

	$total = $result->num_rows;
	$number_of_pages = ceil ($total / $results_per_page);
	
		
	if(!isset($_POST['nome_art'])) {
		$nome_art = "";
	}else {
		$nome_art = $_POST['nome_art'];
	}
	
	if(!isset($_POST['nome_marc'])) {
		$nome_marc = "";
	}else {
		$nome_marc = $_POST['nome_marc'];
	}
	
	if(!isset($_POST['type'])) {
		$type = "";
	}else {
		$type = $_POST['type'];
	}	
	
	if(!isset($_POST['distr'])) {
		$nome_distr = "";
	}else {
		$nome_distr = $_POST['distr'];
	}	
	
	if($nome_marc) {
		$query = $con->query("SELECT * FROM (database_shop.articoli INNER JOIN marca ON articoli.id_marca = marca.id_mar) INNER JOIN categorie ON 
		articoli.id_categoria = categorie.id INNER JOIN distr ON articoli.id_distr = distr.id WHERE nome_marca LIKE '%".$nome_marc."%'
		LIMIT " . $page_first_result . ',' . $results_per_page);
	}
	else if($nome_art) {
		$query = $con->query("SELECT * FROM (database_shop.articoli INNER JOIN marca ON articoli.id_marca = marca.id_mar) 
		INNER JOIN categorie ON articoli.id_categoria = categorie.id INNER JOIN distr ON articoli.id_distr = distr.id 
		WHERE nome LIKE '%".$nome_art."%' LIMIT " . $page_first_result . ',' . $results_per_page);
	}else if($type) {
		$query = $con->query("SELECT * FROM (database_shop.articoli INNER JOIN marca ON articoli.id_marca = marca.id_mar) INNER JOIN categorie ON 
		articoli.id_categoria = categorie.id INNER JOIN distr ON articoli.id_distr = distr.id WHERE tipo LIKE '%".$type."%'
		LIMIT " . $page_first_result . ',' . $results_per_page);
	}else if($nome_distr) {
		$query = $con->query("SELECT * FROM (database_shop.articoli INNER JOIN marca ON articoli.id_marca = marca.id_mar) INNER JOIN categorie ON 
		articoli.id_categoria = categorie.id INNER JOIN distr ON articoli.id_distr = distr.id WHERE nome_distr LIKE '%".$nome_distr."%'
		LIMIT " . $page_first_result . ',' . $results_per_page);
	}else {		
		$query = $con->query("SELECT * FROM (articoli INNER JOIN marca ON articoli.id_marca = marca.id_mar) INNER JOIN categorie ON articoli.id_categoria = categorie.id 
		INNER JOIN distr ON articoli.id_distr = distr.id LIMIT " . $page_first_result . ',' . $results_per_page);
	}
	if (!$query) {
		echo 'Could not run query: ' . mysqli_error($con);
		exit;
	}
	
?>
	<div id="grid_right">
		<div class="tab">
			<span>
				
				<form id="searchform" action="gestione_art.php" method="POST">
					<div class="distrSel">
						<div class="insImgBut">
							<a class="add" href="insert_art.php" title="aggiungi articolo"><image class="insArtBut" src="./images/add.svg"></a><br>
							<b>Inserisci</b>
						</div>	
						</span>
						<input class="inserInput" name="nome_art" type="text" placeholder="Cerca per nome">
						<input class="inserInput" name="nome_marc" type="text" placeholder="Cerca per Marca">
						<input class="inserInput" name="type" type="text" placeholder="Cerca per Tipo">
						<input class="inserInput" name="distr" type="text" placeholder="Cerca per Distributore">
							
						<input class="inpCerca submitArt" type="submit" value="Cerca">
					</div>	
				</form>
				<table class="table_art">
					<thead>
						<tr>
							<th scope="col">Modifica</th>
							<th scope="col">Elimina</th>
							<th scope="col">Nome</th>
							<th scope="col">Marca</th>
							<th scope="col">Tipo</th>
							<th scope="col">Taglia</th>
							<th scope="col">N.Pezzi</th>
							<th scope="col">Prezzo</th>
							<th scope="col">Distributore</th>
							<th scope="col">Id Sconto</th>
							<th scope="col">Immagine</th>
						</tr>
					</thead>
					<tbody>
						<?php 
						if ($query->num_rows > 0) {
							while($row = mysqli_fetch_assoc($query)) {?>
								<tr>
									<td class="td_center"><a title="modifica" href="edit_art.php?id=<?php echo $row['id_art'];?>&tipo=<?php echo $row['tipo'];?>
									&marca=<?php echo $row['nome_marca'];?>&distr=<?php echo $row['nome_distr']; ?>&img=<?php echo $row["immagine"]; ?>">
										<image class="icons" src="./images/edit2.svg"></a>
									</td>
									<td class="td_center"><a title="elimina" href="delete_art.php?id=<?php echo $row['id_art']; ?>">
										<image class="icons" src="./images/delete.svg"></a>
									</td>
									<td><?php echo $row['nome']; ?></td>
									<td><?php echo $row['nome_marca']; ?></td>
									<td><?php echo $row['tipo']; ?></td>
									<td><?php echo $row['taglia']; ?></td>
									<td><?php echo $row['pezzi']; ?></td>
									<td><?php echo $row['prezzo']; ?></td>
									<td><?php echo $row['nome_distr']; ?></td>
									<td><?php echo $row['sconto_id']; ?></td>
									<td class="td_center"><a href="<?php echo $row['immagine']; ?>"><img class="thumbimg" src="<?php echo $row['immagine']; ?>"></td>
								</tr>
							<?php
							
							}
						}else {
							echo "Non ci sono righe da mostrare.";
						}
						
						?>
					</tbody>
				</table>
				<div class="pagination">
					<?php
					   $series = 1;
					   $self = "gestione_art.php";
					   $page_pagination = '';
						if ($number_of_pages > '1' ) {
					   
					   
							   $range =10;
							   $range_min = ($range % 2 == 0) ? ($range / 2) - 1 : ($range - 1) / 2;
							   $range_max = ($range % 2 == 0) ? $range_min + 1 : $range_min;
							   $page_min = $page- $range_min;
							   $page_max = $page+ $range_max;
					   
							   $page_min = ($page_min < 1) ? 1 : $page_min;
							   $page_max = ($page_max < ($page_min + $range - 1)) ? $page_min + $range - 1 : $page_max;
							   if ($page_max > $number_of_pages) {
								   $page_min = ($page_min > 1) ? $number_of_pages - $range + 1 : 1;
								   $page_max = $number_of_pages;
							   }
					   
							   $page_min = ($page_min < 1) ? 1 : $page_min;
					   
							   //$page_content .= '<p class="menuPage">';
					   
							   if ( ($page > ($range - $range_min)) && ($number_of_pages > $range) ) {
								   $page_pagination .= '<a title="First" href="'.$self.'?page=1">&lt;</a> ';
							   }
					   
							   if ($page != 1) {
								   $page_pagination .= '<a href="'.$self.'?page='.($page-1). '"></a> ';
							   }
					   
							   for ($i = $page_min;$i <= $page_max;$i++) {
								   if ($i == $page)
								   $page_pagination .= '<a class="active">' . $i . '</a> ';
								   else
								   $page_pagination.= '<a href="'.$self.'?page='.$i. '">'.$i.'</a> ';
							   }
					   
							   if ($page < $number_of_pages) {
								   $page_pagination.= ' <a href="'.$self.'?page='.($page + 1) . '"></a>';
							   }
					   
					   
							   if (($page< ($number_of_pages - $range_max)) && ($number_of_pages > $range)) {
								   $page_pagination .= ' <a title="Last" href="'.$self.'?page='.$number_of_pages. '">&gt;</a> ';
							   }
							   $pages['PAGINATION'] ='<p id="pagination">'.$page_pagination.'</p>';
						   }//end if more than 1 page
					   echo $page_pagination;
					   
					?>
				</div>
			</span>
		</div>
	</div>
	
<?php include("footer.php"); ?>
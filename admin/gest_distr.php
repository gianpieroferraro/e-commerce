<?php 
	$results_per_page =  4;

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
	
	$query = "SELECT * FROM distr";
	$result = mysqli_query($con, $query);
	
	$total = $result->num_rows;
	$number_of_pages = ceil ($total / $results_per_page);
	
	
	if(!isset($_POST['distr'])) {
		$distr = "";
	}else {
		$distr = $_POST['distr'];
	}
	
	if($distr) {
		$query = $con->query("SELECT * FROM distr WHERE nome_distr LIKE '%".$distr."%' LIMIT " .$page_first_result. ',' .$results_per_page);
	}else {
		$query = $con->query("SELECT * FROM distr LIMIT " . $page_first_result . ',' . $results_per_page);
	}
	
	$distr_res = $con->query("SELECT * FROM distr");
?>
	<div id="grid_right">
		<div class="tab">
			<span>
				<form id="searchform" action="gest_distr.php" method="POST">
					<div class="distrSel">
						<div class="insImgBut">
							<a class="add" href="insert_distr.php" title="aggiungi Distributore"><image class="insArtBut" src="./images/add.svg"></a><br>
							<b>Inserisci</b>
						</div>
						<div>
							<select  class="inserInput" name="distr">
								<option disabled selected value>Distributore</option>
								<?php while($p = mysqli_fetch_assoc($distr_res)) {echo "<option value='".$p['nome_distr']."'>" . $p['nome_distr']."</option>";} ?>
							</select>
						</div>
						<input class="inpCerca submitArt"  type="submit" value="Cerca">
					</div>
				</form>
				<table class="table_art">
					<thead>
						<tr>
							<th scope="col">Modifica</th>
							<th scope="col">Elimina</th>
							<th scope="col">Distributore</th>
							<th scope="col">Email</th>
							<th scope="col">Telefono</th>
							<th scope="col">Indirizzo</th>
							<th scope="col">P.IVA</th>
						</tr>
					</thead>
					<tbody>
						<?php 
						if ($query->num_rows > 0) {
							while($row = mysqli_fetch_assoc($query)) {?>
								<tr>
									<td class="td_center"><a title="modifica" href="edit_distr.php?id=<?php echo $row['id'];?>">
										<image class="icons" src="./images/edit2.svg"></a>
									</td>
									<td class="td_center"><a title="elimina" href="delete_distr.php?id=<?php echo $row['id']; ?>">
										<image class="icons" src="./images/delete.svg"></a>
									</td>
									<td><?php echo $row['nome_distr']; ?></td>
									<td><a href="mailto:<?php echo $row['email']; ?>"><?php echo $row['email']; ?></td>
									<td><?php echo $row['tel']; ?></td>
									<td><?php echo $row['indirizzo']; ?></td>
									<td><?php echo $row['p_iva']; ?></td>
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
					   $self = "gest_distr.php";
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
<?php 
	include("config/config.php");
?>
<div class="menu_search_little">
	<ul>
	   <li class='has-sub categoria' id="categoria_menu"><a href='#'><span>Categorias</span></a>
	      <ul class="lista_mini">
			<?php
				$query_cat= "SELECT id_cat, nome_cat from categorias"; 
				$stmt_cat = $mydb->prepare($query_cat);
				$stmt_cat->execute(); 

				$stmt_cat->bind_result($id, $nome); 
				while ($stmt_cat->fetch()) { 
			?>
	         <li>
	         	<a href='#'>
	         		<input type="checkbox" name="categoria" value="<?php echo $nome;?>" id="ckb_cat_<?php echo $id;?>" class="check_paint" data-id="<?php echo $id;?>">
	         		<label for="ckb_cat_<?php echo $id;?>" name="lbl_cat_<?php echo $id;?>" class="label_paint"><?php echo $nome;?></label>
	         	</a>
	         </li>
			<?php
				}
				$stmt_cat->close();
			?>
	      </ul>
	   </li>
	   <li>
	   		<div id="teste_cat"></div>
	   </li>
	   <li class='has-sub last plataforma' id="plataforma_menu"><a href='#'><span>Plataforma</span></a>
	      <ul  class="lista_mini">

			<?php
				$query_plat= "SELECT id_plat, nome_plat, img_plat from plataforma"; 
				$stmt_plat = $mydb->prepare($query_plat);
				$stmt_plat->execute(); 

				$stmt_plat->bind_result($id, $nome, $img); 
				while ($stmt_plat->fetch()) { 
			?>
			         <li>
			         	<a href='#'>
							<img src="<?php echo $img;?>" alt="SO" class="plat_<?php echo $nome;?>" data-id="<?php echo $id;?>">
							<input type="checkbox" name="plataforma" value="<?php echo $nome;?>" id="ckb_plat_<?php echo $id;?>" class="check_paint">
			         		<label for="ckb_plat_<?php echo $id;?>" name="lbl_plat_<?php echo $id;?>" class="label_paint"><?php echo $nome;?></label>
			         	</a>
			         </li>
			<?php
				}
				$stmt_plat->close();
			?>
	      </ul>
	   </li>
	   <li>
	   		<div id="teste_plat"></div>
	   </li>
	</ul>
</div>

			<div class="container_menu" id="feed_menu">
				
			</div>
			<div class="bundle_pack" id="feed_container">

			</div>
			<div class="game_pack">

			</div>
			<div class="payment">
			</div>
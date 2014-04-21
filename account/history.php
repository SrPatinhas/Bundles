<?php 
    include("../config/config.php");

    if (!isset($_SESSION)) {
        session_start();
    }
    if (isset($_COOKIE["id_user"])){
        $_SESSION["id_user"] = $_COOKIE["id_user"];
        $_SESSION["user"] = $_COOKIE["user"];
        $user = $_COOKIE["id_user"];
    }else{
        if (isset($_SESSION["id_user"])){
            $user = $_SESSION["id_user"];
        } else {
            $user = "";
        }
    }
?> 

<style type="text/css">
	.custab{
	    border: 1px solid #ccc;
	    padding: 5px;
	    margin: 5% 0;
	    box-shadow: 3px 3px 2px #ccc;
	    transition: 0.5s;
	}

	.custab:hover{
	    box-shadow: 3px 3px 0px transparent;
	    transition: 0.5s;
	}
</style>

<div class="history_pack">
    <table class="table table-striped table-bordered table-hover custab" style="backgroud:white; color:black;">
    <thead>
        <tr>
            <th>#</th>
            <th>Email</th>
            <th>Valor Pago</th>
            <th>Nome do Bundle</th>
            <th>Data da Compra</th>
            <th>Chave</th>
        </tr>
    </thead>
    <tbody>
    	<?php
    		$query_history= "SELECT c.*, b.nome_bundle  FROM compras AS c INNER JOIN bundles AS b on b.id_bundle = c.id_bundle WHERE c.id_user = ? "; 
					$stmt_history = $mydb->prepare($query_history);
					$stmt_history->bind_param("i", $user); 
					$stmt_history->execute(); 

					$result_history = $stmt_history->get_result();
					while ($row_history = $result_history->fetch_assoc()) {
		?>
			            <tr>
			                <td>#<?php echo $row_history['id_compras']; ?></td>
			                <td><h6><?php echo $row_history['email_gift']; ?></h6></td>
			               	<td><?php echo round($row_history['valor'], 2); ?> €</td>
			                <td><?php echo $row_history['nome_bundle']; ?></td>
			               	<td><?php echo $row_history['data_compra']; ?></td>
			                <td><?php echo $row_history['key']; ?></td>

			            </tr>
		<?php
					}
					$result_history->free();
					$stmt_history->close();
		?>


    </tbody>
    </table>
</div>
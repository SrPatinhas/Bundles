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
            header('location:../index.php');
        }
    }
?>
<link rel="stylesheet" type="text/css" href="book.css">

<div class="page-header effect7" style="background: #FFF;width:1010px;">
  <h1 class="title-h1">Favoritos</h1>
</div>
<div class="container game_pack effect7" style="width: 950px">
   
    <div id="products" class="row list-group">
    <?php
            
                $query_bundles= "SELECT b.*  FROM bundles AS b LEFT JOIN favoritos AS f on b.id_bundle = f.id_bundle WHERE f.id_user = ? "; 
                $stmt_bundles = $mydb->prepare($query_bundles);
                $stmt_bundles->bind_param("i", $user); 
                $stmt_bundles->execute(); 

                $result_bundles = $stmt_bundles->get_result();
                while ($row_bundles = $result_bundles->fetch_assoc()) {
                    $bundle_id = $row_bundles['id_bundle'];
            ?>      <div class="bundle_info_total" id="bundle_total_<?php echo $bundle_id;?>" data-id="<?php echo $bundle_id;?>">
                        <div class="item  col-xs-4 col-lg-4 list-group-item" id="bundle_info_<?php echo $bundle_id;?>">
                            <div class="thumbnail">
                                <img class="group list-group-image" src="../<?php echo $row_bundles['capa_bundle']; ?>" alt="" style="max-width: 450px;max-height: 200px;">
                                <div class="caption">
                                    <h4 class="group inner list-group-item-heading"><?php echo $row_bundles['nome_bundle']; ?></h4>
                                    <p class="group inner list-group-item-text">Data de Inicio: <?php echo $row_bundles['data_ini_bundle']; ?></p>
                                    <p class="group inner list-group-item-text">Data de Fim: <?php echo $row_bundles['data_fim_bundle']; ?></p>
                                    
                                    <div class="row">
                                        <div class="col-xs-12 col-md-6">
                                            <p class="lead"><?php echo round($row_bundles['preco_bundle'], 2);?> &#128</p>
                                        </div>
                                         <div class="col-xs-12 col-md-6">
                                            <a class="btn btn-danger remove_bundle" data-id="<?php echo $bundle_id;?>" ><span class="icon-heart-empty"></span>Remover dos Favoritos</a>

                                            <a class="btn btn-info" style="float:right;" data-toggle="collapse" data-target="#bundle_<?php echo $bundle_id; ?>"><span class="icon-plus"></span>Ver Jogos</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="bundle_<?php echo $bundle_id; ?>" class="panel-collapse collapse out">
                            <div class="panel-body well">
                              <table class="table table-striped table-condensed">
                                   <thead>
                                        <tr>
                                            <th>CAPA</th>
                                            <th class="table-bordered">Nome</th>
                                            <th class="table-bordered">Ano</th>
                                            <th class="table-bordered">Descrição</th>
                                        </tr>
                                    </thead>   
                                    <tbody>
                            <?php
                            
                                $query_jogos= "SELECT j.*  FROM jogos AS j LEFT JOIN bundle_jogos AS bj on j.id_jogo = bj.id_jogo WHERE bj.id_bundle = ? "; 
                                $stmt_jogos = $mydb->prepare($query_jogos);
                                $stmt_jogos->bind_param("i", $bundle_id); 
                                $stmt_jogos->execute(); 

                                $result_jogos = $stmt_jogos->get_result();
                                while ($row_jogos = $result_jogos->fetch_assoc()) {
                            ?>
                                        <tr>
                                            <td><img class="img-thumbnail col-md-10" src="<?php echo $row_jogos['img_jogo']; ?>" alt="" /></td>
                                            <td class="table-bordered"><?php echo $row_jogos['nome_jogo']; ?></td>
                                            <td class="table-bordered"><?php echo $row_jogos['lanc_jogo']; ?></td>
                                            <td class="table-bordered"><?php echo $row_jogos['informacao']; ?></td>
                                        </tr>
                            <?php 
                                }
                                $result_jogos->free();
                                $stmt_jogos->close();
                            ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
<?php
                    }
                    $result_bundles->free();
                    $stmt_bundles->close();
?>
    </div>
</div>
</div>
            <script>
                $(function() {
                    $(document).on('click', ".remove_bundle", function() {
                        var id = $(this).attr("data-id");
                        var dataString = 'id='+ id ;

                        var base = "#bundle_total_" + id;
                        var bundle = "#bundle_info_" + id;
                        $.ajax({
                            type: "POST",
                            url: "save_book.php",
                            data: dataString,
                            cache: false,
                            success: function(html){
                                    $(base).effect( "blind", "slow" );
                                    $('#add_bundle_bookmarks').attr('data-tipo', 'remove');
                                    $('#label_fav').text('Remover dos Favoritos');
                                    $('#label_icon').removeClass().addClass('icon-heart-empty');
                            } 
                        });
                        return false;
                    });
                });
            </script>

<?php
    require_once ("../config/config.php");

    if($_POST['page']){
        $page = $_POST['page'];
        $cur_page = $page;
        $page -= 1;
        $per_page = 10;
        $previous_btn = true;
        $next_btn = true;
        $first_btn = true;
        $last_btn = true;
        $start = $page * $per_page;

        $final_body ='<thead>
                    <tr>
                      <th>#</th>
                      <th>Nome</th>
                      <th>Username</th>
                      <th>Email</th>
                      <th>Avatar</th>
                      <th>Tipo</th>
                      <th>Estado</th>
                      <th style="width: 70px;"></th>
                    </tr>
                  </thead><tbody>';

        $query= "SELECT `id_user`, `nome_user`,  `username`, `email_user`, `avatar_user`, `type`, `verificado` FROM `user` LIMIT ?, ?"; 
        $stmt = $mydb->prepare($query);
        $stmt->bind_param("ii", $start, $per_page); 
        $stmt->execute(); 

        $stmt->bind_result($id, $nome, $username, $email, $avatar, $tipo, $verificado); 
        while ($stmt->fetch()) {
            switch ($verificado) {
                case 'ativo':
                    $tipo_span = "success";
                    break;
                case 'pendente':
                    $tipo_span = "warning";
                    break;
                case 'inativo':
                    $tipo_span = "default";
                    break;
                case 'banido':
                    $tipo_span = "danger";
                    break;
            }
            $class_edit = "editable editable-click editable-disabled";
            $tbody ="<tr class='user_details' data-pk='$id'  id='user_details_$id'>".
                      "<td style='vertical-align: middle;'>$id</td>".
                      "<td style='vertical-align: middle;'><a href='#' id='nome_$id'  class='nome_edit $class_edit'   data-pk='$id'>$nome</a></td>".
                      "<td style='vertical-align: middle;'><a href='#' id='user_$id'  class='user_edit $class_edit'   data-pk='$id'>$username</a></td>".
                      "<td style='vertical-align: middle;'><a href='#' id='email_$id' class='email_edit $class_edit'  data-pk='$id' data-type='email' >$email</a></td>".
                      "<td style='vertical-align: middle;'><a href='#' id='avatar_$id'class='avatar_edit $class_edit' data-pk='$id'><img src='$avatar' class='img-thumbnail' style='max-width:60px; max-height:70px;margin:-3px;' alt='$nome'></a></td>".
                      "<td style='vertical-align: middle;'><a href='#' id='tipo_$id'  class='tipo_edit $class_edit'   data-pk='$id' data-type='select' data-title='Selecionar cargo'>$tipo</a></td>".
                      "<td style='vertical-align: middle;'><a href='#' id='state_$id' class='state_edit $class_edit'  data-pk='$id' data-type='select' data-value='$id' data-title='Selecionar estado'><span class='label label-$tipo_span'>$verificado</span></a></td>".
                      "<td style='vertical-align: middle;'>".
                      "    <a href='#' class='editable_user' data-pk='$id'>".
                      "      <button type='button' class='btn btn-default btn-xs'>".
                      "          <span style='color:black;' class='glyphicon glyphicon-pencil'></span>".
                      "      </button>".
                      "    </a>".
                      "    <a href='#myModal' role='button' data-toggle='modal' class='modal_show_up' data-ik='$id' data-nk='$nome'>".
                      "      <button type='button' class='btn btn-danger btn-xs'>".
                      "          <span style='color:white;' class='glyphicon glyphicon-remove'></span>".
                      "      </button>".
                      "    </a>".
                      "</td>".
                "</tr>";
            $final_body.=$tbody; 
        }
        $stmt->close();

        $final_body.="</tbody>      \n<tfoot>       \n<tr>        \n";

        /* --------------------------------------------- */
        $query_pag_num = "SELECT COUNT(*) AS count_page FROM `user`";
        $stmt_page = $mydb->prepare($query_pag_num);
        $stmt_page->execute();
        $stmt_page->bind_result($contador_page);
        //fetch the first result row, this pumps the result values in the bound variables
        if($stmt_page->fetch()){
            $count = $contador_page;
        }

        $cur_result = 10 * $cur_page - 9;
        $cur_p_result = 10 * $cur_page;
        if ($cur_result > $count) {
            $cur_result = $count;
            $cur_p_result = $count;
        }
        if ($cur_p_result > $count) {
            $cur_p_result = $count;
        }
        $no_of_paginations = ceil($count / $per_page);
        $stmt_page->close();
        /* ---------------Calculating the starting and endign values for the loop----------------------------------- */
        if ($cur_page >= 7) {
            $start_loop = $cur_page - 3;
            if ($no_of_paginations > $cur_page + 3)
                $end_loop = $cur_page + 3;
            else if ($cur_page <= $no_of_paginations && $cur_page > $no_of_paginations - 6) {
                $start_loop = $no_of_paginations - 6;
                $end_loop = $no_of_paginations;
            } else {
                $end_loop = $no_of_paginations;
            }
        } else {
            $start_loop = 1;
            if ($no_of_paginations > 7)
                $end_loop = 7;
            else
                $end_loop = $no_of_paginations;
        }
        /* ----------------------------------------------------------------------------------------------------------- */
        $final_body .= "<td colspan='2'>          \n<div style='text-align:left;'>";

        // FOR ENABLING THE FIRST BUTTON
        if ($first_btn && $cur_page > 1) {
            $page_list = "<li p='1'><a p='1' href='#'>First</a></li>";
        } else if ($first_btn) {
            $page_list = "<li p='1' class='disabled' style='z-index:-1;'><a p='1' href='#'>First</a></li>";
        }

        // FOR ENABLING THE PREVIOUS BUTTON
        if ($previous_btn && $cur_page > 1) {
            $pre = $cur_page - 1;
            $page_list .= "<li p='$pre'><a p='$pre' href='#'>&laquo;</a></li>";
        } else if ($previous_btn) {
            $page_list .= "<li class='disabled' style='z-index:-1;'><a href='#'>&laquo;</a></li>";
        }
        for ($i = $start_loop; $i <= $end_loop; $i++) {
            if ($cur_page == $i)
                $page_list .= "<li p='$i' class='active'><a p='$i' href='#'>{$i}</a></li>";
            else
                $page_list .= "<li p='$i'><a p='$i' href='#'>{$i}</a></li>";
        }

        // TO ENABLE THE NEXT BUTTON
        if ($next_btn && $cur_page < $no_of_paginations) {
            $nex = $cur_page + 1;
            $page_list .= "<li p='$nex'><a p='$nex' href='#'>&raquo;</a></li>";
        } else if ($next_btn) {
            $page_list .= "<li class='disabled' style='z-index:-1;'><a href='#'>&raquo;</a></li>";
        }

        // TO ENABLE THE END BUTTON
        if ($last_btn && $cur_page < $no_of_paginations) {
            $page_list .= "<li p='$no_of_paginations'><a p='$no_of_paginations' href='#'>Last</a></li>";
        } else if ($last_btn) {
            $page_list .= "<li p='$no_of_paginations' style='z-index:-1;' class='disabled'><a p='$no_of_paginations' href='#'>Last</a></li>";
        }

        $total_list = "<p class='text-muted' a='$no_of_paginations'>Page <b>$cur_page</b> of <b id='page_total' data-page='$no_of_paginations'>$no_of_paginations</b></p>";
        $total_result = "<p class='text-muted' a='$no_of_paginations'>Resultados <b>$cur_result</b> until <b>$cur_p_result</b> of <b>$count</b></p>";
        $final_body.= $total_list.$total_result;
        $final_body.= "</td>\n<td colspan='5'>\n<ul class='pagination' style='margin-left: 25%;' id='pagination_user'>";
        $final_body.= $page_list; // Content for pagination
        $final_body.="</ul>       \n</div>          \n</td>         \n</tr>        \n </tfoot>";
 
        echo $final_body;
    }
?>
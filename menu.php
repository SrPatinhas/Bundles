<?php
    if (!isset($_SESSION)) {
        session_start();
    }
    if (isset($_COOKIE["id_user"])){
        $_SESSION["id_user"] = $_COOKIE["id_user"];
        $_SESSION["user"] = $_COOKIE["user"];
        $_SESSION["tipo"] = $_COOKIE["tipo"];
        $tipo =  $_SESSION["tipo"];
        $user = $_COOKIE["id_user"];
    }else{
        if (isset($_SESSION["id_user"])){
            $user = $_SESSION["id_user"];
            $tipo =  $_SESSION["tipo"];
        } else {
            $user = "";
            $tipo = "";
        }
    }
?> 
        <div class="container">
           <div class="content">
                <ul class="ca-menu">
                    <li>
                        <a href="<?php echo $caminho; ?>">
                            <span class="ca-icon">A</span>
                            <div class="ca-content">
                                <h2 class="ca-main">Home</h2>
                                <h3 class="ca-sub">Ultimas e Noticias</h3>
                            </div>
                        </a>
                    </li>
                    <?php if ($user != "") { ?>
                        <li>
                            <a href="<?php echo $caminho; ?>account/">
                                <span class="ca-icon">U</span>
                                <div class="ca-content">
                                    <h2 class="ca-main">Perfil</h2>
                                    <h3 class="ca-sub">Detalhes sobre a sua contas</h3>
                                </div>
                            </a>
                        </li>
                    <?php } else { echo "<li style='background:none; box-shadow:none;-webkit-box-shadow:none;'></li>"; }?>
                    <?php if ($user != "") { ?>
                        <li>
                            <a href="<?php echo $caminho; ?>bookmarks/">
                                <span class="ca-icon">N</span>
                                <div class="ca-content">
                                    <h2 class="ca-main">Favoritos</h2>
                                    <h3 class="ca-sub">Tudo o que marcou como favorito</h3>
                                </div>
                            </a>
                        </li>
                    <?php } ?>
                    <li>
                        <a href="#" data-toggle="modal" data-target="#Modal_search">
                            <span class="ca-icon">L</span>
                            <div class="ca-content">
                                <h2 class="ca-main">Pesquisa</h2>
                                <h3 class="ca-sub">Pesquise aqui o que pretende</h3>
                            </div>
                        </a>
                    </li>
                    <?php if (($user != "") and (($tipo != "developer") and ($tipo != "administrador"))) { ?>
                        <li id="sub_menu_option">
                            <a href="<?php echo $caminho; ?>config/logout.php">
                                <span class="ca-icon">X</span>
                                <div class="ca-content">
                                    <h2 class="ca-main">Sair</h2>
                                    <h3 class="ca-sub">Sair da Conta</h3>
                                </div>
                            </a>
                        </li>
                    <?php } else if (($user != "") and (($tipo == "developer") or ($tipo == "administrador"))) { ?>
                        <li id="sub_menu_option">
                            <a href="#">
                                <span class="ca-icon">S</span>
                                <div class="ca-content">
                                    <h2 class="ca-main">Opções</h2>
                                    <h3 class="ca-sub">Definições e sair</h3>
                                </div>
                            </a>
                            <ul style="display: none;" class="sub_menu_option">
                                <li>
                                    <a href="<?php echo $caminho; ?>back_office/">
                                        <div class="ca-content">
                                            <h3 class="ca-sub_option">Panel de Administração</h3>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?php echo $caminho; ?>config/logout.php">
                                        <div class="ca-content">
                                            <h3 class="ca-sub_option">Sair</h3>
                                        </div>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    <?php } else { ?>
                        <li>
                            <a href="#" data-toggle="modal" data-target="#Modal_login">
                                <span class="ca-icon">U</span>
                                <div class="ca-content" id="bt_modal_login_call">
                                    <h2 class="ca-main">Login</h2>
                                    <h3 class="ca-sub">Entrar na Sua Conta</h3>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="#" data-toggle="modal" data-target="#Modal_register">
                                <span class="ca-icon">+</span>
                                <div class="ca-content">
                                    <h2 class="ca-main">Registar</h2>
                                    <h3 class="ca-sub">Criar a sua Conta</h3>
                                </div>
                            </a>
                        </li>
                    <?php } ?>
                </ul>
            </div>
        </div>
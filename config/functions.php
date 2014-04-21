<?php
include ('config.php');
    function caminholocal(){
        $caminho_local = "/escola/Semestre%203/Design/";
        return $caminho_local;
    }

    function user_bd(){
        $user = "root";
        return $pass;
    }
    function pass_bd(){
        $pass = "1234";
        return $user;
    }
    function crypto_rand_secure($min, $max) {
        $range = $max - $min;
        if ($range < 0) return $min; // not so random...
        $log = log($range, 2);
        $bytes = (int) ($log / 8) + 1; // length in bytes
        $bits = (int) $log + 1; // length in bits
        $filter = (int) (1 << $bits) - 1; // set all lower bits to 1
        do {
            $rnd = hexdec(bin2hex(openssl_random_pseudo_bytes($bytes)));
            $rnd = $rnd & $filter; // discard irrelevant bits
        } while ($rnd >= $range);
        return $min + $rnd;
    }

    function getToken($length){
        $token = "";
        $codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $codeAlphabet.= "abcdefghijklmnopqrstuvwxyz";
        $codeAlphabet.= "0123456789";
        for($i=0;$i<$length;$i++){
            $token .= $codeAlphabet[crypto_rand_secure(0,strlen($codeAlphabet))];
        }
        return $token;
    }
    function getKey($length){
        $token = "";
        $codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $codeAlphabet.= "abcdefghijklmnopqrstuvwxyz";
        $codeAlphabet.= "0123456789";
        for($i=0;$i<$length;$i++){
            $token .= $codeAlphabet[crypto_rand_secure(0,strlen($codeAlphabet))];
        }
        return $token;
    }

    function getCategorias($id_jogo){
        global $mydb;
        $valor="";

        $query_cat= "SELECT cat.nome_cat FROM categorias AS cat LEFT JOIN jogos_cat AS jcat ON cat.id_cat = jcat.id_cat WHERE jcat.id_jogo = ? "; 
        $stmt_cat = $mydb->prepare($query_cat);
        $stmt_cat->bind_param("i", $id_jogo); 
        $stmt_cat->execute(); 

        $stmt_cat->bind_result($nome_cat); 
        while ($stmt_cat->fetch()) { 
            $valor .= "<span>$nome_cat</span> ";
        }
        $stmt_cat->close();
        return $valor;
    }

    function getPlataformas($id_jogo){
        global $mydb;
        $valor="";

        $query_plat= "SELECT plat.nome_plat FROM plataforma AS plat LEFT JOIN jogos_plat AS jplat ON plat.id_plat = jplat.id_plat WHERE jplat.id_jogo = ?"; 
        $stmt_plat = $mydb->prepare($query_plat);
        $stmt_plat->bind_param("i", $id_jogo); 
        $stmt_plat->execute(); 

        $stmt_plat->bind_result($nome_plat); 
        while ($stmt_plat->fetch()) { 
            switch ($nome_plat) {
                case 'IOS':
                        $plat = "apple";
                    break;
                case 'Android':
                        $plat = "android";
                    break;
                case 'Linux':
                        $plat = "linux";
                    break;
                case 'Steam':
                        $plat = "steam";
                    break;
                case 'Windows':
                        $plat = "windows";
                    break;

                default:
                    # code...
                    break;
            }
            $valor .= "<span class='plat-$plat'></span> ";
        }
        $stmt_plat->close();
        return $valor;
    }
?>
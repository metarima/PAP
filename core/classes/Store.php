<?php

namespace core\classes;

use Exception;

class Store
{
    public static function Layout($estruturas, $dados = null)
    {
        if (!is_array($estruturas)) {
            throw new Exception("Coleção de estruturas inválida");
        }

        if (!empty($dados) && is_array($dados)) {
            extract($dados);
        }


        foreach ($estruturas as $estrutura) {
            include("../core/views/$estrutura.php");
        }

    }
    public static function criarHash($num_caracteres = 12)
    {
        // Criar hashes
        $chars =
            '01234567890123456789abcdefghijlmnopqrstuvwxyzabcdefghijlmnopqrstuvwxyzABCDEFGH
IJLMNOPQRSTUVWXYZABCDEFGHIJLMNOPQRSTUVWXYZ';
        return substr(str_shuffle($chars), 0, $num_caracteres);
    }
    public static function clienteLogado()
    {
        return isset($_SESSION['cliente']);
    }
    

    public static function Layout_admin($estruturas, $dados = null) 
 { 
 // Estruturas são a coleção de ficheiros (html_header.php .....)
 // seguindo a sequência de apresentação 
 //html_header.php nav_bar.php inicio.php html_footer.php
 // Verifica se estruturas é um array
 if (!is_array($estruturas)) // Se não for array
 { } 
 // variáveis 
 if (!empty($dados) && is_array($dados)) { 
 // significa que foram enviadas informações, que queremos
 // Passar para dentro das nossas views
 extract($dados); 
 } 
 // apresentar as views da aplicação
 // Ficheiros que estão colocados dentro das views
 foreach ($estruturas as $estrutura) { 
 include("../../core/views/$estrutura.php"); // como vou usar 
 }
}

    public static function adminLogado()
    {
        // Verifica se temos um admin logado / em sessão
        // SE EXISTIR um cliente na sessão vai devolver true
        return isset($_SESSION['admin']);
    }

    public static function Printdata($data, $die = true)
    {
        if (is_array($data) || is_object($data)) {
            echo "<pre>";
            print_r($data);
        } else {
            echo "<pre>";
            echo $data;
        }
        if ($die) {
            die("FIM");
        }
    }

    public static function redirect($rota = '', $admin = false)
    {
        // Faz o redirecionamento para a URL desejada (rota)
        if (!$admin) {
            header("Location: " . BASE_URL . "?a=$rota");
        } else {
            header("Location: " . BASE_URL . "/admin?a=$rota");
        }
    }


}
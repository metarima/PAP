<?php

namespace core\models;
use core\classes\Database;
use core\classes\Store;

class clientes
{
    public function verificar_email_existe($email)
    {
        $bd = new Database();
        $parametros = [
            ':email' => strtolower(trim($email))
        ];
        $resultados = $bd->select("SELECT email FROM clientes WHERE email = :email", $parametros);
        // se o cliente já existe
        if (count($resultados) != 0) {
            return true;
        } else {
            return false;
        }
    }
    public function validar_login($utilizador, $password)
    {
        $parametros = [
            ':utilizador' => $utilizador
        ];
        $bd = new Database();
        $resultados = $bd->select("
        SELECT * FROM clientes 
        WHERE email = :utilizador 
        AND ACTIVO = 1 
        AND deleted_at IS NULL", $parametros);
        if (count($resultados) != 1) {
            // Não existe utilizador
            return false;
        } else {
            // Temos utilizador , verifcar a password
            // Que está codificada
            $utilizador = $resultados[0];
            // Verifar a pass
            if (!password_verify($password, $utilizador->senha)) {
                // password inválida
                return false;
            } else {
                // Login é válido // Utilizador existe e a pass está OK
                return $utilizador;
            }
        }
    }
    public function validar_email($purl)
    {
        // Validar o email do cliente
        $bd = new Database();
        $parametros = [
            ':purl' => $purl
        ];
        $resultados = $bd->select(
            "SELECT * FROM clientes WHERE purl = :purl",
            $parametros
        );
        // Verifca se foi encontrado o cliente
        if (count($resultados) != 1) {
            return false;
        }
        // Foi encontrado o Purl
        $id_cliente = $resultados[0]->id_cliente;
        // Já posso atualizar os dados
        $parametros = [
            ':id_cliente' => $id_cliente
        ];
        // store::Printdata($parametros);
        // Vou atualizar na bd o campo ativo do user, ativo passa a 1
        // e meto o purl a nulo
        $bd->update("UPDATE clientes SET purl = NULL, activo=1, updated_at=NOW() WHERE id_cliente = :id_cliente", $parametros);
        return true;
    }
    public function registar_cliente()
    {
        $bd = new Database();
        $purl = store::criarHash();
        $parametros = [
            // NOME DOS PARAMETROS = NOME DOS CAMPOS
            ':email' => strtolower(trim($_POST['text_email'])),
            // ENCRIPTAÇÃO DA SENHA
            ':senha' => password_hash($_POST['text_senha_1'], PASSWORD_DEFAULT),
            ':nome_completo' => trim($_POST['text_nome_completo']),
            ':morada' => trim($_POST['text_morada']),
            ':cidade' => trim($_POST['text_cidade']),
            ':telefone' => trim($_POST['text_telefone']),
            ':purl' => $purl,
            ':activo' => 0,
        ];
        $bd->insert("
        INSERT INTO clientes VALUES(
        0,
        :email,
        :senha,
        :nome_completo,
        :morada,
        :cidade,
        :telefone,
        :purl,
        :activo,
        NOW(),
        NOW(),
        NULL
        )
        ", $parametros);
        return $purl;
    }
}
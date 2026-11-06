<?php

namespace core\controllers;

use core\classes\Database;
use core\classes\EnviarEmail;
use core\classes\Store;
use core\models\Clientes;

class Main
{
    // Validar o email do cliente

    public function confirmar_email()
    {
        // Vamos agora verificar se o utilizador já existe
        // Vamos agora verificar se o utilizador já existe
        if (Store::clienteLogado()) {
            $this->index();
            return;
        }
        // Se não existe na query string um purl
        if (!isset($_GET['purl'])) {

            $this->index();
            return;
        }
        $purl = $_GET['purl'];
        // Veriifca se o purl é válido
        if (strlen($purl) != 12) {
            $this->index();
            return;
        }
        $cliente = new Clientes();
        $resultado = $cliente->validar_email($purl);
        if ($resultado) {

            Store::Layout([
                'layouts/html_header',
                'layouts/header',
                'conta_confirmada_sucesso',
                'layouts/footer',
                'layouts/html_footer',
            ]);
            return;

        } else {
            Store::redirect();
        }
    }
    public function login()
    {
        /* Verificar se existe um utilizador logado */
        //apresenta o Layout Informar o envio do Email
        Store::Layout([
            'layouts/html_header',
            'layouts/header',
            'login_frm',
            'layouts/footer',
            'layouts/html_footer',
        ]);
    }

    public function login_submit()
    {
        /* Verificar se existe um utilizador logado */
        if (Store::clienteLogado()) {
            Store::redirect();
            return;
        }
        // veriifca se foi efetuado um post do Formulário de Login
        // veriifca se foi efetuado um post do Formulário de Login
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            if (Store::clienteLogado()) {
                Store::redirect();
                return;
            }
        }
        // Validar campos
        if (
            !isset($_POST['text_utilizador']) ||
            !isset($_POST['text_password']) || !filter_var(
                trim($_POST['text_utilizador']),
                FILTER_VALIDATE_EMAIL
            )
        ) {
            // erro de preenchimento do form
            $_SESSION['erro'] = 'Login Inválido';
            store::redirect('login');
            return;
        }
        // Prepara os dados para o model
        $utilizador = trim(strtolower($_POST['text_utilizador']));
        $password = trim($_POST['text_password']);
        // Ir à bd (ver login)
        // carrega o model e verifica se o login é correto
        $cliente = new Clientes();
        // chama model Clientes, validar_login
        // Para verificar user e pass
        $resultado = $cliente->validar_login($utilizador, $password);
        // analisa o resultado
        if (is_bool($resultado)) {
            //Login inválido
            $_SESSION['erro'] = 'Login Inválido';
            Store::redirect('login');
            return;
        } else {
            // Login Válido, criar sessão cliente
            // Coloca os dados na sessão / Criar sessão do cliente
            // Optamos por estes três códigos na sessão
            $_SESSION['cliente'] = $resultado->id_cliente;
            $_SESSION['utilizador'] = $resultado->email;
            $_SESSION['nome_cliente'] = $resultado->nome_completo;
            // redirecionar para o inicio
            Store::redirect();
        }
    }
    public function logout()
    {
        // remove as varáveis da sessão e redericiona
        // para o inicio da aplicação
        unset($_SESSION['cliente']);
        unset($_SESSION['utilizador']);
        unset($_SESSION['nome_cliente']);
        // redireciona para o inicio da aplicação
        Store::redirect();
    }


    public function criar_cliente()
    {

        if (Store::clienteLogado()) {
            $this->index();
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            $this->index();
            return;
        }

        if ($_POST['text_senha_1'] !== $_POST['text_senha_2']) {
            // AS passwords são diferentes
            $_SESSION['erro'] = 'Senhas são Diferentes!!!!';
            $this->novo_cliente();
            return;
        }

        $cliente = new Clientes();
        if ($cliente->verificar_email_existe($_POST['text_email'])) {
            $_SESSION['erro'] = 'Já existe um Cliente com Esse EMAIL';
            $this->novo_cliente();
            return;
        }

        // INSERIDO NOVO CLIENTE NA BD E DEVOLVER O PURL
        $email_cliente = strtolower(trim($_POST['text_email']));
        $purl = $cliente->registar_cliente();
        //envio do email para o cliente
        $email = new EnviarEmail();
        $resultado = $email->enviar_email_confirmacao_novo_cliente($email_cliente, $purl);
        if ($resultado) {
            //apresenta o Layout Criar Novo Utilizador
            Store::Layout([
                'layouts/html_header',
                'layouts/header',
                'criar_cliente_sucesso',
                'layouts/footer',
                'layouts/html_footer',
            ]);
            return;
        } else {
            echo "Aconteceu um Erro";
        }
    }
    public function novo_cliente()
    {
        if (Store::clienteLogado()) {
            $this->index();
            return;
        }

        Store::Layout([
            'layouts/html_header',
            'layouts/header',
            'criar_cliente',
            'layouts/footer',
            'layouts/html_footer',
        ]);
    }
    public function index()
    {

        $dados = [
            'titulo' => APP_NAME . ' ' . APP_VERSION,
        ];

        Store::Layout([
            'layouts/html_header',
            'layouts/header',
            'inicio',
            'layouts/footer',
            'layouts/html_footer',
        ], $dados);

    }
    public function loja()
    {

        Store::Layout([
            'layouts/html_header',
            'layouts/header',
            'loja',
            'layouts/footer',
            'layouts/html_footer',
        ]);
    }

    public function carrinho()
    {

        Store::Layout([
            'layouts/html_header',
            'layouts/header',
            'carrinho',
            'layouts/footer',
            'layouts/html_footer',
        ]);
    }
}
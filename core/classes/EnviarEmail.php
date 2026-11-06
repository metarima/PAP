<?php

namespace core\classes;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//require 'vendor/autoload.php';


class EnviarEmail
{

    private function desencriptografar_senha($senha_criptografada)
    {
        $chave = EMAIL_KEY;
        $senha_criptografada = base64_decode($senha_criptografada);
        $iv = EMAIL_IV;
        $tag = substr($senha_criptografada, 16, 16);
        $senha_encriptada = substr($senha_criptografada, 32);
        $senha_decifrada = openssl_decrypt(
            $senha_encriptada,
            'aes-128-gcm',
            $chave,
            OPENSSL_RAW_DATA,
            $iv,
            $tag
        );
        if ($senha_decifrada === false) {
            return "Erro na decriptação da senha.";
        }
        return $senha_decifrada;
    }

    function criptografar_senha($senha)
    {
        // Definir chave e IV para a criptografia
        $chave = EMAIL_KEY;
        $iv = EMAIL_IV;

        // Gerar uma tag e criptografar a senha com AES-128-GCM
        $cipher = 'aes-128-gcm';
        $iv_len = openssl_cipher_iv_length($cipher);

        // Criptografando a senha
        $senha_criptografada = openssl_encrypt(
            $senha,
            $cipher,
            $chave,
            OPENSSL_RAW_DATA,
            $iv,
            $tag
        );

        // Retornar a senha criptografada em base64, junto com a tag
        // A senha criptografada será concatenada com a tag e o IV (para possibilitar a decriptação posteriormente)
        $senha_completa = base64_encode($iv . $tag . $senha_criptografada);

        return $senha_completa;
    }
    public function enviar_email_confirmacao_novo_cliente($email_cliente, $purl)
    {

        $mail = new PHPMailer(true);
        try {
            //Server settings
            $mail->SMTPDebug = 0; //Enable verbose 
            $mail->isSMTP(); //Send using SMTP
            $mail->Host = EMAIL_HOST;
            $mail->SMTPAuth = true; //Enable SMTP 
            $mail->Username = EMAIL_FROM;
            $senha = $this->desencriptografar_senha(EMAIL_PASS_ENC);
            $mail->Password = $senha;
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; //Enable implicit 
            $mail->Port = EMAIL_PORT;
            $mail->CharSet = 'UTF-8';
            //Recipients
            $mail->setFrom(EMAIL_FROM, APP_NAME);
            $mail->addAddress($email_cliente, 'Registo Conta'); //Add a recipient
            //Content
            $mail->isHTML(true); //Set email format to 
            $mail->Subject = APP_NAME . ' - Confirmação de Email.';
            // Corpo do texto do nosso email e Mensagem
            $link = BASE_URL . '?a=confirmar_email&purl=' . $purl;
            $html = '<p>Seja bem Vindo à Nossa Loja ' . APP_NAME . '.</p>';
            $html .= '<p>Para poder Entrar na Nossa Loja, Necessita sonfirmar o 
seu Email.</p>';
            $html .= '<p>Para confirmar o Email, click no Link abaixo:</p>';
            $html .= '<p><a href="' . $link . '">Confirmar Email</a><p>';
            $html .= '<p><i><small>' . APP_NAME . '</small></i></p>';
            $mail->Body = $html;

            $mail->send();
            return true;
        } catch (Exception $e) {
            return false;
        }
    }
}
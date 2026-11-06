<?php


namespace core\classes;

use Exception;
use PDO;
use PDOException;

class Database
{
    private $ligacao;

    private function ligar()
    {
        $this->ligacao = new PDO(
            'mysql:' .
            'host=' . MYSQL_SERVER . ';' .
            'dbname=' . MYSQL_DATABASE . ';' .
            'charset=' . MYSQL_CHARSET,
            MYSQL_USER,
            MYSQL_PASS,
            array(PDO::ATTR_PERSISTENT => true)
        );
        
    }
    private function desligar()
    {
        $this->ligacao = null;
    }


    public function select($sql, $parametros = null)
    {
        $sql = trim($sql);

        if (!preg_match("/^SELECT/i", $sql)){
            throw new Exception('Base de Ddados - Não é uma instrução SELECT!');
        }


        // Executa função de pesquisa de SQL
        // Primeiro faz a ligação à BD
        $this->ligar();
        // todos os select's vão ter resultados
        $resultados = null;
        try {
            // Comunicação com a BD
            if (!empty($parametros)) // Se tiver parâmetros, vai preparar a instru
            {
                // query é preparada aqui
                $executar = $this->ligacao->prepare($sql);
                // é executada com os parâmetros fornecidos
                $executar->execute($parametros);
    

                $resultados = $executar->fetchAll(PDO::FETCH_CLASS);
            } else 
            {
                $executar = $this->ligacao->prepare($sql);
                $executar->execute();
                $resultados = $executar->fetchAll(PDO::FETCH_CLASS);
            }
        } catch (PDOException $e) // Caso tenha erro, poderei ver através da variáv
        {
            // Caso exista erro
            return false;
        }
        $this->desligar();
        // devolver os resultados obtidos
        return $resultados;
    }

    public function insert($sql, $parametros = null)
    {
        $sql = trim($sql);

        if (!preg_match("/^INSERT/i", $sql)){
            throw new Exception('Base de Ddados - Não é uma instrução INSERT!');
        }


        // Executa função de pesquisa de SQL
        // Primeiro faz a ligação à BD
        $this->ligar();
        // todos os select's vão ter resultados
        try {
            // Comunicação com a BD
            if (!empty($parametros)) // Se tiver parâmetros, vai preparar a instru
            {
                // query é preparada aqui
                $executar = $this->ligacao->prepare($sql);
                // é executada com os parâmetros fornecidos
                $executar->execute($parametros);
    

            } else 
            {
                $executar = $this->ligacao->prepare($sql);
                $executar->execute();
            }
        } catch (PDOException $e) // Caso tenha erro, poderei ver através da variáv
        {
            // Caso exista erro
            return false;
        }
        $this->desligar();
        // devolver os resultados obtidos
    }

    public function update($sql, $parametros = null)
    {
        $sql = trim($sql);

        if (!preg_match("/^UPDATE/i", $sql)){
            throw new Exception('Base de Ddados - Não é uma instrução UPDATE!');
        }


        // Executa função de pesquisa de SQL
        // Primeiro faz a ligação à BD
        $this->ligar();
        // todos os select's vão ter resultados
        try {
            // Comunicação com a BD
            if (!empty($parametros)) // Se tiver parâmetros, vai preparar a instru
            {
                // query é preparada aqui
                $executar = $this->ligacao->prepare($sql);
                // é executada com os parâmetros fornecidos
                $executar->execute($parametros);
    

            } else 
            {
                $executar = $this->ligacao->prepare($sql);
                $executar->execute();
            }
        } catch (PDOException $e) // Caso tenha erro, poderei ver através da variáv
        {
            // Caso exista erro
            return false;
        }
        $this->desligar();
        // devolver os resultados obtidos
    }

    public function delete($sql, $parametros = null)
    {
        $sql = trim($sql);

        if (!preg_match("/^DELETE/i", $sql)){
            throw new Exception('Base de Ddados - Não é uma instrução DELETE!');
        }


        // Executa função de pesquisa de SQL
        // Primeiro faz a ligação à BD
        $this->ligar();
        // todos os select's vão ter resultados
        try {
            // Comunicação com a BD
            if (!empty($parametros)) // Se tiver parâmetros, vai preparar a instru
            {
                // query é preparada aqui
                $executar = $this->ligacao->prepare($sql);
                // é executada com os parâmetros fornecidos
                $executar->execute($parametros);
    

            } else 
            {
                $executar = $this->ligacao->prepare($sql);
                $executar->execute();
            }
        } catch (PDOException $e) // Caso tenha erro, poderei ver através da variáv
        {
            // Caso exista erro
            return false;
        }
        $this->desligar();
        // devolver os resultados obtidos
    }

    public function statement($sql, $parametros = null)
    {
        $sql = trim($sql);

        if (preg_match("/^(SELECT|INSERT|UPDATE|DELETE)/i", $sql)){
            throw new Exception('Base de Ddados - Instrução Inválida!');
        }


        // Executa função de pesquisa de SQL
        // Primeiro faz a ligação à BD
        $this->ligar();
        // todos os select's vão ter resultados
        try {
            // Comunicação com a BD
            if (!empty($parametros)) // Se tiver parâmetros, vai preparar a instru
            {
                // query é preparada aqui
                $executar = $this->ligacao->prepare($sql);
                // é executada com os parâmetros fornecidos
                $executar->execute($parametros);
    

            } else 
            {
                $executar = $this->ligacao->prepare($sql);
                $executar->execute();
            }
        } catch (PDOException $e) // Caso tenha erro, poderei ver através da variáv
        {
            // Caso exista erro
            return false;
        }
        $this->desligar();
        // devolver os resultados obtidos
    }
}
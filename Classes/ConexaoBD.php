<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ConexaoBD
 *
 * @author Daniel
 */
class ConexaoBD {

    private $servidor;
    private $usuario;
    private $senha;
    private $banco;
    private $conexao;
    private $qry;
    private $dados;
    private $totalDados;

    public function __construct() {
        $this->servidor = "localhost";
        $this->usuario = "root";
        $this->senha = "root";  
        $this->banco = "log";
        self::conectar();
    }

    public function conectar() {
        $mysqli = new mysqli($this->servidor, $this->usuario, $this->senha, $this->banco);
        if($mysqli->connect_error){
            die("Não foi possível conectar com o servidor de banco de dados" . $mysqli->connect_error);
        }
        
        $this->conexao = $mysqli;

//        $this->banco = @mysqli_select_db($this->banco) or
//                die("Não foi possível conectar com o Banco de dados" . mysqli_error());
    }

    public function executarSQL($sql) {
        $this->qry = $this->conexao->query($sql) 
                or die("Erro ao executar o comando SQL: $sql <br>" . $this->conexao->error);
        return $this->qry;
    }

    public function desconectar() {
        return $this->conexao->close();
    }

}

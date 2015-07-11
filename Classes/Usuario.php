<?php

include_once 'conexaoBD.php';

class Usuario {
    
    public $no_userid;
    public $nome;
    
    public function listarUsuarios () {
        $arrUsuarios = array();
        $i = 0;
        $sql = "SELECT * FROM usuarios order by nome";
        
        $conexao = new ConexaoBD();
        $rs = $conexao->executarSQL($sql);
        
        while ($row = $rs->fetch_assoc()) {
            $usr = new usuario();
            $usr->no_userid = $row['NO_USERID'];
            $usr->nome = $row['NOME'];
            $arrUsuarios[$i] = $usr;
            $i++;
        }
        
        $conexao->desconectar();
        return $arrUsuarios;
    }
}

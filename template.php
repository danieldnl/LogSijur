<?php
include_once 'classes/ConexaoBD.php';

$sql = "SELECT * FROM usuarios order by nome";    
$conexao = new ConexaoBD();
$rs = $conexao->executarSQL($sql);
var_dump($conexao, $rs);


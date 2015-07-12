
<?php include 'header.php'; ?>

<?php include 'ajudantes.php'; ?>

<?php

$dtInicio = '';
$dtFim = '';
$expediente = '';

if (!empty($_POST['dtInicio'])) {
    $dtInicio = date('Y-m-d H:i:s', strtotime(traduz_data_para_banco($_POST['dtInicio'])));
} elseif (isset($_GET['dtInicio'])) {
    $dtInicio = date('Y-m-d H:i:s', strtotime(traduz_data_para_banco($_GET['dtInicio'])));
}

//Somente executa a consulta se houver data de início digitada
$consulta = false;
if ($dtInicio != '') {
    if (!empty($_POST['dtFim'])) {
        $dtFim = implode('-', array_reverse(explode('/', $_POST['dtFim'])));
        $dtFim = date('Y-m-d 23:59:59', strtotime($dtFim));
    } else {
        $dtFim = date('Y-m-d 23:59:59', strtotime($dtInicio));
    }

    //Condições da cláusula WHERE
    $sqlWhere = '';
    if (!empty($_POST['expediente'])) {
        $sqlWhere = $sqlWhere . "L.CO_EXPEDIENTE = '" . $_POST['expediente'] . "' AND ";
        $expediente = $_POST['expediente'];
    }

    if (!empty($_POST['usuario'])) {
        $sqlWhere = $sqlWhere . "L.NO_USERID = '" . $_POST['usuario'] . "'";
    } else {
        $sqlWhere = $sqlWhere . "SUBSTRING(L.NO_USERID, 1, 1) IN ('C','E')";
    }

    $consulta = true;
}
?>

<?php include 'form.php'; ?>

<?php include 'tabela.php'; ?>

<?php include 'footer.php';

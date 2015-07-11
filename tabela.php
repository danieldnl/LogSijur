
<?php require_once 'Classes/Paginator.php'; ?>

<div class="col-md-12">
    <table class="table table-striped">
        <tr>
            <th>Matrícula</th>
            <th>Nome</th>
            <th>Data/Hora</th>
            <th>Expediente</th>
            <th>Módulo</th>
            <th>Ação</th>
            <th>Campo</th>
            <th>VR Anterior</th>
            <th>VR Atual</th>
        </tr>

        <?php
        if ($consulta) {
            $sql = "SELECT L.NO_USERID, S.NOME, S.NO_USERID, L.DT_ACESSO, L.MODULO, L.CO_EXPEDIENTE, 
                    L.ACAO, L.NO_CAMPO, L.VR_ANTERIOR, L. VR_ATUAL FROM Log L
                    INNER JOIN USUARIOS S on L.NO_USERID = S.NO_USERID 
                    WHERE L.DT_ACESSO >= '$dtInicio' AND 
                    L.DT_ACESSO <= '$dtFim' AND $sqlWhere ORDER BY L.NO_USERID, L.DT_ACESSO";

            $conn = new ConexaoBD();

            //Definições para paginação
            $limit = ( isset($_GET['limit']) ) ? $_GET['limit'] : 25;
            $page = ( isset($_GET['page']) ) ? $_GET['page'] : 1;
            $links = ( isset($_GET['links']) ) ? $_GET['links'] : 7;
            $Paginator = new Paginator($conn, $sql);
            $results = $Paginator->getData($page, $limit);

            for ($i = 0; $i < count($results->data); $i++) {
                echo "<tr>";
                echo "<td>" . $results->data[$i]['NO_USERID'] . "</td>";
                echo "<td>" . $results->data[$i]['NOME'] . "</td>";
                echo "<td>" . $results->data[$i]['DT_ACESSO'] . "</td>";
                echo "<td>" . $results->data[$i]['CO_EXPEDIENTE'] . "</td>";
                echo "<td>" . $results->data[$i]['MODULO'] . "</td>";
                echo "<td>" . $results->data[$i]['ACAO'] . "</td>";
                echo "<td>" . $results->data[$i]['NO_CAMPO'] . "</td>";
                echo "<td>" . $results->data[$i]['VR_ANTERIOR'] . "</td>";
                echo "<td>" . $results->data[$i]['VR_ATUAL'] . "</td>";
                echo "</tr>";
            }
            
            $campos = '';
            if (isset($_POST['dtInicio'])) {
                $campos = $campos . 'dtInicio=' .$_POST['dtInicio'] . '&';
            }

            if (isset($_POST['dtFim'])) {
                $campos = $campos . 'dtFim=' .$_POST['dtFim'] . '&';
            }
            
            if (isset($_POST['expediente'])) {
                $campos = $campos . 'expediente=' .$_POST['expediente'] . '&';
            }
            
            if (isset($_POST['usuario'])) {
                $campos = $campos . 'usuario=' .$_POST['usuario']. '&';
            }
            
            echo $Paginator->createLinks($links, 'pagination pagination-sm', $campos);

            //$rs = $conn->executarSQL($sql);
//            while ($row = $results->fetch_assoc()) {
//                echo "<tr>";
//                echo "<td>" . $row['NO_USERID'] . "</td>";
//                echo "<td>" . $row['NOME'] . "</td>";
//                echo "<td>" . $row['DT_ACESSO'] . "</td>";
//                echo "<td>" . $row['CO_EXPEDIENTE'] . "</td>";
//                echo "<td>" . $row['MODULO'] . "</td>";
//                echo "<td>" . $row['ACAO'] . "</td>";
//                echo "<td>" . $row['NO_CAMPO'] . "</td>";
//                echo "<td>" . $row['VR_ANTERIOR'] . "</td>";
//                echo "<td>" . $row['VR_ATUAL'] . "</td>";
//                echo "</tr>";
//            }
        }
        ?>
    </table>
</div>

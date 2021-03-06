<?php

if (!isset($_SESSION)) {
    session_start();
}
if (isset($_SESSION['banco'])) {
    if ($_SESSION['banco'] == 'primeiro') {
        include_once './banco/conexao_primeiro.php';
    } else {
        include_once './banco/conexao_segunda.php';
    }
}

$campo = filter_input(INPUT_POST, 'pesquisaVeiculo', FILTER_SANITIZE_STRING);
$query = $pdo->prepare("SELECT * FROM veiculo WHERE modelo LIKE "
        . "'%$campo%' OR marca LIKE '%$campo%' OR placa LIKE '%$campo%' OR chassi LIKE '%$campo%'"
        . " OR tipo LIKE '%$campo%' AND excluido=0 LIMIT 10");
$query->execute();
$count = $query->rowCount();
//$sql->bind_result($id, $produto, $valor);
if ($count >= 1) {
    echo '<div class="table-responsive">';
    echo "
 <table class='table table-bordered table-striped' style='text-align: center;'>
                    <thead>
                        <tr>
                            <th>MODELO</th>
                            <th>MARCA</th>
                            <th>PLACA</th>
                            <th>CHASSI</th>
                            <th>TIPO</th>
                            <th>VISUALIZAR DADOS</th>
                            <th>DELETAR</th>
                        </tr>
                    </thead>
                    <tbody>
        ";


    while ($dado = $query->fetch(PDO::FETCH_ASSOC)) {
        echo "<thead>
                        <tr>
                            <td>$dado[modelo]</th>
                            <td>$dado[marca]</th>
                            <td>$dado[placa]</th>
                            <td>$dado[chassi]</th>
                            <td>$dado[tipo]</th>
                            <td><center><a href='visualizar-veiculo?id=" . $dado["id"] . "' class='btn btn-primary'>Visualizar</a></center></th>
                            <td><a href='deletar-veiculo?id=" . $dado["id"] . "' class='btn btn-primary'>Deletar</a></th>
                            
                        </tr>
                    </thead>";
    }
    echo '</tbody>';
    echo '</table>';
    echo '</div>';
} else {
    echo '<div class="table-responsive">';
    echo "
 <table class='table table-bordered table-striped' style='text-align: center;'>
                    <thead>
                        <tr>
                            <th>MODELO</th>
                            <th>MARCA</th>
                            <th>PLACA</th>
                            <th>CHASSI</th>
                            <th>TIPO</th>
                            <th>VISUALIZAR DADOS</th>
                            <th>DELETAR</th>
                        </tr>
                    </thead>
                    <tbody>
        ";
    echo '</tbody>';
    echo '</table>';
    echo '</div>';
    echo '<center><h5>Veículo Não Encontrado</h5></center>';
}
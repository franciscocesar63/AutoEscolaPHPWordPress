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

function dateEmMysql($dateSql) {
    if (!empty($dateSql)) {
        $ano = substr($dateSql, 6);
        $mes = substr($dateSql, 3, -5);
        $dia = substr($dateSql, 0, -8);
        return $ano . "-" . $mes . "-" . $dia;
    }
    return "";
}

$campo = filter_input(INPUT_POST, 'pesquisaImprimirAula', FILTER_SANITIZE_STRING);
$campo1 = dateEmMysql($campo);

$query = $pdo->prepare("SELECT * FROM aula a INNER JOIN pratica p ON p.id=a.id WHERE a.data LIKE '%$campo1%' LIMIT 10");
$query->execute();
$count = $query->rowCount();


if ($count >= 1) {
    echo '<div class="table-responsive">';
    echo "
 <table class='table table-bordered table-striped' style='text-align: center;'>
                   <thead>
                        <tr>
                            <th title='Nome do Instrutor'>INSTRUTOR</th>
                            <th title='Nome do Aluno'>ALUNO</th>
                            <th title='Placa do veículo'>PLACA</th>
                            <th title='Tipo de aula'>TIPO</th>
                            <th title='Data da Aula'>DATA</th>
                            <th title='Início da aula'>INICIO</th>
                            <th title='Término da aula'>FIM</th>
                            <th title='Quantidade de aula cadastrada, 50 Minutos por aula. Máximo 3'>QUANTIDADE</th>
                            <th title='Visualizar dados da aula selecionada'>VISUALIZAR</th>
                            <th title='Deletar dados da aula selecionada'>DELETAR</th>
                        </tr>
                    </thead>
                    <tbody>
        ";


    while ($dado = $query->fetch(PDO::FETCH_ASSOC)) {
        $query_instrutor = $pdo->prepare("SELECT nome FROM pessoa WHERE id=$dado[id_instrutor] LIMIT 1");
        $query_instrutor->execute();
        $dado_instrutor = $query_instrutor->fetch(PDO::FETCH_ASSOC);

        $query_aluno = $pdo->prepare("SELECT nome FROM pessoa WHERE id=$dado[id_aluno] LIMIT 1");
        $query_aluno->execute();
        $dado_aluno = $query_aluno->fetch(PDO::FETCH_ASSOC);

        $query_veiculo = $pdo->prepare("SELECT placa FROM veiculo WHERE id=$dado[id_veiculo] LIMIT 1");
        $query_veiculo->execute();
        $dado_veiculo = $query_veiculo->fetch(PDO::FETCH_ASSOC);
        echo "<thead>
                         <tr>
                            <td>$dado_instrutor[nome]</th>
                            <td>$dado_aluno[nome]</th>
                            <td>$dado_veiculo[placa]</th>
                            <td>$dado[tipo]</th>
                            <td>";
        echo date("d/m/Y", strtotime($dado['data']));
        echo "</th>
                            <td>$dado[inicio]</th>
                            <td>$dado[fim]</th>";
        echo '<td><a href="visualizar-aula?id=' . $dado['id'] . '" class="btn btn-primary">Visualizar</a></td>';
        echo "</tr>
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
                            <th title='Nome do Instrutor'>INSTRUTOR</th>
                            <th title='Nome do Aluno'>ALUNO</th>
                            <th title='Placa do veículo'>PLACA</th>
                            <th title='Tipo de aula'>TIPO</th>
                            <th title='Data da Aula'>DATA</th>
                            <th title='Início da aula'>INICIO</th>
                            <th title='Término da aula'>FIM</th>
                            <th title='Quantidade de aula cadastrada, 50 Minutos por aula. Máximo 3'>QUANTIDADE</th>
                            <th title='Visualizar dados da aula selecionada'>VISUALIZAR</th>
                            <th title='Deletar dados da aula selecionada'>DELETAR</th>
                        </tr>
                    </thead>
                    <tbody>
        ";

    echo '</tbody>';
    echo '</table>';
    echo '</div>';
    echo '<center><h5>Aula não Encontrada!</h5></center>';
}
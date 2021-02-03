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

$campo = filter_input(INPUT_POST, 'pesquisaSecretaria', FILTER_SANITIZE_STRING);

$query = $pdo->prepare("SELECT * FROM pessoa p INNER JOIN funcionario f ON p.id=f.id WHERE p.nome LIKE "
        . "'%$campo%' AND f.cargo='secretaria' AND p.excluido=0 AND f.excluido=0 LIMIT 10");
$query->execute();

$count = $query->rowCount();
//$sql->bind_result($id, $produto, $valor);
if ($count >= 1) {
    echo '<div class="table-responsive">';
    echo "
 <table class='table table-bordered table-striped' style='text-align: center;'>
                    <thead>
                        <tr>
                            <th>NOME</th>
                            <th>CPF</th>
                            <th>RG</th>
                            <th>TELEFONE</th>
                            <th>SALÁRIO</th>
                            <th>VISUALIZAR DADOS</th>
                            <th>DELETAR</th>
                        </tr>
                    </thead>
                    <tbody>
        ";


    while ($dado = $query->fetch(PDO::FETCH_ASSOC)) {
        echo "<thead>
                        <tr>
                            <td>$dado[nome]</th>
                            <td>$dado[cpf]</th>
                            <td>$dado[rg]</th>
                            <td>$dado[telefone]</th>
                            <td>R$ $dado[salario]</th>
                            <td><a href='visualizar-aluno?id=" . $dado["id"] . "' class='btn btn-primary'>Visualizar</a></th>
                            <td>VEIO DAQUI</th>
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
                            <th>NOME</th>
                            <th>CPF</th>
                            <th>RG</th>
                            <th>TELEFONE</th>
                            <th>SALÁRIO</th>
                            <th>VISUALIZAR DADOS</th>
                            <th>DELETAR</th>
                        </tr>
                    </thead>
                    <tbody>
        ";

    echo '</tbody>';
    echo '</table>';
    echo '</div>';
    echo '<center><h5>Instrutor Não Encontrado</h5></center>';
}
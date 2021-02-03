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


$campo = filter_input(INPUT_POST, 'pesquisaInstrutorAula', FILTER_SANITIZE_STRING);


$query = $pdo->prepare("SELECT * FROM pessoa p INNER JOIN instrutor i ON p.id=i.id WHERE p.nome LIKE "
        . "'%$campo%' OR i.numero_cnh LIKE '%$campo%' AND p.excluido=0 AND i.excluido=0 LIMIT 3");
$query->execute();
$count = $query->rowCount();
//$sql->bind_result($id, $produto, $valor);
if ($count >= 1) {
    echo '<div class="table-responsive">';
    echo "
 <table class='table table-bordered table-striped' style='text-align: center;'>
                    <thead>
                        <tr>
                            <th>CNH</th>
                            <th>NOME</th>
                            <th>CPF</th>
                            <th>SELECIONE</th>
                        </tr>
                    </thead>
                    <tbody>
        ";


    while ($dado = $query->fetch(PDO::FETCH_ASSOC)) {
        echo "<thead>
                        <tr>
                            <td>$dado[numero_cnh]</th>
                            <td>$dado[nome]</th>
                            <td>$dado[cpf]</th>
                            <td><input type='radio' name='opcao_instrutor' value='$dado[id]'></td>
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
                            <th>CNH</th>
                            <th>NOME</th>
                            <th>CPF</th>
                            <th>SELECIONE</th>
                        </tr>
                    </thead>
                    <tbody>
        ";
    
    echo '</tbody>';
    echo '</table>';
    echo '</div>';
    echo '<center><h5>Instrutor Não Encontrado</h5></center>';
}
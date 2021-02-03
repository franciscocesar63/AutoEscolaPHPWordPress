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

$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_STRING);
$nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_STRING);
$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_STRING);
$telefone = filter_input(INPUT_POST, 'telefone', FILTER_SANITIZE_STRING);
$sexo_novo = filter_input(INPUT_POST, 'sexo', FILTER_SANITIZE_STRING);


$logradouro = filter_input(INPUT_POST, 'logradouro', FILTER_SANITIZE_STRING);
$numero = filter_input(INPUT_POST, 'numero', FILTER_SANITIZE_STRING);
$bairro = filter_input(INPUT_POST, 'bairro', FILTER_SANITIZE_STRING);
$complemento = filter_input(INPUT_POST, 'complemento', FILTER_SANITIZE_STRING);
$cep = filter_input(INPUT_POST, 'cep', FILTER_SANITIZE_STRING);
$cidade = filter_input(INPUT_POST, 'cidade', FILTER_SANITIZE_STRING);
try {
    $query_pessoa = $pdo->prepare("CALL stp_atualiza_pessoa('$id','$nome','$sexo','$email','$telefone')");
    $query_pessoa->execute();
    $query_endereco = $pdo->prepare("CALL stp_atuliza_endereco('$id','$logradouro','$numero',"
            . "'$bairro','$complemento','$cidade','$cep')");
    $query_endereco->execute();
} catch (Exception $exc) {
    echo '<script>alert("Houve um erro ao atualizar dados do aluno, tente novamente!");</script>';
}
?>
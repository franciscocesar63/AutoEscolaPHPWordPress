<?php

if (!isset($_SESSION)) {
    session_start();
}
if (isset($_SESSION['banco'])) {
    if ($_SESSION['banco'] == 'primeiro') {
        include_once './conexao_primeiro.php';
    } else {
        include_once './conexao_segunda.php';
    }
}

$nome = $_POST['nome'];
$cpf = $_POST['cpf'];
$rg = $_POST['rg'];
$email = $_POST['email'];
$telefone = $_POST['telefone'];
$sexo = $_POST['sexo'];

$logradouro = $_POST['logradouro'];
$numero = $_POST['numero'];
$bairro = $_POST['bairro'];
$complemento = $_POST['complemento'];
$cep = $_POST['cep'];
$cidade = $_POST['cidade'];
try {
    $cpf_cadastrado = $pdo->prepare("SELECT cpf FROM pessoa WHERE cpf=$cpf LIMIT 1");
    $cpf_cadastrado->execute();
    $count = $cpf_cadastrado->rowCount();

    if ($count == 1) {
        throw new Exception("CPF já cadastrado no sistema!", 1);
    } else {
        $query_endereco = $pdo->prepare("CALL stp_inserir_endereco('$logradouro','$numero','$bairro',"
                . "'$complemento','$cidade','$cep')");
        $query_endereco->execute();

        $query_pessoa = $pdo->prepare("CALL stp_inserir_pessoa('$nome','$sexo','$cpf','$rg','$email',"
                . "'$telefone')");
        $query_pessoa->execute();

        $query_aluno = $pdo->prepare("CALL stp_inserir_aluno('$cpf')");
        $query_aluno->execute();



        echo '<script>alert("Aluno Cadastrado com Sucesso");window.location.href="../painel-usuario.php"</script>';
    }
} catch (Exception $ex) {
    echo '<script>alert("Ocorreu um erro ao cadastrar o aluno, tente novamente.");window.location.href="../painel-usuario.php"</script>';
}
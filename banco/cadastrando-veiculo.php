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
$modelo = $_POST['modelo'];
$marca = $_POST['marca'];
$placa = $_POST['placa'];

$chassi = $_POST['chassi'];
$tipo_veiculo = $_POST['tipo_veiculo'];
try {
    $placa_cadastrada = $pdo->prepare("SELECT placa FROM veiculo WHERE placa=$placa LIMIT 1");
    $placa_cadastrada->execute();
    $count = $placa_cadastrada->rowCount();
    var_dump($count);
    if ($count >= 1) {
        throw new Exception("Veículo já cadastrado no sistema!", 1);
    } else {
        $query_veiculo = $pdo->prepare("CALL stp_inserir_veiculo('$modelo', '$marca',"
                . "'$placa','$chassi','$tipo_veiculo')");
        $query_veiculo->execute();

        echo '<script>alert("Veículo Cadastrado com Sucesso");window.location.href="../painel-usuario.php"</script>';
    }
} catch (Exception $ex) {
    echo '<script>alert("Ocorreu um erro ao cadastrar o veículo, tente novamente.");window.location.href="../painel-usuario.php"</script>';
}
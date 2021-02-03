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


$opcao_instrutor = filter_input(INPUT_POST, 'opcaoInstrutor', FILTER_SANITIZE_STRING);
$opcao_aluno = filter_input(INPUT_POST, 'opcaoAluno', FILTER_SANITIZE_STRING);
$opcao_veiculo = filter_input(INPUT_POST, 'opcaoVeiculo', FILTER_SANITIZE_STRING);

$data_aula = filter_input(INPUT_POST, 'data_aula', FILTER_SANITIZE_STRING);
$inicio_aula = filter_input(INPUT_POST, 'hora_aula', FILTER_SANITIZE_STRING);
$quantidade_aulas = filter_input(INPUT_POST, 'quantidade_aula', FILTER_SANITIZE_STRING);
$fim = hora_inicio_fim($inicio_aula, $quantidade_aulas);
$inicio_array = explode(" ", $inicio_aula);
$inicio = $inicio_array[0] . $inicio_array[1] . $inicio_array[2];

//echo 'inicio' . $inicio;

$data = explode('/', $data_aula);
$mes = $data[0];
$dia = $data[1];
$ano = $data[2];
$data_final = $ano . '-' . $dia . '-' . $mes;

$query_verificar_aula = $pdo->prepare("SELECT * FROM aula WHERE tipo='pratica'");
$query_verificar_aula->execute();






try {
    while ($dados = $query_verificar_aula->fetch(PDO::FETCH_ASSOC)) {
        var_dump($dados);
        echo 'datafinal: ' . $data_final . '<br>';
        echo 'dadosinicio: ' . $inicio;
        if ($dados['data'] == $data_final && $dados['inicio'] == $inicio . ':00') {
            echo 'entrou aqui';
            throw new Exception("Aula existente no mesmo horário e data.", 1);
        } elseif ($dados['data'] == $data_final && $dados['fim'] == $fim . ':00') {
            throw new Exception("Aula existente no mesmo horário e data.", 1);
        }
    }

    $query_aula_pratica = $pdo->prepare("CALL stp_inserir_pratica('$data_final','$inicio','$fim','$quantidade_aulas'"
            . ",'$opcao_instrutor','$opcao_aluno','$opcao_veiculo')");
    $query_aula_pratica->execute();
    echo '<script>alert("Cadastrado com sucesso!");window.location.href="../painel-usuario.php"</script>';
} catch (Exception $ex) {
    $error = $ex->getMessage();
    echo"<script>alert('$error');window.location.href='../painel-usuario.php'</script>";
    echo '<br>' . $error;
}

function hora_inicio_fim($inicio, $quantidade) {


    $conversao_hora = explode(":", $inicio);
    $hora = $conversao_hora[0] * 3600;
    $minuto = $conversao_hora[1] * 60; //segundo dos minutos

    $segundo = $hora;
    $segundo += $minuto;


    if ($quantidade == '1') {
        $segundos = 3000; //50 minutos
        $segundo += $segundos;
        $restodivisao = $segundo % 3600;
        $minutos = $restodivisao / 60;
        $horas = ($segundo - $restodivisao) / 3600;
        $resultado = $horas . ':' . $minutos;
//        echo 'INICIO: ' . $inicio . '<br>';
//        echo 'FIM: ' . $resultado;
    } elseif ($quantidade == '2') {
        $segundos = 6000; //100 minutos
        $segundo += $segundos;
        $restodivisao = $segundo % 3600;
        $minutos = $restodivisao / 60;
        $horas = ($segundo - $restodivisao) / 3600;
        $resultado = $horas . ':' . $minutos;
//        echo 'INICIO: ' . $inicio . '<br>';
//        echo 'FIM: ' . $resultado;
    } elseif ($quantidade == '3') {
        $segundos = 9000; //150 minutos
        $segundo += $segundos;
        $restodivisao = $segundo % 3600;
        $minutos = $restodivisao / 60;
        $horas = ($segundo - $restodivisao) / 3600;
        $resultado = $horas . ':' . $minutos;
//        echo 'INICIO: ' . $inicio . '<br>';
//        echo 'FIM: ' . $resultado;
    } elseif ($quantidade == '0') {
        $segundos = 0; //50 minutos
        $segundo += $segundos;
        $restodivisao = $segundo % 3600;
        $minutos = $restodivisao / 60;
        $horas = ($segundo - $restodivisao) / 3600;
        $resultado = $horas . ':' . $minutos;
    }

    return $resultado;

//    if ($minuto % 60 == 60) {//não vai ser decimal
//        $resultado = $hora / 60;
//        $resultado .= ':00';
//    } else {
//        $resultado = $hora / 60;
//        $resto = $minuto / 60;
//        $resultado .= ':' . $resto;
//    }
}

?>
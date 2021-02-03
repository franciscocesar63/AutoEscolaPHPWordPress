<!doctype html>
<html lang="pt"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title></title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="apple-touch-icon" href="apple-touch-icon.png">
        <!--JQuery JS-->
        <!--<script src="http://code.jquery.com/jquery-1.8.2.js"></script>-->
        <script src="jquery/jquery-3.3.1.min.js"></script>
        <!--<script src="http://code.jquery.com/ui/1.9.0/jquery-ui.js"></script>-->
        <script  src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"  ></script>
        <script src="js/jquery.js" charset="utf-8"></script>
        <!--DatePicker-->
        <script src="datepicker/datepicker.js"></script>
        <script src="datepicker/datepicker.pt-BR.min.js"></script>
        <script src="datepicker/wickedpicker.js"></script>
        <script src="datepicker/wickedpicker.min.js"></script>
        <script src="datepicker/wickedpickerSpec.js"></script>
        <!--Bootstrap-->
        <link rel="stylesheet" href="css/bootstrap.min.css">        
        <!--DatePicker-->
        <link rel="stylesheet" href="datepicker/datepicker.css">
        <link rel="stylesheet" href="datepicker/wickedpicker.css">
        <link rel="stylesheet" href="datepicker/wickedpicker.min.css">
        <!--JQuery CSS-->
        <link rel="stylesheet" href="http://code.jquery.com/ui/1.9.0/themes/base/jquery-ui.css" />
        <!--FAVICON-->
        <link rel="shortcut icon" href="favicon.ico" type="image/x-icon"/>

        <!--<link rel="stylesheet" href="css/bootstrap-theme.min.css">-->
        <link rel="stylesheet" href="css/styles.css">
        <script src="js/vendor/modernizr-2.8.3-respond-1.4.2.min.js"></script>
    </head>
    <body>

        <img src="img/autoescola_slide_4.jpg"  width="100%" height="50%" style=" border: 10px 
             solid; border-radius: 20px;" >
             <?php
             include './navbar.php';
//        $x = active(0);
//        include './carousel.php';
             ?>
        <div class="container" style="margin-top: 20px;border: 5px solid; border-radius: 25px;">
            <!--<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>-->
            <center><h2>Dados da Aula</h2></center>
            <?php
            if (isset($_SESSION['banco'])) {
                if ($_SESSION['banco'] == 'primeiro') {
                    include_once 'banco/conexao_primeiro.php';
                } else {
                    include_once 'banco/conexao_segunda.php';
                }
            }
//                $pdo = connectar();


            $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_STRING);

            $query = $pdo->prepare("SELECT * FROM aula a INNER JOIN pratica p ON p.id=a.id WHERE p.id=$id LIMIT 1");
            $query->execute();
            $dado = $query->fetch(PDO::FETCH_ASSOC);

            $query_instrutor = $pdo->prepare("SELECT nome FROM pessoa WHERE id=$dado[id_instrutor]");
            $query_instrutor->execute();
            $dado_instrutor = $query_instrutor->fetch(PDO::FETCH_ASSOC);

            $query_aluno = $pdo->prepare("SELECT nome FROM pessoa WHERE id=$dado[id_aluno] LIMIT 1");
            $query_aluno->execute();
            $dado_aluno = $query_aluno->fetch(PDO::FETCH_ASSOC);

            $query_veiculo = $pdo->prepare("SELECT placa FROM veiculo WHERE id=$dado[id_veiculo] LIMIT 1");
            $query_veiculo->execute();
            $dado_veiculo = $query_veiculo->fetch(PDO::FETCH_ASSOC);
            ?>
            <form action="" method="POST" style="margin-bottom: 20px;">

                <div class="row">

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="data" class="control-label">Data:</label>
                            <input disabled="disabled" value="<?php echo $dado['data']; ?>" type="text" class="form-control" id="data" name="data"maxlength="30" required="">
                        </div>
                        <div class="form-group">
                            <label for="inicio" class="control-label">Início:</label>
                            <input disabled="disabled" value="<?php echo $dado['inicio']; ?>" type="text" name="inicio" onkeydown="javascript:fMasc(this, cpf);" class="form-control" id="inicio" maxlength="11" required="">
                        </div>
                        <div class="form-group">
                            <label for="fim" class="control-label">Fim:</label>
                            <input disabled="disabled" value="<?php echo $dado['fim']; ?>" type="text" class="form-control" id="fim" name="fim" maxlength="11" required="">
                        </div>

                        <div class="form-group">
                            <label for="tipo" class="control-label">Tipo:</label>
                            <input disabled="disabled" value="<?php echo $dado['tipo']; ?>" type="text" class="form-control" id="tipo" name="tipo" maxlength="18" required="">
                        </div>


                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="instrutor" class="control-label">Instrutor:</label>
                            <input disabled="disabled" value="<?php echo $dado_instrutor['nome']; ?>" type="text" class="form-control" id="instrutor" name="instrutor" maxlength="30" required="">
                        </div>
                        <div class="form-group">
                            <label for="nome_aluno" class="control-label">Aluno:</label>
                            <input disabled="disabled" value="<?php echo $dado_aluno['nome']; ?>" type="text" class="form-control" id="nome_aluno" name="nome_aluno" maxlength="30" required="">
                        </div>
                        <div class="form-group">
                            <label for="placa" class="control-label">Veículo:</label>
                            <input disabled="disabled"  value="<?php echo $dado_veiculo['placa']; ?>" type="text" class="form-control" id="placa" name="placa" maxlength="10">
                        </div>

                    </div>

                </div>
                <!--<a type="submit" class="btn btn-primary">Salvar</a>-->
                <input type="submit" value="Salvar" class="btn btn-primary">
                <a href="pesquisar-aluno.php" type="button" class="btn btn-default">Voltar</a>
            </form>

        </div>
        <?php
//            $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_STRING);
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

        if (isset($nome)) {

            try {
                $query_pessoa = $pdo->prepare("CALL stp_atualiza_pessoa('$id','$nome','$sexo','$email','$telefone')");
                $query_pessoa->execute();
                $query_endereco = $pdo->prepare("CALL stp_atuliza_endereco('$id','$logradouro','$numero',"
                        . "'$bairro','$complemento','$cidade','$cep')");
                $query_endereco->execute();

                echo '<script>alert("Aluno atualizado com Sucesso!");window.location.href="visualizar-aluno.php"</script>';
            } catch (Exception $exc) {
                echo '<script>alert("Houve um erro ao atualizar dados do aluno, tente novamente!");</script>';
            }
        }
        ?>


        <footer>
            <center><strong><p>&copy; Francisco César 2018</p></strong></center>
        </footer>
        <!-- scripts padrões para funcionamento do site -->
        <script src="js/javascript.js"></script>

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js" type="text/javascript"></script>
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
        <script src="js/jquery-1.11.3.min.js"></script>
        <script>window.jQuery || document.write('<script src="js/vendor/jquery-1.11.2.min.js"><\/script>');</script>

        <script src="js/bootstrap.min.js"></script>

    </body>
</html>

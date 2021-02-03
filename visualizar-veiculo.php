<!doctype html>
<html lang="pt"> <!--<![endif]-->
    <head>
        <script lang="JavaScript" src="js/javascript.js"></script>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title></title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="apple-touch-icon" href="apple-touch-icon.png">

        <link rel="stylesheet" href="css/bootstrap.min.css">
        <link rel="shortcut icon" href="favicon.ico" type="image/x-icon"/>

        <link rel="stylesheet" href="css/bootstrap-theme.min.css">
        <link rel="stylesheet" href="css/main.css">
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
        <div class="container">
            <!--<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>-->
            <center><h2>Dados do Aluno</h2></center>
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

            $query = $pdo->prepare("SELECT * FROM pessoa p INNER JOIN aluno a ON p.id=a.id INNER JOIN endereco e ON a.id=e.id"
                    . " WHERE p.id='$id' AND p.excluido=0 AND a.excluido=0 LIMIT 10");
            $query->execute();

            $dado = $query->fetch(PDO::FETCH_ASSOC);
            ?>
            <form action="" method="POST">

                <div class="row">

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="nome" class="control-label">Nome:</label>
                            <input value="<?php echo $dado['nome']; ?>" type="text" class="form-control" id="nome" name="nome"maxlength="30" required="">
                        </div>
                        <div class="form-group">
                            <label for="cpf" class="control-label">CPF:</label>
                            <input disabled="disabled" value="<?php echo $dado['cpf']; ?>" type="text" name="cpf" onkeydown="javascript:fMasc(this, cpf);" class="form-control" id="cpf" maxlength="11" required="">
                        </div>
                        <div class="form-group">
                            <label for="rg" class="control-label">RG:</label>
                            <input disabled="disabled" value="<?php echo $dado['rg']; ?>" type="text" class="form-control" id="rg" name="rg" maxlength="11" required="">
                        </div>
                        <div class="form-group">
                            <label for="email" class="control-label">E-Mail:</label>
                            <input value="<?php echo $dado['email']; ?>" type="email" class="form-control" id="email" name="email" maxlength="30" required="">
                        </div>
                        <div class="form-group">
                            <label for="telefone" class="control-label">Telefone:</label>
                            <input value="<?php echo $dado['telefone']; ?>" type="text" class="form-control" id="telefone" name="telefone" maxlength="18" required="">
                        </div>
                        <div class="form-group">
                            <label for="sexo" class="control-label">Sexo:</label>
                            <select class="form-control form-control-sm" id="sexo" name="sexo" required>
                                <?php
                                $sexo = $dado['sexo'];
                                $femenino = '';
                                $masculino = '';
                                if ($sexo == 'masculino') {
                                    $masculino = 'selected';
                                } else {
                                    $femenino = 'selected';
                                }
                                ?>

                                <option value="">Selecione</option>
                                <option value="masculino" <?php echo $masculino; ?> >Masculino</option>
                                <option value="feminino" <?php echo $femenino; ?> >Feminino</option> </select>
                        </div>
                        <div class="form-group">


                        </div>


                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="logradouro" class="control-label">Rua:</label>
                            <input value="<?php echo $dado['logradouro']; ?>" type="text" class="form-control" id="logradouro" name="logradouro" maxlength="30" required="">
                        </div>
                        <div class="form-group">
                            <label for="numero" class="control-label">Número:</label>
                            <input value="<?php echo $dado['numero']; ?>" type="text" class="form-control" id="numero" name="numero" maxlength="10" placeholder="S/Nº">
                        </div>
                        <div class="form-group">
                            <label for="bairro" class="control-label">Bairro:</label>
                            <input value="<?php echo $dado['bairro']; ?>" type="text" class="form-control" name="bairro" id="bairro" maxlength="30 required="" >
                        </div>
                        <div class="form-group">
                            <label for="complemento" class="control-label">Complemento:</label>
                            <input value="<?php echo $dado['complemento']; ?>" type="text" class="form-control" id="complemento" name="complemento" maxlength="30" placeholder="Opcional">
                        </div>
                        <div class="form-group">
                            <label for="cidade" class="control-label">Cidade:</label>
                            <input value="<?php echo $dado['cidade']; ?>" type="text" class="form-control" id="cidade" name="cidade" maxlength="30" required="">
                        </div>
                        <div class="form-group">
                            <label for="cep" class="control-label">CEP:</label>
                            <input value="<?php echo $dado['cep']; ?>" type="text" onblur="pesquisacep(this.value);" class="form-control" id="cep" name="cep" maxlength="30" required="">
                        </div>

                    </div>

                </div>
                <!--<a type="submit" class="btn btn-primary">Salvar</a>-->
                <input type="submit" value="Salvar" class="btn btn-primary">
                <a href="pesquisar-aluno.php" type="button" class="btn btn-default">Voltar</a>
            </form>


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
        </div> <!-- /container -->        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
        <script>window.jQuery || document.write('<script src="js/vendor/jquery-1.11.2.min.js"><\/script>')</script>

        <script src="js/bootstrap.min.js"></script>
        <script src="js/main.js"></script>

        <!-- Google Analytics: change UA-XXXXX-X to be your site's ID. -->
        <script>
                                (function (b, o, i, l, e, r) {
                                    b.GoogleAnalyticsObject = l;
                                    b[l] || (b[l] =
                                            function () {
                                                (b[l].q = b[l].q || []).push(arguments)
                                            });
                                    b[l].l = +new Date;
                                    e = o.createElement(i);
                                    r = o.getElementsByTagName(i)[0];
                                    e.src = '//www.google-analytics.com/analytics.js';
                                    r.parentNode.insertBefore(e, r)
                                }(window, document, 'script', 'ga'));
                                ga('create', 'UA-XXXXX-X', 'auto');
                                ga('send', 'pageview');
        </script>
    </body>
</html>

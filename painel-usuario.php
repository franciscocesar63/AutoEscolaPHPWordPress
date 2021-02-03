<!doctype html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang=""> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang=""> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" lang=""> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="pt"> <!--<![endif]-->

    <head>
        <script src="js/javascript.js"></script>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title></title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="apple-touch-icon" href="apple-touch-icon.png">

        <link rel="stylesheet" href="css/bootstrap.min.css">
        <link rel="shortcut icon" href="favicon.ico" type="image/x-icon"/>
        <style>
<?php include './css/styles.css'; ?>
        </style>
        <!--<link rel="stylesheet" href="css/bootstrap-theme.min.css">-->
        <!--<link rel="stylesheet" href="css/main.css">-->
        <script src="js/vendor/modernizr-2.8.3-respond-1.4.2.min.js"></script>
    </head>
    <body>
        <div class="container">
            <?php
            include './navbar.php';
            ?>  
        </div>
        <img src="img/autoescola_slide_4.jpg" width="100%" height="50%" style=" border: 10px 
             solid; border-radius: 20px;" >
        <div class="container">
            <!--<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>-->
            <div style="margin-top: 20px;text-align: center; border-width: 5px; border-color: #000;border-style: solid; border-radius: 40px;">

                <?php
                if (!isset($_SESSION)) {
                    session_start();
                }
//            print_r($_SESSION);  esse aqui mostra os detalhes da variavel, nesse caso da session, parecido com var_dump
                if (isset($_SESSION['cargo'])) {
                    if ($_SESSION['cargo'] == 'gerente') {
                        echo '<center><h1>Painel do Gerente</h1></center>';
                    } else {
                        echo '<center><h1>Painel da Secretária</h1></center>';
                    }
                } else {
                    echo '<script>alert("Usuário não autenticado no sistema.");window.location.href="login.php"</script>';
                }
                ?>            
                <h4>Cadastros de Sistema</h4>
                <!-- Modal Cadastrar Aluno -->
                <button type="button" id="modalButton" class="btn btn-primary botaoPainel" data-toggle="modal" data-target="#myModal" data-whatever="@mdo">Cadastrar Aluno</button>

                <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" id="myModalLabel">Cadastrar Aluno</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <form action="banco/cadastrando-aluno.php" method="POST">
                                            <div class="form-group">
                                                <label for="nome" class="control-label">Nome:</label>
                                                <input type="text" class="form-control" id="nome" name="nome"maxlength="30" required="">
                                            </div>
                                            <div class="form-group">
                                                <label for="cpf" class="control-label">CPF:</label>
                                                <input type="text" onkeyup="maskCPF(this.value);" name="cpf" class="form-control" id="cpf" maxlength="11" onBlur="validaCPF(this.value);" >
                                            </div>
                                            <div class="form-group">
                                                <label for="rg" class="control-label">RG:</label>
                                                <input type="text" class="form-control" id="rg" name="rg" maxlength="11" required="">
                                            </div>
                                            <div class="form-group">
                                                <label for="email" class="control-label">E-Mail:</label>
                                                <input type="email" class="form-control" id="email" name="email" maxlength="30" required="">
                                            </div>
                                            <div class="form-group">
                                                <label for="telefone" class="control-label">Telefone:</label>
                                                <input type="text" class="form-control" id="telefone" name="telefone" maxlength="18" required="">
                                            </div>
                                            <div class="form-group">
                                                <label for="sexo" class="control-label">Sexo:</label>
                                                <select id="sexo" name="sexo" required>

                                                    <option value="">Selecione</option>
                                                    <option value="masculino">Masculino</option>
                                                    <option value="feminino">Feminino</option> </select>
                                            </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="logradouro" class="control-label">Rua:</label>
                                            <input type="text" class="form-control" id="logradouro" name="logradouro" maxlength="30" required="">
                                        </div>
                                        <div class="form-group">
                                            <label for="numero" class="control-label">Número:</label>
                                            <input type="text" class="form-control" id="numero" name="numero" maxlength="10" placeholder="S/Nº">
                                        </div>
                                        <div class="form-group">
                                            <label for="bairro" class="control-label">Bairro:</label>
                                            <input type="text" class="form-control" name="bairro" id="bairro" maxlength="30 required="" >
                                        </div>
                                        <div class="form-group">
                                            <label for="complemento" class="control-label">Complemento:</label>
                                            <input type="text" class="form-control" id="complemento" name="complemento" maxlength="30" placeholder="Opcional">
                                        </div>
                                        <div class="form-group">
                                            <label for="cidade" class="control-label">Cidade:</label>
                                            <input type="text" class="form-control" id="cidade" name="cidade" maxlength="30" required="">
                                        </div>
                                        <div class="form-group">
                                            <label for="cep" class="control-label">CEP:</label>
                                            <input type="text" onblur="pesquisacep(this.value);" class="form-control" id="cep" name="cep" maxlength="30" required="">
                                        </div>
                                        <button type="submit" class="btn btn-primary">Salvar</button>
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                        </form>

                                    </div>

                                </div>
                            </div>
                            <div class="modal-footer">
                            </div>
                        </div>
                    </div>
                </div>

                <!--Modal Cadastrar Instrutor-->

                <?php
                if (isset($_SESSION['cargo'])) {

                    if ($_SESSION['cargo'] == 'gerente') {
                        ?>
                        <button type="button" class="btn btn-primary botaoPainel" data-toggle="modal" data-target="#myModal3" data-whatever="@mdo">Cadastrar Instrutor</button>
                        <div class="modal fade" id="myModal3" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title" id="myModalLabel">Cadastrar Instrutor</h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-md-6">

                                                <form action="banco/cadastrando-instrutor.php" method="POST">
                                                    <div class="form-group">
                                                        <label for="nome" class="control-label">Nome:</label>
                                                        <input type="text" class="form-control" id="nome" name="nome"maxlength="30" required="">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="cpf" class="control-label">CPF:</label>
                                                        <input type="text" name="cpf" onkeydown="javascript:fMasc(this, cpf);" class="form-control" id="cpf" maxlength="11" required="">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="rg" class="control-label">RG:</label>
                                                        <input type="text" class="form-control" id="rg" name="rg" maxlength="11" required="">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="email" class="control-label">E-Mail:</label>
                                                        <input type="email" class="form-control" id="email" name="email" maxlength="30" required="">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="telefone" class="control-label">Telefone:</label>
                                                        <input type="text" class="form-control" id="telefone" name="telefone" maxlength="18" required="">
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="salario" class="control-label">Salário:</label>
                                                        <input type="text" class="form-control" id="salario" name="salario" maxlength="30" required="">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="sexo" class="control-label">Sexo:</label>
                                                        <select name="sexo"><option value="masculino">Masculino</option><option value="feminino">Feminino</option> </select>
                                                    </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="logradouro" class="control-label">Rua:</label>
                                                    <input type="text" class="form-control" id="logradouro" name="logradouro" maxlength="30" required="">
                                                </div>
                                                <div class="form-group">
                                                    <label for="numero" class="control-label">Número:</label>
                                                    <input type="text" class="form-control" id="numero" name="numero" maxlength="10" placeholder="S/Nº">
                                                </div>
                                                <div class="form-group">
                                                    <label for="bairro" class="control-label">Bairro:</label>
                                                    <input type="text" class="form-control" name="bairro" id="bairro" maxlength="30 required="" >
                                                </div>
                                                <div class="form-group">
                                                    <label for="complemento" class="control-label">Complemento:</label>
                                                    <input type="text" class="form-control" id="complemento" name="complemento" maxlength="30" placeholder="Opcional">
                                                </div>
                                                <div class="form-group">
                                                    <label for="cidade" class="control-label">Cidade:</label>
                                                    <input type="text" class="form-control" id="cidade" name="cidade" maxlength="30" required="">
                                                </div>
                                                <div class="form-group">
                                                    <label for="cep" class="control-label">CEP:</label>
                                                    <input type="text" onblur="pesquisacep(this.value);" class="form-control" id="cep" name="cep" maxlength="30" required="">
                                                </div>
                                                <div class="form-group">
                                                    <label for="numero_cnh" class="control-label">CNH:</label>
                                                    <input type="text" class="form-control" id="numero_cnh" name="numero_cnh" maxlength="30" required="">
                                                </div>

                                                <button type="submit" class="btn btn-primary">Salvar</button>
                                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                }
                ?>

                <!--Modal Cadastrar Secretária-->
                <?php
                if (isset($_SESSION['cargo'])) {
                    if ($_SESSION['cargo'] == 'gerente') {
                        echo ' <button type="button" class="btn btn-primary botaoPainel" data-toggle="modal" data-target="#myModal4" data-whatever="@mdo">Cadastrar Secretária</button>
            <div class="modal fade" id="myModal4" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="myModalLabel">Cadastrar Secretária</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-6">

                                    <form action="banco/cadastrando-secretaria.php" method="POST">
                                        <div class="form-group">
                                            <label for="nome" class="control-label">Nome:</label>
                                            <input type="text" class="form-control" id="nome" name="nome"maxlength="30" required="">
                                        </div>
                                        <div class="form-group">
                                            <label for="cpf" class="control-label">CPF:</label>
                                            <input type="text" name="cpf" onkeydown="javascript:fMasc(this, cpf);" class="form-control" id="cpf" maxlength="11" required="">
                                        </div>
                                        <div class="form-group">
                                            <label for="rg" class="control-label">RG:</label>
                                            <input type="text" class="form-control" id="rg" name="rg" maxlength="11" required="">
                                        </div>
                                        <div class="form-group">
                                            <label for="email" class="control-label">E-Mail:</label>
                                            <input type="email" class="form-control" id="email" name="email" maxlength="30" required="">
                                        </div>
                                        <div class="form-group">
                                            <label for="telefone" class="control-label">Telefone:</label>
                                            <input type="text" class="form-control" id="telefone" name="telefone" maxlength="18" required="">
                                        </div>
                                        <div class="form-group">
                                            <label for="login" class="control-label">Login:</label>
                                            <input type="text"  class="form-control" id="login" name="login" maxlength="30" required="">
                                        </div>
                                        <div class="form-group">
                                            <label for="senha" class="control-label">Senha:</label>
                                            <input type="text" class="form-control" id="senha" name="senha" maxlength="30" required="">
                                        </div>

                                        <div class="form-group">
                                            <label for="sexo" class="control-label">Sexo:</label>
                                            <select name="sexo"><option value="masculino">Masculino</option><option value="feminino">Feminino</option> </select>
                                        </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="logradouro" class="control-label">Rua:</label>
                                        <input type="text" class="form-control" id="logradouro" name="logradouro" maxlength="30" required="">
                                    </div>
                                    <div class="form-group">
                                        <label for="numero" class="control-label">Número:</label>
                                        <input type="text" class="form-control" id="numero" name="numero" maxlength="10" placeholder="S/Nº">
                                    </div>
                                    <div class="form-group">
                                        <label for="bairro" class="control-label">Bairro:</label>
                                        <input type="text" class="form-control" name="bairro" id="bairro" maxlength="30 required="" >
                                    </div>
                                    <div class="form-group">
                                        <label for="complemento" class="control-label">Complemento:</label>
                                        <input type="text" class="form-control" id="complemento" name="complemento" maxlength="30" placeholder="Opcional">
                                    </div>
                                    <div class="form-group">
                                        <label for="cidade" class="control-label">Cidade:</label>
                                        <input type="text" class="form-control" id="cidade" name="cidade" maxlength="30" required="">
                                    </div>
                                    <div class="form-group">
                                        <label for="cep" class="control-label">CEP:</label>
                                        <input type="text" onblur="pesquisacep(this.value);" class="form-control" id="cep" name="cep" maxlength="30" required="">
                                    </div>
                                    <div class="form-group">
                                        <label for="salario" class="control-label">Salário:</label>
                                        <input type="text" class="form-control" id="salario" name="salario" maxlength="30" required="">
                                    </div>

                                    <button type="submit" class="btn btn-primary">Salvar</button>
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                        </div>
                    </div>
                </div>
            </div>';
                    }
                }
                ?>

                <!--Modal Cadastrar Veículo-->
                <button type="button" class="btn btn-primary botaoPainel" data-toggle="modal" data-target="#myModal2" data-whatever="@mdo">Cadastrar Veículo</button>
                <div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" id="myModalLabel">Cadastrar Veículo</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-6">

                                        <form action="banco/cadastrando-veiculo.php" method="POST">
                                            <div class="form-group">
                                                <label for="modelo" class="control-label">Modelo:</label>
                                                <input type="text" class="form-control" id="modelo" name="modelo" maxlength="30" required="">
                                            </div>
                                            <div class="form-group">
                                                <label for="marca" class="control-label">Marca:</label>
                                                <input type="text" class="form-control" id="marca" name="marca" maxlength="30" required="">
                                            </div>
                                            <div class="form-group">
                                                <label for="sexo" class="control-label">Tipo de Veículo:</label>
                                                <select name="tipo_veiculo">
                                                    <option value="carro">Carro</option>
                                                    <option value="moto">Moto</option> 
                                                    <option value="onibus">Ônibus</option>
                                                    <option value="caminhao">Caminhão</option> 
                                                </select>
                                            </div>
                                    </div>
                                    <div class="col-md-6">

                                        <div class="form-group">
                                            <label for="placa" class="control-label">Placa:</label>
                                            <input type="text" class="form-control" id="placa" name="placa" maxlength="7" required="">
                                        </div><div class="form-group">
                                            <label for="chassi" class="control-label">Chassi:</label>
                                            <input type="text" class="form-control" id="chassi" name="chassi" maxlength="30" placeholder="Opcional">
                                        </div>


                                        <button type="submit" class="btn btn-primary">Salvar</button>
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                            </div>
                        </div>
                    </div>
                </div>


                <br><br><a class="btn btn-primary botaoPainel" href="cadastrar-aula-pratica.php">Cadastrar Aula</a>

                <br><br><h4>Pesquisas</h4>

                <!-- Pesquisar Aluno -->
                <a class="btn btn-primary botaoPainel" href="pesquisar-aluno.php">Pesquisar Aluno</a>
                <?php
                if (!isset($_SESSION)) {
                    session_start();
                }

                if ($_SESSION['cargo'] == 'gerente') {
                    ?>
                    <a class="btn btn-primary botaoPainel" href="pesquisar-instrutor.php">Pesquisar Instrutor</a>
                    <?php
                }
                ?>
                <a class="btn btn-primary botaoPainel" href="pesquisar-veiculo.php">Pesquisar Veículo</a>
                <a class = "btn btn-primary botaoPainel" href = "pesquisar-secretaria.php">Pesquisar Secretária</a>
                <?php
                if ($_SESSION['cargo'] == 'gerente') {
                    ?>
                    <a class = "btn btn-primary botaoPainel" href = "pesquisar-aulas.php">Pesquisar Aulas</a>
                    <?php
                }
                ?>


                <br><br>
            </div>
        </div>



        <!-- scripts padrões para funcionamento do site -->
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
        <script>window.jQuery || document.write('<script src="js/vendor/jquery-1.11.2.min.js"><\/script>')</script>

        <script src="js/bootstrap.min.js"></script>
        <script src="js/main.js"></script>
    </body>

    <footer>
        <center><strong><p>&copy; Francisco César 2018</p></strong></center>
    </footer>
</html>
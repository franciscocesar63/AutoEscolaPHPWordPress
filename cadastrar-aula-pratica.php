<!doctype html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang=""> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang=""> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" lang=""> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="pt"> <!--<![endif]-->

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

        <img  src="img/autoescola_slide_4.jpg"  width="100%" height="50%" style="border: 10px 
              solid; border-radius: 20px;" >
              <?php
              include 'navbar.php';
//        $x = active(0);
//        include './carousel.php';
              ?>
        <div class="container">
            <!--<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>-->
            <center><h3><strong>Cadastrar Aula Prática</strong>s</h3></center>
            <div class="" style="border-width: 5px; border-color: #000;border-style: solid; border-radius: 40px;">

                <div class="container"><br>
                    <div class="row">
                        <div class="col-6">
                            <form class="instrutorAula" action="processa-instrutor-aula.php" autocomplete="off">
                                <label for="pesquisaInstrutorAula">Instrutor: </label>
                                <input class="form-control" type="text" name="pesquisaInstrutorAula" id="pesquisaInstrutorAula" placeholder="Digite Aqui">
                            </form>
                            <div id="resultadoInstrutorAula">
                                <?php
//                echo 'banco: ' . $_SESSION['banco'];
                                if (isset($_SESSION['banco'])) {
                                    if ($_SESSION['banco'] == 'primeiro') {
                                        include_once './banco/conexao_primeiro.php';
                                    } else {
                                        include_once './banco/conexao_segunda.php';
                                    }
                                }
//                $pdo = connectar();
                                $query_instrutor_aula = $pdo->prepare("SELECT * FROM pessoa p INNER JOIN instrutor i ON p.id = i.id  LIMIT 3");
                                $query_instrutor_aula->execute();
                                echo '<div class="table-responsive">';
                                echo '
                    <table class="table table-bordered table-striped" style="text-align: center;">
                    <thead>
                        <tr>
                            <th>CNH</th>
                            <th>NOME</th>
                            <th>CPF</th>
                            <th>SELECIONE</th>
                        </tr>
                    </thead>
                    <tbody>
              ';


                                while ($dado = $query_instrutor_aula->fetch(PDO::FETCH_ASSOC)) {
                                    echo "<thead>
                        <tr>
                            <td>$dado[numero_cnh]</th>
                            <td>$dado[nome]</th>
                            <td>$dado[cpf]</th>
                            <td><input type='radio' id='opcao_instrutor' name='opcao_instrutor' value='$dado[id]' required=''></td>";
                                    echo "</tr>
                    </thead>";
                                }
                                echo '</tbody>';
                                echo '</table>';
                                echo '</div>';
                                ?>

                            </div>



                        </div>




                        <div class="col-6">
                            <form class="alunoAula" action="processa-aluno-aula.php" autocomplete="off">
                                <div class="form-group">

                                    <label for="pesquisaAlunoAula">Aluno: </label>
                                    <input type="text" class="form-control" placeholder="Digite aqui" name="pesquisaAlunoAula" id="pesquisaAlunoAula">
                                </div>
                            </form>
                            <div id="resultadoAlunoAula">
                                <?php
//                echo 'banco: ' . $_SESSION['banco'];
                                if (isset($_SESSION['banco'])) {
                                    if ($_SESSION['banco'] == 'primeiro') {
                                        include_once './banco/conexao_primeiro.php';
                                    } else {
                                        include_once './banco/conexao_segunda.php';
                                    }
                                }
//                $pdo = connectar();
                                $query_aluno_aula = $pdo->prepare("SELECT * FROM pessoa p INNER JOIN aluno a ON p.id = a.id  LIMIT 3");
                                $query_aluno_aula->execute();
                                echo '<div class="table-responsive">';
                                echo '
                    <table class="table table-bordered table-striped" style="text-align: center;">
                    <thead>
                        <tr>
                            <th>MATRICULA</th>
                            <th>NOME</th>
                            <th>CPF</th>
                            <th>SELECIONE</th>
                        </tr>
                    </thead>
              ';


                                while ($dado = $query_aluno_aula->fetch(PDO::FETCH_ASSOC)) {
                                    echo "<thead>
                        <tr>
                            <td>$dado[matricula]</th>
                            <td>$dado[nome]</th>
                            <td>$dado[cpf]</th>
                            <td><input type='radio' name='opcao_aluno' id='opcao_aluno' value='$dado[id]' required=''></td>";
                                    echo "</tr>
                    </thead>";
                                }

                                echo '</tbody>';
                                echo '</table>';
                                echo '</div>';
                                ?>

                            </div>



                        </div>



                    </div>
                </div>
                <div class="container">
                    <div class="row">

                        <div class="col-6"> <!-- pesquisar veiculo -->
                            <form class="veiculoAula" action="processa-veiculo-aula.php" autocomplete="off">
                                <label for="pesquisaVeiculoAula">Veículo: </label>
                                <input class="form-control" type="text" name="pesquisaVeiculoAula" id="pesquisaVeiculoAula" placeholder="Digite Aqui">
                            </form>


                            <div id="resultadoVeiculoAula">
                                <?php
                                if (!isset($_SESSION)) {
                                    session_start();
                                }
//                print_r($_SESSION);
//                echo 'banco: ' . $_SESSION['banco'];
                                if (isset($_SESSION['banco'])) {
                                    if ($_SESSION['banco'] == 'primeiro') {
                                        include_once './banco/conexao_primeiro.php';
                                    } else {
                                        include_once './banco/conexao_segunda.php';
                                    }
                                }
                                $query = $pdo->prepare("SELECT * FROM veiculo");
                                $query->execute();
                                echo '<div class="table-responsive">';
                                echo '
                    <table class="table table-bordered table-striped" style="text-align: center;">
                    <thead>
                        <tr>
                            <th>MODELO</th>
                            <th>PLACA</th>
                            <th>MARCA</th>
                            <th>TIPO</th>
                            <th>SELECIONE</th>
                        </tr>
                    </thead>
                    <tbody>
              ';


                                while ($dado = $query->fetch(PDO::FETCH_ASSOC)) {
                                    echo "<thead>
                        <tr>
                            <td>$dado[modelo]</th>
                            <td>$dado[placa]</th>
                            <td>$dado[marca]</th>
                            <td>$dado[tipo]</th>";
                                    echo "<td><input id='opcao_veiculo' type='radio' name='opcao_veiculo' value='$dado[id]' required=''></td>";
                                    echo "</tr>
                    </thead>";
                                }
                                echo '</tbody>';
                                echo '</table>';
                                echo '</div>';
                                ?>

                            </div>


                        </div>

                        <div class="col-6">
                            <form method="POST" action="banco/cadastrando-aula-pratica.php" autocomplete="off">
                                <input hidden="" name="opcaoInstrutor" id="opcaoInstrutor">
                                <input hidden="" name="opcaoAluno" id="opcaoAluno">
                                <input hidden="" name="opcaoVeiculo" id="opcaoVeiculo">
                                <div class="form-group">
                                    <label for="data-datepicker">Data da Aula: </label>
                                    <input type="text" name="data_aula" placeholder="DD/MM/YYYY" class="form-control" id="data-datepicker" required="">
                                </div>


                                <div class="form-group">
                                    <label for="hora_aula">Inicio da Aula: </label>                       
                                    <input type="text" id="timepicker" name="hora_aula" class="form-control timepicker" required=""/>

                                </div>
                                <div class="form-group">
                                    <select class="form-control" name="quantidade_aula" required="">
                                        <option value="">Quantidade de Aulas</option>
                                        <option value="1">1 aula</option>
                                        <option value="2">2 aulas</option>
                                        <option value="3">3 aulas</option>
                                    </select>
                                </div>

                                <input class="btn btn-primary botaoPainel" type="submit" value="Cadastrar" onclick="implementarOption();">
                                <button type="button" class="btn btn-default botaoPainel" style="border-radius: 20px;"  ><a style="text-decoration: none;" href="painel-usuario.php">Cancelar</a></button>
                            </form><br>
                        </div>
                        


                    </div>

                </div>
                <!--DatePicker JS-->
                <script type="text/javascript">
                    $('#data-datepicker').datepicker({
                        format: "dd/mm/yyyy",
                        language: "pt-BR",
                        calendarWeeks: true,
                        todayHighlight: true
                    });
                    var options = {
                        now: "12:00",
                        twentyFour: true,
                        upArrow: 'wickedpicker__controls__control-up',
                        downArrow: 'wickedpicker__controls__control-down',
                        close: 'wickedpicker__close',
                        hoverState: 'hover-state',
                        title: 'Início da Aula',
                        showSeconds: false,
                        secondsInterval: 1,
                        minutesInterval: 1,
                        beforeShow: null,
                        show: null,
                        clearable: false,
                    };
                    $('#timepicker').wickedpicker(options);

                </script>
                <!--DatePicker JS-->
            </div>

        </div>

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
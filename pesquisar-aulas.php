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



        <div class="container">
            <?php
            include './navbar.php';
            ?>  
        </div>
        <img src="img/autoescola_slide_4.jpg" width="100%" height="50%" style="border: 10px 
             solid; border-radius: 20px;" >
        <!--<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>-->
        <div class="" style="margin-top: 20px;margin-left: 20px;margin-right: 20px;  border: 6px solid; border-radius: 25px;">
            <div></div>
            <h4 style="margin-left: 20px;">Pesquisar Aulas</h4>
            <form class="form-group" action="processa-aula-cadastrada.php" autocomplete="off" style="margin-left: 20px;">
                <input class="form-control-lg" name="pesquisaImprimirAula" id="pesquisaImprimirAula">
                <button class="btn btn-primary" onclick="cliqueAjax();">Pesquisar</button>
            </form>

            <div id="resultadoImprimirAula">
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
                $query = $pdo->prepare("SELECT * FROM aula a INNER JOIN pratica p ON a.id=p.id ORDER BY data LIMIT 10");
                $query->execute();
                echo '<div class="table-responsive">';
                echo '
                    <table class="table table-bordered table-striped" style="text-align: center;">
                    <thead>
                        <tr>
                            <th title="Nome do Instrutor">INSTRUTOR</th>
                            <th title="Nome do Aluno">ALUNO</th>
                            <th title="Placa do veículo">PLACA</th>
                            <th title="Tipo de aula">TIPO</th>
                            <th title="Data da Aula">DATA</th>
                            <th title="Início da aula">INICIO</th>
                            <th title="Término da aula">FIM</th>
                            <th title="Quantidade de aula cadastrada, 50 Minutos por aula. Máximo 3">QUANTIDADE</th>
                            <th title="Visualizar dados da aula selecionada">VISUALIZAR</th>
                            <th title="Deletar dados da aula selecionada">DELETAR</th>
                        </tr>
                    </thead>
                    <tbody>
              ';


                while ($dado = $query->fetch(PDO::FETCH_ASSOC)) {
                    $query_instrutor = $pdo->prepare("SELECT nome FROM pessoa WHERE id=$dado[id_instrutor] LIMIT 1");
                    $query_instrutor->execute();
                    $dado_instrutor = $query_instrutor->fetch(PDO::FETCH_ASSOC);

                    $query_aluno = $pdo->prepare("SELECT nome FROM pessoa WHERE id=$dado[id_aluno] LIMIT 1");
                    $query_aluno->execute();
                    $dado_aluno = $query_aluno->fetch(PDO::FETCH_ASSOC);
                    
                    $query_veiculo = $pdo->prepare("SELECT placa FROM veiculo WHERE id=$dado[id_veiculo] LIMIT 1");
                    $query_veiculo->execute();
                    $dado_veiculo = $query_veiculo->fetch(PDO::FETCH_ASSOC);
                    echo "<thead>
                        <tr>
                            <td>$dado_instrutor[nome]</th>
                            <td>$dado_aluno[nome]</th>
                            <td>$dado_veiculo[placa]</th>
                            <td>$dado[tipo]</th>
                            <td>";
                    echo date("d/m/Y", strtotime($dado['data']));
                    echo "</th>
                            <td>$dado[inicio]</th>
                            <td>$dado[fim]</th>
                            <td>$dado[quantidade]</th>";
                    echo '<td><a href="visualizar-aula?id=' . $dado['id'] . '" class="btn btn-primary">Visualizar</a></td>';
                    echo "</tr>
                    </thead>";
                }
                echo '</tbody>';
                echo '</table>';
                echo '</div>';
                ?>

            </div>



        </div>





        <!--Button to Open the Modal -->


        <!-- The Modal -->
        <?php
        $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_STRING);

//        echo 'id: ' . $id;
        if (isset($id)) {

            $query_test = $pdo->prepare("SELECT * FROM pessoa p INNER JOIN instrutor a ON p.id=a.id"
                    . " WHERE p.id=$id AND p.excluido=0 AND a.excluido=0 LIMIT 10");
            $query_test->execute();

            $dado_test = $query_test->fetch(PDO::FETCH_ASSOC);
        }
        ?>

        <!--        <a id="btn_visualizar" name = "btn_visualizar" type = "button" 
                   class = "btn btn-primary" data-toggle = "modal" data-target = "#myModal">
                    Visualizar</a>-->
        <div class = "modal fade" id = "myModal">
            <div class = "modal-dialog modal-lg">
                <div class = "modal-content">

                    <!--Modal Header -->
                    <div class = "modal-header">
                        <h4 class = "modal-title">Visualizar Instrutor</h4>
                        <button type = "button" class = "close" data-dismiss = "modal">&times;
                        </button>
                    </div>

                    <!--Modal body -->
                    <div class = "modal-body">

                        <div class = "col-6">
                            <?php
//                            echo 'oi: ' . $dado_test['nome'];
                            ?>
                        </div>

                    </div>

                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>

                </div>
            </div>
        </div>


        <footer>
            <center><strong><p>&copy; Francisco César 2018</p></strong></center>
        </footer>

        <!-- scripts padrões para funcionamento do site -->
<!--        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
        <script>window.jQuery || document.write('<script src="js/vendor/jquery-1.11.2.min.js"><\/script>')</script>
        <script src="js/javascript.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="js/main.js"></script>-->


        <!-- scripts padrões para funcionamento do site -->
        <script src="js/javascript.js"></script>

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js" type="text/javascript"></script>
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
        <script src="js/jquery-1.11.3.min.js"></script>
        <script>window.jQuery || document.write('<script src="js/vendor/jquery-1.11.2.min.js"><\/script>');</script>

        <script src="js/bootstrap.min.js"></script>

    </body>


</html>
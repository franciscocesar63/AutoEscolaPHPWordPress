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

        <link rel="stylesheet" href="css/bootstrap-theme.min.css">
        <link rel="stylesheet" href="css/main.css">
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
        <div class="container" style="margin-top: 20px;border: 5px solid;border-radius: 25px;">

            <h4>Pesquisar Secretária</h4>
            <form action="processa-secretaria.php" autocomplete="off">
                <input class="form-control" type="text" name="pesquisaSecretaria" id="pesquisaSecretaria" placeholder="Digite Aqui">
            </form>


            <div id="resultadoSecretaria">
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
                $query = $pdo->prepare("SELECT * FROM pessoa p INNER JOIN funcionario f ON p.id=f.id AND f.excluido=0"
                        . " AND p.excluido=0 AND f.cargo='secretaria' LIMIT 10");
                $query->execute();
                echo '<div class="table-responsive">';
                echo '
                    <table class="table table-bordered table-striped" style="text-align: center;">
                    <thead>
                        <tr>
                            <th>NOME</th>
                            <th>CPF</th>
                            <th>RG</th>
                            <th>TELEFONE</th>
                            <th>SALÁRIO</th>
                            <th>VISUALIZAR DADOS</th>
                            <th>DELETAR</th>
                        </tr>
                    </thead>
                    <tbody>
              ';


                while ($dado = $query->fetch(PDO::FETCH_ASSOC)) {
                    echo "<thead>
                        <tr>
                            <td>$dado[nome]</th>
                            <td>$dado[cpf]</th>
                            <td>$dado[rg]</th>
                            <td>$dado[telefone]</th>
                            <td>R$ $dado[salario]</th>";
                    echo '<td><a href="visualizar-aluno?id=' . $dado['id'] . '" class="btn btn-primary">Visualizar</a></td>';
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
//        $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_STRING);
//
////        echo 'id: ' . $id;
//        if (isset($id)) {
//
//            $query_test = $pdo->prepare("SELECT * FROM pessoa p INNER JOIN funcionario f ON p.id=f.id"
//                    . " WHERE p.id=$id AND p.excluido=0 AND f.excluido=0 AND f.cargo='secretaria' LIMIT 10");
//            $query_test->execute();
//
//            $dado_test = $query_test->fetch(PDO::FETCH_ASSOC);
//        }
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



        <!-- scripts padrões para funcionamento do site -->
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
        <script>window.jQuery || document.write('<script src="js/vendor/jquery-1.11.2.min.js"><\/script>')</script>
        <script src="js/javascript.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="js/main.js"></script>

    </body>


</html>
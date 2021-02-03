<!doctype html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang=""> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang=""> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" lang=""> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="pt"> <!--<![endif]-->
    <?php
    echo 'banco: ' . $_SESSION['banco'];
    if (isset($_SESSION['banco'])) {
        if ($_SESSION['banco'] == 'primeiro') {
            include_once './banco/conexao_primeiro.php';
        } else {
            include_once './banco/conexao_segunda.php';
        }
    }
    ?>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title></title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="apple-touch-icon" href="apple-touch-icon.png">

        <link rel="stylesheet" href="css/bootstrap.min.css">

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
        <img src="img/autoescola_slide_4.jpg" width="100%" height="50%" style="position: absolute;">
        <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
        <div class="container">
            <?php
//            include_once './banco/conexao.php';
            echo '<form method="GET" action="">';
            echo '<div class="form-group">';
            echo '<label for="pesquisa" class="control-label">Pesquisar:</label>';
            echo '<input type="text" id="pesquisa" name="pesquisa" placeholder="Digite aqui:" class="form-control" maxlength="30">';
            echo '</div>';
            echo '<input type="submit" value="Pesquisar">';
            echo '</form>';


            echo '
<div class="table-responsive-lg">    
<table class="table">
        <thread>        
        <tr>
        <th><strong>MATRÍCULA</strong></th>
        <th><strong>NOME</strong></th>
        <th><strong>CPF</strong></th>
        <th><strong>RG</strong></th>
        <th><strong>TELEFONE</strong></th>
        <th><strong>EDITAR</strong></th>
        <th><strong>EXCLUIR</strong></th>
        </tr>
        </thread>';
            while ($lista = $query->fetch(PDO::FETCH_ASSOC)) {
                echo "<tr>\n";
                echo "<td>" . $lista['matricula'] . "</td>\n";
                echo "<td>" . $lista['nome'] . "</td>\n";
                echo "<td>" . $lista['cpf'] . "</td>\n";
                echo "<td>" . $lista['rg'] . "</td>\n";
                echo "<td>" . $lista['telefone'] . "</td>\n";
//    echo "<td>" . pbd_model_aluno($lista['id']) . "</td>\n";
                echo '<td><a class="btn btn-default" onclick="return confirmar_operação()" href="../deletando-pessoa?id=' . $lista['id'] . '">DELETAR</a></td>';
                echo "</tr>\n";
            }

            echo "</table>\n";
            echo '</div>';
            ?>
        </div>
        <script>
            $(#pesquisa).keyup(function () {
                alert("testando");
            });
        </script>




        <!-- scripts padrões para funcionamento do site -->
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
        <script>window.jQuery || document.write('<script src="js/vendor/jquery-1.11.2.min.js"><\/script>')</script>

        <script src="js/bootstrap.min.js"></script>
        <script src="js/main.js"></script>

    </body>
</html>
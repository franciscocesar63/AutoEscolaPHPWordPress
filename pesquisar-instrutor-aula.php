<!doctype html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang=""> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang=""> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" lang=""> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang=""> <!--<![endif]-->
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
        <?php
        include './navbar.php';
//        $x = active(0);
//        include './carousel.php'; 
        ?>
        <img src="img/autoescola_slide_4.jpg" width="100%" height="50%" style="position: absolute;">
        <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>

        <form method="GET" action="">
            <div class="form-group"> 
                <label for="pesquisa" class="control-label">Pesquisar:</label>
                <input type="text" name="pesquisa" placeholder="Digite aqui:" class="form-control" id="pesquisa" maxlength="30">
            </div>
            <input type="submit" value="Pesquisar">
        </form>

        <?php
        if (isset($_SESSION['banco'])) {
            if ($_SESSION['banco'] == 'primeiro') {
                include_once './banco/conexao_primeiro.php';
            } else {
                include_once './banco/conexao_segunda.php';
            }
        }
        $pesquisa = isset($_GET['pesquisa']);
//    if (isset($pesquisa)) {

        $query = $pdo->prepare("SELECT * FROM pessoa p INNER JOIN instrutor i ON p.id=i.id"
                . " WHERE p.nome LIKE '%$pesquisa%' AND p.excluido=0 AND i.excluido=0 LIMIT 10");
        $query->execute();



        echo "<table class='table'>\n";
        echo '<tr>';
        echo '<th><strong>HABILITAÇÃO</strong></th>';
        echo '<th><strong>NOME</strong></th>';
        echo '<th><strong>CPF</strong></th>';
        echo '<th><strong>RG</strong></th>';
        echo '<th><strong>TELEFONE</strong></th>';
        echo '<th><strong>EDITAR</strong></th>';
        echo '<th><strong>EXCLUIR</strong></th>';
        echo '<th></tr>';
        echo '</thread>';
        while ($lista = $query->fetch(PDO::FETCH_ASSOC)) {
//        var_dump($lista);
            echo "<tr>\n";
            echo "<td>" . $lista['numero_cnh'] . "</td>\n";
            echo "<td>" . $lista['nome'] . "</td>\n";
            echo "<td>" . $lista['cpf'] . "</td>\n";
            echo "<td>" . $lista['rg'] . "</td>\n";
            echo "<td>" . $lista['telefone'] . "</td>\n";
//            echo "<td>" . pbd_model_pessoa($lista['id']) . "</td>\n";
            echo "</tr>\n";
        }
        echo "</table>\n";
        ?>




        <footer >
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

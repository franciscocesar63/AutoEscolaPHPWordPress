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
        <link rel="shortcut icon" href="favicon.ico" type="image/x-icon"/>

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

        <img src="img/autoescola_slide_4.jpg"  width="100%" height="50%" style=" border: 10px 
              solid; border-radius: 20px;" >

        <div class="container">
            <!--<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>-->
            <br>
            <form name="formulario" action="http://scripts.redehost.com.br/formmail.aspx" method="post">
                <input type=hidden name="destino" value="franciscocesar888@gmail.com">
                <input type=hidden name="enviado" value="localhost">
                <p><b>Nome:</b><br>
                    <input type=text name="nome" size="45"></p><br>
                <p><b>Email:</b><br>
                    <input type=text name="email" size="45"></p><br>
                <p><b>Assunto:</b><br>
                    <input type=text name="assunto" size="45"></p><br>
                <p><b>Mensagem:</b><br>
                    <textarea name="Mensagem" rows="10" cols="60" wrap="virtual"></textarea></p><br>
                <p><input type="submit" value="Enviar Email"> 
                    <input type="reset" value="Limpar Formulário"></p>
            </form>

        </div>

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

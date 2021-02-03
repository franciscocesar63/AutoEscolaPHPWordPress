
<!doctype html>
<?php
$banco = filter_input(INPUT_POST, 'banco', FILTER_SANITIZE_STRING);
$login = filter_input(INPUT_POST, 'login', FILTER_SANITIZE_STRING);
$senha = filter_input(INPUT_POST, 'senha', FILTER_SANITIZE_STRING);
if ($banco == 'primeiro') {
    include_once './banco/conexao_primeiro.php';
} else {
    include_once './banco/conexao_segunda.php';
}
//ini_set("session.use_only_cookies", "1");
//ini_set("session.use_trans_sid", "0");
if (isset($login) && strlen($login) > 0) {
    if (!isset($_SESSION)) {
        ini_set('session.gc_maxlifetime', 8 * 60 * 60);
        ini_set("session.cache_expire", 14400);
        session_save_path();
        session_start();
    }
    $_SESSION['banco'] = $banco;

//    $_SESSION['last_login_timestamp'] = time();
//    pbd_fechar_sessao_ao_fechar_navegador();
    if (isset($_SESSION['usuario'])) {
        $erro[] = 'O usuário já está conectado no sistema, tente novamente mais tarde.';
        unset($_SESSION['usuario']);
        session_destroy();
        header("Location: login.php");
    }

    $_SESSION['login'] = $pdo->quote($login);
//    $_SESSION['senha'] = md5(md5($senha));
    $_SESSION['senha'] = $senha;

    $query = $pdo->prepare("SELECT senha, id FROM usuario WHERE login = $_SESSION[login] AND excluido = 0 ");
    $query->execute();
    $dado = $query->fetch(PDO::FETCH_ASSOC);
//    var_dump($dado);
    try {
        $id_usuario = $dado['id'];
        $query_func = $pdo->prepare("SELECT * FROM funcionario WHERE id = $id_usuario AND excluido = 0");
        $query_func->execute();
        $dado_func = $query_func->fetch(PDO::FETCH_ASSOC);

        $query_pessoa = $pdo->prepare("SELECT * FROM pessoa WHERE id = $id_usuario AND excluido = 0");
        $query_pessoa->execute();
        $dado_pessoa = $query_pessoa->fetch(PDO::FETCH_ASSOC);
        
        
        
        $total = $query->rowCount();
//        var_dump($dado_func);



        if ($total == 0) {
            $erro[] = "Este login não pertence à nenhum usuário.";
        } else {
            if ($dado['senha'] == $_SESSION['senha']) {
//                session_set_cookie_params(0, "/", $HTTP_SERVER_VARS["HTTP_HOST"], 0);
                $_SESSION['usuario'] = $dado['id'];
                $_SESSION['cargo'] = $dado_func['cargo'];
                $_SESSION['nome_usuario'] = $dado_pessoa['nome'];
                session_name($login);
            } else {
                $erro[] = "Senha incorreta.";
            }
        }
    } catch (Exception $ex) {
        $erro[] = 'Login ou senha incorretos.';
//        echo '<script>alert("Login ou senha incorretos, tente novamente!");window.location.href="login.php"</script>';
    }
//    $_SESSION['cargo'] = $dado_func['cargo'];

    if (!isset($erro) || count($erro) == 0) {
//        if (isset($dado_func['cargo'])) {
//            if ($dado_func['cargo'] == 'gerente') {
//                echo '<script>alert("Autenticado com sucesso!");window.location.href="painel-gerente.php"</script>';
//            } else {
//                echo '<script>alert("Autenticado com sucesso!");window.location.href="painel-secretaria.php"</script>';
//            }
//        }
        echo '<script>window.location.href="painel-usuario.php"</script>';
//        print_r($_SESSION);
    }
}
?>

<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">
        <link rel="icon" href="../../../../favicon.ico">
        <link rel="shortcut icon" href="favicon.ico" type="image/x-icon"/>

        <title>Acesso Restrito</title>

        <!-- Bootstrap core CSS -->
        <link href="css/bootstrap.min.css" rel="stylesheet">

        <!-- Custom styles for this template -->
        <link href="css/signin.css" rel="stylesheet">
    </head>

    <body class="text-center">
        <header>
            <?php
            include './navbar.php';
            ?>
        </header>

        <form class="form-signin" method="POST" action="" >
            <img class="mb-4" src="img/logo-sistema.png">
            <!--<h1 class="h3 mb-3 font-weight-normal">Login</h1>-->
            <?php
            if (isset($erro)) {

                if (count($erro) > 0) {
                    foreach ($erro as $msg) {
                        echo "<p>$msg</p>";
                    }
                }
            }
            ?>
            <label for="login" class="sr-only">Login</label>
            <input type="text" name="login" id="login" class="form-control" placeholder="Login" required autofocus>
            <label for="senha" class="sr-only">Senha</label>
            <input type="password" id="senha" name="senha" class="form-control" placeholder="Senha" required>
            <div class="form-group">
                <label for="select_banco"></label>
                <select class="form-control form-control-lg" name="banco" id="select_banco" required="">
                    <option value="">Selecione a Auto escola</option>
                    <option value="primeiro">Primeiro</option>
                    <option value="segundo">Segundo</option>
                </select>
            </div>


            <button class="btn btn-lg btn-primary btn-block" type="submit">Entrar</button>
            <p class="mt-5 mb-3 text-muted">&copy; Francisco César 2018</p>

        </form>



        <!-- scripts padrões para funcionamento do site -->
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
        <script>window.jQuery || document.write('<script src="js/vendor/jquery-1.11.2.min.js"><\/script>')</script>

        <script src="js/bootstrap.min.js"></script>
        <script src="js/main.js"></script>
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




<nav class="navbar fixed-top navbar-expand-lg navbar-dark" style="font-weight: bold; background-color: #062c33;">
    <div class="container">
        <a class="navbar-dark h1 mb-0 mr-4" href="index.php"><img src="img/logo-sistema.png"></a>
        <!--<a class="navbar-brand h1 mb-0" href="index.php"><img src="imagens/logo-sistema.png"></a>-->

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSite">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSite">
            <ul class="navbar-nav ">

                <li class="nav-item">
                    <a class="nav-link <?php echo isset($active); ?>" href="index.php">Inicio</a>
                </li>
                <?php
                if (!isset($_SESSION)) {
                    session_start();
                }
                if (isset($_SESSION['usuario'])) {
                    echo '<li class="nav-item">
                    <a class="nav-link <?php echo isset($active1); ?>" href="painel-usuario.php">Painel do Usuário</a>
                </li>';
                    echo '<li class="nav-item">
                    <a class="nav-link <?php echo isset($active4); ?>"  href="logout.php">Sair</a>
                </li>';
                }
                if (!isset($_SESSION['usuario'])) {
                    echo '<li class="nav-item">
                    <a class="nav-link <?php echo isset($active3); ?>"  href="login.php">Acesso Restrito</a>
                            </li>
                ';
                }
                ?>
                <li class="nav-item">
                    <a class="nav-link <?php echo isset($active2); ?>"  href="contato.php">Contato</a>
                </li>


            </ul>




        </div>  
        <ul class="navbar-nav mr-auto" style="color: #999999; float: right;"> 
            <?php
            if (!isset($_SESSION)) {
                session_start();
            }
            if(isset($_SESSION['usuario'])) {
                echo 'Bem Vindo: ' . $_SESSION['nome_usuario'];
            }
            ?>
        </ul>

    </div>
</nav>
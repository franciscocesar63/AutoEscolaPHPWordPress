<html>

    <body>
        <?php
        if (!isset($_SESSION)) {
            session_start();
        }
        echo '<h1>' . $_SESSION['cargo'] . '</h1>';
        ?>

    </body>
</html>
<h1><a href="Index.php">quizy.pl</a></h1>

<ul>
    <?php

    if((isset($_SESSION["role"]) && $_SESSION["role"] > 0)){
        header("Location: Login.php");
        exit;
    }
    echo "<li><a href=\"QuizList.php\">Quizy</a></li>";
    echo "<li><a href=\"Profile.php\">Profil</a></li>";
    echo "<li><a href=\"Stats.php\">Statystyki</a></li>";

    if(isset($_SESSION["role"]) && ($_SESSION["role"] >1)){
        echo "<li><a href=\"AdminPanel.php\">Admin Panel</a></li>";
    }
    if((isset($_SESSION["role"]) && $_SESSION["role"] > 0)){
        echo "<li><form action=\"Header.php\" method=\"POST\"><button type=\"submit\"  name=\"logOut\">Wyloguj</button></form></li>";
    }
    if (isset($_POST['logOut'])) {
        session_unset();
//        session_destroy();

        header("Location: Index.php");

    }
    ?>

</ul>


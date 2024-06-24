<?php
session_start();

if(!(isset($_SESSION["role"]) && $_SESSION["role"] > 0)){
    header("Location: Login.php");
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Strona Główna</title>
    <title>My Website</title>
    <link rel="stylesheet" href="../CSS/Index.css">
</head>
<body>
<header>

    <h1><a href="Index.php">quizy.pl</a></h1>

    <ul>
        <li><a href="QuizList.php">Quizy</a></li>
        <li><a href="Profile.php">Profil</a></li>
        <li><a href="Stats.php">Statystyki</a></li>
        <?php

        if(isset($_SESSION["role"]) && ($_SESSION["role"] >1)){
            echo "<li><a href=\"AdminPanel.php\">Admin Panel</a></li>";
        }
        ?>
        <li><form action="Index.php" method="POST"><button type="submit"  name="logOut">Wyloguj</button></form></li>
    </ul>

    <?php
    if (isset($_POST['logOut'])) {

        session_unset();
        session_destroy();

        header("Location: Index.php");
    }
    ?>
</header>
<main>
    <section>
        <h2>Wybierz quiz z listy</h2>
        <form method="POST">
            <input type="submit" name="quizList" value="Kliknij aby przejść">
        </form>
    </section>
    <section>
        <h2>Wykonaj quiz dnia</h2>
        <form method="POST">
            <input type="submit" name="dayQuiz" value="Kliknij aby przejść">
        </form>
    </section>
    <section>
        <h2>Wykonaj losowy quiz</h2>

        <form method="POST">
            <input type="submit" name="randomQuiz" value="Kliknij aby wylosować">
        </form>

    </section>
    <section>
        <h2>Spróbuj tryb arcade</h2>

    </section>

</main>
<footer>
    <?php
    include 'Footer.php';
    ?>
</footer>
</body>
</html>

<?php
include_once "Connect.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $query = "SELECT COUNT(*) FROM quizzes";

    $result = $conn->query($query);

    while ($row = $result->fetch_assoc()) {
        $max = $row['COUNT(*)'];
    }

    if(isset($_POST['quizList'])){
        header("Location: QuizList.php");
    }
    if (isset($_POST['randomQuiz'])) {
        $quiz_id = rand(1, $max);
        setcookie('selected_quiz', $quiz_id, time() + 360, '/');
        header("Location: Quiz_form.php");
    }
    if(isset($_POST['dayQuiz'])){

        $today = date('Y-m-d');
        $pseudoRandomNumber = generatePseudoRandomNumberByDate($today);
        setcookie('selected_quiz', $pseudoRandomNumber % $max + 1, time() + 360, '/');
        header("Location: Quiz_form.php");
        exit();
    }


}


function generatePseudoRandomNumberByDate($date) {
    // Wydobycie roku, miesiąca i dnia z daty
    $year = date('Y', strtotime($date));
    $month = date('m', strtotime($date));
    $day = date('d', strtotime($date));
    $combined = $year . $month . $day;
    $seed = intval($combined);
    srand($seed);
    $randomNumber = rand();
    srand();

    return $randomNumber;
}



?>
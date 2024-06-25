<?php
session_start();
if(!(isset($_SESSION["role"]) && $_SESSION["role"] > 0)){
    header("Location: Login.php");
}
$id_users = $_SESSION["id_users"];
include_once "Connect.php";

$generalPoints= 0;

$query = "SELECT SUM(score) FROM user_quiz_attempts WHERE user_id = $id_users";
$result = $conn->query($query);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $generalPoints = $row['SUM(score)'];

    }
}
$generalGames = 0;
$query = "SELECT COUNT(*) FROM user_quiz_attempts WHERE user_id = $id_users";
$result = $conn->query($query);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $generalGames = $row['COUNT(*)'];

    }

    $maxPoints = 0;
    $query = "SELECT COUNT(*) FROM user_quiz_attempts WHERE user_id =$id_users";
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $maxPoints = $row['COUNT(*)'];

        }
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Statystyki</title>
    <link rel="stylesheet" href="../CSS/Stats.css">
    <link rel="stylesheet" href="../CSS/General.css">

</head>
<body>
<header>
    <h1><a href="Index.php">quizy.pl</a></h1>
</header>
<main>
<article>
    <h2>Ogólnie</h2>
    <section>
        <h3>Ilość rozgrywek</h3>
        <p><?php echo $generalGames?></p>
    </section>
    <section>
        <h3>Łączna ilość punktów</h3>
        <p><?php echo $generalPoints?></p>
    </section>
</article>



</main>
<h2>

</h2>
<footer>
    <?php
    include 'Footer.php'
    ?>
</footer>
</body>
</html>


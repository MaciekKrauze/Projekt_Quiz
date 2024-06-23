<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Strona Główna</title>
    <link rel="stylesheet" href="">
</head>
<body>
<header>
    <h1><a href="Index.php">quizy.pl</a></h1>
</header>
<main>
    <h2>Co chcesz zrobić?</h2>
    <ul>
        <li><a href=" Admin_panel/Add.php">Dodać</a></li>
        <li><a href="Admin_panel/View.php">Przeglądać</a></li>
        <li><a href="Admin_panel/Delete.php">Usunąć</a></li>
    </ul>


    <form action="AdminPanel.php" method="post">
        <label for="View"> Przeglądać</label>
        <input type="radio" id="View" value="View" name="action_one">
        <label for="Add"> Dodać</label>
        <input type="radio" id="Add" value="Add" name="action_one">
        <label for="Modify">Zmodyfikować</label>
        <input type="radio" id="Modify" value="Modify" name="action_one">
        <label for="Delete">Usunąć</label>
        <input type="radio" id="Delete" value="Delete" name="action_one">
        <input type="submit">
    </form>

    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        echo 1;
    }
    ?>
</main>
<footer>
    <?php
    include 'Footer.php'
    ?>
</footer>
</body>
</html>


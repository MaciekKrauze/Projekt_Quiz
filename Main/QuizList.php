<?php
session_start();
include_once "Connect.php";

$query = "SELECT * FROM categories ";

$result = $conn->query($query);
$categories = [];
$i = 0;
while ($row = $result->fetch_assoc()) {
    $categories[$i] = $row['category_name'];
    $i++;
}

?>

    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Lista quizów</title>
        <link rel="stylesheet" href="">
    </head>
    <body>
    <header>
        <h1><a href="Index.php">quizy.pl</a></h1>
        <?php

        ?>
    </header>
    <main>
        <?php
        $quizz_names = [];
        for ($j = 0; $j < count($categories); $j++) {
            echo "<section>";
            echo "<h2> $categories[$j] </h2>";
            $query1 = "SELECT * FROM quizzes WHERE category_id = (" . ($j + 1) . ") ";
            $result1 = $conn->query($query1);

            if ($result1->num_rows > 0) {
                while ($row = $result1->fetch_assoc()) {
                    $quiz_id = $row['quiz_id']; // Get quiz ID
                    $quiz_name = $row['quiz_name'];
                    $quiz_type = $row['quiz_type'];
                    $description = $row['description'];

                    echo "<div>";
                    echo "<h3> $quiz_name</h3>";

                    switch ($quiz_type) {
                        case 1:
                            echo "Test jednokrotnego wyboru";
                            break;
                        case 2:
                            echo "Test wielokrotnego wyboru";
                            break;
                        case 3:
                            echo "Test typu: odgadnij coś z obrazka";
                            break;
                    }
                    echo "<p>$description</p>";


                    echo "<form action='#' method='post'>";
                    echo "<input type='hidden' name='quiz_id' value='$quiz_id'>";
                    echo "<button type='submit' name='selectQuiz'>Wybierz ten quiz</button>";
                    echo "</form>";

                    echo "</div>";
                }
            }
            echo "</section>";
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

<?php

if (isset($_POST['quiz_id']) && is_numeric($_POST['quiz_id'])) {
    $quiz_id = $_POST['quiz_id'];


    setcookie('selected_quiz', $quiz_id, time() + 3600, '/'); // 1 hour cookie


    header('Location: Quiz_form.php');

    exit;
}
?>
<?php
session_start();
if(!(isset($_SESSION["role"]) && $_SESSION["role"] > 0)){
    header("Location: Login.php");
}
include_once "Connect.php";
$action_one = isset($_POST["action_one"]) ? $_POST["action_one"] : null;
$action_two = isset($_POST["action_two"]) ? $_POST["action_two"] : null;
?>
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


    <form action="AdminPanel.php" method="post">
        <label for="View"> Przeglądać</label>
        <input type="radio" id="View" value="View" name="action_one" <?php if ($action_one == "View") echo "checked"; ?>>

        <label for="Add"> Dodać</label>
        <input type="radio" id="Add" value="Add" name="action_one" <?php if ($action_one == "Add") echo "checked"; ?>>

        <label for="Modify">Zmodyfikować</label>
        <input type="radio" id="Modify" value="Modify" name="action_one" <?php if ($action_one == "Modify") echo "checked"; ?>>

        <label for="Delete">Usunąć</label>
        <input type="radio" id="Delete" value="Delete" name="action_one" <?php if ($action_one == "Delete") echo "checked"; ?>>

        <input type="submit">
    </form>

    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST["action_one"])) {
        echo "<h2>Jaką tabelę?</h2>";
        echo "<form action=\"AdminPanel.php\" method=\"post\">";
        $tables = ["users", "quizzes", "categories", "quiz_answers", "quiz_questions", "user_quiz_answers", "user_quiz_attempts"];
        for ($i = 0; $i < count($tables); $i++) {
            echo "<label>$tables[$i]</label>";
            if($action_two == $tables[$i]){
                echo "<input type=\"radio\" id=\"$tables[$i]\" value=\"$tables[$i]\" name=\"action_two\" checked>";
            }
            else {
                echo "<input type=\"radio\" id=\"$tables[$i]\" value=\"$tables[$i]\" name=\"action_two\" >";
            }
        }
        echo "<input type=\"hidden\" name=\"action_one\" value=\"$action_one\">";
        echo "<input type=\"submit\">";
        echo "</form>";


        switch ($_POST["action_one"]) {
            case "View":
                if (isset($_POST["action_two"])) {
                    $temp = $_POST["action_two"];
                    echo "<table>";
                    $query = "SELECT COLUMN_NAME FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = 'quizzespage' AND TABLE_NAME = '$temp'";
                    $result = $conn->query($query);
                    $columns =[];
                    $a = 0;
                    echo "<tr>";
                    while ($row = $result->fetch_assoc()) {
                        $temp1 = $row['COLUMN_NAME'];
                        $columns[$a] = $temp1;
                        $a++;
                        echo "<th>$temp1</th>";
                    }
                    echo "</tr>";
                    $query = "SELECT * FROM $temp";

                    $result = $conn->query($query);
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        for ($j = 0; $j < count($columns); $j++) {
                            $temp1 = $row[$columns[$j]];
                            echo "<td>$temp1</td>";
                        }
                        echo "</tr>";
                    }
                    echo "</table>";

                }



                break;
            case "Add":
                echo "Wybrano: Dodać";
                break;
            case "Modify":
                echo "Wybrano: Zmodyfikować";
                break;
            case "Delete":
                echo "<h2>Numer id do usunięcia</h2>";
                echo "<form>";
                echo "<input type='number'>";
                echo "<input type=\"submit\">";
                echo "</form>";


                $query = "DELETE FROM users WHERE id_users = 12";
                break;
            default:
                echo "Nieznana akcja";
                break;
            }
        }
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


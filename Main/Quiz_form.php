<?php
session_start();
$id_users = $_SESSION['id_users'];
$quiz_id = $_COOKIE['selected_quiz'];
$points = 0;
include_once "Connect.php";

    $query = "SELECT * FROM quizzes WHERE quiz_id = $quiz_id";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $quiz_type = $row['quiz_type'];
            $quiz_name = $row['quiz_name'];
        }
    }
    $questions = [];
    $questions_text = [];
    $query1 = "SELECT * FROM quiz_questions WHERE quiz_id = $quiz_id";
    $result1 = $conn->query($query1);
    $i = 0;
    if ($result1->num_rows > 0) {
    while($row = $result1->fetch_assoc()) {
        $questions[$i] = $row['question_id'];
        $questions_text[$i] = $row['question_text'];
        $i++;
    }

        $query2 = "SELECT * FROM quiz_answers WHERE question_id = $questions[$i]";
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Quiz</title>
    <link rel="stylesheet" href="">
</head>
<body>
<header>
    <?php
//    include 'Header.php'
    ?>
</header>
<main>

    <?php
        switch ($quiz_type){
            case 1:
                echo "<h2>QUIZ: $quiz_name</h2>";
                echo "<form method='POST' action='Quiz_form.php'>";
                for ($j = 0; $j < count($questions); $j++) {
                    echo "<div>";
                    echo "<h3>$questions_text[$j]</h3>";
                    $query2 = "SELECT * FROM quiz_answers WHERE question_id= $questions[$j]";
                    $result2 = $conn->query($query2);
                    $i = 0;
                    $answers =[];
                    if ($result2->num_rows > 0) {
                        while ($row = $result2->fetch_assoc()) {
                            $answers[$i] = $row['answer_text'];

                            echo "<label for=\"html\" >$answers[$i]</label>";
                            echo "<input type='radio' id='$answers[$i]' name = \"$questions[$j]\" value='$questions[$i]'> <br>";

                            $i++;
                        }
                    }
                    echo "</div>";
                }
                echo "<input type='submit' value='submit'>";
                echo "</form>";
                break;
            case 2:

                break;
            case 3:

                break;
        }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        foreach ($questions as $question_id) {
            // Check if an answer is selected for the current question
            if (isset($_POST[$question_id])) {
                $user_answers[$question_id] = $_POST[$question_id];
            } else {
                // Handle cases where no answer is selected (optional: assign a default value)
                $user_answers[$question_id] = null; // or any other default value
            }
        }
    }
    var_dump($user_answers);
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
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

}
?>


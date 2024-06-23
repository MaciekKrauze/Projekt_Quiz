<?php
session_start();
$id_users = $_SESSION['id_users'];
$quiz_id = $_COOKIE['selected_quiz'];
$points = 0;
include_once "Connect.php";

$query = "SELECT * FROM quizzes WHERE quiz_id = $quiz_id";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $quiz_type = $row['quiz_type'];
        $quiz_name = $row['quiz_name'];
    }
}

$questions = [];
$questions_text = [];
$questions_images = [];
$query1 = "SELECT * FROM quiz_questions WHERE quiz_id = $quiz_id";
$result1 = $conn->query($query1);
$i = 0;
if ($result1->num_rows > 0) {
    while ($row = $result1->fetch_assoc()) {
        $questions[$i] = $row['question_id'];
        $questions_text[$i] = $row['question_text'];
        $questions_images[$i] = $row['question_image'];
        $i++;
    }
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
    <h1><a href="Index.php">quizy.pl</a></h1>
</header>
<main>



    <?php

    echo "<h2>QUIZ: $quiz_name</h2>";
    echo "<form method='POST' action='Quiz_form.php'>";
    switch ($quiz_type) {
        case 1:

            $correct_answers = [];


            for ($k = 0; $k < count($questions); $k++) {
                $query3 = "SELECT * FROM quiz_answers WHERE question_id = $questions[$k] AND is_correct = 1";
                $result3 = $conn->query($query3);
                while ($row = $result3->fetch_assoc()) {
                    $correct_answers[$k + 1] = $row['answer_id'];
                }
            }

            for ($j = 0; $j < count($questions); $j++) {
                echo "<div>";
                echo "<h3>$questions_text[$j]</h3>";
                $query2 = "SELECT * FROM quiz_answers WHERE question_id = $questions[$j]";
                $result2 = $conn->query($query2);
                $answers = [];
                if ($result2->num_rows > 0) {
                    while ($row = $result2->fetch_assoc()) {
                        $answer_id = $row['answer_id'];
                        $answer_text = $row['answer_text'];
                        echo "<label for='answer_$answer_id'>$answer_text</label>";
                        echo "<input type='radio' id='answer_$answer_id' name='question_$questions[$j]' value='$answer_id'> <br>";
                    }
                }
                echo "</div>";
            }
            echo "<input type='submit' value='submit'>";
            echo "</form>";

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $user_answers = [];
                $a = 1;
                foreach ($questions as $question_id) {
                    if (isset($_POST["question_$question_id"])) {
                        $user_answers[$a] = $_POST["question_$question_id"];
                    } else {
                        $user_answers[$question_id] = null;
                    }
                    $a++;
                }

                for ($l = 1; $l < count($questions) + 1; $l++) {

                    $a = $l-1;
                $query4 = "INSERT INTO user_quiz_answers (user_id, question_id, selected_answer_id) VALUES ($id_users, $question_id[$a], $user_answers[$l])";
                $result4 = $conn->query($query4);


                    if($user_answers[$l] == $correct_answers[$l] ){
                   $points++;
                    }
                }
                $query4 = "INSERT INTO user_quiz_attempts (user_id, quiz_id, score) VALUES ($id_users, $quiz_id, $points)";
                $result4 = $conn->query($query4);

                echo "Qeustions ";
                print_r($questions);
                echo " <br> Correct ";
                print_r($correct_answers);
                echo " <br>USEr ";
                print_r( $user_answers);

//        header("Location: QuizList.php");
            }
            break;
        case 2:
//
//            $correct_answers = [];
//
//
//            for ($k = 0; $k < count($questions); $k++) {
//                $query3 = "SELECT * FROM quiz_answers WHERE question_id = $questions[$k] AND is_correct = 1";
//                $result3 = $conn->query($query3);
//                $temp_answers = [];
//                $a = 0;
//                while ($row = $result3->fetch_assoc()) {
//                    $temp = $row['answer_id'];
//                     $temp_answers[$a]= $temp ;
//                     $a++;
//                }
//                $correct_answers[$k] = $temp_answers;
//            }
//


//            for ($m = 0; $m < count($questions); $m++) {
//                echo "<div>";
//                echo "<h3>$questions_text[$m]</h3>";
//                $query2 = "SELECT * FROM quiz_answers WHERE question_id = $questions[$m]";
//                $result2 = $conn->query($query2);
//                $answers = [];
//                if ($result2->num_rows > 0) {
//                    while ($row = $result2->fetch_assoc()) {
//                         $answer_id = $row['answer_id'];
//                        $answer_text = $row['answer_text'];
//                        echo "<label for='answer_$answer_id'>$answer_text</label>";
//                        echo "<input type='checkbox' id='answer_$answer_id' name='question_$questions[$m]' value='$answer_id'> <br>";
//
//                    }
//                }
//                echo "</div>";
//            }
//            echo "<input type='submit' value='submit'>";
//            echo "</form>";
//
//
//            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
//                $user_answers = [];
//                $a = 1;
//
//                for ($n = 0; $n < count($questions); $n++) {
//                    $temp_answers = $_POST["question_$questions[$n]"];
//                    var_dump($temp_answers);
//                    echo "<br>";
//                    for ($o = 0; $o < count($temp_answers); $o++) {
//                        $temp_answers[$o] = $_POST["question_$questions[$n]"];
//                    }
//                    $user_answers[$n] = $temp_answers;
//                    var_dump($user_answers);
//                }


//                foreach ($questions as $question_id) {
//
//                    var_dump($_POST["question_$answer_id"]);
//
//                    if (isset($_POST["question_$question_id"])) {
//                        $user_answers[$a] = $_POST["question_$question_id"];
//                    } else {
//                        $user_answers[$question_id] = null;
//                    }
//                    $a++;
//                }

//                for ($l = 1; $l < count($questions) + 1; $l++) {
//                    if($user_answers[$l] == $correct_answers[$l] ){
//                $a = $l-1;
//                $query4 = "INSERT INTO user_quiz_answers (user_id, question_id, selected_answer_id) VALUES ($id_users, $question_id[$a], $user_answers[$l])";
//                $result4 = $conn->query($query4);
//                        $points++;
////                    }
//                }
//                $query4 = "INSERT INTO user_quiz_attempts (user_id, quiz_id, score) VALUES ($id_users, $quiz_id, $points)";
//                $result4 = $conn->query($query4);
//
//                echo "Qeustions ";
//                print_r($questions);
//                echo " <br> Correct ";
//                print_r($correct_answers);
//                echo " <br>USEr ";
//                print_r( $user_answers);
//
////        header("Location: QuizList.php");
////            }
    ///
    ///
    ///
    ///


            $correct_answers = [];
            for ($k = 0; $k < count($questions); $k++) {
                $query3 = "SELECT * FROM quiz_answers WHERE question_id = ? AND is_correct = 1";
                $stmt3 = $conn->prepare($query3);
                $stmt3->bind_param('i', $questions[$k]);
                $stmt3->execute();
                $result3 = $stmt3->get_result();
                $temp_answers = [];
                while ($row = $result3->fetch_assoc()) {
                    $temp_answers[] = $row['answer_id'];
                }
                $correct_answers[$questions[$k]] = $temp_answers;
                $stmt3->close();
            }

// Generowanie formularza
            echo "<form action='' method='POST'>";
            for ($m = 0; $m < count($questions); $m++) {
                echo "<div>";
                echo "<h3>$questions_text[$m]</h3>";
                $query2 = "SELECT * FROM quiz_answers WHERE question_id = ?";
                $stmt2 = $conn->prepare($query2);
                $stmt2->bind_param('i', $questions[$m]);
                $stmt2->execute();
                $result2 = $stmt2->get_result();
                if ($result2->num_rows > 0) {
                    while ($row = $result2->fetch_assoc()) {
                        $answer_id = $row['answer_id'];
                        $answer_text = $row['answer_text'];
                        echo "<label for='answer_{$questions[$m]}_$answer_id'>$answer_text</label>";
                        echo "<input type='checkbox' id='answer_{$questions[$m]}_$answer_id' name='question_{$questions[$m]}[]' value='$answer_id'> <br>";
                    }
                }
                echo "</div>";
                $stmt2->close();
            }
            echo "<input type='submit' value='submit'>";
            echo "</form>";

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $user_answers = [];
                for ($n = 0; $n < count($questions); $n++) {
                    if (isset($_POST["question_{$questions[$n]}"])) {
                        $temp_answers = $_POST["question_{$questions[$n]}"];
                        $user_answers[$questions[$n]] = $temp_answers;
                    } else {
                        $user_answers[$questions[$n]] = [];
                    }
                }

                // Wyświetlenie odpowiedzi dla celów debugowania
                var_dump($user_answers);

                // Zapis odpowiedzi do bazy danych
                foreach ($user_answers as $question_id => $answers) {
                    foreach ($answers as $answer_id) {
                        $query = "INSERT INTO user_quiz_answers (user_id, question_id, answer_id) VALUES (?, ?, ?)";
                        $stmt = $conn->prepare($query);
                        $stmt->bind_param('iii', $id_users, $question_id, $answer_id);
                        $stmt->execute();
                    }
                }

                // Sprawdzenie poprawności odpowiedzi
                $correct_count = 0;
                foreach ($user_answers as $question_id => $answers) {
                    if (isset($correct_answers[$question_id])) {
                        if ($answers == $correct_answers[$question_id]) {
                            $correct_count++;
                        }
                    }
                }
                echo $correct_count;
                echo "Odpowiedzi zostały zapisane. Liczba poprawnych odpowiedzi: $correct_count";
            }


            break;
        case 3:
            $correct_answers = [];


            for ($k = 0; $k < count($questions); $k++) {
                $query3 = "SELECT * FROM quiz_answers WHERE question_id = $questions[$k] AND is_correct = 1";
                $result3 = $conn->query($query3);
                while ($row = $result3->fetch_assoc()) {
                    $correct_answers[$k + 1] = $row['answer_id'];
                }
            }
            var_dump($questions_images);
            for ($j = 0; $j < count($questions); $j++) {
                echo "<div>";
                echo "<h3>$questions_text[$j]</h3>";
                $query2 = "SELECT * FROM quiz_answers WHERE question_id = $questions[$j]";
                $result2 = $conn->query($query2);
                $answers = [];
                if ($result2->num_rows > 0) {
                    while ($row = $result2->fetch_assoc()) {
                        $answer_id = $row['answer_id'];
                        $answer_text = $row['answer_text'];
                        echo "<img src=\"$questions_images[$j]\">";
                        echo "<input type='text' id='answer_$answer_id' > <br>";
                    }
                }
                echo "</div>";
            }
            echo "<input type='submit' value='submit'>";
            echo "</form>";
            echo "Qeustions ";
            print_r($questions);
            echo " <br> Correct ";
            print_r($correct_answers);
            echo " <br>USEr ";
            print_r( $user_answers);

            break;

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
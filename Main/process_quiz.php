<?php
session_start();
include_once "Connect.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $quiz_id = 1; // Assuming you have the quiz_id available
    $user_id = 1; // Assuming you have the user_id available

    // Loop through the POST data to get the answers
    foreach ($_POST as $question_id => $answer_id) {
        $question_id = intval($question_id);
        $answer_id = intval($answer_id);

        // Save the user's answer to the database
        $query = "INSERT INTO user_answers (user_id, question_id, answer_id) VALUES ($user_id, $question_id, $answer_id)";
        $conn->query($query);
    }

    // Redirect to a confirmation page or back to the quiz
    header("Location: quiz_confirmation.php");
    exit();
}
?>
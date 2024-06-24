<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Zarejestruj się</title>
    <link rel="stylesheet" href="../CSS/Register.css">
</head>
<body>
<header>
    <h1><a href="Index.php">quizy.pl</a></h1>
</header>
<main>
<h2>Zarejestruj się</h2>
<form action="Register.php" method="POST">
    <div>
        <label for="first_name">Imię:</label>
        <input type="text" name="first_name" id="first_name" >
    </div>
    <div>
        <label for="last_name">Nazwisko:</label>
        <input type="text" name="last_name" id="last_name">
    </div>
    <div>
        <label for="user_name">Nazwa użytkownika</label>
        <input type="text" name="user_name" id="user_name">
    </div>
    <div>
        <label for="email]">Email</label>
        <input type="email" name="email" id="email">
    </div>
    <div>
        <label for="password">Hasło:</label>
        <input type="password" name="password" id="password">
    </div>
    <div>
        <label for="pasword1">Potwiedź hasło:</label>
        <input type="password" name="password1" id="pasword1">
    </div>
    <input type="submit" value="Zarejestruj się">

</form>
    <span>
        <h3>Masz już konto?</h3>
        <p><a href="Login.php">Zaloguj się</a></p>
    </span>
    <?php

    include_once "Connect.php";




    if (isset($_POST["first_name"]) && isset($_POST["last_name"]) && isset($_POST["user_name"]) && isset($_POST["email"])
    && isset($_POST["password"]) && isset($_POST["password1"]))
    {
        $first_name = $_POST['first_name'];
        $last_name = $_POST["last_name"];
        $user_name = $_POST["user_name"];
        $email = $_POST["email"];
        $password = $_POST["password"];
        $password1 = $_POST["password1"];

        $query = "SELECT * FROM users WHERE user_name = \"$user_name\"";
        $result = $conn->query($query);
        if ($result->num_rows > 0) {
            echo "<script>alert('Jest już taka nazwa użytkownika!');</script>";
        }
        else{

            $query = "SELECT * FROM users WHERE email = \"$email\" ";
            $result = $conn->query($query);
            if ($result->num_rows > 0) {
                echo "<script>alert('Email jest wykorzystany!');</script>";
                }
            else{
                if($password == $password1){
                    $role = 1;
                    $query = "INSERT INTO users(first_name, last_name, user_name, email, password, role) VALUES ('$first_name', '$last_name', '$user_name', '$email', '$password', $role)";
                    mysqli_query($conn, $query);


                }
                else{
                    echo "<script>alert('Hasła nie są takie same!');</script>";
                }
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


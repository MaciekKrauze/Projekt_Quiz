<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Zaloguj się</title>
    <link rel="stylesheet" href="../CSS/Login.css">
    <link rel="stylesheet" href="../CSS/General.css">

</head>
<body>
<header>
    <h1><a href="Index.php">quizy.pl</a></h1>
</header>
<main>

<form action="Login.php" method="POST">
    <div>
        <label for="user_name">Nazwa użytkownika:</label>
        <input type="text" name="user_name" id="user_name" >
    </div>
    <div>
        <label for="password">Hasło:</label>
        <input type="password" name="password" id="password">
    </div>
    <input type="submit" value="Zaloguj się">
</form>

<span>
    <h3>Nie masz konta?</h3>
    <p><a href="Register.php">Zarejestruj się</a></p>
</span>
</main>
<footer>
    <?php
    include 'Footer.php'
    ?>
</footer>
</body>
</html>

<?php
include_once "Connect.php";

    if(isset($_POST["user_name"]) && isset($_POST["password"])){
        $user_name_given = $_POST["user_name"];
        $password_given = $_POST["password"];
        $query = "SELECT * FROM users WHERE user_name = '$user_name_given'";

        $result = $conn->query($query);

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $id_users = $row['id_users'];
            $password = $row['password'];
            $role = $row['role'];

        }
    }
        if($password_given == $password){
            $_SESSION["id_users"] = $id_users ;
            $_SESSION["role"] = $role;
            header("Location: Index.php");
            exit;
        }
        else{
            echo "<script>alert('Błędne hasło!');</script>";

        }

    }

?>



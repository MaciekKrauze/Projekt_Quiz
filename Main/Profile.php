<?php
session_start();
include_once "Connect.php";
$id_users = $_SESSION['id_users'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Profil</title>
    <title>My Website</title>
    <link rel="stylesheet" href="">
</head>
<body>
<header>
    <?php
//    include 'Header.php'
    ?>
</header>
<main>
    <h2>Profil</h2>
<?php
    if (isset($_SESSION["id_users"])){

    $query = "SELECT * FROM users WHERE id_users = '$id_users'";

    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $first_name = $row['first_name'];
            $last_name = $row['last_name'];
            $user_name = $row['user_name'];
            $email = $row['email'];
            $password = $row['password'];
            $avatar = $row['avatar'];
            $created_at = $row['created_at'];
        }

        echo "<section>";
        echo "<h3>Imię</h3>";
        echo "<p>$first_name</p>";
        echo "</section>";

        echo "<section>";
        echo "<h3>Nazwisko</h3>";
        echo "<p>$last_name</p>";
        echo "</section>";

        echo "<section>";
        echo "<h3>Nazwa użytkownika</h3>";
        echo "<p>$user_name</p>";
        echo "</section>";

        echo "<section>";
        echo "<h3>Email</h3>";
        echo "<p>$email</p>";
        echo "</section>";

        echo "<section>";
        echo "<h3>Hasło</h3>";
        echo "<p>$password </p>";
        echo "</section>";

        echo "<section>";
        echo "<h3>Avatar</h3>";
        echo "<img src='$avatar' alt=\"Avatar\">";
        echo "</section>";

        echo "<section>";
        echo "<h3>Data stworzenia konta</h3>";
        echo "<p> $created_at </p>";
        echo "</section>";
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


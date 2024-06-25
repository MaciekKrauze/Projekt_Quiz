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
    <link rel="stylesheet" href="../CSS/Profile.css">
    <link rel="stylesheet" href="../CSS/General.css">

</head>
<body>
<header>
    <h1><a href="Index.php">quizy.pl</a></h1>
</header>
<main>
    <h2>Profil</h2>
    <?php
    if (isset($_SESSION["id_users"])) {

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
            ?>
            <form method="post" action="Profile.php">
                <section>
                    <h3>Imię</h3>
                    <input type="text" name="first_name" value="<?php echo $first_name; ?>">
                </section>
                <section>
                    <h3>Nazwisko</h3>
                    <input type="text" name="last_name" value="<?php echo $last_name; ?>">
                </section>
                <section>
                    <h3>Nazwa użytkownika</h3>
                    <input type="text" name="user_name" value="<?php echo $user_name; ?>">
                </section>
                <section>
                    <h3>Email</h3>
                    <input type="email" name="email" value="<?php echo $email; ?>">
                </section>
                <section>
                    <h3>Hasło</h3>
                    <input type="password" name="password" value="<?php echo $password; ?>">
                </section>
                <section>
                    <h3>Avatar</h3>
                    <input type="file" name="avatar">
                    <img src="../Images/User_images/<?php echo $avatar;  ?>" alt="Avatar" >
                </section>
                <section>
                    <h3>Data stworzenia konta</h3>
                    <p><?php echo $created_at; ?></p>
                </section>
                <section>
                    <input type="submit" value="Zaktualizuj profil">
                </section>
            </form>
            <?php
        }
    }
    ?>
</main>
<footer>
    <?php
    // include 'Footer.php';
    ?>
</footer>
</body>
</html>
<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $first_name = $_POST['first_name'];
    $last_name= $_POST['last_name'];
    $user_name= $_POST['user_name'];
    $email= $_POST['email'];
    $password= $_POST['password'];
    $avatar= $_POST['avatar'];
    var_dump($avatar);
    $query1 = "UPDATE users SET first_name = '$first_name', last_name = '$last_name', user_name = '$user_name', email = '$email', 
                 password = '$password', avatar = '$avatar'  WHERE (id_users = $id_users)";

    $result = $conn->query($query1);
}
?>
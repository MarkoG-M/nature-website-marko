<?php
session_start();
require "db.php";

$error = "";

if($_SERVER["REQUEST_METHOD"] === "POST"){

    $email = $_POST["email"];
    $password = $_POST["password"];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if($user && password_verify($password, $user["password"])){

        $_SESSION["user_id"] = $user["id"];
        $_SESSION["username"] = $user["username"];

        header("Location: /nature/homepage/home.php");
        exit;

    } else {
        $error = "Falsche Login-Daten!";
    }
}
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Login</title>

    <link rel="stylesheet" href="/nature/css/auth.css">
    <link rel="stylesheet" href="/nature/css/general.css">
    <link rel="stylesheet" href="/nature/css/header.css">
</head>

<body>

<?php include "header.php"; ?>

<div class="auth-container">

    <h1>Login</h1>

    <form method="POST">

        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Passwort" required>

        <button type="submit">Einloggen</button>

    </form>

    <p class="error"><?php echo $error; ?></p>

</div>

</body>
</html>
<?php
session_start();
require "db.php";

if($_SERVER["REQUEST_METHOD"] === "POST"){

    $username = $_POST["username"];
    $email = $_POST["email"];
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT);

    $stmt = $pdo->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
    $stmt->execute([$username, $email, $password]);

    header("Location: /nature/login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Register</title>

    <link rel="stylesheet" href="/nature/css/auth.css">
    <link rel="stylesheet" href="/nature/css/general.css">
    <link rel="stylesheet" href="/nature/css/header.css">
</head>

<body>

<?php include "header.php"; ?>

<div class="auth-container">

    <h1>Register</h1>

    <form method="POST">

        <input name="username" placeholder="Username" required>
        <input name="email" type="email" placeholder="Email" required>
        <input name="password" type="password" placeholder="Passwort" required>

        <button type="submit">Account erstellen</button>

    </form>

</div>

</body>
</html>
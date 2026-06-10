<?php
session_start();
require "db.php";

if(!isset($_SESSION["user_id"])){
    header("Location: /nature/login.php");
    exit;
}

$userId = (int)$_SESSION["user_id"];
$error = "";
$message = "";

$stmt = $pdo->prepare("SELECT id, username, email FROM users WHERE id = ?");
$stmt->execute([$userId]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if(!$user){
    session_destroy();
    header("Location: /nature/login.php");
    exit;
}

if($_SERVER["REQUEST_METHOD"] === "POST"){
    $username = trim($_POST["username"] ?? "");
    $email = trim($_POST["email"] ?? "");

    if($username === "" || $email === ""){
        $error = "Bitte fülle alle Felder aus.";
    } elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $error = "Bitte gib eine gültige Email-Adresse ein.";
    } else {
        $emailCheck = $pdo->prepare("SELECT id FROM users WHERE email = ? AND id != ? LIMIT 1");
        $emailCheck->execute([$email, $userId]);

        if($emailCheck->fetchColumn()){
            $error = "Diese Email wird bereits benutzt.";
        } else {
            $updateStmt = $pdo->prepare("UPDATE users SET username = ?, email = ? WHERE id = ?");
            $updateStmt->execute([$username, $email, $userId]);

            $_SESSION["username"] = $username;

            $user["username"] = $username;
            $user["email"] = $email;
            $message = "Profil wurde aktualisiert.";
        }
    }
}

function e($value){
    return htmlspecialchars((string)$value, ENT_QUOTES, "UTF-8");
}
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Profil bearbeiten</title>

    <link rel="stylesheet" href="/nature/css/auth.css">
    <link rel="stylesheet" href="/nature/css/general.css">
    <link rel="stylesheet" href="/nature/css/header.css">
</head>

<body>

<?php include "header.php"; ?>

<div class="auth-container">

    <h1>Profil bearbeiten</h1>

    <form method="POST">

        <input name="username" placeholder="Username" value="<?php echo e($user["username"]); ?>" required>
        <input name="email" type="email" placeholder="Email" value="<?php echo e($user["email"]); ?>" required>

        <button type="submit">Änderungen speichern</button>

    </form>

    <?php if($message): ?>
        <p class="success"><?php echo e($message); ?></p>
    <?php endif; ?>

    <?php if($error): ?>
        <p class="error"><?php echo e($error); ?></p>
    <?php endif; ?>

    <a href="/nature/homepage/home.php">Zurück zur Startseite</a>

</div>

</body>
</html>

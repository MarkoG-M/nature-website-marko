<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kontakt</title>
    <link rel="stylesheet" href="kontakt.css">
    <link rel="stylesheet" href="header.css">
</head>
<body>
    <?php session_start(); ?>
<?php include "../header.php"; ?>

    <main class="main">
        <div class="contact-card">
            <h2 class="card-title">Schreibe uns eine Nachricht</h2>
            <form action="javascript:void(0);" method="post" class="contact-form">
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" id="name" name="name" placeholder="Dein Name" required>
                </div>
                <div class="form-group">
                    <label for="email">E-Mail</label>
                    <input type="email" id="email" name="email" placeholder="Deine E-Mail-Adresse" required>
                </div>
                <div class="form-group">
                    <label for="message">Nachricht</label>
                    <textarea id="message" name="message" rows="5" placeholder="Deine Nachricht" required></textarea>
                </div>
                <button type="button" class="submit-button">Absenden</button>
            </form>
        </div>
    </main>

    <footer class="footer">
        <div class="container">
            <p class="footer-text">© 2025 Nature Calls. Alle Rechte vorbehalten.</p>
        </div>
    </footer>
</body>
</html>

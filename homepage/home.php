<!DOCTYPE html>
<html lang="de">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Landing Page mit Videos</title>
    <link rel="stylesheet" href="css/header.css" />
    <link rel="stylesheet" href="css/general.css" />
    <link rel="stylesheet" href="css/hero.css" />
  </head>
  <body>

    <?php session_start(); ?>
<?php include "../header.php"; ?>

    <div class="video-container">
      <video
        class="landing-video"
        id="landing-video"
        autoplay
        muted
        playsinline
        preload="auto"
      ></video>
      <div class="overlay"></div>
      <div class="hero-text">
        <h1>Entdecken Sie die atemberaubendsten Orte der Erde</h1>
      </div>
    </div>

    <script src="js/homepage.js"></script>
  </body>
</html>

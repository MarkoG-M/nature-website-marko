<!DOCTYPE html>
<html lang="de">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <link rel="stylesheet" href="css/header.css">
  <link rel="stylesheet" href="css/general.css">
  <link rel="stylesheet" href="css/hero.css">
  <link rel="stylesheet" href="css/neuseeland.css">

  <script defer src="js/scroll-animation-explore.js"></script>

  <title>Neuseeland</title>
</head>

<body>

  <?php session_start(); ?>
<?php include "../header.php"; ?>

  <div class="landingpage-image-container">
    <img class="hero-image" src="images/neuseeland-hero.jpg" alt="">

    <div class="text-image">
      <h1>Neuseeland</h1>
      <p>Abenteuer, Natur und unberührte Landschaften</p>
    </div>
  </div>

  <p class="uberschrift">Die schönsten Orte</p>

  <section class="grid">

    <div class="card reveal">
      <div class="img-box img-large">
        <img src="images/milford-sound.jpg" alt="">
      </div>

      <div class="text-box">
        <h3>Milford Sound</h3>
        <p>
          Einer der berühmtesten Fjorde der Welt mit gewaltigen Bergen,
          Wasserfällen und einzigartiger Natur.
        </p>
      </div>
    </div>

    <div class="card reveal reverse">
      <div class="img-box img-medium">
        <img src="images/queenstown.jpg" alt="">
      </div>

      <div class="text-box">
        <h3>Queenstown</h3>
        <p>
          Die Abenteuerhauptstadt Neuseelands bietet Bungee-Jumping,
          Wandern, Skifahren und spektakuläre Ausblicke.
        </p>
      </div>
    </div>

    <div class="card reveal">
      <div class="img-box img-wide">
        <img src="images/mount-cook.jpg" alt="">
      </div>

      <div class="text-box">
        <h3>Mount Cook</h3>
        <p>
          Mit 3.724 Metern ist der Mount Cook der höchste Berg des Landes
          und ein Paradies für Naturliebhaber.
        </p>
      </div>
    </div>

  </section>

  <section class="facts">

    <div class="fact-card reveal">
      <div class="number">01</div>
      <h4>Zwei Hauptinseln</h4>
      <p>Neuseeland besteht hauptsächlich aus einer Nord- und Südinsel.</p>
    </div>

    <div class="fact-card reveal">
      <div class="number">02</div>
      <h4>Herr der Ringe</h4>
      <p>Viele Szenen der bekannten Filmreihe wurden hier gedreht.</p>
    </div>

    <div class="fact-card reveal">
      <div class="number">03</div>
      <h4>Einzigartige Natur</h4>
      <p>Von Fjorden bis Vulkanen bietet Neuseeland enorme Vielfalt.</p>
    </div>

  </section>

  <section class="quote-slider reveal">

    <button class="arrow left" onclick="changeQuote(-1)">‹</button>

    <div class="quote-box">

      <h2 id="quoteText">
        „Neuseeland ist die letzte große Wildnis unserer modernen Welt.“
      </h2>

    </div>

    <button class="arrow right" onclick="changeQuote(1)">›</button>

  </section>

</body>
</html>
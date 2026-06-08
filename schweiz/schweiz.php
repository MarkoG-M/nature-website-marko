<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <link rel="stylesheet" href="css/header.css">
  <link rel="stylesheet" href="css/general.css">
  <link rel="stylesheet" href="css/hero.css">
  <link rel="stylesheet" href="css/schweiz.css">

  <script defer src="js/scroll-animation-explore.js"></script>

  <title>Schweiz</title>
</head>

<body>

  <?php session_start(); ?>
<?php include "../header.php"; ?>

  <!-- HERO -->
  <div class="landingpage-image-container">
    <img class="hero-image" src="images/schweiz-hero.jpg" alt="">

    <div class="text-image">
      <h1>Schweiz</h1>
      <p>Berge, Seen und Natur</p>
    </div>
  </div>

  <!-- TITLE -->
  <p class="uberschrift">Die schönsten Orte</p>

  <!-- CARDS -->
  <section class="grid">

    <div class="card reveal">
      <div class="img-box img-large">
        <img src="images/alpen.jpg" alt="">
      </div>

      <div class="text-box">
        <h3>Schweizer Alpen</h3>
        <p>
          Die Alpen prägen die Landschaft der Schweiz mit riesigen Bergen,
          Gletschern und atemberaubenden Ausblicken.
        </p>
      </div>
    </div>

    <div class="card reveal reverse">
      <div class="img-box img-medium">
        <img src="images/luzern.jpg" alt="">
      </div>

      <div class="text-box">
        <h3>Luzern</h3>
        <p>
          Die Stadt Luzern verbindet historische Architektur mit
          wunderschönen Seen und Berglandschaften.
        </p>
      </div>
    </div>

    <div class="card reveal">
      <div class="img-box img-wide">
        <img src="images/matterhorn.jpg" alt="">
      </div>

      <div class="text-box">
        <h3>Matterhorn</h3>
        <p>
          Das Matterhorn zählt zu den bekanntesten Bergen der Welt
          und ist das Wahrzeichen der Schweiz.
        </p>
      </div>
    </div>

  </section>

  <!-- FACTS -->
  <section class="facts">

    <div class="fact-card reveal">
      <div class="number">01</div>
      <h4>Hohe Berge</h4>
      <p>Die Schweiz besitzt über 4000 Berge über 2000 Meter Höhe.</p>
    </div>

    <div class="fact-card reveal">
      <div class="number">02</div>
      <h4>Saubere Seen</h4>
      <p>Viele Seen der Schweiz zählen zu den saubersten Europas.</p>
    </div>

    <div class="fact-card reveal">
      <div class="number">03</div>
      <h4>Natur & Ruhe</h4>
      <p>Die Schweiz ist bekannt für ihre ruhigen Landschaften und Natur.</p>
    </div>

  </section>

  <!-- QUOTE -->
  <section class="quote-slider reveal">

    <button class="arrow left" onclick="changeQuote(-1)">‹</button>

    <div class="quote-box">

      <h2 id="quoteText">
        „Die Berge rufen und ich muss gehen.“
      </h2>

    </div>

    <button class="arrow right" onclick="changeQuote(1)">›</button>

  </section>

</body>
</html>
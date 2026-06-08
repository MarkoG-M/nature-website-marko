<!DOCTYPE html>
<html lang="de">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <link rel="stylesheet" href="css/header.css">
  <link rel="stylesheet" href="css/general.css">
  <link rel="stylesheet" href="css/hero.css">
  <link rel="stylesheet" href="css/japan.css">

  <script defer src="js/scroll-animation-explore.js"></script>

  <title>Japan</title>
</head>

<body>

  <?php session_start(); ?>
<?php include "../header.php"; ?>

  <div class="landingpage-image-container">
    <img class="hero-image" src="images/japan-hero.jpg" alt="">

    <div class="text-image">
      <h1>Japan</h1>
      <p>Tradition trifft Zukunft</p>
    </div>
  </div>

  <p class="uberschrift">Die schönsten Orte</p>

  <section class="grid">

    <div class="card reveal">
      <div class="img-box img-large">
        <img src="images/tokio.jpg" alt="">
      </div>

      <div class="text-box">
        <h3>Tokio</h3>
        <p>
          Tokio verbindet futuristische Architektur mit traditionellen
          Tempeln und zählt zu den faszinierendsten Metropolen der Welt.
        </p>
      </div>
    </div>

    <div class="card reveal reverse">
      <div class="img-box img-medium">
        <img src="images/kyoto.jpg" alt="">
      </div>

      <div class="text-box">
        <h3>Kyoto</h3>
        <p>
          Kyoto begeistert mit historischen Tempeln, Bambuswäldern,
          Gärten und einer einzigartigen kulturellen Atmosphäre.
        </p>
      </div>
    </div>

    <div class="card reveal">
      <div class="img-box img-wide">
        <img src="images/fuji.jpg" alt="">
      </div>

      <div class="text-box">
        <h3>Mount Fuji</h3>
        <p>
          Der Mount Fuji ist das Wahrzeichen Japans und bietet
          spektakuläre Ausblicke auf die umliegende Landschaft.
        </p>
      </div>
    </div>

  </section>

  <section class="facts">

    <div class="fact-card reveal">
      <div class="number">01</div>
      <h4>Inselstaat</h4>
      <p>Japan besteht aus über 14.000 Inseln im Pazifischen Ozean.</p>
    </div>

    <div class="fact-card reveal">
      <div class="number">02</div>
      <h4>Kirschblüte</h4>
      <p>Die Sakura-Saison zählt zu den bekanntesten Naturereignissen Japans.</p>
    </div>

    <div class="fact-card reveal">
      <div class="number">03</div>
      <h4>Hochgeschwindigkeitszüge</h4>
      <p>Die Shinkansen-Züge gehören zu den schnellsten der Welt.</p>
    </div>

  </section>

  <section class="quote-slider reveal">

    <button class="arrow left" onclick="changeQuote(-1)">‹</button>

    <div class="quote-box">

      <h2 id="quoteText">
        „Reisen lässt uns erkennen, dass wir alle Teil derselben Welt sind.“
      </h2>

    </div>

    <button class="arrow right" onclick="changeQuote(1)">›</button>

  </section>

</body>
</html>
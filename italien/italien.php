<!DOCTYPE html>
<html lang="de">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <link rel="stylesheet" href="css/header.css">
  <link rel="stylesheet" href="css/general.css">
  <link rel="stylesheet" href="css/hero.css">
  <link rel="stylesheet" href="css/italien.css">

  <script defer src="js/scroll-animation-explore.js"></script>

  <title>Italien</title>
</head>

<body>

  <?php session_start(); ?>
<?php include "../header.php"; ?>

  <div class="landingpage-image-container">
    <img class="hero-image" src="images/italien-hero.jpg" alt="">

    <div class="text-image">
      <h1>Italien</h1>
      <p>Kultur, Geschichte und mediterranes Lebensgefühl</p>
    </div>
  </div>

  <p class="uberschrift">Die schönsten Orte</p>

  <section class="grid">

    <div class="card reveal">
      <div class="img-box img-large">
        <img src="images/rom.jpg" alt="">
      </div>

      <div class="text-box">
        <h3>Rom</h3>
        <p>
          Die ewige Stadt begeistert mit antiken Bauwerken,
          beeindruckender Geschichte und weltberühmten Sehenswürdigkeiten
          wie dem Kolosseum und dem Petersdom.
        </p>
      </div>
    </div>

    <div class="card reveal reverse">
      <div class="img-box img-medium">
        <img src="images/venedig.jpg" alt="">
      </div>

      <div class="text-box">
        <h3>Venedig</h3>
        <p>
          Die Lagunenstadt ist bekannt für ihre romantischen Kanäle,
          historischen Paläste und einzigartigen Gondelfahrten.
        </p>
      </div>
    </div>

    <div class="card reveal">
      <div class="img-box img-wide">
        <img src="images/toskana.jpg" alt="">
      </div>

      <div class="text-box">
        <h3>Toskana</h3>
        <p>
          Sanfte Hügel, Weinberge und malerische Dörfer machen
          die Toskana zu einer der schönsten Regionen Europas.
        </p>
      </div>
    </div>

  </section>

  <section class="facts">

    <div class="fact-card reveal">
      <div class="number">01</div>
      <h4>UNESCO-Welterbe</h4>
      <p>Italien besitzt mehr UNESCO-Welterbestätten als jedes andere Land.</p>
    </div>

    <div class="fact-card reveal">
      <div class="number">02</div>
      <h4>Berühmte Küche</h4>
      <p>Pizza, Pasta und Gelato gehören zu den bekanntesten Spezialitäten der Welt.</p>
    </div>

    <div class="fact-card reveal">
      <div class="number">03</div>
      <h4>Mittelmeer</h4>
      <p>Über 7.500 Kilometer Küste prägen Italiens vielfältige Landschaft.</p>
    </div>

  </section>

  <section class="quote-slider reveal">

    <button class="arrow left" onclick="changeQuote(-1)">‹</button>

    <div class="quote-box">

      <h2 id="quoteText">
        „Wer Italien bereist, reist durch Geschichte, Kunst und Lebensfreude.“
      </h2>

    </div>

    <button class="arrow right" onclick="changeQuote(1)">›</button>

  </section>

</body>
</html>
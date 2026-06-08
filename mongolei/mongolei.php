<!DOCTYPE html>
<html lang="de">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <link rel="stylesheet" href="css/header.css">
  <link rel="stylesheet" href="css/general.css">
  <link rel="stylesheet" href="css/hero.css">
  <link rel="stylesheet" href="css/mongolei.css">

  <script defer src="js/scroll-animation-explore.js"></script>

  <title>Mongolei</title>
</head>

<body>

  <?php session_start(); ?>
<?php include "../header.php"; ?>

  <div class="landingpage-image-container">
    <img class="hero-image" src="images/mongolei-hero.jpg" alt="">

    <div class="text-image">
      <h1>Mongolei</h1>
      <p>Endlose Steppen und grenzenlose Freiheit</p>
    </div>
  </div>

  <p class="uberschrift">Die schönsten Orte</p>

  <section class="grid">

    <div class="card reveal">
      <div class="img-box img-large">
        <img src="images/gobi.jpg" alt="">
      </div>

      <div class="text-box">
        <h3>Gobi-Wüste</h3>
        <p>
          Die Gobi zählt zu den größten Wüsten der Welt und beeindruckt
          mit riesigen Dünen, Felsformationen und einzigartigen Landschaften.
        </p>
      </div>
    </div>

    <div class="card reveal reverse">
      <div class="img-box img-medium">
        <img src="images/ulaanbaatar.jpg" alt="">
      </div>

      <div class="text-box">
        <h3>Ulaanbaatar</h3>
        <p>
          Die Hauptstadt verbindet moderne Entwicklung mit der reichen
          Geschichte und Kultur der mongolischen Nomaden.
        </p>
      </div>
    </div>

    <div class="card reveal">
      <div class="img-box img-wide">
        <img src="images/steppe.jpg" alt="">
      </div>

      <div class="text-box">
        <h3>Mongolische Steppe</h3>
        <p>
          Die weiten Graslandschaften der Mongolei gehören zu den
          unberührtesten Naturgebieten der Erde.
        </p>
      </div>
    </div>

  </section>

  <section class="facts">

    <div class="fact-card reveal">
      <div class="number">01</div>
      <h4>Dünn besiedelt</h4>
      <p>Die Mongolei hat eine der niedrigsten Bevölkerungsdichten der Welt.</p>
    </div>

    <div class="fact-card reveal">
      <div class="number">02</div>
      <h4>Nomadenkultur</h4>
      <p>Viele Familien leben noch heute traditionell in Jurten.</p>
    </div>

    <div class="fact-card reveal">
      <div class="number">03</div>
      <h4>Dschingis Khan</h4>
      <p>Die Mongolei war das Zentrum des größten zusammenhängenden Reiches der Geschichte.</p>
    </div>

  </section>

  <section class="quote-slider reveal">

    <button class="arrow left" onclick="changeQuote(-1)">‹</button>

    <div class="quote-box">

      <h2 id="quoteText">
        „In der Weite der Steppe findet man eine Freiheit, die anderswo selten geworden ist.“
      </h2>

    </div>

    <button class="arrow right" onclick="changeQuote(1)">›</button>

  </section>

</body>
</html>
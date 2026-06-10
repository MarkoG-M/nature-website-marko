<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <link rel="stylesheet" href="css/header.css">
  <link rel="stylesheet" href="css/general.css">
  <link rel="stylesheet" href="css/hero.css">
  <link rel="stylesheet" href="css/china.css">

  <script defer src="js/scroll-animation-explore.js"></script>

  <title>China</title>
</head>

<body>
<?php session_start(); ?>
  <?php include "../header.php"; ?>
<div class="landingpage-image-container">
    <img class="hero-image" src="images/china-mauer-gross.jpg" alt="">
    <div class="text-image">
      <h1>China</h1>
      <p>Geschichte als Land selbst</p>
    </div>
    <div class="overlay"></div>
  </div>
<p class="uberschrift">Die coolsten Attraktionen</p>
<section class="grid">

    <div class="card reveal">
      <div class="img-box img-large">
        <img src="images/terracota.jpg" alt="">
      </div>
      <div class="text-box">
        <h3>Terracotta Armee</h3>
        <p>
          Die Terrakotta-Armee ist ein archäologisches Wunder aus Tausenden Tonfiguren, die den ersten Kaiser Chinas schützen sollten.
        </p>
      </div>
    </div>

    <div class="card reveal reverse">
      <div class="img-box img-medium">
        <img src="images/nationalparkforestchina.jpg" alt="">
      </div>
      <div class="text-box">
        <h3>Zhangjiajie National Forest Park</h3>
        <p>
          Riesige Sandstein-Säulen, die wie schwebende Berge wirken und die Avatar-Welt inspirierten.
        </p>
      </div>
    </div>

    <div class="card reveal">
      <div class="img-box img-wide">
        <img src="images/geoparkchina.jpg" alt="">
      </div>
      <div class="text-box">
        <h3>Zhangye Danxia Geopark</h3>
        <p>
          Farbige Gesteinsformationen, die über Millionen Jahre durch Mineralien entstanden sind.
        </p>
      </div>
    </div>

  </section>
<section class="facts">

    <div class="fact-card reveal">
      <div class="number">01</div>
      <h4>UNESCO Weltrekord</h4>
      <p>China besitzt eine der größten Anzahl an UNESCO-Welterbestätten weltweit.</p>
    </div>

    <div class="fact-card reveal">
      <div class="number">02</div>
      <h4>Historische Tiefe</h4>
      <p>Über 4000 Jahre dokumentierte Zivilisationsgeschichte prägen das Land.</p>
    </div>

    <div class="fact-card reveal">
      <div class="number">03</div>
      <h4>Extreme Landschaften</h4>
      <p>Von Wüsten bis Regenwäldern – China hat nahezu jede Klimazone.</p>
    </div>

  </section>
<section class="quote reveal">
    <h2>
      „Reisen ist nicht das Entdecken neuer Orte, sondern das Sehen mit neuen Augen.“
    </h2>
  </section>

</body>
</html>
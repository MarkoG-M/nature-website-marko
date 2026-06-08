<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/header.css">
  <link rel="stylesheet" href="css/general.css">
  <link rel="stylesheet" href="css/heropage.css">
  <link rel="stylesheet" href="css/explore-places.css">
  <link rel="stylesheet" href="css/scroll-animation.css">
  <script defer src="js/scroll-animation-explore.js"></script>
  <title>Explore</title>
</head>
<body>

  <?php session_start(); ?>
<?php include "../header.php"; ?>

  <div class="landingpage-image-container">
    <img class="hero-image" src="../explorepage/images-hero/2400-julian-alps-mountains.jpg" alt="">
    <div class="text-image">
      <h1>Entdecke die Welt</h1>
      <p>Entdecken Sie atemberaubende Reiseziele und unvergessliche Erlebnisse</p>
    </div>
    <div class="overlay"></div>
  </div>

  <h1 class="uberschrift">Vorschau</h1>


  <div class="places-container">
    <div class="place-box">
      <a href="../china/china.php"><img src="places-images/china-mauer-klein.jpg" alt=""></a>
      <h3>China</h3>
      <p>Vom majestätischen Yangtse bis zur Stille der Seidenstraße – China ist ein Land, das in jedem Winkel Geschichte atmet.</p>
      <a href="../flights/flights.php?country=china">
        <button>Flug buchen</button>
      </a>
    </div>
    <div class="place-box">
      <a href="../schweiz/schweiz.php"><img src="places-images/swiss-alps-small.jpg" alt=""></a>
      <h3>Schweiz</h3>
      <p>In den Alpen, wo die Gletscher flüstern, liegt eine unberührte Ruhe, die das Herz erobert.</p>
      <a href="../flights/flights.php?country=schweiz">
        <button>Flug buchen</button>
      </a>
    </div>
    <div class="place-box">
      <a href="../japan/japan.php"><img src="places-images/Japanese-Woods-small.jpg" alt=""></a>
      <h3>Japan</h3>
      <p>Zwischen Kirschblüten und Zen-Gärten verschmilzt Vergangenheit und Gegenwart in Japans stiller Eleganz.</p>
      <a href="../flights/flights.php?country=japan">
        <button>Flug buchen</button>
      </a>
    </div>
    <div class="place-box">
      <a href="../italien/italien.php"><img src="places-images/italien-kolosseum-klein.jpg" alt=""></a>
      <h3>Italien</h3>
      <p>Die sanften Hügel der Toskana, die glitzernden Kanäle Venedigs – Italien ist ein Gedicht aus Kunst und Kultur.</p>
      <a href="../flights/flights.php?country=italien">
        <button>Flug buchen</button>
      </a>
    </div>
    <div class="place-box">
      <a href="../neuseeland/neuseeland.php"><img src="places-images/neuseeland-small.jpg" alt=""></a>
      <h3>Neuseeland</h3>
      <p>Zwischen grünen Fjorden und vulkanischen Gipfeln, wo der Wind das Land erzählt, lebt die Magie der Erde.</p>
      <a href="../flights/flights.php?country=neuseeland">
        <button>Flug buchen</button>
      </a>
    </div>
    <div class="place-box">
      <a href="../mongolei/mongolei.php"><img src="places-images/mongolei-wuste-klein.jpg" alt=""></a>
      <h3>Mongolei</h3>
      <p>Endlose Steppen, die im goldenen Sonnenuntergang verschwimmen – in der Mongolei spürt man das Erbe der Weite.</p>
      <a href="../flights/flights.php?country=mongolei">
        <button>Flug buchen</button>
      </a>
    </div>
  </div>
</body>
</html>
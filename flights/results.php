<?php

require "../flight_api.php";

$country = $_GET['country'] ?? '';
$departure = $_GET['departure'] ?? '';
$outbound = $_GET['outbound'] ?? '';
$return = $_GET['return'] ?? '';
$sort = $_GET['sort'] ?? '';

$countryCities = [
    "japan" => "Tokyo",
    "china" => "Beijing",
    "schweiz" => "Zurich",
    "italien" => "Rome",
    "neuseeland" => "Auckland",
    "mongolei" => "Ulaanbaatar"
];

$airportTest = searchAirport($departure);

$fromAirport = searchAirport($departure);

$toAirport = searchAirport(
    $countryCities[$country]
);

echo "<pre>";
print_r($toAirport);
echo "</pre>";
exit;

$from = $fromAirport["data"][1]["navigation"]["relevantFlightParams"];
$to = $toAirport["data"][0]["navigation"]["relevantFlightParams"];

$data = searchFlights(

    $from["skyId"],
    $from["entityId"],

    $to["skyId"],
    $to["entityId"],

    $outbound
);

$flights = [];

if(isset($data["data"]["itineraries"])){

    foreach($data["data"]["itineraries"] as $item){

        $leg = $item["legs"][0];

        $priceText = $item["price"]["formatted"] ?? "0";

        preg_match('/[\d\.]+/', $priceText, $matches);

        $price = isset($matches[0])
            ? floatval($matches[0])
            : 0;

        $flights[] = [

            "city" => $leg["destination"]["city"] ?? "Unbekannt",

            "price" => $price,

            "priceFormatted" => $priceText,

            "airline" =>
                $leg["carriers"]["marketing"][0]["name"]
                ?? "Airline",

            "duration" =>
                round(
                    ($leg["durationInMinutes"] ?? 0) / 60,
                    1
                ),

            "stops" =>
                max(
                    count($leg["segments"] ?? []) - 1,
                    0
                ),

            "departureTime" =>
                $leg["departure"] ?? "",

            "arrivalTime" =>
                $leg["arrival"] ?? ""
        ];
    }
}

if($sort == "price_asc"){
    usort(
        $flights,
        fn($a,$b) => $a["price"] <=> $b["price"]
    );
}

if($sort == "price_desc"){
    usort(
        $flights,
        fn($a,$b) => $b["price"] <=> $a["price"]
    );
}

?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Flüge</title>

    <link rel="stylesheet" href="css/results.css">
</head>
<body>

<h1>Flüge nach <?php echo ucfirst($country); ?></h1>

<div class="info">
    <p><strong>Abflug:</strong> <?php echo $departure; ?></p>
    <p><strong>Hinflug:</strong> <?php echo $outbound; ?></p>
    <p><strong>Rückflug:</strong> <?php echo $return; ?></p>
</div>

<form method="GET" class="sort-form">

    <input type="hidden" name="country" value="<?php echo $country; ?>">
    <input type="hidden" name="departure" value="<?php echo $departure; ?>">
    <input type="hidden" name="outbound" value="<?php echo $outbound; ?>">
    <input type="hidden" name="return" value="<?php echo $return; ?>">

    <select name="sort">
        <option value="">Sortieren</option>
        <option value="price_asc">Preis aufsteigend</option>
        <option value="price_desc">Preis absteigend</option>
    </select>

    <button type="submit">Anwenden</button>

</form>

<div class="flights-container">

<?php foreach($flights as $flight): ?>

    <div class="flight-card">

        <div class="top-row">
            <h3><?php echo $departure; ?> → <?php echo $flight['city']; ?></h3>

            <div class="price-badge">
                <?php echo $flight['priceFormatted']; ?>
            </div>
        </div>

        <div class="airline">
            ✈ <?php echo $flight['airline']; ?>
        </div>

        <div class="details">
            <p>⏱ Dauer: ca. <?php echo $flight['duration']; ?>h</p>

            <p>
            🛫 <?php echo date("H:i", strtotime($flight['departureTime'])); ?>
            </p>

            <p>
            🛬 <?php echo date("H:i", strtotime($flight['arrivalTime'])); ?>
            </p>

            <p>
                <?php if($flight['stops'] == 0): ?>
                    🟢 Direktflug
                <?php else: ?>
                    🟠 <?php echo $flight['stops']; ?> Stop(s)
                <?php endif; ?>
            </p>

            <p>📅 <?php echo $outbound; ?> → <?php echo $return; ?></p>
        </div>

        <button>In Warenkorb</button>

    </div>

<?php endforeach; ?>

</div>

</body>
</html>
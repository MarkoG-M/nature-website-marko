<?php

session_start();
require "../flight_api.php";

$country = strtolower(trim($_GET['country'] ?? ''));
$departure = $_GET['departure'] ?? '';
$outbound = $_GET['outbound'] ?? '';
$return = $_GET['return'] ?? '';
$sort = $_GET['sort'] ?? '';
$currency = "EUR";
$error = "";

$countryAirports = [
    "japan" => "HND",
    "china" => "PEK",
    "schweiz" => "ZRH",
    "italien" => "FCO",
    "neuseeland" => "AKL",
    "mongolei" => "UBN"
];

$departureAirports = [
    "Frankfurt" => "FRA",
    "München" => "MUC",
    "MÃ¼nchen" => "MUC",
    "Berlin" => "BER",
    "Hamburg" => "HAM",
    "Köln" => "CGN",
    "KÃ¶ln" => "CGN",
    "FRA" => "FRA",
    "MUC" => "MUC",
    "BER" => "BER",
    "HAM" => "HAM",
    "CGN" => "CGN"
];

$departureNames = [
    "FRA" => "Frankfurt",
    "MUC" => "München",
    "BER" => "Berlin",
    "HAM" => "Hamburg",
    "CGN" => "Köln"
];

$fromCode = $departureAirports[$departure] ?? strtoupper($departure);
$toCode = $countryAirports[$country] ?? '';
$departureLabel = $departureNames[$fromCode] ?? $departure;
$flights = [];
$searchKey = implode("|", [$country, $fromCode, $toCode, $outbound, $return, "Economy", $currency]);

if(!isset($_SESSION["flight_results_cache"]) || !is_array($_SESSION["flight_results_cache"])){
    $_SESSION["flight_results_cache"] = [];
}

if(!$toCode){
    $error = "Für dieses Land ist noch kein Zielflughafen hinterlegt.";
} elseif(!$fromCode || !$outbound || !$return){
    $error = "Bitte fülle alle Suchfelder aus.";
} elseif(FLIGHT_API_KEY === "DEIN_FLIGHTAPI_KEY_HIER"){
    $error = "Bitte trage deinen FlightAPI-Key in flight_api.php ein.";
} elseif(isset($_SESSION["flight_results_cache"][$searchKey])){
    $flights = $_SESSION["flight_results_cache"][$searchKey];
} else {
    $data = searchFlightsStable($fromCode, $toCode, $outbound, $return, 1, 0, 0, "Economy", $currency);

    if(isset($data["error"])){
        $error = $data["error"];
    } else {
        $flights = $data["flights"];
        $_SESSION["flight_results_cache"][$searchKey] = $flights;
    }
}

if($sort == "price_asc"){
    usort($flights, fn($a,$b) => $a["price"] <=> $b["price"]);
}

if($sort == "price_desc"){
    usort($flights, fn($a,$b) => $b["price"] <=> $a["price"]);
}

function e($value){
    return htmlspecialchars((string)$value, ENT_QUOTES, "UTF-8");
}

function formatTime($value){
    if(!$value){
        return "--:--";
    }

    return date("H:i", strtotime($value));
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

<h1>Flüge nach <?php echo e(ucfirst($country)); ?></h1>

<div class="info">
    <p><strong>Abflug:</strong> <?php echo e($departureLabel); ?> (<?php echo e($fromCode); ?>)</p>
    <p><strong>Ziel:</strong> <?php echo e($toCode); ?></p>
    <p><strong>Hinflug:</strong> <?php echo e($outbound); ?></p>
    <p><strong>Rückflug:</strong> <?php echo e($return); ?></p>
</div>

<form method="GET" class="sort-form">

    <input type="hidden" name="country" value="<?php echo e($country); ?>">
    <input type="hidden" name="departure" value="<?php echo e($fromCode); ?>">
    <input type="hidden" name="outbound" value="<?php echo e($outbound); ?>">
    <input type="hidden" name="return" value="<?php echo e($return); ?>">

    <select name="sort">
        <option value="">Sortieren</option>
        <option value="price_asc" <?php echo $sort === "price_asc" ? "selected" : ""; ?>>Preis aufsteigend</option>
        <option value="price_desc" <?php echo $sort === "price_desc" ? "selected" : ""; ?>>Preis absteigend</option>
    </select>

    <button type="submit">Anwenden</button>

</form>

<?php if($error): ?>
    <p class="error"><?php echo e($error); ?></p>
<?php endif; ?>

<?php if(!$error && count($flights) === 0): ?>
    <p class="error">Keine Flüge gefunden.</p>
<?php endif; ?>

<div class="flights-container">

<?php foreach($flights as $flight): ?>

    <div class="flight-card">

        <div class="top-row">
            <h3><?php echo e($departureLabel); ?> → <?php echo e($flight['city']); ?></h3>

            <div class="price-badge">
                <?php echo e($flight['priceFormatted']); ?>
            </div>
        </div>

        <div class="airline">
            ✈ <?php echo e($flight['airline']); ?>
        </div>

        <div class="details">
            <p>Hinflug Dauer: ca. <?php echo e($flight['duration']); ?>h</p>
            <p>Start: <?php echo e(formatTime($flight['departureTime'])); ?></p>
            <p>Ankunft: <?php echo e(formatTime($flight['arrivalTime'])); ?></p>

            <p>
                <?php if($flight['stops'] == 0): ?>
                    Direktflug
                <?php else: ?>
                    <?php echo e($flight['stops']); ?> Stop(s)
                <?php endif; ?>
            </p>

            <?php if($flight['returnDuration'] !== null): ?>
                <p>Rückflug Dauer: ca. <?php echo e($flight['returnDuration']); ?>h</p>
                <p>Rückflug Start: <?php echo e(formatTime($flight['returnDepartureTime'])); ?></p>
                <p>Rückflug Ankunft: <?php echo e(formatTime($flight['returnArrivalTime'])); ?></p>
            <?php endif; ?>

            <p><?php echo e($outbound); ?> → <?php echo e($return); ?></p>
        </div>
        <form action="add_to_cart.php" method="POST" class="cart-form">
            <input type="hidden" name="country" value="<?php echo e($country); ?>">
            <input type="hidden" name="departure_city" value="<?php echo e($fromCode); ?>">
            <input type="hidden" name="arrival_city" value="<?php echo e($toCode); ?>">
            <input type="hidden" name="price" value="<?php echo e($flight['price']); ?>">
            <input type="hidden" name="departure_date" value="<?php echo e($outbound); ?>">
            <input type="hidden" name="return_date" value="<?php echo e($return); ?>">
            <button type="submit">In Warenkorb</button>
        </form>

    </div>

<?php endforeach; ?>

</div>

</body>
</html>



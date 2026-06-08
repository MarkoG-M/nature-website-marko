<?php
session_start();
require "../db.php";

if(!isset($_SESSION["user_id"])){
    header("Location: /nature/login.php");
    exit;
}

if($_SERVER["REQUEST_METHOD"] !== "POST"){
    header("Location: /nature/flights/cart.php");
    exit;
}

$userId = (int)$_SESSION["user_id"];
$countryName = trim($_POST["country"] ?? "");
$departureCity = strtoupper(trim($_POST["departure_city"] ?? ""));
$arrivalCity = strtoupper(trim($_POST["arrival_city"] ?? ""));
$price = (float)($_POST["price"] ?? 0);
$departureDate = trim($_POST["departure_date"] ?? "");
$returnDate = trim($_POST["return_date"] ?? "");

if($countryName === "" || $departureCity === "" || $arrivalCity === "" || $price <= 0 || $departureDate === "" || $returnDate === ""){
    header("Location: /nature/flights/cart.php?error=missing");
    exit;
}

try {
    $pdo->beginTransaction();

    $countryStmt = $pdo->prepare("SELECT id FROM countries WHERE LOWER(name) = LOWER(?) LIMIT 1");
    $countryStmt->execute([$countryName]);
    $countryId = $countryStmt->fetchColumn();

    if(!$countryId){
        $insertCountry = $pdo->prepare("INSERT INTO countries (name) VALUES (?)");
        $insertCountry->execute([$countryName]);
        $countryId = $pdo->lastInsertId();
    }

    $flightStmt = $pdo->prepare(
        "SELECT id FROM flights
         WHERE country_id = ?
         AND departure_city = ?
         AND arrival_city = ?
         AND price = ?
         AND departure_date = ?
         AND return_date = ?
         LIMIT 1"
    );
    $flightStmt->execute([$countryId, $departureCity, $arrivalCity, $price, $departureDate, $returnDate]);
    $flightId = $flightStmt->fetchColumn();

    if(!$flightId){
        $insertFlight = $pdo->prepare(
            "INSERT INTO flights (country_id, departure_city, arrival_city, price, departure_date, return_date)
             VALUES (?, ?, ?, ?, ?, ?)"
        );
        $insertFlight->execute([$countryId, $departureCity, $arrivalCity, $price, $departureDate, $returnDate]);
        $flightId = $pdo->lastInsertId();
    }

    $cartCheck = $pdo->prepare("SELECT id FROM cart WHERE user_id = ? AND flight_id = ? LIMIT 1");
    $cartCheck->execute([$userId, $flightId]);
    $cartId = $cartCheck->fetchColumn();

    if(!$cartId){
        $insertCart = $pdo->prepare("INSERT INTO cart (user_id, flight_id) VALUES (?, ?)");
        $insertCart->execute([$userId, $flightId]);
    }

    $pdo->commit();

    header("Location: /nature/flights/cart.php?added=1");
    exit;

} catch(PDOException $e){
    if($pdo->inTransaction()){
        $pdo->rollBack();
    }

    die("Warenkorb Fehler: " . $e->getMessage());
}

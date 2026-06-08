<?php
session_start();
require "../db.php";

if(!isset($_SESSION["user_id"])){
    header("Location: /nature/login.php");
    exit;
}

$userId = (int)$_SESSION["user_id"];
$message = "";
$error = "";

if(isset($_GET["added"])){
    $message = "Flug wurde in den Warenkorb gelegt.";
}

if(isset($_GET["error"])){
    $error = "Der Flug konnte nicht gespeichert werden.";
}

if($_SERVER["REQUEST_METHOD"] === "POST"){
    $action = $_POST["action"] ?? "";

    if($action === "remove"){
        $cartId = (int)($_POST["cart_id"] ?? 0);
        $deleteStmt = $pdo->prepare("DELETE FROM cart WHERE id = ? AND user_id = ?");
        $deleteStmt->execute([$cartId, $userId]);
        header("Location: /nature/flights/cart.php?removed=1");
        exit;
    }

    if($action === "clear"){
        $clearStmt = $pdo->prepare("DELETE FROM cart WHERE user_id = ?");
        $clearStmt->execute([$userId]);
        header("Location: /nature/flights/cart.php?cleared=1");
        exit;
    }

    if($action === "checkout"){
        try {
            $pdo->beginTransaction();
            $cartFlightsStmt = $pdo->prepare("SELECT flight_id FROM cart WHERE user_id = ?");
            $cartFlightsStmt->execute([$userId]);
            $flightIds = $cartFlightsStmt->fetchAll(PDO::FETCH_COLUMN);
            $bookingStmt = $pdo->prepare("INSERT INTO bookings (user_id, flight_id, booking_date) VALUES (?, ?, NOW())");

            foreach($flightIds as $flightId){
                $bookingStmt->execute([$userId, $flightId]);
            }

            $clearStmt = $pdo->prepare("DELETE FROM cart WHERE user_id = ?");
            $clearStmt->execute([$userId]);
            $pdo->commit();
            header("Location: /nature/flights/cart.php?booked=1");
            exit;
        } catch(PDOException $e){
            if($pdo->inTransaction()){
                $pdo->rollBack();
            }
            die("Buchungsfehler: " . $e->getMessage());
        }
    }
}

if(isset($_GET["removed"])){
    $message = "Flug wurde aus dem Warenkorb entfernt.";
}

if(isset($_GET["cleared"])){
    $message = "Warenkorb wurde geleert.";
}

if(isset($_GET["booked"])){
    $message = "Buchung wurde gespeichert.";
}

$itemsStmt = $pdo->prepare(
    "SELECT cart.id AS cart_id, flights.id AS flight_id, countries.name AS country_name,
        flights.departure_city, flights.arrival_city, flights.price, flights.departure_date, flights.return_date
     FROM cart
     INNER JOIN flights ON cart.flight_id = flights.id
     INNER JOIN countries ON flights.country_id = countries.id
     WHERE cart.user_id = ?
     ORDER BY cart.id DESC"
);
$itemsStmt->execute([$userId]);
$cartItems = $itemsStmt->fetchAll(PDO::FETCH_ASSOC);

$totalStmt = $pdo->prepare(
    "SELECT COALESCE(SUM(flights.price), 0)
     FROM cart
     INNER JOIN flights ON cart.flight_id = flights.id
     WHERE cart.user_id = ?"
);
$totalStmt->execute([$userId]);
$total = (float)$totalStmt->fetchColumn();

$countStmt = $pdo->prepare("SELECT COUNT(*) FROM cart WHERE user_id = ?");
$countStmt->execute([$userId]);
$itemCount = (int)$countStmt->fetchColumn();

$bookingStmt = $pdo->prepare(
    "SELECT bookings.id, bookings.booking_date, countries.name AS country_name,
        flights.departure_city, flights.arrival_city, flights.price, flights.departure_date, flights.return_date
     FROM bookings
     INNER JOIN flights ON bookings.flight_id = flights.id
     INNER JOIN countries ON flights.country_id = countries.id
     WHERE bookings.user_id = ?
     ORDER BY bookings.booking_date DESC
     LIMIT 5"
);
$bookingStmt->execute([$userId]);
$recentBookings = $bookingStmt->fetchAll(PDO::FETCH_ASSOC);

function e($value){
    return htmlspecialchars((string)$value, ENT_QUOTES, "UTF-8");
}

function money($value){
    return number_format((float)$value, 2, ",", ".") . " EUR";
}
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Warenkorb</title>
    <link rel="stylesheet" href="/nature/css/general.css">
    <link rel="stylesheet" href="/nature/css/header.css">
    <link rel="stylesheet" href="css/cart.css">
</head>
<body>

<main class="cart-page">
    <section class="cart-header">
        <div>
            <p class="eyebrow">Nature Calls</p>
            <h1>Warenkorb</h1>
        </div>
        <a href="/nature/explorepage/explore.php" class="secondary-link">Weiter entdecken</a>
    </section>

    <?php if($message): ?>
        <p class="notice success"><?php echo e($message); ?></p>
    <?php endif; ?>

    <?php if($error): ?>
        <p class="notice error"><?php echo e($error); ?></p>
    <?php endif; ?>

    <section class="summary-band">
        <div><span>Flüge</span><strong><?php echo e($itemCount); ?></strong></div>
        <div><span>Gesamt</span><strong><?php echo e(money($total)); ?></strong></div>
        <div><span>User</span><strong><?php echo e($_SESSION["username"] ?? ""); ?></strong></div>
    </section>

    <?php if(count($cartItems) === 0): ?>
        <section class="empty-state">
            <h2>Dein Warenkorb ist leer</h2>
            <p>Such dir einen Flug aus und speichere ihn hier für später.</p>
            <a href="/nature/explorepage/explore.php">Reiseziele ansehen</a>
        </section>
    <?php else: ?>
        <section class="cart-grid">
            <div class="cart-list">
                <?php foreach($cartItems as $item): ?>
                    <article class="cart-item">
                        <div>
                            <p class="country"><?php echo e(ucfirst($item["country_name"])); ?></p>
                            <h2><?php echo e($item["departure_city"]); ?> → <?php echo e($item["arrival_city"]); ?></h2>
                        </div>
                        <div class="flight-meta">
                            <span>Hinflug: <?php echo e($item["departure_date"]); ?></span>
                            <span>Rückflug: <?php echo e($item["return_date"]); ?></span>
                            <span>Preis: <?php echo e(money($item["price"])); ?></span>
                        </div>
                        <form method="POST">
                            <input type="hidden" name="action" value="remove">
                            <input type="hidden" name="cart_id" value="<?php echo e($item["cart_id"]); ?>">
                            <button type="submit" class="ghost-button">Entfernen</button>
                        </form>
                    </article>
                <?php endforeach; ?>
            </div>

            <aside class="checkout-panel">
                <h2>Zusammenfassung</h2>
                <p><?php echo e($itemCount); ?> Flug/Flüge im Warenkorb</p>
                <strong><?php echo e(money($total)); ?></strong>
                <form method="POST"><input type="hidden" name="action" value="checkout"><button type="submit">Buchung speichern</button></form>
                <form method="POST"><input type="hidden" name="action" value="clear"><button type="submit" class="ghost-button">Warenkorb leeren</button></form>
            </aside>
        </section>
    <?php endif; ?>

    <?php if(count($recentBookings) > 0): ?>
        <section class="recent-bookings">
            <h2>Letzte Buchungen</h2>
            <div class="booking-list">
                <?php foreach($recentBookings as $booking): ?>
                    <article>
                        <strong><?php echo e($booking["departure_city"]); ?> → <?php echo e($booking["arrival_city"]); ?></strong>
                        <span><?php echo e($booking["country_name"]); ?> · <?php echo e($booking["booking_date"]); ?></span>
                        <span><?php echo e(money($booking["price"])); ?></span>
                    </article>
                <?php endforeach; ?>
            </div>
        </section>
    <?php endif; ?>
</main>

</body>
</html>


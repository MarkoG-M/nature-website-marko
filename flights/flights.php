<?php
$country = $_GET['country'] ?? 'Unbekannt';
$today = date('Y-m-d');
?>

<?php
$country = $_GET['country'] ?? 'Unbekannt';
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Flüge suchen</title>

    <link rel="stylesheet" href="css/flights.css">
</head>
<body>

<div class="container">

    <h1>
        Flüge nach <?php echo ucfirst($country); ?>
    </h1>

    <form action="results.php" method="GET">

        <input
            type="hidden"
            name="country"
            value="<?php echo $country; ?>"
        >

        <label>Von wo möchten Sie fliegen?</label>

        <select name="departure" required>
            <option value="">Bitte wählen</option>
            <option value="Frankfurt">Frankfurt</option>
            <option value="München">München</option>
            <option value="Berlin">Berlin</option>
            <option value="Hamburg">Hamburg</option>
            <option value="Köln">Köln</option>
        </select>

        <label for="outbound">Hinflug</label>
        <input
            type="date"
            id="outbound"
            name="outbound"
            required
        >

        <label for="return">Rückflug</label>
        <input
            type="date"
            id="return"
            name="return"
            required
        >

        <button type="submit">
            Flüge suchen
        </button>

    </form>

</div>

</body>
</html>
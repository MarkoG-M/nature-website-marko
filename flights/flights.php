<?php
$country = $_GET['country'] ?? 'Unbekannt';
$today = date('Y-m-d');
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
        Flüge nach <?php echo htmlspecialchars(ucfirst($country), ENT_QUOTES, "UTF-8"); ?>
    </h1>

    <form action="results.php" method="GET">

        <input
            type="hidden"
            name="country"
            value="<?php echo htmlspecialchars($country, ENT_QUOTES, "UTF-8"); ?>"
        >

        <label>Von wo möchten Sie fliegen?</label>

        <select name="departure" required>
            <option value="">Bitte wählen</option>
            <option value="FRA">Frankfurt</option>
            <option value="MUC">München</option>
            <option value="BER">Berlin</option>
            <option value="HAM">Hamburg</option>
            <option value="CGN">Köln</option>
        </select>

        <label for="outbound">Hinflug</label>
        <input
            type="date"
            id="outbound"
            name="outbound"
            min="<?php echo $today; ?>"
            required
        >

        <label for="return">Rückflug</label>
        <input
            type="date"
            id="return"
            name="return"
            min="<?php echo $today; ?>"
            required
        >

        <button type="submit">
            Flüge suchen
        </button>

    </form>

</div>

</body>
</html>

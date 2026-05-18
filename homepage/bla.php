<?php
require "db.php";

/* =========================
   TASK HINZUFÜGEN
========================= */
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $task = trim($_POST["task"]);

    if (!empty($task)) {
        $stmt = $pdo->prepare("INSERT INTO todos (task) VALUES (?)");
        $stmt->execute([$task]);
    }
}

/* =========================
   TASK LÖSCHEN
========================= */
if (isset($_GET["delete"])) {
    $id = (int) $_GET["delete"];

    $stmt = $pdo->prepare("DELETE FROM todos WHERE id = ?");
    $stmt->execute([$id]);

    // WICHTIG: hier deinen Dateinamen benutzen
    header("Location: bla.php");
    exit;
}

/* =========================
   DATEN LADEN
========================= */
$stmt = $pdo->query("SELECT * FROM todos ORDER BY id DESC");
$todos = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html>
<head>
    <title>ToDo App</title>

    <style>
        body { font-family: Arial; margin: 40px; }
        input { padding: 10px; width: 250px; }
        button { padding: 10px; cursor: pointer; }

        .todo {
            margin: 10px 0;
            padding: 10px;
            background: #f4f4f4;
            display: flex;
            justify-content: space-between;
        }

        a {
            color: red;
            text-decoration: none;
        }
    </style>
</head>

<body>

<h1>ToDo App</h1>

<form method="POST">
    <input type="text" name="task" placeholder="Neue Aufgabe">
    <button type="submit">Hinzufügen</button>
</form>

<hr>

<?php foreach ($todos as $todo): ?>
    <div class="todo">
        <span><?= htmlspecialchars($todo["task"]) ?></span>

        <a href="?delete=<?= $todo["id"] ?>"
           onclick="return confirm('Wirklich löschen?')">
           löschen
        </a>
    </div>
<?php endforeach; ?>

</body>
</html>
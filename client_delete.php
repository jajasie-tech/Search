<?php
require_once 'Core/GOMEZ_Db_Config.php';
require_once 'Core/model.php';

$clientID = filter_input(
    INPUT_GET, 'client_id', FILTER_VALIDATE_INT
);

if (!$clientID) {
    exit("Invalid client ID.");
}

$client = getClientByID($pdo, $clientID);

if (!$client) {
    exit("Client not found.");
}

$bakerID = $client['baker_id'];

function e($value) {
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Delete Client</title>
</head>
<body>

<h1>Delete Client</h1>

<p>Are you sure you want to delete this client?</p>

<p>Client Name: <?= e($client['client_name']) ?></p>
<p>Client ID: <?= e($client['client_id']) ?></p>
<p>Order Type: <?= e($client['order_type']) ?></p>

<form action="Core/handleforms.php" method="POST">

    <input type="hidden" name="client_id"
           value="<?= e($client['client_id']) ?>">

    <input type="hidden" name="baker_id"
           value="<?= e($client['baker_id']) ?>">

    <button type="submit" name="deleteClientBtn">
        Yes, Delete Client
    </button>

</form>

<p>
    <a href="view_all.php?baker_id=<?= e($bakerID) ?>">
        Cancel
    </a>
</p>

</body>
</html>
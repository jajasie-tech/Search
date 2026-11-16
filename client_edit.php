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
    <title>Edit Client</title>
</head>
<body>

<h1>Edit Client</h1>

<p>Client ID: <?= e($client['client_id']) ?></p>
<p>Baker ID: <?= e($client['baker_id']) ?></p>

<form action="Core/handleforms.php" method="POST">

    <input type="hidden" name="client_id"
           value="<?= e($client['client_id']) ?>">

    <input type="hidden" name="baker_id"
           value="<?= e($client['baker_id']) ?>">

    <label>Client Name:</label><br>
    <input type="text" name="client_name"
           value="<?= e($client['client_name']) ?>" required><br><br>

    <label>Contact Number:</label><br>
    <input type="text" name="contact_number"
           value="<?= e($client['contact_number']) ?>" required><br><br>

    <label>Location:</label><br>
    <input type="text" name="location"
           value="<?= e($client['location']) ?>" required><br><br>

    <label>Order Type:</label><br>
    <input type="text" name="order_type"
           value="<?= e($client['order_type']) ?>" required><br><br>

    <button type="submit" name="updateClientBtn">
        Update Client
    </button>

</form>

<p>
    <a href="view_all.php?baker_id=<?= e($bakerID) ?>">
        Back to Clients
    </a>
</p>

</body>
</html>
<?php
require_once 'Core/GOMEZ_Db_Config.php';
require_once 'Core/model.php';

$bakerID = filter_input(
    INPUT_GET, 'baker_id', FILTER_VALIDATE_INT
);

if (!$bakerID) {
    exit("Invalid baker ID.");
}

$baker = getBakerByID($pdo, $bakerID);

if (!$baker) {
    exit("Baker not found.");
}

$clients = seeAllClientsByBakerID($pdo, $bakerID);

function e($value) {
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Baker Clients</title>
</head>
<body>

<h1>Client Management</h1>

<h2>Baker Information</h2>

<p>Baker ID: <?= e($baker['baker_id']) ?></p>
<p>Baker Name: <?= e($baker['baker_name']) ?></p>
<p>Specialization: <?= e($baker['specialization_type']) ?></p>


<hr>

<h2>Clients of <?= e($baker['baker_name']) ?></h2>

<table border="1" cellpadding="8" cellspacing="0">
    <tr>
        <th>Client ID</th>
        <th>Client Name</th>
        <th>Contact Number</th>
        <th>Location</th>
        <th>Order Type</th>
        <th>Date Added</th>
        <th>Action</th>
    </tr>

    <?php foreach ($clients as $row) { ?>
        <tr>
            <td><?= e($row['client_id']) ?></td>
            <td><?= e($row['client_name']) ?></td>
            <td><?= e($row['contact_number']) ?></td>
            <td><?= e($row['location']) ?></td>
            <td><?= e($row['order_type']) ?></td>
            <td><?= e($row['date_added']) ?></td>
            <td>
                <a href="client_edit.php?client_id=<?= e($row['client_id']) ?>">
                    Edit
                </a>
                |
                <a href="client_delete.php?client_id=<?= e($row['client_id']) ?>">
                    Delete
                </a>
            </td>
        </tr>
    <?php } ?>

</table>

<p><a href="baker_index.php">Back to Bakers</a></p>

</body>
</html>
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

function e($value) {
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Delete Baker</title>
</head>
<body>

<h1>Delete Baker</h1>

<p>Are you sure you want to delete this baker?</p>

<p>
    Baker Name:
    <?= e($baker['baker_name']) ?>
</p>

<p>Baker ID: <?= e($baker['baker_id']) ?></p>

<p>
    Warning: Deleting this baker will also delete all clients
    associated with this baker.
</p>

<form action="Core/handleforms.php" method="POST">

    <input type="hidden" name="baker_id"
           value="<?= e($baker['baker_id']) ?>">

    <button type="submit" name="deleteBakerBtn">
        Yes, Delete Baker
    </button>

</form>

<p><a href="baker_index.php">Cancel</a></p>

</body>
</html>
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
    <title>Edit Baker</title>
</head>
<body>

<h1>Edit Baker</h1>

<p>Baker ID: <?= e($baker['baker_id']) ?></p>

<form action="Core/handleforms.php" method="POST">

    <input type="hidden" name="baker_id"
           value="<?= e($baker['baker_id']) ?>">

    <label>Baker Name:</label><br>
    <input type="text" name="baker_name"
           value="<?= e($baker['baker_name']) ?>" required><br><br>

    <label>Contact Number:</label><br>
    <input type="text" name="contact_number"
           value="<?= e($baker['contact_number']) ?>" required><br><br>

    <label>Specialization Type:</label><br>
    <input type="text" name="specialization_type"
           value="<?= e($baker['specialization_type']) ?>" required><br><br>

    <button type="submit" name="updateBakerBtn">
        Update Baker
    </button>

</form>

<p><a href="baker_index.php">Back to Bakers</a></p>

</body>
</html>
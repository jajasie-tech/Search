<?php
require_once 'Core/GOMEZ_Db_Config.php';
require_once 'Core/model.php';

// SEARCH CLIENT OR DISPLAY ALL CLIENTS
if (isset($_GET['searchInput']) && trim($_GET['searchInput']) != '') {

    $searchInput = trim($_GET['searchInput']);
    $clients = searchForAClient($pdo, $searchInput);

} else {

    $clients = seeAllClients($pdo);

}

// GET ALL BAKERS FOR THE DROPDOWN
$bakers = seeAllBakers($pdo);

function e($value) {
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Client Management</title>
</head>
<body>

<h1>Client Management</h1>

<h2>Client Form</h2>

<form action="Core/handleforms.php" method="POST">

    <label>Select Baker:</label><br>
    <select name="baker_id" required>
        <option value="">Select a baker</option>

        <?php foreach ($bakers as $baker) { ?>
            <option value="<?= e($baker['baker_id']) ?>">
                <?= e($baker['baker_name']) ?>
            </option>
        <?php } ?>

    </select><br><br>

    <label>Client Name:</label><br>
    <input type="text" name="client_name" required><br><br>

    <label>Contact Number:</label><br>
    <input type="text" name="contact_number" required><br><br>

    <label>Location:</label><br>
    <input type="text" name="location" required><br><br>

    <label>Order Type:</label><br>
    <input type="text" name="order_type" required><br><br>

    <button type="submit" name="insertClientBtn">
        Add Client
    </button>

</form>


<form action="client_index.php" method="GET">

    <input
        type="text"
        name="searchInput"
        placeholder="Search by Client ID, Baker Name, Client Name, Contact Number, Location, or Order Type"
        value="<?php echo htmlspecialchars($_GET['searchInput'] ?? ''); ?>"
    >

    <button type="submit" name="searchBtn">
        Search
    </button>

</form>


<hr>

<h2>All Clients</h2>

<table border="1" cellpadding="8" cellspacing="0">
    <tr>
        <th>Client ID</th>
        <th>Baker Name</th>
        <th>Client Name</th>
        <th>Contact Number</th>
        <th>Location</th>
        <th>Order Type</th>
        <th>Date Added</th>
        <th>Added By</th>
        <th>Last Updated By</th>
        <th>Last Updated</th>
        <th>Action</th>
    </tr>

    <?php foreach ($clients as $row) { ?>
        <tr>
            <td><?= e($row['client_id']) ?></td>
            <td><?= e($row['baker_name']) ?></td>
            <td><?= e($row['client_name']) ?></td>
            <td><?= e($row['contact_number']) ?></td>
            <td><?= e($row['location']) ?></td>
            <td><?= e($row['order_type']) ?></td>
            <td><?= e($row['date_added']) ?></td>
             <td><?= e($row['added_by']) ?></td>
            <td><?= e($row['last_updated_by'] ?? 'Not yet updated') ?></td>
            <td><?= e($row['last_updated'] ?? 'Not yet updated') ?></td>
            <td>
                <a href="client_edit.php?client_id=<?= e($row['client_id']) ?>">
                    Edit
                </a>
                |
                <a href="client_delete.php?client_id=<?= e($row['client_id']) ?>">
                    Delete
                </a>
                |
                <a href="view_all.php?baker_id=<?= e($row['baker_id']) ?>">
                    View Baker's Clients
                </a>
            </td>
        </tr>
    <?php } ?>

</table>

<p><a href="baker_index.php">Back to Bakers</a></p>

</body>
</html>
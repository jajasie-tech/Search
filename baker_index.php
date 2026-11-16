<?php
require_once 'core/model.php';
require_once 'core/handleforms.php';

if (!isset($_SESSION['username'])) {
    header("Location: User/login.php");
}
?>

<?php if (isset($_SESSION['username'])) { ?>
    Hello! <?php echo $_SESSION['username']; ?>
    <a href="core/handleForms.php?logoutUserA=1">Logout</a>
<?php } else {
    echo "<h1>No user logged in</h1>";
} ?>


<?php
require_once 'Core/GOMEZ_Db_Config.php';
require_once 'Core/model.php';


if (isset($_GET['searchInput'])) {

    $searchInput = $_GET['searchInput'];

    if ($searchInput != "") {

        $bakers = searchForABaker($pdo, $searchInput);

    } else {

        $bakers = seeAllBakers($pdo);

    }

} else {

    $bakers = seeAllBakers($pdo);

}


function e($value) {
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Pastry Supplier System</title>
</head>
<body>

<h1>Pastry Supplier System</h1>

<h2>Baker Form</h2>

<form action="Core/handleforms.php" method="POST">

    <label>Baker Name:</label><br>
    <input type="text" name="baker_name" required><br><br>

    <label>Contact Number:</label><br>
    <input type="text" name="contact_number" required><br><br>

    <label>Specialization Type:</label><br>
    <input type="text" name="specialization_type"
           placeholder="e.g. Cakes, Bread, Pastries" required><br><br>

    <button type="submit" name="insertBakerBtn">
        Add Baker
    </button>


</form>


<form action="baker_index.php" method="GET">

    <input
        type="text"
        name="searchInput"
        placeholder="Search Baker Name"
    >

    <button type="submit" name="searchBtn">
        Search
    </button>

</form>


<hr>

<h2>Registered Bakers</h2>

<table border="1" cellpadding="8" cellspacing="0">
    <tr>
        <th>Baker ID</th>
        <th>Baker Name</th>
        <th>Contact Number</th>
        <th>Specialization Type</th>
        <th>Date Added</th>
        <th>Added By</th>
        <th>Last Updated By</th>
        <th>Last Updated</th>
        <th>Action</th>
    </tr>

    <?php foreach ($bakers as $row) { ?>
        <tr>
            <td><?= e($row['baker_id']) ?></td>
            <td><?= e($row['baker_name']) ?></td>
            <td><?= e($row['contact_number']) ?></td>
            <td><?= e($row['specialization_type']) ?></td>
            <td><?= e($row['date_added']) ?></td>
            <td><?= e($row['added_by']) ?></td>
            <td><?= e($row['last_updated_by'] ?? 'Not yet updated') ?></td>
            <td><?= e($row['last_updated'] ?? 'Not yet updated') ?></td>
            <td>
                <p><a href="client_index.php">Manage All Clients</a></p>
                <a href="baker_edit.php?baker_id=<?= e($row['baker_id']) ?>">
                    Edit
                </a>
                |
                <a href="baker_delete.php?baker_id=<?= e($row['baker_id']) ?>">
                    Delete
                </a>
                |
                <a href="view_all.php?baker_id=<?= e($row['baker_id']) ?>">
                    View Clients
                </a>
            </td>
        </tr>

    <?php } ?>

</table>

</body>
</html>
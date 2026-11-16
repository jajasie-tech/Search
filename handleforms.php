<?php

require_once 'GOMEZ_Db_Config.php';
require_once 'model.php';

function cleanInput($value) {
    return trim($value ?? "");
}

function applicationInputsAreValid($fields) {
    foreach ($fields as $field) {
        if ($field === "") {
            return false;
        }
    }

    return true;
}

// INSERT BAKER
if (isset($_POST['insertBakerBtn'])) {

    $bakerName = cleanInput($_POST['baker_name'] ?? '');
    $contactNumber = cleanInput($_POST['contact_number'] ?? '');
    $specializationType = cleanInput($_POST['specialization_type'] ?? '');

    $fields = [
        $bakerName, $contactNumber, $specializationType
    ];

    if (applicationInputsAreValid($fields)) {

        $query = insertBaker(
    $pdo, $bakerName, $contactNumber,
    $specializationType, $_SESSION['username']  
);

        if ($query) {
            header("Location: ../baker_index.php");
            exit;
        }
    }

    echo "Baker insertion failed. Check your inputs.";
}

// UPDATE BAKER
if (isset($_POST['updateBakerBtn'])) {

    $bakerID = filter_input(
        INPUT_POST, 'baker_id', FILTER_VALIDATE_INT
    );

    $bakerName = cleanInput($_POST['baker_name'] ?? '');
    $contactNumber = cleanInput($_POST['contact_number'] ?? '');
    $specializationType = cleanInput($_POST['specialization_type'] ?? '');

    $fields = [
        $bakerName, $contactNumber, $specializationType
    ];

    if ($bakerID && applicationInputsAreValid($fields)) {

        $query = updateBaker(
    $pdo, $bakerID, $bakerName,
    $contactNumber, $specializationType,
    $_SESSION['username']
);

        if ($query) {
            header("Location: ../baker_index.php");
            exit;
        }
    }

    echo "Baker update failed. Check your inputs.";
}

// DELETE BAKER
if (isset($_POST['deleteBakerBtn'])) {

    $bakerID = filter_input(
        INPUT_POST, 'baker_id', FILTER_VALIDATE_INT
    );

    if ($bakerID) {
        $query = deleteBaker($pdo, $bakerID);

        if ($query) {
            header("Location: ../baker_index.php");
            exit;
        }
    }

    echo "Baker deletion failed.";
}

// INSERT CLIENT
if (isset($_POST['insertClientBtn'])) {

    $bakerID = filter_input(
        INPUT_POST, 'baker_id', FILTER_VALIDATE_INT
    );

    $clientName = cleanInput($_POST['client_name'] ?? '');
    $contactNumber = cleanInput($_POST['contact_number'] ?? '');
    $location = cleanInput($_POST['location'] ?? '');
    $orderType = cleanInput($_POST['order_type'] ?? '');

    $fields = [
        $clientName, $contactNumber, $location, $orderType
    ];

    if ($bakerID && applicationInputsAreValid($fields)) {

        $query = insertClient(
    $pdo, $bakerID, $clientName,
    $contactNumber, $location, $orderType,
    $_SESSION['username']
);

        if ($query) {
            header("Location: ../client_index.php?baker_id=" . $bakerID);
            exit;
        }
    }

    echo "Client insertion failed. Check your inputs.";
}

// UPDATE CLIENT
if (isset($_POST['updateClientBtn'])) {

    $clientID = filter_input(
        INPUT_POST, 'client_id', FILTER_VALIDATE_INT
    );

    $bakerID = filter_input(
        INPUT_POST, 'baker_id', FILTER_VALIDATE_INT
    );

    $clientName = cleanInput($_POST['client_name'] ?? '');
    $contactNumber = cleanInput($_POST['contact_number'] ?? '');
    $location = cleanInput($_POST['location'] ?? '');
    $orderType = cleanInput($_POST['order_type'] ?? '');

    $fields = [
        $clientName, $contactNumber, $location, $orderType
    ];

    if ($clientID && $bakerID
        && applicationInputsAreValid($fields)) {

        $query = updateClient(
            $pdo,
            $clientID,
            $bakerID,
            $clientName,
            $contactNumber,
            $location,
            $orderType,
            $_SESSION['username']
        );

        if ($query) {
            header("Location: ../client_index.php");
            exit;
        }
    }

    echo "Client update failed. Check your inputs.";
}

// DELETE CLIENT
if (isset($_POST['deleteClientBtn'])) {

    $clientID = filter_input(
        INPUT_POST, 'client_id', FILTER_VALIDATE_INT
    );

    $bakerID = filter_input(
        INPUT_POST, 'baker_id', FILTER_VALIDATE_INT
    );

    if ($clientID && $bakerID) {
        $query = deleteClient($pdo, $clientID);

        if ($query) {
            header("Location: ../view_all.php?baker_id=" . $bakerID);
            exit;
        }
    }

    echo "Client deletion failed.";
}


if (isset($_POST['registerUserBtn'])) {

    $username = $_POST['username'];
    $password = sha1($_POST['password']);

    if (!empty($username) && !empty($password)) {

        $insertQuery = insertNewUser($pdo, $username, $password);

        if ($insertQuery) {
            header("Location: ../User/login.php");
        } else {
            header("Location: ../User/register.php");
        }

    } else {
        $_SESSION['message'] = "Please make sure the input fields are not empty for registration!";
        header("Location: ../User/login.php");
        exit();
    }
}

if (isset($_POST['loginUserBtn'])) {

    $username = $_POST['username'];
    $password = sha1($_POST['password']);

    if (!empty($username) && !empty($password)) {

        $loginQuery = loginUser($pdo, $username, $password);

        if ($loginQuery) {
            header("Location: ../baker_index.php");
        } else {
            header("Location: ../User/login.php");
        }

    } else {
        $_SESSION['message'] = "Please make sure the input fields are not empty for the login!";
        header("Location: ../User/login.php");
        exit();
    }
}

if (isset($_GET['logoutUserA'])) {
    unset($_SESSION['username']);
    header("Location: ../User/login.php");
    exit();
}

?>
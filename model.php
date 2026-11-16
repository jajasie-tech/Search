<?php

function insertBaker($pdo, $bakerName, $contactNumber,
    $specializationType, $addedBy) {

    $sql = "INSERT INTO baker
    (baker_name, contact_number, specialization_type, added_by)
    VALUES (?, ?, ?, ?)";

    $stmt = $pdo->prepare($sql);

    return $stmt->execute([
        $bakerName, $contactNumber, $specializationType, $addedBy
    ]);
}

function seeAllBakers($pdo) {
    $sql = "SELECT * FROM baker
            ORDER BY baker_id DESC";

    $stmt = $pdo->prepare($sql);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getBakerByID($pdo, $bakerID) {
    $sql = "SELECT * FROM baker
            WHERE baker_id = ?";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([$bakerID]);

    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function seeAllClients($pdo) {
    $sql = "SELECT client.*, baker.baker_name
            FROM client
            INNER JOIN baker
            ON client.baker_id = baker.baker_id
            ORDER BY client.client_id DESC";

    $stmt = $pdo->prepare($sql);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


function updateBaker($pdo, $bakerID,
    $bakerName, $contactNumber, $specializationType, $updatedBy) {

    $sql = "UPDATE baker SET
        baker_name = ?,
        contact_number = ?,
        specialization_type = ?,
        last_updated_by = ?,
        last_updated = CURRENT_TIMESTAMP
        WHERE baker_id = ?";

    $stmt = $pdo->prepare($sql);

    return $stmt->execute([
        $bakerName, $contactNumber, $specializationType,
        $updatedBy, $bakerID
    ]);
}

function deleteBaker($pdo, $bakerID) {

    $sql = "DELETE FROM client
            WHERE baker_id = ?";

    $stmt = $pdo->prepare($sql);

    if ($stmt->execute([$bakerID])) {

        $sql = "DELETE FROM baker
                WHERE baker_id = ?";

        $stmt = $pdo->prepare($sql);

        return $stmt->execute([$bakerID]);
    }

    return false;
}

function insertClient($pdo, $bakerID, $clientName,
    $contactNumber, $location, $orderType, $addedBy) {

    $sql = "INSERT INTO client
    (baker_id, client_name, contact_number, location, order_type, added_by)
    VALUES (?, ?, ?, ?, ?, ?)";

    $stmt = $pdo->prepare($sql);

    return $stmt->execute([
        $bakerID, $clientName, $contactNumber,
        $location, $orderType, $addedBy
    ]);
}

function seeAllClientsByBakerID($pdo, $bakerID) {
    $sql = "SELECT * FROM client
            WHERE baker_id = ?
            ORDER BY client_id DESC";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([$bakerID]);

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getClientByID($pdo, $clientID) {
    $sql = "SELECT * FROM client
            WHERE client_id = ?";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([$clientID]);

    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function updateClient($pdo, $clientID, $bakerID,
    $clientName, $contactNumber, $location, $orderType, $updatedBy) {

    $sql = "UPDATE client SET
        baker_id = ?,
        client_name = ?,
        contact_number = ?,
        location = ?,
        order_type = ?,
        last_updated_by = ?,
        last_updated = CURRENT_TIMESTAMP
        WHERE client_id = ?";

    $stmt = $pdo->prepare($sql);

    return $stmt->execute([
        $bakerID, $clientName, $contactNumber,
        $location, $orderType, $updatedBy, $clientID
    ]);
}

function deleteClient($pdo, $clientID) {
    $sql = "DELETE FROM client
            WHERE client_id = ?";

    $stmt = $pdo->prepare($sql);

    return $stmt->execute([$clientID]);
}

function insertNewUser($pdo, $username, $password) {

    $checkUserSql = "SELECT * FROM user_passwords WHERE username = ?";
    $checkUserSqlStmt = $pdo->prepare($checkUserSql);
    $checkUserSqlStmt->execute([$username]);

    if ($checkUserSqlStmt->rowCount() == 0) {

        $sql = "INSERT INTO user_passwords (username,password) VALUES(?,?)";
        $stmt = $pdo->prepare($sql);
        $executeQuery = $stmt->execute([$username, $password]);

        if ($executeQuery) {
            $_SESSION['message'] = "User successfully inserted";
            return true;
        } else {
            $_SESSION['message'] = "Error occured, please try again";
        }

    } else {
        $_SESSION['message'] = "User already exists";
    }
}


function loginUser($pdo, $username, $password) {

    $sql = "SELECT * FROM user_passwords WHERE username = ?";
    $stmt = $pdo->prepare($sql);

    if ($stmt->execute([$username])) {

        $userInfoRow = $stmt->fetch();
        $usernameFromDB = $userInfoRow['username'];
        $passwordFromDB = $userInfoRow['password'];

        if ($password == $passwordFromDB) {
            $_SESSION['username'] = $usernameFromDB;
            $_SESSION['message'] = "Login successful!";
            return true;
        } else {
            $_SESSION['message'] = "Username/password invalid";
        }
    }

    if ($stmt->rowCount() == 0) {
        $_SESSION['message'] = "Username/password invalid";
    }
}


function searchForABaker($pdo, $searchInput) {

    $sql = "SELECT * FROM baker
            WHERE baker_name LIKE ?
            OR contact_number LIKE ?
            OR specialization_type LIKE ?";

    $stmt = $pdo->prepare($sql);

    $searchValue = '%' . $searchInput . '%';

    $executeQuery = $stmt->execute([
        $searchValue,
        $searchValue,
        $searchValue
    ]);

    if ($executeQuery) {
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    return [];
}


function searchForAClient($pdo, $searchInput) {

    $sql = "SELECT client.*, baker.baker_name
            FROM client
            INNER JOIN baker
            ON client.baker_id = baker.baker_id
            WHERE client.client_id LIKE ?
            OR baker.baker_name LIKE ?
            OR client.client_name LIKE ?
            OR client.contact_number LIKE ?
            OR client.location LIKE ?
            OR client.order_type LIKE ?
            ORDER BY client.client_id DESC";

    $searchValue = '%' . $searchInput . '%';

    $stmt = $pdo->prepare($sql);

    $executeQuery = $stmt->execute([
        $searchValue,
        $searchValue,
        $searchValue,
        $searchValue,
        $searchValue,
        $searchValue
    ]);

    if ($executeQuery) {
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    return [];
}
        

?>
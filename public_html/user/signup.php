<?php
header('Content-type: application/json; charset= utf8');

include('../../db.php');

try {
    $pdo = new PDO(
        "mysql:host=$db[host];dbname=$db[dbname];port=$db[port];charset=$db[charset]",
        $db['username'],
        $db['password']
    );
} catch (PDOException $e) {
    echo "Database connection failed.";
    exit;
}

$sql = 'SELECT email FROM users';
$statement = $pdo->prepare($sql);
$statement->execute();
$hadEmails = $statement->fetchAll(PDO::FETCH_ASSOC);
try {
    $name = filter_input(INPUT_POST, 'name');
    if (!$name) {
        throw new Exception('Invalid name.');
    }

    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
    if (!$email) {
        throw new Exception('Invalid email.');
    }
    foreach ($hadEmails as $hadEmail) {
        if ($hadEmail['email'] == $email) {
            throw new Exception('The E-mail that you inputted has existed.');
        }
    }

    $password = filter_input(INPUT_POST, 'password');
    $confirmPassword = filter_input(INPUT_POST, 'confirmPassword');
    if (!$password || mb_strlen($password) < 8) {
        throw new Exception('Password must contain 8+ characters.');
    } elseif ($password <> $confirmPassword) {
        throw new Exception('Confirm password does not match!');
    }

    $passwordHash = password_hash($password, PASSWORD_DEFAULT);
    if ($passwordHash === false) {
        throw new Exception('Password hash failed.');
    }
} catch (Exception $e) {
    header('HTTP/1.1 400 Bad request');
    echo $e->getMessage();
    exit;
}

$sql = 'INSERT INTO users(`name`, email, `password`) VALUES(:name, :email, :password)';
$statement = $pdo->prepare($sql);
$statement->bindValue(':name', $name, PDO::PARAM_STR);
$statement->bindValue(':email', $email, PDO::PARAM_STR);
$statement->bindValue(':password', $passwordHash, PDO::PARAM_STR);
$result = $statement->execute();

if ($result) {
    echo json_encode(['id' => $pdo->lastInsertId()]);
} else {
    var_dump($pdo->errorInfo());
}

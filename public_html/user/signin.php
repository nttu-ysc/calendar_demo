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

try {
    $email = filter_input(INPUT_POST, 'email');
    $sql = 'SELECT * FROM users WHERE email=:email';
    $statement = $pdo->prepare($sql);
    $statement->bindValue(':email', $email, PDO::PARAM_STR);
    $statement->execute();
    $user = $statement->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        throw new Exception("The email address you entered does not exist.");
    }

    $password = filter_input(INPUT_POST, 'password');
    if (password_verify($password, $user['password']) == false) {
        throw new Exception("Password Error");
    }
    session_start();
    $_SESSION['user_logged_in'] = 'yes';
    $_SESSION['name'] = $user['name'];
    $_SESSION['id'] = $user['id'];
    $_SESSION['email'] = $user['email'];

    echo json_encode($_SESSION['user_logged_in']);
} catch (\Throwable $th) {
    header('HTTP/1.1 401 Unauthorized');
    echo $th->getMessage();
}

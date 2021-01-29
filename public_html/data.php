<?php
include('../db.php');

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

$year = date('Y');
$month = date('m');
session_start();
$sql = 'SELECT id, title, `date`, start_time FROM events WHERE year =:year AND month =:month AND user_id =:user_id ORDER BY `date`, start_time ASC';
$statement = $pdo->prepare($sql);
$statement->bindValue(':year', $year, PDO::PARAM_INT);
$statement->bindValue(':month', $month, PDO::PARAM_INT);
$statement->bindValue(':user_id', $_SESSION['id'], PDO::PARAM_INT);
$statement->execute();

$events = $statement->fetchAll(PDO::FETCH_ASSOC);
foreach ($events as $key => $event) {
    $events[$key]['start_time'] = substr($event['start_time'], 0, 5);
}

$days = cal_days_in_month(CAL_GREGORIAN, $month, $year);

$firstDateOfTheMonth = new DateTime("$year-$month-1");
$frontPadding = $firstDateOfTheMonth->format('w');
$lastDateOfTheMonth = new DateTime("$year-$month-$days");
$backPadding = 6 - $lastDateOfTheMonth->format('w');

for ($i = 0; $i < $frontPadding; $i++) {
    $dates[] = null;
}

for ($i = 1; $i <= $days; $i++) {
    $dates[] = $i;
}

for ($i = 0; $i < $backPadding; $i++) {
    $dates[] = null;
}
?>

<script>
    var events = <?= json_encode($events, JSON_NUMERIC_CHECK) ?>;
</script>
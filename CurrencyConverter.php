<?php
include("connection/Connection.php");
$result = 0;

$conn = null;

try {
    $conn = Connection::get()->connect();
    // echo"<script>";
    // echo "console.log('A connection to the PostgreSQL database server has been established successfully.')";
    // echo"</script>";
} catch (\PDOException $e) {
    $format = "A connection to the PostrgreSQL database server has been failed %s";
    
    $log = sprintf("console.log('%s')", sprintf($format, $e->getMessage()));

    echo "<script>" . $log . "</script>";

    $conn = null;
}

$price = $_POST['price'];
$currentValute = $_POST['currentValute'];
$nextValute = $_POST['nextValute'];

$stmt = $conn->query("SELECT vunitrate FROM valute WHERE name LIKE '" . $currentValute . "';");

$currentVunit = $stmt->fetchAll();

$stmt = $conn->query("SELECT vunitrate FROM valute WHERE name LIKE '" . $nextValute . "';");

$nextVunit = $stmt->fetchAll();

$price = floatval($price);

$result += round($price * floatval($currentVunit[0]['vunitrate']) / floatval($nextVunit[0]['vunitrate']), 2);

echo "" . $price . " " . $_POST['currentValute'] . " = " . $result . " " . $_POST['nextValute'];
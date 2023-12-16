<?php

require __DIR__ . '/configLocal.php'; // refer to configExample.php
// require __DIR__ . '/configProd.php'; // alwaysdata

$host = $config['database']['host'];
$user = $config['database']['user'];
$password = $config['database']['password'];
$database = $config['database']['database'];


mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
try {
    $mysqli = new mysqli($host, $user, $password, $database);
} catch (Exception $e) {
    echo "MySQLi Error Code: " . $e->getCode() . "<br />";
    echo "Exception Msg: " . $e->getMessage();
    exit();
}

?>
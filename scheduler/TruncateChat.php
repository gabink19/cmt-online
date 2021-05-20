<?php
ini_set('max_execution_time', 90000);
ini_set('memory_limit', '1G');
date_default_timezone_set("Asia/Jakarta");
$servername = "localhost";
$username = "devcmtmysql";
$password = "Devcmt2019";
$dbname = "cmt";
$uploadChat = '/home/developt/web-cmt-online/cmt-online/public/uploadChat/';
$path = '/home/developt/web-cmt-online/cmt-online/log/';
$expiredDate = date('Y-m-d', strtotime("-3 months", strtotime(date('Y-m-d'))));

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$deletedfiles = 0 ;
$folder = glob($uploadChat."*");
foreach ($folder as $value) {
    $dateFile = date("Y-m-d", filectime($value));
    if ($dateFile<$expiredDate) {
        unlink($value);
        $deletedfiles++;
    }
}
error_log(date('Y-m-d H:i:s').' : Total File Delete = '.$deletedfiles. "\n",3,$path.'log_truncate_'.date('Ymd').'.txt');
$sql = "DELETE FROM chat WHERE updateDate < '".$expiredDate." 00:00:00'";
if ($conn->query($sql) === TRUE) {
    error_log(date('Y-m-d H:i:s').' : Success Query = '.$sql. "\n",3,$path.'log_truncate_'.date('Ymd').'.txt');
} else {
    error_log(date('Y-m-d H:i:s').' : Failed Query = '.$sql. "\n",3,$path.'log_truncate_'.date('Ymd').'.txt');
}

$conn->close();
error_log("\n",3,$path.'log_truncate_'.date('Ymd').'.txt');

?>
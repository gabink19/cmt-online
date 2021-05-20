<?php
ini_set('max_execution_time', 90000);
ini_set('memory_limit', '1G');
date_default_timezone_set("Asia/Jakarta");
$servername = "localhost";
$username = "devcmtmysql";
$password = "Devcmt2019";
$dbname = "cmt";
$path = '/home/developt/web-cmt-online/cmt-online/log/';

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT tp_id,tp_tgl_lahir FROM tbl_peserta";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    error_log(date('Y-m-d H:i:s').' : Total Peserta = '.$result->num_rows. "\n",3,$path.'log_umur_'.date('Ymd').'.txt');
    // output data of each row
    while($row = $result->fetch_assoc()) {
    	$date1 = $row['tp_tgl_lahir'];
		$date2 = date('Y-m-d');

		$diff = abs(strtotime($date2) - strtotime($date1));

		$years = floor($diff / (365*60*60*24));

        $update_umur = "UPDATE tbl_peserta SET tp_umur='".$years."' WHERE tp_id='".$row['tp_id']."'";
        if ($conn->query($update_umur) === TRUE) {
            error_log(date('Y-m-d H:i:s').' : ('.$date1.' - '.$date2.' = '.$years.') --> Success Query = '.$update_umur. "\n",3,$path.'log_umur_'.date('Ymd').'.txt');
        } else {
            error_log(date('Y-m-d H:i:s').' : ('.$date1.' - '.$date2.' = '.$years.') --> Failed Query = '.$update_umur. "\n",3,$path.'log_umur_'.date('Ymd').'.txt');
        }
    }
    echo "Done";
} else {
    echo "0 results";
}

$conn->close();
error_log("\n",3,$path.'log_umur_'.date('Ymd').'.txt');

?>
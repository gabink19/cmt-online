<?php
	
	date_default_timezone_set('Asia/Jakarta');
	$hostDb 	= "localhost";
	$userDb		= "devcmtmysql";
	$passDb		= "Devcmt2019";
	$db			= "cmt";
	$db_port 	= 3306;

	$path  = "/";
	$folderLog  = "/home/developt/web-cmt-online/cmt-online/log";
	$fileName 	= "LOG_Import_".date("Ymd").".log";
	
	$folderread		= '/home/developt/web-cmt-online/cmt-online/public/importBatch/queue';
	$folderresult		= '/home/developt/web-cmt-online/cmt-online/public/importBatch/result';
	$folderafterread		= '/home/developt/web-cmt-online/cmt-online/public/importBatch/finish';
?>

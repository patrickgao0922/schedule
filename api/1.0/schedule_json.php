<?php

include_once "../../database.php";

$is_debug = false;

if(
	!empty($_REQUEST["device_name"]) &&
	!empty($_REQUEST["day_code"])
) {

	if($is_debug) {
    $device_name = "BC1M600241";
  	$day_code = 2; 
	}
	else {
		$device_name = $_REQUEST["device_name"];
		$day_code = $_REQUEST["day_code"];
	}

	$pdo = Database::connect();
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $sql = "SELECT * FROM Schedule WHERE ScheduleRemoteName = ? AND ScheduleDaycode = ?";

	//test
	//var_dump($sql);
  //var_dump($device_name);
  //var_dump($day_code);

  $q = $pdo->prepare($sql);
  $q->execute(array($device_name, $day_code));

	// https://stackoverflow.com/questions/12970771/loop-results-pdo-php
	// https://secure.php.net/manual/en/pdostatement.rowcount.php
	$res_arr = array();
	if($q->rowCount() > 0) {
		while ($row = $q->fetch(PDO::FETCH_ASSOC)) {
			$res_arr[] = $row;
		}
	}
	else {

	}
  Database::disconnect();

	echo json_encode($res_arr);
}
else {

}


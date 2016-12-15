<?php
require_once '../../database.php';

if(
	!empty($_POST["device_name"]) &&
	$_POST["day_code"] != "" &&
	!empty($_POST["time"]) &&	
	!empty($_POST["command"]) 
) {
	$device_name = $_POST["device_name"];
	$day_code = $_POST["day_code"];
	$time = $_POST["time"];
	$command = $_POST["command"];

	$command = __destill_command($command);

	$pdo = Database::connect();
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $sql = "INSERT INTO Schedule (ScheduleRemoteName, ScheduleDaycode, ScheduleTime, ScheduleCommandJSON) values (?, ?, ?, ?)";
  $q = $pdo->prepare($sql);
  $q->execute(array($device_name, $day_code, $time, $command));
	$last_inserted_id = $pdo->lastInsertId();
  Database::disconnect();

	$arr = array(
		"last_inserted_id" => $last_inserted_id,
		"device_name" => $device_name,
		"day_code" => $day_code,
		"time" => $time,
		"command" => $command
	);

	echo json_encode($arr);
}
else {

	$arr = array();
	echo json_encode($arr);
}


// func
/*
Assume your command is like this:

{
	"mac": " 489C3123-CD92-1C64-5BE5-A62A644C314F",
	"name": " BEC-M600223",
	"type": " motolux_11_channel",
	"command": {
		"channel": 1,
		"description": "Up",
		"cmdList": [
			{
				"dly": 0,
				"cmd": "AT%2BPIOB0",
				"rpl": "OK%2BPIOB:0"
			},
			{
				"dly": 0.5,
				"cmd": "AT%2BPIOB1",
				"rpl": "OK%2BPIOB:1"
			}
		]
	}
}
*/
function __destill_command($json_command) {
	$cmds = json_decode($json_command);

  // I don't want to reset anything.
  //unset($cmds->name);
  //unset($cmds->mac);
  //unset($cmds->command->cmdList);

  // clean up white space in the type and the name
  $cmds->type = preg_replace('/\s+/', '', $cmds->type);
  $cmds->name = preg_replace('/\s+/', '', $cmds->name);
  return json_encode($cmds);
}

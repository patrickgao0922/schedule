<?php
  require_once '../../database.php';

  if (!empty($_REQUEST["schedule_id"])) {
    $schedule_id = $_REQUEST['schedule_id'];

    // delete data
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "DELETE FROM Schedule WHERE ScheduleId = ?";
    $q = $pdo->prepare($sql);
    $q->execute(array($schedule_id));
    Database::disconnect();

		$arr = array(
			"is_deleted" => "true",
			"deleted_id" => $schedule_id
		);
		echo json_encode($arr);
  }
	else {
    $arr = array(
			"is_deleted" => "false",
			"schedule_id_empty" => true,
		);
		echo json_encode($arr);		
	}



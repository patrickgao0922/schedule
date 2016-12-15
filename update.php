<?php 
	
	require 'database.php';

	$id = null;
	if ( !empty($_GET['id'])) {
		$id = $_REQUEST['id'];
	}
	
	if ( null==$id ) {
		header("Location: index.php");
	}
	
	if ( !empty($_POST)) {
		// keep track validation errors
		$remoteNameError = null;
		$daycodeError = null;
		$timeError = null;
		$commandError = null;
		
		// keep track post values
		$remoteName = $_POST['remoteName'];
		$daycode= $_POST['daycode'];
		$time= $_POST['time'];
		$command = $_POST['command'];
		
		// validate input
		$valid = true;
		if (empty($remoteName)) {
			$remoteNameError = 'Please enter Name';
			$valid = false;
		}
		
		if (empty($daycode)&& $daycode!="0") {
			$daycodeError = 'Please enter the day code';
			$valid = false;
		}
		
		if (empty($time)) {
			$timeError = 'Please enter the time (HH:MM) in UTC';
			$valid = false;
		}
		
		if (empty($command)) {
			$commandError = 'Please enter a JSON Command';
			$valid = false;
		}		
		
		// update data
		if ($valid) {
			$pdo = Database::connect();
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = "UPDATE Schedule set ScheduleRemoteName= ?, ScheduleDaycode = ?, ScheduleTime = ?, ScheduleCommandJSON =? WHERE ScheduleId = ?";
			$q = $pdo->prepare($sql);
			$q->execute(array($remoteName, $daycode, $time, $command, $id));
			Database::disconnect();
			header("Location: index.php");
		}
	} else {
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "SELECT * FROM Schedule where ScheduleId = ?";
		$q = $pdo->prepare($sql);
		$q->execute(array($id));
    // once fetch with assoc, can do $data[x]  
		$data = $q->fetch(PDO::FETCH_ASSOC);
		$remoteName = $data['ScheduleRemoteName'];
		$daycode = $data['ScheduleDaycode'];
		$time = $data['ScheduleTime'];
		$command = $data['ScheduleCommandJSON'];
		Database::disconnect();

	}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link   href="css/bootstrap.min.css" rel="stylesheet">
    <script src="js/bootstrap.min.js"></script>
</head>

<body>
    <div class="container">
    
    			<div class="span10 offset1">
    				<div class="row">
		    			<h3>Update</h3>
		    		</div>
    		
	    			<form class="form-horizontal" action="update.php?id=<?php echo $id?>" method="post">
					  <div class="control-group <?php echo !empty($remoteNameError)?'error':'';?>">
					    <label class="control-label">Name</label>
					    <div class="controls">
					      	<input name="remoteName" type="text"  placeholder="Name" value="<?php echo !empty($remoteName)?$remoteName:'';?>">
					      	<?php if (!empty($remoteNameError)): ?>
					      		<span class="help-inline"><?php echo $remoteNameError;?></span>
					      	<?php endif; ?>
					    </div>
					  </div>
					  <div class="control-group <?php echo !empty($daycodeError)?'error':'';?>">
					    <label class="control-label">Day code</label>
					    <div class="controls">
					      	<input name="daycode" type="text" placeholder="Day code" value="<?php echo $daycode ?>">
					      	<?php if (!empty($daycodeError)): ?>
					      		<span class="help-inline"><?php echo $daycodeError;?></span>
					      	<?php endif;?>
					    </div>
					  </div>
					  <div class="control-group <?php echo !empty($timeError)?'error':'';?>">
					    <label class="control-label">Time</label>
					    <div class="controls">
					      	<input name="time" type="text"  placeholder="00:00" value="<?php echo !empty($time)?$time:'';?>">
					      	<?php if (!empty($timeError)): ?>
					      		<span class="help-inline"><?php echo $timeError;?></span>
					      	<?php endif;?>
					    </div>
					  <div class="control-group <?php echo !empty($commandError)?'error':'';?>">
					    <label class="control-label">Command</label>
					    <div class="controls">
					      	<textarea name="command" type="text" style="width:250px;" placeholder='{"type":"Becker5Channel","command":{"channel":5,"description":"Up"}}'><?php echo !empty($command)?($command):'';?></textarea>
					      	<?php if (!empty($coomandError)): ?>
					      		<span class="help-inline"><?php echo $commandError;?></span>
					      	<?php endif;?>
					    </div>					    
					  </div>
					  <div class="form-actions">
						  <button type="submit" class="btn btn-success">Update</button>
						  <a class="btn" href="index.php">Back</a>
						</div>
					</form>
				</div>
				
    </div> <!-- /container -->
  </body>
</html>

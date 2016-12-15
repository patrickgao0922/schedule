<?php 
	
  // need db
	require 'database.php';

  // post
	if (!empty($_POST)) {
		// keep track validation errors
		$remoteNameError = null;
		$daycodeError = null;
		$timeError = null;
		$commandError = null;
		
		// keep track post values
    // device_name, day_code, time, cmd
		$remoteName = $_POST['remoteName'];
		$daycode = $_POST['daycode'];
		$time= $_POST['time'];
		$command= $_POST['command'];
		
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
		
		// is valid
		if ($valid) {
      // connnect db
			$pdo = Database::connect();

      // set attr
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

      // $sql with sub
			$sql = "INSERT INTO Schedule (ScheduleRemoteName, ScheduleDaycode, ScheduleTime, ScheduleCommandJSON ) values(?, ?, ?, ?)";

      // prepare
			$q = $pdo->prepare($sql);

      // execute with sub parameter
			$q->execute(array($remoteName, $daycode, $time, $command));

      // disconnect
			Database::disconnect();

      // gone
			header("Location: index.php");
		}
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
		    			<h3>Create a new schedule</h3>
		    		</div>
    		
	    			<form class="form-horizontal" action="create.php" method="post">
					  <div class="control-group <?php echo !empty($nameError)?'error':'';?>">
					    <label class="control-label">Name</label>
					    <div class="controls">
					      	<input name="remoteName" type="text"  placeholder="BC1E310942" value="<?php echo !empty($remoteName)?$remoteName:'';?>">
					      	<?php if (!empty($nameError)): ?>
					      		<span class="help-inline"><?php echo $nameError;?></span>
					      	<?php endif; ?><br/>e.g. BC1E310942 or BC10110006
					    </div>
					  </div>
					  <div class="control-group <?php echo !empty($daycodeError)?'error':'';?>">
					    <label class="control-label">Day code</label>
					    <div class="controls">
					      	<input name="daycode" type="text" placeholder="0" value="<?php echo $daycode;?>">
					      	<?php if (!empty($daycodeError)): ?>
					      		<span class="help-inline"><?php echo $daycodeError;?></span>
					      	<?php endif;?><br/>Monday=1, Sunday=0. <a href="http://www.w3schools.com/jsref/jsref_getutcday.asp">See here</a>
					    </div>
					  </div>
					  <div class="control-group <?php echo !empty($timeError)?'error':'';?>">
					    <label class="control-label">Time</label>
					    <div class="controls">
					      	<input name="time" type="text"  placeholder="07:30" value="<?php echo !empty($mobile)?$mobile:'';?>">
					      	<?php if (!empty($mobileError)): ?>
					      		<span class="help-inline"><?php echo $mobileError;?></span>
					      	<?php endif;?><br/>Time in 24 hour clock (UTC TIME), hours and minutes
					    </div>
					  </div>
					  
					  <div class="control-group <?php echo !empty($commandError)?'error':'';?>">
					    <label class="control-label">Command</label>
					    <div class="controls">
					      	<textarea name="command" type="text" style="width:250px;height:100px;" ><?php echo !empty($command)?$command:'{"type":"Becker5Channel","command":{"channel":5,"description":"Up"}}';?></textarea>
					      	<?php if (!empty($commandError)): ?>
					      		<span class="help-inline"><?php echo $commandError;?></span>
					      	<?php endif;?><br/>Valid types include Becker5Channel,Viva4Channel and Somfy4Channel. Commands can be Up or Down
					    </div>
					  </div>
					  					  
					  <div class="form-actions">
						  <button type="submit" class="btn btn-success">Create</button>
						  <a class="btn" href="index.php">Back</a>
						</div>
					</form>
				</div>
				
    </div> <!-- /container -->
  </body>
</html>

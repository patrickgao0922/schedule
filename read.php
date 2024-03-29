<?php 
	require 'database.php';
	$id = null;
	if ( !empty($_GET['id'])) {
		$id = $_REQUEST['id'];
	}
	
	if ( null==$id ) {
		header("Location: index.php");
	} else {
    //
		$pdo = Database::connect();
    //
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //
		$sql = "SELECT * FROM Schedule where ScheduleId = ?";

    // pdo prepare sql
		$q = $pdo->prepare($sql);

    // query executes with param
		$q->execute(array($id));

    // query fetch data
		$data = $q->fetch(PDO::FETCH_ASSOC);

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
		    			<h3>Read</h3>
		    		</div>
		    		
	    			<div class="form-horizontal" >
					  <div class="control-group">
					    <label class="control-label">Remote</label>
					    <div class="controls">
						    <label class="checkbox">
						     	<?php echo $data['ScheduleRemoteName'];?>
						    </label>
					    </div>
					  </div>
					  <div class="control-group">
					    <label class="control-label">Day</label>
					    <div class="controls">
					      	<label class="checkbox">
						     	<?php echo $data['ScheduleDaycode'];?>
						    </label>
					    </div>
					  </div>
					  <div class="control-group">
					    <label class="control-label">Time</label>
					    <div class="controls">
					      	<label class="checkbox">
						     	<?php echo $data['ScheduleTime'];?>
						    </label>
					    </div>
					  </div>
					  <div class="control-group">
					    <label class="control-label">Command</label>
					    <div class="controls">
					      	<label class="checkbox">
						     	<?php echo $data['ScheduleCommandJSON'];?>
						    </label>
					    </div>
					  </div>					  
					    <div class="form-actions">
						  <a class="btn" href="index.php">Back</a>
					   </div>
					
					 
					</div>
				</div>
				
    </div> <!-- /container -->
  </body>
</html>

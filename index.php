<?php
	date_default_timezone_set('UTC');// NOT Australia/Melbourne
	include_once 'database.php';
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
  	<div class="row">
    	<h3>Remote commands scheduler</h3>
    	<h4><?php echo "UTC Date/Time: ". (date('l jS \of F Y H:i')); ?></h4>
    	</div>
		<div class="row">
		<p>
			<a href="create.php" class="btn btn-success">Create new schedule</a>
		</p>
				
		<table class="table table-striped table-bordered">
		  <thead>
		  	<tr>
					<th>ID</th>
		      <th>Remote</th>
		      <th>Day</th>
		      <th>Time</th>
		      <th>Command</th>
		      <th>Action</th>
		    </tr>
		  </thead>
		  <tbody>
		  <?php 
				$pdo = Database::connect();
				$sql = 'SELECT * FROM Schedule ORDER BY ScheduleId DESC';
        // pdo can run query as well.
	 		  foreach ($pdo->query($sql) as $row) {
			 		echo '<tr>';
					echo '<td>'. $row["ScheduleId"]. '</td>';
					echo '<td>'. $row['ScheduleRemoteName'] . '</td>';
					echo '<td>'. $row['ScheduleDaycode'] . '</td>';
							   	echo '<td>'. $row['ScheduleTime'] . '</td>';
							   	echo '<td>'. $row['ScheduleCommandJSON'] . '</td>';
							   	echo '<td width=150>';
							   	/*
							   	echo '<a class="btn" href="read.php?id='.$row['ScheduleId'].'">Read</a>';
							   	echo '&nbsp;';
							   	*/
							   	echo '<a class="btn btn-success" href="update.php?id='.$row['ScheduleId'].'">Update</a>';
							   	echo '&nbsp;';
							   	echo '<a class="btn btn-danger" href="delete.php?id='.$row['ScheduleId'].'">Delete</a>';
							   	echo '</td>';
							   	echo '</tr>';
					   }
					   Database::disconnect();
					  ?>
				      </tbody>
	            </table>
    	</div>
    	
    	<div class="row">
		<h3>Pending commands</h3>
		<table class="table table-striped table-bordered">
		              <thead>
		                <tr>
		                  <th>Command Id</th>
		                  <th>Date/Time (UTC)</th>
		                  <th>Remote name</th>
		                  <th>Command</th>
		                  <th>Action</th>
		                </tr>
		              </thead>
		              <tbody>
		              <?php 
					   $pdo = Database::connect();
					   $sql = 'SELECT * FROM Command where commandComplete = 0 order by CommandDate DESC';
	 				   foreach ($pdo->query($sql) as $row) {
						   		echo '<tr>';
							   	echo '<td>'. $row['CommandId'] . '</td>';
							   	echo '<td>'. $row['CommandDate'] . '</td>';
							   	echo '<td>'. $row['RemoteName'] . '</td>';
							   	echo '<td>'. $row['CommandJSON'] . '</td>';
							   	
							   	echo '<td width=100>';
							   	//echo '<a class="btn btn-danger" href="delete_command.php?id='.$row['CommandId'].'">Delete</a>';
							   	echo '</td>';
							   	
							   	echo '</tr>';
					   }
					   Database::disconnect();
					  ?>
				      </tbody>
	            </table>

	</div>
    </div> <!-- /container -->
  </body>
</html>

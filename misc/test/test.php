<?php
	date_default_timezone_set('UTC');// NOT Australia/Melbourne
	include 'database.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <script src="js/bootstrap.min.js"></script>
</head>

<body>


</body>

<?php
echo "<br/>connecting to db<br/>";
$pdo = Database::connect();

?>

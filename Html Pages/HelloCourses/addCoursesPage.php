<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<?php
include ('conn/connData.txt');
$mysqli = new mysqli($server, $user, $pass, $dbname, $port);
if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}

$sql = 'SELECT CID, CName FROM Class';
$CID = null;
$CName = null;
//prepare the statement
/*
$stmt = $mysqli->prepare($sql);
if(!$stmt){
	echo "Prepare failed: (" . $myslqi->errno .")" . $mysqli->error;
}
*/
//execute
/*
if(!$stmt->execute()){
	echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
}
*/
//show the result for the sea1
/*
if(!($stmt->bind_result($CIS, $CName))){
	echo "Binding output parameters failed: (" . $stmt->errno . ") " . $stmt->error;
}
*/
echo '234';
?>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>Course Selection</title>
	<link rel="stylesheet" href="css/jquery.multiselect2side.css" type="text/css" media="screen" />
	<script type="text/javascript" src="js/jquery.js" ></script>
	<script type="text/javascript" src="js/jquery.multiselect2side.js" ></script>
	<script type="text/javascript">
		$().ready(function() {
			$('#courses').multiselect2side({
				selectedPosition: 'right',
				moveOptions: false,
				labelsx: '',
				labeldx: '',
				autoSort: true,
				autoSortAvailable: true
				});
				return false;
			});
	</script>
</head>
<body>
		<h3>Courses have taken</h3>
		<p></p>
		<select name="courses" id='courses' multiple='multiple' size='8' >
			<?php
/*
				while($stmt->fetch()){
					each '<option value="$CIS"> '. $CName.'</option>';
				}
*/

			?>
			<option value="1">Option a 1</option>
			<option value="2">Option b 2</option>
			<option value="3">Option c 3</option>
			<option value="4">Option d 4</option>
			<option value="5">Option e 5</option>
			<option value="6">Option f 6</option>
			<option value="7">Option g 7</option>
			<option value="8">Option h 8</option>
			<option value="9">Option i 9</option>
			<option value="10">Option l 10</option>
		</select>		
</body>
</html>

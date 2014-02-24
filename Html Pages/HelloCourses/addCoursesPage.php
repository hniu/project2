<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<?php
include ('conn/connData.txt');
session_start();
$id=$_SESSION['id'];
$name=$_SESSION['name'];
$lastSelectedCourses = array();
//---------------------------------------------set up the connection with mysql
$mysqli = new mysqli($server, $user, $pass, $dbname, $port);
if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}

//---------------------------------------help to load all courses int the selection list
function loadUnselectedCourses(){
	global $mysqli;
	global $id;
	$sql = 'SELECT CID, CName FROM Class WHERE CID NOT IN (SELECT CID from ChosenClass WHERE ID = ?)';
	$CID = NULL;
	$CName = NULL;
	//create statement
	$stmt=$mysqli->prepare($sql);
	//bind the id
	$stmt->bind_param("i", $id);
	//execute query
	$stmt->execute();
	//bind result
	$stmt->bind_result($CID, $CName);
	//print options
	while($stmt->fetch()){
		echo '<option value='.$CID.'> '. $CName.'</option>';
	}
}

//---------------------------------------help to select the chosen class
function loadSelectedCourses(){
	global $mysqli;
	global $id;
	global $lastSelectedCourses;
	$sql = 'select CID, CName from ChosenClass left join Class using (CID) where ID = ?';
	$CID = NULL;
	$CName = NULL;
	//create statement
	$stmt=$mysqli->prepare($sql);
	//bind the id
	$stmt->bind_param("i", $id);
	//execute query
	$stmt->execute();
	//bind result
	$stmt->bind_result($CID, $CName);
	//print options
	while($stmt->fetch()){
		echo '<option value='.$CID.' selected> '. $CName.'</option>';
		array_push($lastSelectedCourses, strval($CID));
	}
	$_SESSION['selCourses'] = $lastSelectedCourses;
}



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
				search: "Search: ",
				selectedPosition: 'right',
				moveOptions: false,
				labelsx: '',
				labeldx: '',
				labelsx: '* Selected *',
				autoSort: true,
				autoSortAvailable: true
				});
				return false;
		});
	</script>
</head>
<body>
	<h3>Welcome, <?php echo $name?></h3>
	<form action="DBOp/chosenCoursesOP.php" method="post">
	<select name="courses[]" id='courses' multiple='multiple' size='8' >
	<?php
		//preload all selected courses

		loadUnselectedCourses();
		loadSelectedCourses();
	?>
	</select>
	<input type="submit" id="save" name="save" value="Save">
	</form>		
</body>

</html>


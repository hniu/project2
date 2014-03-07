<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<?php
include ('conn/connData.txt');
session_start();
$id=$_SESSION['id'];
$name=$_SESSION['name'];
$trackid = $_SESSION['mid'];
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

//---------------------------------------------load all terms
function loadTerm(){
	global $mysqli;
	global $id;
	$sql = 'SELECT TID, TermName from Term';
	$tid = NULL;
	$termname = NULL;
	//create statement
	$stmt=$mysqli->prepare($sql);
	//execute query
	$stmt->execute();
	//bind result
	$stmt->bind_result($tid, $termname);
	//print options
	while($stmt->fetch()){
		echo '<option value='.$tid.'> '. $termname.'</option>';
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
//load all tracks
function getTrack(){
	global $mysqli;
	global $trackid;
	$sql = 'select MID, Major, Track from Major';
	$mid = NULL;
	$major = NULL;
	$tname = NULL;
	//create statement
	$stmt=$mysqli->prepare($sql);
	//execute query
	$stmt->execute();
	//bind result
	$stmt->bind_result($mid, $major, $tname);
	while($stmt->fetch()){
		echo '<option value='. $mid .' '. $major;
		if(strcmp($mid,$trackid) == 0)
			echo " selected";
		echo ' > '. $tname.'</option>';
	}
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

		function getSelValue(sel){
			var value = (sel.options[sel.selectedIndex].value);
			var text = (sel.options[sel.selectedIndex].innerHTML);
			var a = document.getElementById('schedulelink'); //or grab it by tagname etc
			a.href = "DBOp/schedule.php?track=" + text + "&id=" + value;
		}
		function getTermValue(sel){
			var value = (sel.options[sel.selectedIndex].value);
			var text = (sel.options[sel.selectedIndex].innerHTML);
			var a = document.getElementById('termlink'); //or grab it by tagname etc
			a.href = "DBOp/suggest.php?termname=" + text + "&termid=" + value;
		}
	</script>
</head>
<body>
	<h3>Welcome, <?php echo $name?></h3>
	<form action="DBOp/chosenCoursesOP.php" method="post">
	<select name="courses[]" id='courses' multiple='multiple' size='20' >
	<?php
		//preload all selected courses

		loadUnselectedCourses();
		loadSelectedCourses();
	?>
	</select>
	<select name="major" id = "major" onChange='getSelValue(this)'>
	<?php
		//preload all the major
		getTrack();
	?>
	</select>
	<br>
	<select name="term" id = "term" onChange='getTermValue(this)'>
	<?php
		//preload all the term
		loadTerm();
	?>
	</select>

	<br>
	<input type="submit" id="save" value="Save">
	</form>
	<a href="DBOp/schedule.php?track=Foundations&id=5" id='schedulelink' >Next Term Schedule</a>
	<br>
	<a href="DBOp/suggest.php?termid=1&termname=Fall 2013" id="termlink" >Suggest for Next Term</a>
	<br>
	<a href="evaluation.php">Evaluation</a>
	<br>
	<a href="DBOp/comment.php">Comments</a>
	<br>
	<a href="DBOp/logout.php">Logout</a>	
</body>

</html>


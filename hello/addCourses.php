<?php
include 'includes/header.php'; ?>
<!-- Stylesheet for the ratings pages -->
<link rel="stylesheet" href="css/rating.css" type="text/css" media="screen" />
<?php 
//connect to the database
include ('conn/connData.php');
//array for selected courseds; later saved as a session
$lastSelectedCourses = array();
$trackid=$_SESSION['mid'];
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
<!-- Stylesheet for the selection boxes and its js scripts-->
<link rel="stylesheet" href="css/jquery.multiselect2side.css" type="text/css" media="screen" />
<script type="text/javascript" src="js/jquery.js" ></script>
<script type="text/javascript" src="js/jquery.multiselect2side.js" ></script>
<!-- Preload the content in div beforehand; minor fix for latency issue -->
<script type="text/javascript" src="js/preload.js"></script>
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
//get the value of the track that user selected
function getSelValue(sel){
	var value = (sel.options[sel.selectedIndex].value);
	var text = (sel.options[sel.selectedIndex].innerHTML);
	var a = document.getElementById('schedulelink'); //or grab it by tagname etc
	a.href = "schedule.php?track=" + text + "&id=" + value;
}
</script>
<?php include 'includes/body.php'; ?>
<table align="center" width="60%"><tr><td>
	<div style="text-align:left;font-weight:bold;font-size:25px;">Update/Add Courses</div>
	<?php
	if( isset($_SESSION['ERRMSG_ARR']) && is_array($_SESSION['ERRMSG_ARR']) && count($_SESSION['ERRMSG_ARR']) >0 ) {
		echo '<div align="center" style="padding:0; font-weight: bold; color:red;font-size:25px;">';
		foreach($_SESSION['ERRMSG_ARR'] as $msg) {
			echo $msg; 
		}
		echo '</div>';
		unset($_SESSION['ERRMSG_ARR']);
	}
?>
<form action="core/chosenCoursesOP.php" method="post">
	<select name="courses[]" id='courses' multiple='multiple' size='20' >
		<?php
		//preload all selected courses
		loadUnselectedCourses();
		loadSelectedCourses();
	?>
	</select>
	<div align="center">
		Track: <select name="major" id = "major" onChange='getSelValue(this)'>
		<?php
		//preload all the major
		getTrack();
		?>
	</select>
	<br>
	<input type="submit" id="buttonstyle" value="Save">
</div>
</form>
</td>
</table>
<br>
<?php include 'includes/footer.php'; ?>
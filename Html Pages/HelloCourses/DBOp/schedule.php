<?php
include ('../conn/connData.txt');
//---------------------------------------------set up the connection with mysql
$mysqli = new mysqli($server, $user, $pass, $dbname, $port);
if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}
//from get
$mid = $_GET['id'];
$tname = $_GET['track'];
//from session
session_start();
$courses = $_SESSION['selCourses'];
$name = $_SESSION['name'];

$typename=NULL;
$totalCredit=NULL;
$GID=NULL;
$groupAlt=NULL;
$graded=NULL;
$classAlt=NULL;
$cid=NULL;
$cname=NULL;
$credit=NULL;

$keys = array();

function printSchedule($sql, $keys){
	global $mysqli;
	global $mid;
	$stmt = $mysqli->prepare($sql);
	if(!$stmt){
		echo "Prepare failed: (" . $mysqli->errno .")" . $mysqli->error;
	}
	if(!$stmt->bind_param("i", $mid)){
		echo "Binding parameters failed: (" . $stmt->errno . ") ".  $stmt->error;
	}
	if(!$stmt->execute()){
		echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
	}
	//check if the user exist
	if(!($stmt->bind_result($typename,
		$totalCredit,
		$GID,
		$groupAlt,
		$graded,
		$classAlt,
		$cid,
		$cname,
		$credit))){
		echo "Binding output parameters failed: (" . $stmt->errno . ") " . $stmt->error;
	}
	//bind result

	while($stmt->fetch()){
    		if(!in_array($typename,$keys , true)){
			echo '<br>'.$typename.'<br>';
      	  		array_push($keys, $typename);
		}
		echo $total .'...'.$totalCredit.'...'. $GID.'...'.$groupAlt.'...'. $graded.'...'. $classAlt.'...'. $cid.'...'. $cname.'...'. $credit.'<br>';
		
	}
	$stmt->close();

}

function isLearned($CID){
	global $courses;
	if(in_array(strval($CID), $courses)){
		return True;
	}
	return False;
}

?>

<html>
<head>
<title>
Course Requirements
</title>
</head>
<body>

<strong>
<font size=13>
Courses in Track (<?php echo $tname?>) for <?php echo $name?> in Next Term.
</font>
</strong>
<table border='1'>
<tr>
<td>TypeName</td><td>TotalCredit</td><td>GID</td><td>GroupAlternetive</td>
<td>Graded</td>
<td>ClassAlternetive</td>
<td>CID</td><td>CName</td><td>Credit</td>
</tr>
<?php
$nextTerm = 'SELECT TypeName, TotalCredit, GID, GroupAlternetive, Graded, ClassAlternetive, CID, CName, Credit FROM TrackClasses right join ScheduleClass Using (CID)  WHERE MID = ?';
printSchedule($nextTerm, $keys);
?>
</table>


<strong>
<font size=13>
Courses in Track (<?php echo $tname?>) for <?php echo $name?>.
</font>
</strong>
<table border='1'>
<tr>
<td>TypeName</td><td>TotalCredit</td><td>GID</td><td>GroupAlternetive</td>
<td>Graded</td>
<td>ClassAlternetive</td>
<td>CID</td><td>CName</td><td>Credit</td>
</tr>
<?php
$allrequired = 'SELECT TypeName, TotalCredit, GID, GroupAlternetive, Graded, ClassAlternetive, CID, CName, Credit FROM TrackClasses WHERE MID = ?';
printSchedule($allrequired, $keys);

$mysqli->close();
?>
</table>
</body>
</html>

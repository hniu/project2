<?php
include ('../conn/connData.txt');
session_start();
$id=$_SESSION['id'];
$name=$_SESSION['name'];
$lastSelectedCourses = $_SESSION['selCourses'];
//submit variable
$MID = $_POST['major'];
$_SESSION['mid'] = $MID;

//---------------------------------------------set up the connection with mysql
$mysqli = new mysqli($server, $user, $pass, $dbname, $port);
if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}

//---------------------------------------help to insert new record in the ChosenClass table

function addCourse($CID){
	global $mysqli;
	global $id;
	$sql = 'insert into ChosenClass values(?,?)';
	$stmt = $mysqli->prepare($sql);
	if(!$stmt){
		echo "Prepare failed: (" . $mysqli->errno .")" . $mysqli->error;
	}
	if(!$stmt->bind_param("ii", $id, $CID)){
			echo "Binding parameters failed: (" . $stmt->errno . ") ".  $stmt->error;
	}
	if(!$stmt->execute()){
		echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
	}
	$stmt->close();
}

//update the track in the user table
function updateTrack($MID){
	global $mysqli;
	global $id;
	$sql = 'update User set MID = ? WHERE ID = ?';
	$stmt = $mysqli->prepare($sql);
	if(!$stmt){
		echo "Prepare failed: (" . $mysqli->errno .")" . $mysqli->error;
	}
	if(!$stmt->bind_param("ii", $MID, $id)){
			echo "Binding parameters failed: (" . $stmt->errno . ") ".  $stmt->error;
	}
	if(!$stmt->execute()){
		echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
	}
	$stmt->close();
}

//---------------------------------------help to delete record in the ChosenClass table

function deleteCourse($CID){
	global $mysqli;
	global $id;
	$sql = 'delete from ChosenClass where ID=? and CID=?';
	$stmt = $mysqli->prepare($sql);
	if(!$stmt){
		echo "Prepare failed: (" . $mysqli->errno .")" . $mysqli->error;
	}
	if(!$stmt->bind_param("ii", $id, $CID)){
		echo "Binding parameters failed: (" . $stmt->errno . ") ".  $stmt->error;
	}

	if(!$stmt->execute()){
		echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
	}
	$stmt->close();
}

//---------------------------------------help to find course name
function findCName($CID){
	global $mysqli;
	$sql = 'SELECT CName FROM Class WHERE CID = ?';
	$CName = NULL;
	//create statement
	$stmt=$mysqli->prepare($sql);
	//bind the id
	$stmt->bind_param("i", $CID);
	//execute query
	$stmt->execute();
	//bind result
	$stmt->bind_result($CName);
	if($stmt->fetch()){
		$stmt->close();
		return $CName;
	}else{
		$stmt->close();
		return '';
	}
}

//check if the course has the pre-request
function checkReg($CID){
	global $mysqli;
	global $list;
	//two array: one is for elective required courses, one is for required courses.
	$electives = array();
	$required = array();
	$electivessql = "Select CID2 from DependentClass dc left join Class c on dc.CID1 = c.CID where CID1 = ?  and DCAlternetive='Y' and 
		((STRCMP(CName, 'CIS 200') = 1 and STRCMP(CName, 'CIS 999') = -1) OR (STRCMP(CName, 'MATH 230') = 1 and STRCMP(CName, 'MATH 999') = -1))";
	$stmt = $mysqli->prepare($electivessql);
	$elec=NULL;
	if(!$stmt){
		echo "Prepare failed: (" . $mysqli->errno .")" . $mysqli->error;
	}
	if(!$stmt->bind_param("i", $CID)){
		echo "Binding parameters failed: (" . $stmt->errno . ") ".  $stmt->error;
	}

	if(!$stmt->execute()){
		echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
	}
	if(!($stmt->bind_result($elec))){
		echo "Binding output parameters failed: (" . $stmt->errno . ") " . $stmt->error;
	}
	while($stmt->fetch()){
		array_push($electives, $elec);
	}
	//get the couses must be taken
	$req=NULL;
	$requiredsql = "Select CID2 from DependentClass dc left join Class c on dc.CID1 = c.CID where CID1 = ?  and DCAlternetive='N' and 
		((STRCMP(CName, 'CIS 200') = 1 and STRCMP(CName, 'CIS 999') = -1) OR (STRCMP(CName, 'MATH 230') = 1 and STRCMP(CName, 'MATH 999') = -1))";
	$stmt = $mysqli->prepare($requiredsql);
	if(!$stmt){
		echo "Prepare failed: (" . $mysqli->errno .")" . $mysqli->error;
	}
	
	if(!$stmt->bind_param("i", $CID)){
		echo "Binding parameters failed: (" . $stmt->errno . ") ".  $stmt->error;
	}

	if(!$stmt->execute()){
		echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
	}
	if(!($stmt->bind_result($req))){
		echo "Binding output parameters failed: (" . $stmt->errno . ") " . $stmt->error;
	}
	while($stmt->fetch()){
		array_push($required, $req);
	}
	//if no required
	if(count($required) != 0){
		//all required in the list
		$neededAnd = array_diff($required, $list);
		if(count($neededAnd) != 0){
			$name = findCName($CID);
			echo "To take {$name}, you need to take all the courses below: ";
			foreach ($neededAnd as $c){
				echo findCName($c). ' ';
			}
			echo '<br>';
			return false;
		}
	}
	//if no electives
	if(count($electives) != 0){
		//anyone in the list will be fine
		$neededOr = array_intersect($electives, $list);
		if(count($neededOr) == 0){
			echo "To take {$name}, you need to take at least one courses below: ";
			foreach ($neededOr as $c){
				echo findCName($c). ' ';
			}
			echo '<br>';
			return false;
		}
	}
	return true;
}



//after selected:
//
//if CID in db is not in list: delete the record from db
//if CID in db is in list: delete the record from list
//if list is not null: insert all record to the db
$list = $_POST['courses'];
//if the list is empty, then create the array to compare
if ($list == NULL){
	$list = array();
}

$deleteList = array_diff($lastSelectedCourses , $list);

foreach ($deleteList as $CID){
	//print "delete" . $CID;
	//if(checkReg($CID)){
		deleteCourse($CID);
	//}
}

$insertList = array_diff($list, $lastSelectedCourses );

//update track
updateTrack($MID);
$alladded = True;
foreach ($insertList as $CID){
	//print "insert" . $CID;
	if(checkReg($CID)){
		addCourse($CID);
	}else{
		$alladded = False;
	}
}
if($alladded){
	header("Location: ../addCoursesPage.php");
}else{
	echo '<br>';
	echo '<a href="../addCoursesPage.php">Back</a>';
}
$mysqli->close();

?>

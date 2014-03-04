<?php
include ('../conn/connData.txt');
session_start();
$id=$_SESSION['id'];
$name=$_SESSION['name'];
$lastSelectedCourses = $_SESSION['selCourses'];
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

//---------------------------------------help to search record in the ChosenClass table
/*
function isCourseExistInDB($CID){
	global $mysqli;
	global $id;
	$result = NULL;
	$sql = 'select count(CID) from ChosenClass where ID = ? and CID = ?';
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
	if(!($stmt->bind_result($result))){
		echo "Binding output parameters failed: (" . $stmt->errno . ") " . $stmt->error;
	}
	if(!$stmt->fetch()){
		echo "Failed to fetch: (" . $stmt->errno . ") " . $stmt->error;
	}
	if(intval($result) == 0){
		return false;
	}else{
		return true;
	}
	$stmt->close();

}
*/



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
	deleteCourse($CID);
}

$insertList = array_diff($list, $lastSelectedCourses );

foreach ($insertList as $CID){
	//print "insert" . $CID;
	addCourse($CID);
}

Header( "Location: ../addCoursesPage.php" );

$mysqli->close();

?>
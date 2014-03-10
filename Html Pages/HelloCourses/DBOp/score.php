<?php
include ('../conn/connData.txt');
//connect the database
$mysqli = new mysqli($server, $user, $pass, $dbname, $port);
if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}

//get all the selected courses
session_start();
$courses = $_SESSION['selCourses'];
$score = 0;
//get all the score of those selected courses
foreach ($courses as $c){
	//catch all the grate for the courses
	$evals = intval($_POST[$c]);
	$total = intval($_POST[$c.'total']);
	$avg = doubleval($_POST[$c.'avg']);
	if($evals == NULL){
		$score = 0;
	}else{
		$score = $evals;
	}
	echo "total".$total;
	echo "avg".$avg;
	echo "evals".$evals;
	$newtotal = $total + 1;
	$newavg = ($avg * $total + $score) / $newtotal;
	echo $score;
	echo '<br>';
	echo $newtotal;
	echo '<br>';
	echo $newavg;
	echo '<br>';
	echo '<br>';
	echo '<br>';

	//get all score without adding new one
	$sql = "update Class set EvaluationNumber=?, EvaluationRate=? where CID = ?";
	$stmt = $mysqli->prepare($sql);

	if(!$stmt){
		echo "Prepare failed: (" . $mysqli->errno .")" . $mysqli->error;
	}

	if(!$stmt->bind_param("idi", $newtotal, $newavg, $c)){
		echo "Binding parameters failed: (" . $stmt->errno . ") ".  $stmt->error;
	}

	if(!$stmt->execute()){
		echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
	}
}
$stmt-> close();
$mysqli->close();
header("Location: ../evaluation.php");
?>
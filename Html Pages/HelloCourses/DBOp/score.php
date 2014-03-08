<?php
//get all the selected courses
session_start();
$courses = $_SESSION['selCourses'];
$score = 0;
//get all the score of those selected courses
foreach ($courses as $c){
	//catch all the grate for the courses
	$evals = $_POST[$c];
	if($evals == NULL){
		$score = 0;
	}else{
		$score = $evals;
	}
	
	$sql = "Update comment";
}
?>
<html>
<head><title>Evaluation</title></head>
	<link rel="stylesheet" href="css/rating.css" type="text/css" media="screen" />
	<script type="text/javascript" src="js/rating.js" ></script>
<body>

<form name="eval" action="DBOp/score.php" method="post">
<?php
include ('conn/connData.txt');

//---------------------------------------------set up the connection with mysql
$mysqli = new mysqli($server, $user, $pass, $dbname, $port);
if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}
// find the course name according to its id
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
//get all the description for the one course id
function findDes($CID){
	global $mysqli;
	$sql = 'SELECT Description FROM Class WHERE CID = ?';
	$des = NULL;
	//create statement
	$stmt=$mysqli->prepare($sql);
	//bind the id

	$stmt->bind_param("i", $CID);
	//execute query
	$stmt->execute();

	//bind result

	$stmt->bind_result($des);

	if($stmt->fetch()){
		$stmt->close();
		return $des;
	}else{
		$stmt->close();
		return '';
	}
}

//get the comment from the database
function getScore($CID){
	global $mysqli;
	$sql = 'SELECT EvaluationRate, EvaluationNumber FROM Class WHERE CID = ?';
	$score = NULL;
	$total = NULL;
	//create statement
	$stmt=$mysqli->prepare($sql);
	//bind the cid
	$stmt->bind_param("i", $CID);
	//execute query
	$stmt->execute();
	//bind result
	$stmt->bind_result($score, $total);
	if($stmt->fetch()){
		echo "<Strong>Rating: ";
		if ($score == NULL){
			$score = 0;
		}
		echo $score;
		echo "</Strong><br>";
		echo "<Strong>Rating By ";
		if ($total == NULL){
			$total = 0;
		}
		echo $total;
		echo " People</Strong><br>";
		echo '<input type="hidden" name= '.$CID.'total value= '.$total.'>';
		echo  '<input type="hidden" name= '.$CID.'avg value='.$score.'>';


	}
	$stmt->close();
}

session_start();
$courses = $_SESSION['selCourses'];

foreach ( $courses as $CID ){
	echo findCName($CID);
	echo '<br><font color=blue>Course Description:';
	$result = findDes($CID);
	if(strlen($result) == 1){
		echo 'None';
	}else{
		echo $result;
	}
	echo '</font><br>';
	$rating = '<span class="star-rating">
  	<input type="radio" name= '.$CID.' value="1"><i></i>
  	<input type="radio" name= '.$CID.' value="2"><i></i>
  	<input type="radio" name= '.$CID.' value="3"><i></i>
  	<input type="radio" name= '.$CID.' value="4"><i></i>
  	<input type="radio" name= '.$CID.' value="5"><i></i>
	</span><br>';
	echo $rating;
	getScore($CID);
}

$mysqli->close();
?>
<input type="submit" value="Evaluate">
</form>
<a href="addCoursesPage.php">Home</a>
</body>
</html>
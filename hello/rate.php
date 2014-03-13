<?php
session_start();
if($_SESSION[authed]!='yes'){
header('location:login.html');
exit();
}
?>
<html>
<head><title>Evaluation</title></head>
	<link rel="stylesheet" href="css/rating.css" type="text/css" media="screen" />
	<script type="text/javascript" src="js/rating.js" ></script>
<body>

<form name="eval" action="core/score.php" method="post">
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
		echo round($score, 1);
		echo "</Strong><br>";
		echo "<Strong>Rating By ";
		if ($total == NULL){
			$total = 0;
		}
		echo $total;
		echo " People</Strong><br><br>";
		echo '<input type="hidden" name= '.$CID.'total value= '.$total.'>';
		echo  '<input type="hidden" name= '.$CID.'avg value='.$score.'>';


	}
	$stmt->close();
}

session_start();
$courses = $_SESSION['selCourses'];

foreach ( $courses as $CID ){
	echo '<font size="5"><b>'.findCName($CID).'</b></font>';
	echo '<br><font color="#353542">Course Description:';
	$result = findDes($CID);
	if(strlen($result) == 1){
		echo 'None';
	}else{
		echo $result;
	}
	echo '</font><br>';
	$rating = '<nav class="segmented-button">
  <b style="color:#ffffff;">Rate:</b> <input type="radio" name='.$CID.' value="1" id="one'.$CID.'">
  <label for="one'.$CID.'" class="first">1</label>
  <input type="radio" name='.$CID.' value="2" id="two'.$CID.'">
  <label for="two'.$CID.'">2</label>
  <input type="radio" name='.$CID.' value="3" id="three'.$CID.'">
  <label for="three'.$CID.'">3</label>
   <input type="radio" name='.$CID.' value="4" id="four'.$CID.'">
  <label for="four'.$CID.'">4</label>
  <input type="radio" name='.$CID.' value="5" id="five'.$CID.'">
  <label for="five'.$CID.'" class="last">5</label>
</nav>';
	echo $rating;
	getScore($CID);
	echo '<hr style="border: 1px solid #1a939c">';
}

$mysqli->close();
?>
<input type="submit" id="buttonstyle" value="Evaluate">
</form>
</body>
</html>
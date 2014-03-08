<html>
<head>
<title>All Courses</title>
</head>
<body>

<div id="div1" style="float:left;width:50%"> 
<?php
include ('../conn/connData.txt');

//---------------------------------------------set up the connection with mysql
$mysqli = new mysqli($server, $user, $pass, $dbname, $port);
if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}

// find the course name according to its id
function findCourses(){
	global $mysqli;
	$sql = 'SELECT CID, CName FROM Class';
	$CID = NULL;
	$CName = NULL;
	//create statement
	$stmt=$mysqli->prepare($sql);
	//execute query
	$stmt->execute();
	//bind result
	$stmt->bind_result($CID,$CName);
	while($stmt->fetch())
	{
		echo '<a href="comment.php?cid='.$CID.'">' . $CName.'</a>';
		echo '<br>';
	}
	$stmt->close();
}
//show all the courese
findCourses();
?>
</div>

<div id="div2" style="float:left;width:48%">
<?php
$cid=$_GET['cid'];

// find the course name according to its id
function findDes(){
	global $mysqli;
	global $cid;
	$sql = 'select CName,Description,Credit,EvaluationRate from Class where CID='.$cid;
	$CName = NULL;
	$Description = NULL;
	$Credit = NULL;
	$ER = NULL;
	//create statement
	$stmt=$mysqli->prepare($sql);
	//execute query
	$stmt->execute();
	//bind result
	$stmt->bind_result($CName,$Description,$Credit,$ER);
	if($stmt->fetch())
	{
		echo '<div class="text" style=" text-align:center;"> <h1>' .$CName.'</h1></a>';
		echo '<br><br>';
		echo '<div class="text" style=" text-align:left;"> Credit: <b>'. $Credit.'</b></a>';
		echo '<br>';
		echo '<div class="text" style=" text-align:left;"> Rating: <b>'.$ER.'</b></a>';
		echo '<br>';
		echo '<div class="text" style=" text-align:left;">	'.$Description.'</a>';
		echo '<br>';
	}
	$stmt->close();

}
//show all the courese
if($cid != NULL){
	findDes();
}

$mysqli->close();
?>
</div>

</body>
</html>
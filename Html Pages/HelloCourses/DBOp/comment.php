<html>
<head>
<title>All Courses</title>
</head>
<body>

<a href="../addCoursesPage.php">HOME</a>

<div id="div1" style="float:left;width:50%"> 
<?php
include ('../conn/connData.txt');

//---------------------------------------------set up the connection with mysql
$mysqli = new mysqli($server, $user, $pass, $dbname, $port);
if ($mysqli->connect_errno) 
{
    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}

//<<<<<<< HEAD
//=======
session_start();
$id=$_SESSION['id'];

//>>>>>>> Update for COmment
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
$_SESSION['precid'] = $cid;

// find the course name according to its id
//<<<<<<< HEAD
//=======
function findDes()
{
//>>>>>>> Update for COmment
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
//<<<<<<< HEAD

}

function findComment()
{
	global $mysqli;
	global $cid;
	$sql = 'select Name,Comment,Time from ClassComment as cc join User as u on cc.ID=u.ID where CID='.$cid;
	$SName = NULL;
	$SComment = NULL;
	$Time = NULL;
		//create statement
	$stmt=$mysqli->prepare($sql);
	//execute query
	$stmt->execute();
	//bind result
	$stmt->bind_result($SName,$SComment,$Time);
	While($stmt->fetch())
	{
		echo '<hr>';
		echo '<div class="text" style=" text-align:left;"> <b>' .$SName.'</b> : '. $Time .'</a> <br>';
		echo '<div class="text" style=" text-align:left;"> ' .$SComment.'</a> <br>';
		
	}
	$stmt->close();
}

function submitComment()
{
	echo '<form name="content" method="get" action='.$_SERVER['PHP_SELF'].'>';
	echo '<div class="text" style=" text-align:left;"> You say: </a> <br>';
	echo '<textarea name="content" cols="36" rows="8" id="content" required = "required" style="border: 1 solid #888888;LINE-HEIGHT:18px;padding: 3px;"></textarea>';
	echo '<input type="hidden" name="cid" value='.$_SESSION['precid'].'>';
	echo '<input type="submit" value="Submit"/>';
	echo '</form>';
}

function commentInsertion()
{
	global $mysqli;
	global $id;
	global $cid;
	$query = 'INSERT INTO ClassComment(CID, ID, Comment) VALUES (?,?,?)';
	#$date = date('Y-m-d H:i:s');
	$stmt = $mysqli->prepare($query);
	if(!$stmt){
		echo "Prepare failed: (" . $mysqli->errno .")" . $mysqli->error;
	
	}
	if(!$stmt->bind_param("iis",  $cid, $id, $_GET['content'])){
			echo "Binding parameters failed: (" . $stmt->errno . ") ".  $stmt->error;
	}
		
	if(!$stmt->execute()){
		echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
	}
	$stmt -> close();
}

if(!empty($_GET['content'])){
	commentInsertion();

}

if($cid != NULL)
{
	findDes();
	findComment();
	submitComment();
//>>>>>>> Update for COmment
}



$mysqli->close();
?>
</div>

</body>
</html>
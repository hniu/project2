<?php
session_start();
if($_SESSION[authed]!='yes'){
header('location:login.html');
exit();
}
?>
<link rel="stylesheet" href="css/rating.css" type="text/css" media="screen" />

<?php
include ('conn/connData.txt');

//---------------------------------------------set up the connection with mysql
$mysqli = new mysqli($server, $user, $pass, $dbname, $port);
if ($mysqli->connect_errno) 
{
    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}

session_start();
$id=$_SESSION['id'];

?>

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
		echo '<div class="text" style="text-align:center; width:100px; height:70px; float:left; 
		background:#303a3b;color:#fff;font-size:20px;padding-top:18px;margin-bottom:5px;">RATING<br><b>'.round($ER, 1).'</b>
		</div><div style="float:left; color:#cffaff;font-size:30px; padding-left:10px; padding-top:20px;"><b>'.$CName.'</b></div>';
		echo '<br><div class="text" style="clear:both; text-align:left;"> Credit: <b>'. $Credit.'</b></div>';
		echo '<br><br>';
		echo '<div class="text" style=" text-align:left;">	'.$Description.'</div>';
		echo '<br><br>';
		echo '<hr style="border: 1px solid #0f9099">';
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
		echo '<div class="text" style=" text-align:left;"> <b>' .$SName.'</b> : '. $Time .'</div> <br>';
		echo '<div class="text" style=" text-align:left;"> ' .$SComment.'</div> <br>';
		echo '<hr style="border: 1px solid #0f9099">';
		
	}
	$stmt->close();
}

function submitComment()
{
	echo '<div align="center">';
	echo '<form name="content" method="get" action='.$_SERVER['PHP_SELF'].'>';
	echo '<br><br><div class="text" style=" text-align:left;"> Comments: </div> <br>';
	echo '<textarea name="content" cols="50" rows="8" id="content" required = "required" style="border: 1 solid #888888;LINE-HEIGHT:18px;padding: 3px; opacity:.7;"></textarea>';
	echo '<input type="hidden" name="cid" value='.$_SESSION['precid'].'>';
	echo '<br><input type="submit" id="buttonstyle" value="Post"/>';
	echo '</form></div>';
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

</body>
</html>
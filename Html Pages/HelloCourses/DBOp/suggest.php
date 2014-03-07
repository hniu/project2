<?php
include ('../conn/connData.txt');
session_start();
$id=$_SESSION['id'];
$name=$_SESSION['name'];
$termid=$_GET['termid'];
$termname=$_GET['termname'];

//---------------------------------------------set up the connection with mysql
$mysqli = new mysqli($server, $user, $pass, $dbname, $port);
if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}
//suggest a certain term courses for the one user id
function suggest($termid, $id){
	global $mysqli;
	$sql = 'select tc.MID, TypeName, TotalCredit, GID, GroupAlternetive, Graded, ClassAlternetive, tc.CID, CName, Credit, TID from User as u
	join TrackClasses as tc on u.MID =tc.MID
	join ScheduleClass as sc on tc.CID = sc.CID
	join 
	(
	select a.CID2 from 
	(select * from DependentClass where CID2 not in (select CID from ChosenClass as cc where cc.ID=?)) as a 
	where a.CID2 not in (select CID1 from DependentClass where CID2 not in (select CID from ChosenClass as cc where cc.ID=?))
	group by CID2
	union
	select CID from Class where CID not in (select CID1 from DependentClass) and CID not in (select CID from ChosenClass as cc where cc.ID=?)
	) as a on tc.CID=a.CID2
	where u.ID=? and sc.TID = ?';
	
	$stmt = $mysqli->prepare($sql);
	if(!$stmt){
		echo "Prepare failed: (" . $mysqli->errno .")" . $mysqli->error;
	}

	if(!$stmt->bind_param("iiiii", $id, $id, $id, $id, $termid)){
		echo "Binding parameters failed: (" . $stmt->errno . ") ".  $stmt->error;
	}

	$MID=NULL;
	$TypeName=NULL;
	$TotalCredit=NULL;	
	$GID=NULL;
	$GroupAlternetive=NULL;
	$Graded=NULL;
	$ClassAlternetive=NULL;
	$CID=NULL;
	$CName=NULL;
	$Credit=NULL;
	$TID=NULL;
	
	if(!$stmt->execute()){
		echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
	}

	if(!($stmt->bind_result($MID, $TypeName, $TotalCredit, $GID, $GroupAlternetive, $Graded, $ClassAlternetive, $CID, $CName, $Credit, $TID))){
		echo "Binding output parameters failed: (" . $stmt->errno . ") " . $stmt->error;
	}
	while($stmt->fetch()){
		echo '<tr>
		<td>'.$MID.'</td>
		<td>'.$TypeName.'</td>
		<td>'.$TotalCredit.'</td>
		<td>'.$GID.'</td>
		<td>'.$GroupAlternetive.'</td>
		<td>'.$Graded.'</td>	
		<td>'.$ClassAlternetive.'</td>
		<td>'.$CName.'</td>
		<td>'.$Credit.'</td>
		</tr>';	
	}
}
?>


<html>
<head>
<title>Suggestion For Next Term</title>
</head>
<body>
Courses Suggestion for <?php echo $termname?>
<table border="1">
<tr><td>MID</td><td>TypeName</td><td>TotalCredit</td><td>GID</td><td>GroupAlternative</td><td>Graded</td><td>ClassAlternative</td>
<td>CName</td><td>Credit</td></tr>
<?php suggest($termid, $id)?>
</table>
</body>
</html>
<?php
include 'includes/header.php'; ?>
<script src="js/dashscripts.js"></script>
<script type="text/javascript" src="js/preload.js"></script>
<?php 
include ('conn/connData.txt');
session_start();
$id=$_SESSION['id'];
$name=$_SESSION['name'];
$termid=$_GET['termid'];
$termname=$_GET['termname'];
$trackid=$_SESSION['mid'];

//---------------------------------------------set up the connection with mysql
$mysqli = new mysqli($server, $user, $pass, $dbname, $port);
if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}
//suggest a certain term courses for the one user id
function suggest($termid, $id, $termname){
	$termname = str_replace(' ', '-', $termname);
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
		$code = explode(" ", $CName);
		echo '<tr>
		<td>'.$TypeName.'</td>
		<td><a href=core/coursetimes.php?coursecode='.$code[0].'&coursenum='.$code[1].'&termid='.$termid.'&termname='.$termname.' id="pop" target="upsched" style="color:blue;">'.$CName.'</td>
		<td>'.$Credit.'</td>
		</tr>';	
	}
}
?>
<?php 
include 'includes/body.php';?>
<div id="overlay_form" style="display:none">
<iframe src="about:blank" name="upsched" width="600" height="380" frameborder="0"></iframe>
<br>
<a href="about:blank" target="upsched" id="close"><b>CLOSE</b></a>
</div>
<div align="center" style="padding:0; font-weight: bold; color:black;font-size:20px;">
	Suggested courses for <?php echo $termname?> based on your completed requirements and chosen track:
</div>
<table border="0" style="font-size:16px; color:black;">
<tr><td>Fulfills</td><td>Course Name</td><td>Credit</td></tr>
<?php suggest($termid, $id, $termname)?>
</table>
<br><br>
<?php include 'includes/footer.php'; ?>
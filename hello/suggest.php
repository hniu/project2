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
	$sql = 'select TypeName, CName, Credit from User as u
	join TrackClasses as tc on u.MID =tc.MID
	join ScheduleClass as sc on tc.CID = sc.CID
	join
	(
select CID from Class
where CID not in (select CID from ChosenClass as cc where cc.ID=?)
and CID not in (select CID1 from DependentClass as dc
where CID2 not in (select CID from ChosenClass as cc where cc.ID=?))
	) as a on tc.CID=a.CID
	where u.ID=? and sc.TID = ?
group by TypeName, CName, Credit';
	
	$stmt = $mysqli->prepare($sql);
	if(!$stmt){
		echo "Prepare failed: (" . $mysqli->errno .")" . $mysqli->error;
	}

	if(!$stmt->bind_param("iiii", $id, $id, $id, $termid)){
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

	if(!($stmt->bind_result($TypeName, $CName, $Credit))){
		echo "Binding output parameters failed: (" . $stmt->errno . ") " . $stmt->error;
	}
	while($stmt->fetch()){
		$code = explode(" ", $CName);
		echo '<tr>
		<td style="border-bottom:1px solid #cfcfcf;">'.$TypeName.'</td>
		<td style="padding:10px;border-bottom:1px solid #cfcfcf;"><a href=core/coursetimes.php?coursecode='.$code[0].'&coursenum='.$code[1].'&termid='.$termid.'&termname='.$termname.' id="pop" target="upsched" style="color:#0715b2;">'.$CName.'</td>
		<td style="border-bottom:1px solid #cfcfcf;">'.$Credit.'</td>
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
<div align="center" style="padding:0; font-weight: bold; color:black; font-size:20px;">
	Suggested courses for <?php echo $termname?> <br>based on your completed requirements and chosen track:<br><br>
</div>
<table border="0" style="background:#f1f1f1;font-size:16px; color:black; width:800px;*border-collapse: collapse; border-spacing: 0px;">
	<tr style="background:#0facb5;"><td width="300" style="padding:10px;">Fulfills</td><td>Course Name</td><td>Credit</td></tr>
	<?php suggest($termid, $id, $termname)?>
</table>
<br><br>
<?php include 'includes/footer.php'; ?>
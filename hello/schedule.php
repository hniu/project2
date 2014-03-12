<?php
include 'includes/header.php'; ?>
<script type="text/javascript" src="js/preload.js"></script>
<?php 
include ('conn/connData.php');
//from get
$mid = $_GET['id'];
$tname = $_GET['track'];
$courses = $_SESSION['selCourses'];
$trackid=$_SESSION['mid'];

$typename=NULL;
$totalCredit=NULL;
$GID=NULL;
$groupAlt=NULL;
$graded=NULL;
$classAlt=NULL;
$cid=NULL;
$cname=NULL;
$credit=NULL;

$keys = array();

function printSchedule($sql, $keys){
	global $mysqli;
	global $mid;
	$stmt = $mysqli->prepare($sql);
	if(!$stmt){
		echo "Prepare failed: (" . $mysqli->errno .")" . $mysqli->error;
	}
	if(!$stmt->bind_param("i", $mid)){
		echo "Binding parameters failed: (" . $stmt->errno . ") ".  $stmt->error;
	}
	if(!$stmt->execute()){
		echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
	}
	//check if the user exist
	if(!($stmt->bind_result($typename,
		$totalCredit,
		$GID,
		$groupAlt,
		$graded,
		$classAlt,
		$cid,
		$cname,
		$credit))){
		echo "Binding output parameters failed: (" . $stmt->errno . ") " . $stmt->error;
	}
	echo '<table width="905" style="*border-collapse: collapse; 
	border-spacing: 0px;"><tr><td bgcolor="#fff">';
	//bind result
	while($stmt->fetch()){
    		if(!in_array($typename,$keys , true)){
			echo '<div style="clear:both; padding:8px; background:#474d81; color:#fff;">'.$typename.' (' . $totalCredit . ' cr)</div>
			<div style="clear:both; padding:8px; background:#e7e7e7; color:#777777; font-style: italic;">';
			if(strpos($typename, "Lower-Division Core") !== false){echo 'Complete all.</div>';}
			if(strpos($typename, "Upper-Division Core") !== false){echo 'Complete all.</div>';}
			if(strpos($typename, "Mathematics Requirements 1") !== false){echo 'Complete one of the sequences below (Calculus, Calculus with Theory, or Calc for Biol Sci).</div>';}
			if(strpos($typename, "Mathematics Requirements 2") !== false){echo 'Choose 2 courses from below.</div>';}
			if(strpos($typename, "Science") !== false){echo 'Complete one of the groups below (Group 7, 8, 9, 10, 11, 12, 13, 14, or 15).</div>';}
			if(strpos($typename, "Colleage Writing") !== false){echo 'Complete all.</div>';}
			if(strpos($typename, "Writing Core") !== false){echo 'Complete one.</div>';}
			if(strpos($typename, "Upper-Division Math") !== false){echo 'Complete one.</div>';}
			if(strpos($typename, "Upper-Division CIS") !== false){echo 'Complete two.</div>';}
			if(strpos($typename, "Track Requirements 1") !== false){echo 'Complete all.</div>';}
			if(strpos($typename, "Track Requirements 2") !== false){echo 'Choose one.</div>';}
      	  		array_push($keys, $typename);
		}
		// echo $total .' '.$totalCredit.' '. $GID.' '.$groupAlt.' '. $graded.' '. $classAlt.' '. $cid.' '. $cname.' '. $credit.'<br>';
		echo '<div style="width:290px; float:left; padding-left:10px; padding-top:8px; padding-bottom:8px;">';
		if((7 <= $GID) && ($GID <= 15)){
			if(isLearned($cid)){
				echo '<del>['.$GID.'] ' . $cname . '</del></div>';
			}else{
				echo '['.$GID.'] '. $cname. '</div>';}
		}else{
			if(isLearned($cid)){
				echo '<del>' . $cname . '</del></div>';
			}else{
				echo $cname. '</div>';}
			}
		}
	$stmt->close();
echo '</td></tr></table><br><br>';
}
//---------------------------------------------load all terms
function loadTerm(){
	global $mysqli;
	global $id;
	$sql = 'SELECT TID, TermName from Term';
	$tid = NULL;
	$termname = NULL;
	//create statement
	$stmt=$mysqli->prepare($sql);
	//execute query
	$stmt->execute();
	//bind result
	$stmt->bind_result($tid, $termname);
	//print options
	while($stmt->fetch()){
		echo '<option value='.$tid.'> '. $termname.'</option>';
	}

}
function isLearned($CID){
	global $courses;
	if(in_array(strval($CID), $courses)){
		return True;
	}
	return False;
}

?>
<?php 
include 'includes/body.php';?>

	<script type="text/javascript">
		function getTermValue(sel){
			var value = (sel.options[sel.selectedIndex].value);
			var text = (sel.options[sel.selectedIndex].innerHTML);
			var a = document.getElementById('termlink'); //or grab it by tagname etc
			a.href = "suggest.php?termname=" + text + "&termid=" + value;
		}
	</script>


<!-- <strong>
<font size=13>
Courses in Track (<?php echo $tname?>) for <?php echo $name?> in Next Term.
</font>
</strong>

<?php
$nextTerm = 'SELECT TypeName, TotalCredit, GID, GroupAlternetive, Graded, ClassAlternetive, CID, CName, Credit FROM TrackClasses right join ScheduleClass Using (CID)  WHERE MID = ?';
printSchedule($nextTerm, $keys);
?> -->
<font size=5><b>Search Course Schedule</b></font><br><br>
	Choose a Term: &nbsp; &nbsp; &nbsp;<select name="term" id = "term" onChange='getTermValue(this)'>
	<?php
		//preload all the term
		loadTerm();
	?>
	</select><br><br>
	<a href="suggest.php?termid=1&termname=Fall 2013" id="termlink" style="padding:5px; background:white;">Search</a>
	<br><br>	
<font size=5><b>An Overview of Completed Requirements</b></font><br><br>
<?php

$allrequired = 'SELECT TypeName, TotalCredit, GID, GroupAlternetive, Graded, ClassAlternetive, CID, CName, Credit FROM TrackClasses WHERE MID = ?';
printSchedule($allrequired, $keys);

$mysqli->close();
?>

<?php include 'includes/footer.php'; ?>

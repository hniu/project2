<?php
session_start();
if($_SESSION[authed]!='yes'){
header('location:login.html');
exit();
}
?>
<div align='center'>
<?php
$coursecode = $_GET['coursecode'];
$coursenum = $_GET['coursenum'];
$termid=$_GET['termid'];
$termname=$_GET['termname'];

if($termid == NULL){
	$term_in = "201303";
}else{
$term = explode('-', $termname);
$term_in = $term[2];
if($termid == "3" || $termid == "4" || $termid == "1"){
$term_in = $term_in-1;
}
$term_in .= 0;
$term_in .= $termid;
}

$rawdata = file_get_contents('http://classes.uoregon.edu/pls/prod/hwskdhnt.P_ListCrse?term_in='.$term_in.'&sel_subj=dummy&sel_day=dummy&sel_schd=dummy&sel_insm=dummy&sel_camp=dummy&sel_levl=dummy&sel_sess=dummy&sel_instr=dummy&sel_ptrm=dummy&sel_attr=dummy&sel_cred=dummy&sel_tuition=dummy&sel_open=dummy&sel_weekend=dummy&sel_title=&sel_to_cred=&sel_from_cred=&sel_subj='.$coursecode.'&sel_crse='.$coursenum.'&sel_crn=&sel_camp=%25&sel_levl=%25&sel_attr=%25&begin_hh=0&begin_mi=0&begin_ap=a&end_hh=0&end_mi=0&end_ap=a&submit_btn=Show+Classes');

$text = '';
$needle = '<CAPTION class="captiontext">Classes Found</CAPTION>';
echo '<TABLE  CLASS="datadisplaytable" SUMMARY="This layout table is used to present the sections found" width="592">';
$start = strpos($rawdata, $needle);

if ($start === false)
echo 'Start not found';
else {
// first argument is $rawdata, not $text
$stop = strpos($rawdata, '<TR ALIGN="center" VALIGN="middle">
<TD COLSPAN="15" CLASS="dddead">&nbsp;<hr></TD>
</TR>
<TR ALIGN="center" VALIGN="middle">
<TD COLSPAN="15" CLASS="dddead"><p class="centeraligntext">', $start);

if ($stop === false)
echo 'End not found' . $termid;

// removed extra { with no matching end }
else
$text = substr($rawdata, $start + strlen($needle), $stop - $start
- strlen($needle));
echo $text;
echo '</TABLE>';
}
?>
</div>
<link href='http://fonts.googleapis.com/css?family=Lato:300,%20400,%20700' rel='stylesheet' type='text/css'>
<style type="text/css">
table{
	font-family: 'Lato', Helvetica, sans-serif;
	font-weight: 300;
 	font-size: 14px;
 	padding: 0;
 		*border-collapse: collapse; 
	border-spacing: 1px;
	color: #000;
}
td{
	padding: 4px;
}
.dddefault{
background: #eaeaea;
} 
.dddead{
	background: #dadada;
}
.dddead b{
	color:#0cadb7;
}

.rightaligntext{
	font-weight: bold;
}
td a{
	text-decoration: none;
	font-style: italic;
	color: #000;
}
</style>
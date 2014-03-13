<?php 
include ('conn/connData.php');
?>
<?php include 'core/pieprogress.php'; ?>
<?php include 'includes/header.php'; ?>
<link href='http://fonts.googleapis.com/css?family=Lobster' rel='stylesheet' type='text/css'>
<script type="text/javascript" src="js/preload.js"></script>
<!-- js for widgets on the dash -->
<script src="js/dashscripts.js"></script>
<?php include 'includes/body.php'; ?>
<table id="main">
	<tr>
		<td id="td35">CIS progress:</td>
		<td id="spacing"></td>
		<td id="td35cal">Upcoming Dates/Deadlines</td>
		<td id="spacing"></td>
		<td id="td30">top recommended courses</td>
	</tr><tr>
	<td style="margin:0; border-left:5px solid #7d7f87; padding:10px; vertical-align:0; background-color: #3c3e44; text-align:center;">
		<div align="center" style="font-family: 'Lato', Helvetica, sans-serif; font-weight: 700; font-size: 1em; color: #ffffff; text-transform: uppercase;">
			<!-- calculate and draw the pie chart according to users profile-->
			<?php if($completedcredits){echo $completedcredits;}else{echo "0";} ?>/104 credits</div><br>
			<canvas id="myCanvas" width="160" height="160" align="left" style="border:0px solid #d3d3d3;">Your browser does not support the HTML5 canvas tag.</canvas>
			<h1><font color="#ffffff">
				<?php if($completedcredits){echo round(($completedcredits/104)*100);}else{echo "0";} ?>% complete</b></h1>(<i>of major credits</i>)</font><br>
		</td>
		<td id="spacing"></td>
		<td bgcolor="#898a8f" valign="top" height="150" style="border-left: 1px solid #fff; padding-left:20px;">
                	<b>7th</b> Winter Course Evaluations Open<br>
                	<b>16th</b> Last Day to Process Complete Withdrawl<br>
                	<b>17-21st</b> Finals Week<br>
                	<b>22-30th</b> Spring Break!<br>
                	<b>31st</b> Spring Term Begins<br><br><br><br><br><br><br><br>
                	<div class="flip"> 
                		<div class="card"> 
                			<div class="face front"> 
                				<?php $datestr = date('Ymd'); echo date('F jS', strtotime($datestr)) . ', ' . date('Y', strtotime($datestr)); ?></div> 
                			</div>
                		</div>
                	</td>
                	<td id="spacing"></td>
                	<td rowspan="6" bgcolor="#fafafa" valign="top">
                		<ol>
                			<?php
                			include 'conn/connData.txt';
                			//calculate top rated courses and print
                			//---------------------------------------------set up the connection with mysql
							$mysqli = new mysqli($server, $user, $pass, $dbname, $port);
							if ($mysqli->connect_errno) {
				  				  echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
							}

							$q = "SELECT CName, CID, round(EvaluationRate, 1) as Avg FROM Class WHERE EvaluationNumber >0 ORDER BY EvaluationRate DESC LIMIT 15;";

							$result = $mysqli->query($q);
							while($row = $result->fetch_array()){
							  echo "<li><a href='courseratings.php?cid=".$row['CID']."' style='display:block;'>".$row['CName']."<div align='right'><b>".$row['Avg']."</b></div></a></li>";
							}
							mysqli_close($mysqli);
							?>
						</ol><br />
					</td>
				</tr><tr>
	<td bgcolor="#3c3e44"></td><td></td>
	<td id="tdlast" bgcolor="#ebebeb"></td></tr><tr>
	<td style="padding:10px;"></td></tr><tr>
	<td colspan="3" id="tdwide" bgcolor="#474d81" style="color:#fff;">course schedule (Spring 2014)</td>
</tr>
<tr>
	<td valign="top" bgcolor="#fff" colspan="3" style="padding:0;">
		<table style="width:100%; *border-collapse: collapse; border-spacing: 0px;"><tr>
			<td bgcolor="#fafafa" valign="top" style="width:65%;">
				<div id="sched">
					<ul id="results" class="update"></ul>
				</div>
			</td>
			<td bgcolor="#1b1d35" valign="top" id="booty">
				<form method="post" action="upcomingschedule.php">
					<input type="submit" value="BI" class="search" /><br />
					<input type="submit" value="CH" class="search" /><br />
					<input type="submit" value="CIS" class="searchonload" /><br />
					<input type="submit" value="MATH" class="search" /><br />
					<input type="submit" value="PHYS" class="search" /><br />
					<input type="submit" value="WR" class="search" /><br />
				</form>
			</td></tr><tr><td></td>
			<td id="tdlast" bgcolor="#1b1d35"></td></tr></table>
		</td></tr><tr>
		<td colspan="3" id="tdlast" bgcolor="#fff"><br></td></tr>
	</table>
	<br>
	<div id="overlay_form" style="display:none">
		<iframe src="about:blank" name="upsched" width="600" height="380" frameborder="0"></iframe>
		<br>
		<a href="about:blank" target="upsched" id="close"><b>CLOSE</b></a>
		</div>
		<script>
		//draw the pie
		function toRadians(deg) {
		    return deg * Math.PI / 180
		}

		var c=document.getElementById("myCanvas");
		var ctx=c.getContext("2d");
		ctx.translate(80,80);
		ctx.rotate((3*Math.PI)/2);

		var percent = (<?php if($completedcredits){echo $completedcredits;}else{echo "0";} ?>/104)*100;
		var per2deg = (percent * 3.6);

		ctx.beginPath();
		var cx = 0;
		var cy = 0;
		ctx.moveTo(cx,cy);
		ctx.arc(cx,cy,80,0,toRadians(per2deg));
		ctx.lineTo(cx,cy);

		ctx.fillStyle='#58c3e5';
		ctx.fill();
		ctx.closePath();

		ctx.beginPath();
		var rx = 0;
		var ry = 0;
		ctx.moveTo(rx,ry);
		ctx.arc(rx,ry,80,toRadians(per2deg),toRadians(360));
		ctx.lineTo(rx,ry);

		ctx.fillStyle='#0facb5';
		ctx.fill();
		ctx.closePath();
		</script>  
<?php include 'includes/footer.php'; ?>
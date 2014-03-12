<?php
include 'includes/header.php'; 
include 'conn/connData.php';
$cid=$_GET['cid'];
?>

<script type="text/javascript" src="js/preload.js"></script>
<script type="text/javascript" src="js/searchratings.js"></script>
<script type="text/javascript" language="JavaScript">
<!--    
        var init;
        function autoResize(id) {
            if(init == 1){
            var newheight;

            if (document.getElementById) {
                newheight = document.getElementById(id).contentWindow.document.body.scrollHeight;
            }
            document.getElementById(id).height = (newheight);
            }else{

            init = 1;}
        };
//-->
</script>
<?php 
include 'includes/body.php';?>

<table width="70%"><tr><td colspan="2" align="center">
    <h1 align="left">View Course Ratings</h1>
    <div id="main">
    <input type="text" id="search" value="CIS" onfocus="this.value='';" autocomplete="off">
    </td></tr><tr><td valign="top">
		<div id="res" style="width:360px; height:500px; overflow:auto; background:white;">
            <div align="right" style="text-align:left;padding-left:50px; padding-top:10px; padding-bottom:10px; background:#f9f9f9; color:#636363;"><a href="rate.php" target="ratings">View Your Ratings</div>
		<ul id="results"></ul>
		</div>
	</div>
</td><td width="65%" valign="top">


<?php 

echo '<iframe height="500" name="ratings" src="';
if($cid == NULL){echo 'rate.php';}else{echo 'ratings.php?cid='.$cid;}
echo '" frameborder="0" id="Main_Content" onload="autoResize(';
echo "'Main_Content'";
echo ');" style="border-radius: 0px 20px 20px 0px; background:#0cadb7; width:100%;"></iframe>';


?> 
</td></tr>
</table>

<br><br>

<?php include 'includes/footer.php'; ?>
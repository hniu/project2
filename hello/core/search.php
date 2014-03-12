<?php
session_start();
if($_SESSION[authed]!='yes'){
header('location:login.html');
exit();
}
?>
<?php
/************************************************
	The Search PHP File
************************************************/


/************************************************
	MySQL Connect
************************************************/

// Credentials
$dbhost = "ix.cs.uoregon.edu";
$dbname = "MotiAdviser";
$dbuser = "guest";
$dbpass = "";
$port = "3469";

//	Connection
global $tutorial_db;

$tutorial_db = new mysqli();
$tutorial_db->connect($dbhost, $dbuser, $dbpass, $dbname, $port);
$tutorial_db->set_charset("utf8");

//	Check Connection

if ($tutorial_db->connect_errno) {
    printf("Connect failed: %s\n", $tutorial_db->connect_error);
    exit();
}

/************************************************
	Search Functionality
************************************************/

// Get Search
$search_string = preg_replace("/[^A-Za-z0-9]/", " ", $_POST['query']);
$search_string = $tutorial_db->real_escape_string($search_string);

// Check Length More Than One Character
if (strlen($search_string) >= 1 && $search_string !== ' ') {
	// Build Query
	$query = 'SELECT * FROM Class WHERE CName LIKE "%'.$search_string.'%" OR CName LIKE "%'.$search_string.'%"';

	// Do Search
	$result = $tutorial_db->query($query);

	while($row = $result->fetch_row()) {

		echo '<li class="result"><a target="ratings" href="ratings.php?cid='. $row[0] .'"><h3>' . $row[1] . '</h3></a></li><br>';

	}

	// Check If We Have Results
	// if (isset($result_array)) {
	// 	printf("oh");
	// 	foreach ($result_array as $result) {

	// 		// Format Output Strings And Hightlight Matches
	// 		$display_function = preg_replace("/".$search_string."/i", "<b class='highlight'>".$search_string."</b>", $result['function']);
	// 		$display_name = preg_replace("/".$search_string."/i", "<b class='highlight'>".$search_string."</b>", $result['name']);
	// 		$display_url = 'http://php.net/manual-lookup.php?pattern='.urlencode($result['function']).'&lang=en';

	// 		// Insert Name
	// 		$output = str_replace('nameString', $display_name, $html);

	// 		// Insert Function
	// 		$output = str_replace('functionString', $display_function, $output);

	// 		// Insert URL
	// 		$output = str_replace('urlString', $display_url, $output);

	// 		// Output
	// 		echo($output);
	// 	}
	// }else{
	
	// 	// Format No Results Output
	// 	$output = str_replace('urlString', 'javascript:void(0);', $html);
	// 	$output = str_replace('nameString', '<b>No Results Found.</b>', $output);
	// 	$output = str_replace('functionString', 'Sorry :(', $output);

	// 	// Output
	// 	echo($output);
	// }
}


/*
// Build Function List (Insert All Functions Into DB - From PHP)

// Compile Functions Array
$functions = get_defined_functions();
$functions = $functions['internal'];

// Loop, Format and Insert
foreach ($functions as $function) {
	$function_name = str_replace("_", " ", $function);
	$function_name = ucwords($function_name);

	$query = '';
	$query = 'INSERT INTO search SET id = "", function = "'.$function.'", name = "'.$function_name.'"';

	$tutorial_db->query($query);
}
*/
?>
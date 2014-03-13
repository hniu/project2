<?php include ('../conn/connData.php'); ?>
<?php
//if we got something through $_POST
if (isset($_POST['search'])) {
$code = $_POST['search'];
$id = NULL;
$name = NULL;

//query for classes with code X that is offered in term Y
$sql = "SELECT CName FROM Class right join ScheduleClass Using (CID) WHERE CName LIKE ?";
    $stmt = $mysqli->prepare($sql);
    if(!$stmt){
        echo "Prepare failed: (" . $mysqli->errno .")" . $mysqli->error;
    }
    if(!$stmt->bind_param("s", $word)){
        echo "Binding parameters failed: (" . $stmt->errno . ") ".  $stmt->error;
    }
    $word = $_POST['search'] . '%';

    if(!$stmt->execute()){
        echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
    }
    if(!($stmt->bind_result($name))){
        echo "Binding output parameters failed: (" . $stmt->errno . ") " . $stmt->error;
    }

    if(($row = $stmt->fetch()) == 0){
        echo "None offered this term.";
    }else{
                if(strlen($code) == 3){
        $id = substr($name, 4, 3);
    }
    else if(strlen($code) == 4){
        $id = substr($name, 5, 3);
    }
    else if(strlen($code) == 2){
        $id = substr($name, 3, 3);
    }
            echo "<li><a href='core/coursetimes.php?coursecode=". $code ."&coursenum=". $id ."' target='upsched' id='pop'>" . $name . "</a></li>";
        while($row = $stmt->fetch()){
                            if(strlen($code) == 3){
        $id = substr($name, 4, 3);
    }
    else if(strlen($code) == 4){
        $id = substr($name, 5, 3);
    }
    else if(strlen($code) == 2){
        $id = substr($name, 3, 3);
    }
            echo "<li><a href='core/coursetimes.php?coursecode=". $code ."&coursenum=". $id ."' target='upsched' id='pop'>" . $name . "</a></li>";
        }
    }
}
?>

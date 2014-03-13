<?php
//this code fetches the number of classes the user has taken in order to calculate the pie chart
$sql = 'select sum(Credit) as total from ChosenClass left join Class using (CID) where ID = ?';
$total = NULL;
    $stmt = $mysqli->prepare($sql);
    if(!$stmt){
        echo "Prepare failed: (" . $mysqli->errno .")" . $mysqli->error;
    }
    if(!$stmt->bind_param("i", $id)){
        echo "Binding parameters failed: (" . $stmt->errno . ") ".  $stmt->error;
    }

    if(!$stmt->execute()){
        echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
    }
    if(!($stmt->bind_result($total))){
        echo "Binding output parameters failed: (" . $stmt->errno . ") " . $stmt->error;
    }

    while($stmt->fetch()){
        $completedcredits = $total;
        break;
    }
 
?>
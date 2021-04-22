<?php

# Example Delete

require('connect.php');

# Delete User
$id   = "*6";
$exec = $MikSQL->ExecuteSQL("delete from user where .id='".$id."'");

#Delete IP Address
#$exec = $MikSQL->ExecuteSQL("delete from ip-address where .id='".$id."'");

if ($exec[0]=="TRUE"){
	
	echo "successfully deleted!";
	
} else {
	
	echo $exec[1]; 
	
}

?>

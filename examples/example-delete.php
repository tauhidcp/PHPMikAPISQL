<?php

# Example Delete

require('connect.php');

# Delete User
$id   = "*3";
$exec = $MikSQL->ExecuteSQL("delete from user where .id='".$id."'");

#Delete IP Address
#$exec = $MikSQL->ExecuteSQL("delete from ip-address where .id='".$id."'");

if ($exec=="TRUE"){
	
	echo "successfully deleted!";
	
}

?>

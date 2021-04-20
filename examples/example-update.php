<?php

# Example Update

require('connect.php');

# Update User
$group = "read"; # full/read/write
$id    = "*4";
$exec  = $MikSQL->ExecuteSQL("update user set group='".$group."' where .id='".$id."'");

# Update IP Address
#$address   = "172.188.77.1/23";
#$network   = "172.188.77.0"; 
#$interface = "ether4"; 
#$id        = "*4";
#$exec = $MikSQL->ExecuteSQL("update ip-address set address='".$address."',network='".$network."',interface='".$interface."' where .id='".$id."'");

if ($exec[0]=="TRUE"){
	
	echo "successfully updated!";
	
} else {
	
	echo $exec[1]; 
	
}

?>

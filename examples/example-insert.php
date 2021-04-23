<?php

# Example Insert 

require('connect.php');

# Insert New User
$user  = "budi";
$group = "full"; # full/read/write
$exec = $MikSQL->ExecuteSQL("insert into user (name,group) values ('".$user."','".$group."')");

# Insert New IP Address
#$address   = "192.168.88.1/24";
#$network   = "192.168.88.0"; 
#$interface = "ether4"; 
#$exec = $MikSQL->ExecuteSQL("insert into ip-address (address,network,interface) values ('".$address."','".$network."','".$interface."')");

if ($exec['status']=="TRUE"){
	
	echo $exec['message'];
	
} else {
	
	echo $exec['message']; 
	
}

?>

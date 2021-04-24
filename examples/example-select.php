<?php

# Example Select 

require('connect.php');

# Select all
$print = $MikSQL->ExecuteSQL("select * from log where message like 'via api' order by .id asc limit 5");
#$print = $MikSQL->ExecuteSQL("select .id,time,message from log where message like 'via api' order by .id asc limit 5");
#$print = $MikSQL->ExecuteSQL("select .id,name,type,mac-address from interface where name='eth-ISP'");
#$print = $MikSQL->ExecuteSQL("select .id,name,type,mac-address from interface where name like 'isp' and type='ether' order by .id desc limit 2");
#$print = $MikSQL->ExecuteSQL("select * from interface where name='eth-Local'");

if ($print['status']!="FALSE"){
	
//print_r($print['data']);

// or
// print specific log item

foreach ($print['data'] as $row){
	
	echo $row['.id']."<br>";
	echo $row['time']."<br>";
	echo $row['message']."<br>";
	echo "-----------------------<br>";
	// dst...
	
} 
// or
// print specific interface item

/*foreach ($print['data'] as $row){
	
	echo $row['.id']."<br>";
	echo $row['name']."<br>";
	echo $row['mac-address']."<br>";
	echo "-----------------------<br>";
	// dst...
	
} */

} else {
	
	echo $print['message'];
	
} 

?>

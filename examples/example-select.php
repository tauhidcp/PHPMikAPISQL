<?php

# Example Select 

require('connect.php');

# Select all
$print = $MikSQL->ExecuteSQL("select * from interface");
#$print = $MikSQL->ExecuteSQL("select * from interface order by .id desc");
#$print = $MikSQL->ExecuteSQL("select * from interface order by .id asc limit 1");

# Select Specific Item
#$print = $MikSQL->ExecuteSQL("select .id,name,type,mac-address from interface");
#$print = $MikSQL->ExecuteSQL("select .id,name,type,mac-address from interface order by .id desc");
#$print = $MikSQL->ExecuteSQL("select .id,name,type,mac-address from interface order by .id desc limit 1");

# Order desc 
#$print = $MikSQL->ExecuteSQL("select * from interface order by .id desc");
#$print = $MikSQL->ExecuteSQL("select .id,name,type,mac-address from interface order by .id desc");
#$print = $MikSQL->ExecuteSQL("select .id,name,type,mac-address from interface order by .id desc limit 2");

# Select Where 
#$print = $MikSQL->ExecuteSQL("select * from interface where disabled='no' order by .id asc");
#$print = $MikSQL->ExecuteSQL("select .id,name,type,mac-address from interface where disabled='no' and name='ether1'");
#$print = $MikSQL->ExecuteSQL("select .id,name,type,mac-address from interface where disabled='no' and type='ether' order by .id desc limit 2");

# Select Where & Order asc 
#$print = $MikSQL->ExecuteSQL("select * from interface where disabled='no' and type='ether' order by .id desc");
#$print = $MikSQL->ExecuteSQL("select .id,name,type,mac-address from interface where disabled='no' order by .id asc limit 3");
#$print = $MikSQL->ExecuteSQL("select .id,name,type,mac-address from interface where disabled='no' order by .id desc limit 2");

if ($print['status']!="FALSE"){
	
//print_r($print['data']);

// or
// print specific interface item

foreach ($print['data'] as $row){
	
	echo $row['.id']."<br>";
	echo $row['name']."<br>";
	echo $row['mac-address']."<br>";
	echo "-----------------------<br>";
	// dst...
	
}

} else {
	
	echo $print['message'];
	
}

?>

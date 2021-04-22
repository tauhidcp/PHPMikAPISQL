<?php

# Example Select 

require('connect.php');

# Select all
$print = $MikSQL->ExecuteSQL("select * from user");
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
#$print = $MikSQL->ExecuteSQL("select * from interface where disabled='no' order by .id desc limit 2");
#$print = $MikSQL->ExecuteSQL("select .id,name,type,mac-address from interface where disabled='no'");
#$print = $MikSQL->ExecuteSQL("select .id,name,type,mac-address from interface where disabled='no' order by .id asc limit 1");

# Select Where & Order asc 
#$print = $MikSQL->ExecuteSQL("select * from interface where disabled='no' order by .id desc");
#$print = $MikSQL->ExecuteSQL("select .id,name,type,mac-address from interface where disabled='no' order by .id asc limit 3");
#$print = $MikSQL->ExecuteSQL("select .id,name,type,mac-address from interface where disabled='no' order by .id desc limit 2");

if ($print[0]!="FALSE"){
	
print_r($print);

// or
// print interface

/*for($i=0; $i<count($print); $i++){
	
	echo $print[$i]['.id']."<br>";
	echo $print[$i]['name']."<br>";
	echo $print[$i]['mac-address']."<br>";
	echo "-----------------------<br>";
	// dst...
	
}*/

} else {
	
	echo $print[1];
	
}

?>

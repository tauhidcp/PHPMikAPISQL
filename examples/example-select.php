<?php

# Example Select 

require('connect.php');

# Select all
$print = $MikSQL->ExecuteSQL("select * from interface");

# Select Specific Item
#$print = $MikSQL->ExecuteSQL("select .id,name,type,mac-address from interface");

# Order desc 
#$print = $MikSQL->ExecuteSQL("select * from interface order by .id desc");
#$print = $MikSQL->ExecuteSQL("select .id,name,type,mac-address from interface order by .id desc");

# Select Where 
#$print = $MikSQL->ExecuteSQL("select * from interface where disabled='no'");
#$print = $MikSQL->ExecuteSQL("select .id,name,type,mac-address from interface where disabled='no'");

# Select Where & Order asc 
#$print = $MikSQL->ExecuteSQL("select * from interface where disabled='no' order by .id asc");
#$print = $MikSQL->ExecuteSQL("select .id,name,type,mac-address from interface where disabled='no' order by .id asc");

//print_r($print);

// or

for($i=0; $i<count($print); $i++){
	
	echo $print[$i]['.id']."<br>";
	echo $print[$i]['name']."<br>";
	// dst...
	
}

?>

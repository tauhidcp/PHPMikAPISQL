<?php

# Example Select 

require('connect.php');

# Select all
$print = $MikSQL->ExecuteSQL("select * from lora");

# Order desc 
#$print = $MikSQL->ExecuteSQL("select * from interface order by .id desc");

# Select Where 
#$print = $MikSQL->ExecuteSQL("select * from interface where disabled='no'");

# Select Where & Order asc 
#$print = $MikSQL->ExecuteSQL("select * from interface where disabled='no' order by .id asc");

print_r($print);

?>

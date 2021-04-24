<?php

require('../PHPMikAPISQL.php');

#$config['host'] = "192.168.56.101"; #VirtualBox (6.47.9)
$config['host'] = "192.168.4.11"; #RouterBoard (6.48.1)
$config['user'] = "admin";
$config['pass'] = "";
$config['port'] = "8728";
	
$MikSQL = new PHPMikAPISQL($config);

?>

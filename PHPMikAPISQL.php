<?php 

/*****************************
 *
 * PHPMikAPISQL Class v0.1
 * 
 * Simple class to execute RouterOS Command like SQL (select, insert, update, delete) 
 * Dependend with routeros_api.class.php (https://github.com/BenMenking/routeros-api.git)
 * 
 * Author : Ahmad Tauhid (ahmad.tauhid.cp [at] gmail [dot] com)
 * 
 * http://www.tauhidslab.my.id/
 * https://github.com/tauhidcp/PHPMikAPISQL.git
 * 
 *  
 ******************************/

require_once("routeros_api.class.php");

class PHPMIkAPISQL{

	private $host;
	private $user;
	private $pass;
	private $port;
	private $conn;
	private $table;  
	private $result;  
	private $by;
	private $order;
	private $output = array();
	
	function __construct($config){
	
		$this->host  = $config['host']; 
		$this->user  = $config['user'];
		$this->pass  = $config['pass'];
		$this->port  = $config['port'];
		$this->conn  = $this->Connection();
		$this->table = parse_ini_file("db/table-list.ini",true)['Tables'];
	
	}
	
	public function ExecuteSQL($sql){
			
		$cmd = $this->getCMD($sql);
		
		
		if ($cmd=="select"){
			
			$result = $this->SelectCMD($sql);
		
		}
		
		if ($cmd=="insert"){
			
			$result = $this->InsertCMD($sql);
			
		}
		
		if ($cmd=="update"){
			
			$result = $this->UpdateCMD($sql);
			
		}
		
		if ($cmd=="delete"){
			
			$result = $this->DeleteCMD($sql);
			
		}
		
		return $result;
	}
	
	/* Select Function */
	private function SelectCMD($sql){		
		
		$table  = $this->getMenu($sql);
		$field  = $this->getField($sql);
		$where  = $this->getWhere($sql);
		$order  = explode(" ",$this->getOrder($sql));
		$limit  = $this->getLimit($sql);
		
		if (count($order)>1){
			
			$this->order  = strtoupper(trim(@$order[1]));  
			$this->by 	  = trim(@$order[0]);
			
		}
		
		if (array_key_exists($table,$this->table)){
			
			$field = str_replace(" ","",$field);
			
			if (empty($where) && empty($this->order)){
				
				$command = $this->table[$table]."/print";
				
				if ($field=="*"){
					
					$this->conn->write($command,true);
					
				} else {
					
					$this->conn->write($command,false);	
					$this->conn->write("=.proplist=".$field,true);	
					
				}
				
				$read   = $this->conn->read(false);
				$this->output = $this->conn->parseResponse($read);
				
			}

			if (empty($where) && !empty($this->order)){
			
				$command = $this->table[$table]."/print";
				
				if ($field=="*"){
					
					$this->conn->write($command,true);
					
				} else {
					
					$this->conn->write($command,false);	
					$this->conn->write("=.proplist=".$field,true);	
					
				}
				
				$read   = $this->conn->read(false);
				$this->output = $this->conn->parseResponse($read);
				$this->output = $this->Sorting($this->output);
			
			}
			
			if (!empty($where) && empty($this->order)){
				
				$where = str_replace("'","",$where);
				$command = $this->table[$table]."/print";
				
				if ($field=="*"){
					
					$this->conn->write($command,false);
					$this->conn->write("?".$where,true);
					
				} else {
					
					$this->conn->write($command,false);	
					$this->conn->write("=.proplist=".$field,false);	
					$this->conn->write("?".$where,true);
					
				}
				
				$read   = $this->conn->read(false);
				$this->output = $this->conn->parseResponse($read);
			
			}

			if (!empty($where) && !empty($this->order)){
				
				$where = str_replace("'","",$where);
				$command = $this->table[$table]."/print";
				
				if ($field=="*"){
					
					$this->conn->write($command,false);
					$this->conn->write("?".$where,true);
					
				} else {
					
					$this->conn->write($command,false);	
					$this->conn->write("=.proplist=".$field,false);	
					$this->conn->write("?".$where,true);
					
				}
				
				$read   = $this->conn->read(false);
				$this->output = $this->conn->parseResponse($read);
				$this->output = $this->Sorting($this->output);
			} 
			
			
			if (!empty($limit)){
					
				$this->output = array_slice($this->output,0,$limit);
					
			}
			
		} else {
			
			$this->output = array("FALSE","<b>table '$table' not found!</b><br><i>add your table to tablelist.ini in db folder</i>");
		}
		
		return $this->output;
		
	}
	
	/* Insert Function */
	private function InsertCMD($sql){
		
		$table  = $this->getMenu($sql);
		$field  = $this->getField($sql);
		
		if (array_key_exists($table,$this->table)){
			
			$values  = explode("values",$field);
			$key     = explode(",",trim($values[0]));
			$val     = explode(",",trim($values[1]));
			
			$command = $this->table[$table]."/add";
			$this->conn->write($command,false);
			
			for ($i=0; $i<count($key); $i++){
				
				if ($i == (count($key)-1)){
					
					$this->conn->write("=$key[$i]=".str_replace("'","",$val[$i]),true);
				
				} else {
					
					$this->conn->write("=$key[$i]=".str_replace("'","",$val[$i]),false);
				}
				
			} 
			
			$result = $this->conn->read(false);
			
			if ($result[0]=="!trap"){
				
				$this->output  = array("FALSE",str_replace("=message=","",$result[1]));
				
			} else if ($result[0]=="!done"){
				
				$this->output = array("TRUE");
			
			}
		
		} else {
			
			$this->output = array("FALSE","<b>table '$table' not found!</b><br><i>add your table to tablelist.ini in db folder</i>");
		}
		
		return $this->output;
		
	}
	
	/* Update Function */
	private function UpdateCMD($sql){
		
		$table  = $this->getMenu($sql);
		$field  = $this->getField($sql);
		$where  = $this->getWhere($sql);
		
		if (array_key_exists($table,$this->table)){
			
			$fieldx  = explode(",",$field);
			$where   = str_replace("'","",$where);
			$command = $this->table[$table]."/set";
			$this->conn->write($command,false);
			
			for ($i=0; $i<count($fieldx); $i++){
				
				$this->conn->write("=".str_replace("'","",trim($fieldx[$i])),false);
			
			} 
			
			$this->conn->write("=".$where,true);
			$result = $this->conn->read(false);
			
			if ($result[0]=="!trap"){
				
				$this->output  = array("FALSE",str_replace("=message=","",$result[1]));
				
			} else if ($result[0]=="!done"){
				
				$this->output = array("TRUE");
			
			}
		
		} else {
			
			$this->output = array("FALSE","<b>table '$table' not found!</b><br><i>add your table to tablelist.ini in db folder</i>");
		}
		
		return $this->output;
	}
	
	/* Delete Function */
	private function DeleteCMD($sql){
		
		$table  = $this->getMenu($sql);
		$where  = $this->getWhere($sql);
		
		if (array_key_exists($table,$this->table)){
			
			$where = str_replace("'","",$where);
			$command = $this->table[$table]."/remove";
			$this->conn->write($command,false);
			$this->conn->write("=".$where,true);
			$result = $this->conn->read(false);
			
			if ($result[0]=="!trap"){
				
				$this->output  = array("FALSE",str_replace("=message=","",$result[1]));
				
			} else if ($result[0]=="!done"){
				
				$this->output = array("TRUE");
			
			}
			
		} else {
			
			$this->output = array("FALSE","<b>table '$table' not found!</b><br><i>add your table to tablelist.ini in db folder</i>");
		}
		
		return $this->output;
	}
	
	private function getCMD($str){
		
		$cmd = explode(" ",strtolower(trim($str)));
		
		return trim($cmd[0]);
		
	}
	
	private function getMenu($str){
		
		$str   = strtolower(trim($str));
		$menu  = "";
		
		if (strpos($str, 'from') !== false){

			$from  = explode("from",$str);
			$where = explode("where",trim(@$from[1]));
			$order = explode("order",trim(@$from[1]));
			$limit = explode("limit",trim(@$from[1]));
			
			// Limit Only
			if ((count($order)==1) && (count($where)==1) && (count($limit)>1)){
				
				$menu = @$limit[0];
			
			// Order Only
			} else if ((count($order)>1) && (count($where)==1) && (count($limit)==1)){
				
				$menu = @$order[0];
			
			// Where Only
			} else if ((count($where)>1) && (count($order)==1) && (count($limit)==1)){
				
				$menu = @$where[0];
			
			// Where Limit
			} else if ((count($order)==1) && (count($where)>1) && (count($limit)>1)){
				
				$menu = @$where[0];
			
			// Order Limit
			} else if ((count($order)>1) && (count($where)==1) && (count($limit)>1)){
				
				$menu = @$order[0];
			
			// Where Order  
			} else if ((count($order)>1) && (count($where)>1) && (count($limit)==1)){
				
				$menu = @$where[0];
			
			// Where Order Limit
			} else if ((count($where)>1) && (count($order)>1) && (count($limit)>1)){
				
				$menu = @$where[0];
			
			// Select Only
			} else {
				
				$menu = @$from[1];
			}
		
		} else if (strpos($str, 'into') !== false){
			
			$into    = explode("into",$str);
			$space   = explode(" ",trim(@$into[1]));
			
			if ((count($into)>1) && (count($space)>1)){
				
				$menu = @$space[0];
			
			}
			
		} else if (strpos($str, 'set') !== false){
			
			$set     = explode("set",$str);
			$update  = explode("update",trim(@$set[0]));
			
			if ((count($set)>1) && (count($update)>1)){
				
				$menu = @$update[1];
			
			}
			
		}
		
		return trim($menu);
		
	}
	
	private function getWhere($str){
		
		$where   = explode("where",strtolower(trim($str)));
		$order   = explode("order",trim(@$where[1]));
		$limit   = explode("limit",trim(@$where[1]));
		$wherex  = "";
		
		if ((count($order)>1) && (count($where)>1) && (count($limit)>1)){
			
			$wherex = @$order[0];
		
		} else if ((count($where)>1) && (count($order)==1) && (count($limit)==1)){
			
			$wherex = @$where[1];
		
		} else if ((count($where)>1) && (count($order)==1) && (count($limit)>1)){
			
			$wherex = @$limit[0];
		
		} else if ((count($where)>1) && (count($order)>1) && (count($limit)==1)){
			
			$wherex = @$order[0];
		
		}
		
		return trim($wherex);
		
	}
	
	
	private function getOrder($str){
		
		$order   = explode("order by",strtolower(trim($str)));
		$limit   = explode("limit",trim(@$order[1]));
		$orderx  = "";
		
		if ((count($order)>1) && (count($limit)>1)){
			
			$orderx = @$limit[0];
		
		}  else if ((count($order)>1) && (count($limit)==1)){
			
			$orderx = @$order[1];
		
		} 
		
		return trim($orderx);
		
	}
	
	private function getLimit($str){
		
		$limit   = explode("limit",strtolower(trim($str)));
		$limitx  = "";
		
		if (count($limit)>1){
			
			$limitx = @$limit[1];
		
		} 
		
		return trim($limitx);
		
	}
	
	private function getField($str){
		
		$str = strtolower(trim($str));
		$fieldx  = "";		
		
		// Select
		if (strpos($str, 'from') !== false) {
			
			$from    = explode("from",$str);
			$select  = explode("select",trim(@$from[0]));

			
			if (count($select)>1){
				
				$fieldx = @$select[1];
			
			} 
		
		// Insert
		} else if (strpos($str, 'into') !== false) {
			
			$table   = $this->getMenu($str);
			$field   = explode($table,$str);
			$fieldx  = str_replace(")","",str_replace("(","",@$field[1]));
		
		// Update
		} else if (strpos($str, 'set') !== false) {
			
			$set    = explode("set",$str);
			$where  = explode("where",trim(@$set[1]));
			
			if ((count($set)>1) && (count($where)>1)){
				
				$fieldx = @$where[0];
			
			} 
		
		}
		
		return trim($fieldx);
		
	}
	
	private function Sorting($array){
		
		if ($this->order=="ASC"){ 
		
			array_multisort(array_map(function($element) {
				return @$element[$this->by];
			}, $array), SORT_ASC, $array);
		
		} 
		
		if ($this->order=="DESC"){ 
		
			array_multisort(array_map(function($element) {
				return @$element[$this->by];
			}, $array), SORT_DESC, $array);
		
		}
		
		return $array;
	} 
	
	private function Connection(){
		
		$api 		= new RouterosAPI();
		$api->port 	= $this->port;

		if ($api->connect($this->host, $this->user, $this->pass)){
		
			return $api;
		
		} else {
			
			die("<b>cannot connect to : ".$this->host."</b>");
		}
	}
	
}


?>
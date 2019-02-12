<?php

/*
* Mysql database class - only one connection allowed
  This class has created as a custom class, Author Sandeep.	

*/

class Database {
	
	private $_connection;
	private static $_instance; //The single instance
	private $_host;
	private $_username;
	private $_password;
	private $_database;
	
	// MySQLi object instance
	public $mysqli = null;
	
	
	/*
	Get an instance of the Database
	@return Instance
	*/
	public static function getInstance() {
		if(!self::$_instance) { // If no instance then make one
			self::$_instance = new self();
		}
		return self::$_instance;
	}
	// Constructor
	public function __construct() {
		
		$CI =& get_instance();
		$CI->load->database();
		$this->_host = $CI->db->hostname;
		$this->_username = $CI->db->username;
		$this->_password = $CI->db->password;
		$this->_database = $CI->db->database;
		
		
				
		$this->_connection = new mysqli($this->_host, $this->_username, 
			$this->_password, $this->_database);
	
		 $this->mysqli = $this->_connection;
                 $this->mysqli->set_charset("utf8");
	
		// Error handling
		if(mysqli_connect_error()) {
			trigger_error("Failed to conenct to MySQL: " . mysql_connect_error(),
				 E_USER_ERROR);
		}
	}
	// Magic method clone is empty to prevent duplication of connection
	private function __clone() { }
	
	
	// Get mysqli connection
	public function getConnection() {
		return $this->_connection;
	}
	
	// Class deconstructor override
	public function __destruct() 
	{
		$this->CloseDB();
	}
	
	// Close database connection
	public function CloseDB() {
		$this->mysqli->close();
	}


    
	
	// select database to use
	public function selectDB($dbName="")
	{
		
		if($dbName==="")
			$selectedDB = $this->mysqli->select_db($this->_database);
		else
			$selectedDB = $this->mysqli->select_db($dbName);
			
		return $selectedDB;
	}
	
	//---------- FUNCTIONS FOR QUERY -------------------------------------
	
	
	// Escape the string get ready to insert or update
	public function clearText($text) {
		$text = trim($text);
		return $this->mysqli->real_escape_string($text);
	}


	// Get the last insert id 
	public function lastInsertID() {
		return $this->mysqli->insert_id;
	}	
	
	
	// Gets the total count and returns integer
    public function totalCount($fieldname, $tablename, $where = "") {
	
		if(empty($fieldname))
			return "Missing Parameter : filed name";
		if(empty($tablename))
			return "Missing Parameter : Table name";
	
		if(!empty($where))
			$where = " WHERE " . $where;
			
        $SQL = "SELECT count(`".$fieldname."`) FROM "
        . $tablename . " " . $where;
        
              
		
        $result = $this->mysqli->query($SQL);
        $count = 0;
        if ($result) {
            while ($row = mysqli_fetch_array($result)) {
            $count = $row[0];
           }
          }
          return $count;
    }
    
    
    //----  Runs a sql query with array output
    
    
    public function runQueryList($query){

        if ($resultset = $this->mysqli->query($query)) {
            if ($resultset->num_rows > 0) {

                    $data = array();
                        while( $row = $resultset->fetch_assoc() ) {
                            $data[] = array_change_key_case($row);
                        }

            } else {
                $data = NULL;
            }
        } else {
            $data = die( $this->mysqli->errno );
        }
        $resultset->close();
        return $data;
    }
    
    
    // runs a sql query and Returns the $resutl
    public function runQuery($query) {
        $result = $this->mysqli->query($query);
        return $result;
    }
    
    // ------- Function to insert data into the table
    
    /*
    parameters --->1.requiredFields as array			*
			 *								  like field name as first and 				*
			 *								  filed value				*
			 *								  									*
			 *								  ie. array("FirstName" 			*	
			 *										   => "Jackson");*
			 
			 if SUCCESS will return the inserted ID otherwise FALSE;
    
    */
    
    
    public function insertQuery($requiredFields, $tableName)
	{
		if(!isset($requiredFields))
			return "Missing Parameter : Required fields";
		if(empty($tableName))
			return "Missing Parameter : Table name";
			
		$SQL ="INSERT INTO `" . $tableName . "` (";
	
		$fieldNames 	="";
		$values	 	="";
		 foreach($requiredFields as $fieldName => $value)
		{
			if($fieldNames!=="")
				$fieldNames .=", ";
			if($values!=="")
				$values .=", ";
			$fieldNames .="`{$fieldName}`";
			
			$value  =$this->clearText($value);
			
			if(get_magic_quotes_gpc()) // apply stripslashes to pevent double escape if magic_quotes_gpc is enabled
				$value = stripslashes($value);
				
			//mysqli_real_escape_string() function escapes special characters in a string for use in an SQL statement.
			
			
			$value = mysqli_real_escape_string($this->_connection,$value);
			$values .="'{$value}'";
		 
		    
		
		}
		
		$SQL .="{$fieldNames}) VALUES ({$values})";
		
		$result = $this->mysqli->query($SQL);
		if($result)
			return $this->lastInsertID();
		else
			return FALSE;
		
	
	
	}

public function updateQuery($requiredFields, $tableName, $where="")
	{
		if(!isset($requiredFields))
			return "Missing Parameter : Required fields";
		if(empty($tableName))
			return "Missing Parameter : Table name";
			
		$SQL ="UPDATE `" . $tableName . "` SET ";
	
		$fieldValues 	="";
		
		 foreach($requiredFields as $fieldName => $value)
		{
			if($fieldValues!=="")
				$fieldValues .=", ";
		
			$value  =$this->clearText($value);
			//mysqli_real_escape_string() function escapes special characters in a string for use in an SQL statement.
			 if(get_magic_quotes_gpc()) // apply stripslashes to pevent double escape if magic_quotes_gpc is enabled
				$value = stripslashes($value);
				
			$value = mysqli_real_escape_string($this->_connection,$value);
			$fieldValues .="`{$fieldName}`='{$value}'";
			
			
		    
		
		}
		$SQL .= $fieldValues;
		
		$whr ="";
		if(!empty($where))
			{
				 $whr .= "  WHERE " . $where; 
				 $SQL .= $whr;
			}
		
		$result = $this->mysqli->query($SQL);
		return $result;
			
	
	
	}
	
	public function checkExistance($tableName, $where) // if exists Id will be returned else 0.
	{
			if(empty($tableName))
						return "Missing Parameter : Table name";
					
			if(empty($where))
						return "Missing Parameter : Where condition.";
			
			if(!empty($where))
                            $where = " WHERE " . $where;
                        
                         $SQL ="SELECT Id FROM `{$tableName}` {$where}";
			 $result = $this->mysqli->query($SQL);
			
					if(mysqli_num_rows($result)>0)
					{
						$value = mysqli_fetch_object($result);
						return $value->Id;
					}
						
					else 
						return 0;
	}
	
	public function fillCombo($tableName, $displayField1, $selectText="...Select...", $displayField2="", $valueField="", $where="" , $orderBy="", $defaultSelectText="", $displayField2AdditioanlText="")
			{
					
					
					if(!empty($where))
						$where =" WHERE " . $where;
						
					
						
					if(empty($tableName))
						return "Missing Parameter : Table name";
					if(empty($displayField1))
						return "Missing Parameter : display field1";
					
					if(!empty($displayField2) && !empty($valueField))
                                        {
                                            if(!empty($displayField2AdditioanlText))
						$SQL ="SELECT {$valueField} AS valueField, CONCAT ({$displayField1}, ' (' , '{$displayField2AdditioanlText}', {$displayField2} , ')' ) AS displayField  FROM `{$tableName}` {$where}";
                                            else	
                                                $SQL ="SELECT {$valueField} AS valueField, CONCAT ({$displayField1}, ' (' , {$displayField2} , ')' ) AS displayField  FROM `{$tableName}` {$where}";
                                        }	
					else if(empty($valueField))
						$SQL ="SELECT DISTINCT {$displayField1} AS displayField, {$displayField1} AS valueField  FROM `{$tableName}` {$where}";
					
					else
						$SQL ="SELECT DISTINCT {$displayField1} AS displayField, {$valueField} AS valueField  FROM `{$tableName}` {$where}";
					
					if(!empty($orderBy))
						{
							$orderBy =" ORDER BY " . $orderBy;
							$SQL .= $orderBy;	
						}
					else
						{
							$SQL .= " ORDER BY {$displayField1}";
						}
						
					//return $SQL;
					
					
					$result = $this->mysqli->query($SQL);
					$retHTML ="";
					
					if(mysqli_num_rows($result)>0)
					{
						$retHTML = "<option value=''>{$selectText}</option>";
				 	
						while($row=mysqli_fetch_array($result))
						{
							$value = $row['valueField'];
							$display = $row['displayField'];
							$dSelect="";
						  
							if(!empty($defaultSelectText) && $defaultSelectText==$display)
								$dSelect="selected";
								
							$retHTML .= "<option {$dSelect} value='{$value}'>{$display}</option>";
						}
					}
					else
						$retHTML = "<option value=''>No data found</option>";
					
					return $retHTML;
							
			
			}	// FILL COMBO FUNCTION ENDING


   public function getFieldValueById($tableName, $fieldName, $where, $orderBy="")
   	{
	
	
			 if(!empty($where))
						$where =" WHERE " . $where;
					
					if(empty($tableName))
						return "Missing Parameter : table name";
					
						
					if(empty($fieldName))
						return "Missing Parameter : field name";
					if(empty($where))
						return "Missing Parameter : where clouse";
		
				    if(!empty($orderBy))
						$orderBy =" ORDER BY " . $orderBy;
					
					$SQL ="SELECT {$fieldName} FROM {$tableName} " . $where . $orderBy;
					
			 		$result = $this->mysqli->query($SQL);
					
					if(mysqli_num_rows($result)>0)
						{
							$row = mysqli_fetch_array($result);
							return $row[$fieldName];
						
						}
					return FALSE;
			
	
	
	}
     
  public function getSystemNo($numberType, $isYearAdded=false, $separatorChar="-") // this function will get the number from sys_setnumber table, and update the given parameter field.
  {
			if(empty($numberType))
				return "Missing Parameter : NumberType";
			
			
			//NumberType
			 $SQL ="SELECT *  FROM `sys_setnumber` WHERE NumberType='{$numberType}' AND Status=1";
			 
			 $result = $this->mysqli->query($SQL);
			
					if(mysqli_num_rows($result)>0)
					{
						 $value = mysqli_fetch_object($result);
						 $numText = $value->NumberText;
						 $lastNumber = $value->LastNumber;
						 $startNumber = $value->StartNumber;
						 $retNum ="";
						 $year   = date("Y"); 
						if(!is_null($numText))
								$retNum =$numText . $separatorChar;
						if($isYearAdded)
							 $retNum .=$year . $separatorChar;
						
						if($lastNumber==0 || $lastNumber==NULL)
						{
							$lastNumber = $startNumber;
							$lastNumber++;
						}	
						else
							$lastNumber++;
						
						 $retNum .=$lastNumber;
						 
						 $SQL = "UPDATE `sys_setnumber` SET LastNumber ='{$lastNumber}' WHERE NumberType='{$numberType}'";
						 $this->mysqli->query($SQL);
						 
						 return $retNum;
					}
					else
						return "Error given number type not found!";
	  
  }      
	
} // CLASS ENDING
?>
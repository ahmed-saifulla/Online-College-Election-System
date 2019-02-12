<?php

/*
*		This is a User Defined Helper :
		Author : Sandeep
		
		This can be used to send Email by using phpmailer plugin
		
*/

if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
 
 
				/****************************************************************
				 *	 Note : 													*
				 *			This is the common Functions for php..				*
				 *			And can be used for every project					*	
				 * 																*
				 *	      Author 		: Sandeep 							 	*
				 * 		  Created On	: 30/07/2011							*				
				 *																*
				 ****************************************************************/																


/*
 * 
 * 
 */

  //------------ PASSWORD KEY ------------------ //
        
        define("PASS_KEY", "$@#@#!@###&**@@@%%%$#@!@@##@#");
        define("PASS_KEY_LENGTH", "7");

        
 
function encriptPassword($password)
{
                $cryptpass = sha1($password); // encripting the password
                $salt      = substr(md5(PASS_KEY),0,PASS_KEY_LENGTH);
                $hashSaltPass = $salt . sha1($salt . $cryptpass);
                return $hashSaltPass;              
    
}

function verifyPassword($given, $stored)
 {
        $cryptpass = sha1($given);
	$salt = substr(md5(PASS_KEY), 0, PASS_KEY_LENGTH);
	$hashSaltPass = $salt . sha1($salt . $cryptpass);
	return ($stored == $hashSaltPass);
}


/* 
 * 
 * This is the function to generate random String from a given String. Especially using
 * for password encryption.
 *  calling method : $res = randStrGen(20);
 * 
 * 
 */

function randStrGen($len)
{
    $result = "";
    $chars = "abcdefghijklmnopqrstuvwxyz0123456789$%&**@##)(!^***%%%%%%%%%%%####";
    $charArray = str_split($chars);
    for($i = 0; $i < $len; $i++)
    {
	    $randItem = array_rand($charArray);
	    $result .= "".$charArray[$randItem];
    }
    return $result;
}



/*------- This function can be used with every insert and update to database field
			to escape double quotes(""), Single quotes(') and backslashes

*/

function cleanUpField($fieldValue)
	{
			$isMagicQuoteActive		= get_magic_quotes_gpc();  // --- > getting whether magic quotes is 
															  //	turnd on or not
			$isFunctionExists		= function_exists("mysql_real_escape_string");	// ie for php v >= 4.3;											  																					// this function only included with 
																					// php v 4.3 or greater			
			if($isFunctionExists) // for  php ver. 4.3 or greater
				{
						// undo any magic effects so mysql_real_escape_string can do the work
						if($isMagicQuoteActive)	
							$fieldValue	=stripslashes($fieldValue);
						
						 $fieldValue	= mysql_real_escape_string($fieldValue);
								
				}
			else //before php v4.3 
				{
						// if magic quotes not already on then add slashes manually
						
						if(!$isMagicQuoteActive)	
							$fieldValue	=addslashes($fieldValue);
						
				}															  
			
			return $fieldValue;	
	}

/////////// ---------------------- [FUNCTION TO REDIRECT] -----------------


function redirectTo($location =NULL)
{
		/*
		if($location!=NULL)
			{
				header("Location: {$location}");
				exit;
			}
	    */
	if($location!=NULL)
	 {	
	   if (!headers_sent())
	 	{
			
                        header("Location: http://" . $_SERVER['HTTP_HOST'] .
                              "/" . $location);
		        exit;		 
	 	} 
    	else 
		 {
		die("Could not redirect; Headers already sent (output)");
	 	}		
	}
}

//------- function to prevent Direct Accress to php file ------

function  noDirectAccess($fileName)
{
	if (preg_match("/{$fileName}/", $_SERVER['SCRIPT_FILENAME']))
	 {
    	die("Access Denied");
    	exit;
 	 }

}


function redirectToSelf($location =NULL)
{
		
		if($location!=NULL)
			{
				header("Location: {$location}");
				exit;
			}
	    
            if($location!=NULL)
            {	
                if (!headers_sent())
	 	{
	 
			header("Location: http://" . $_SERVER['HTTP_HOST'] .
				dirname($_SERVER['PHP_SELF']) . "/" . $location);
	                exit;		 
	 	} 
    	else 
		 {
		die("Could not redirect; Headers already sent (output)");
	 	}		
	}
}


// ----------[ FUNCTION TO INSERT AN ELEMENT INTO AN ARRAY AT SPECIFIED POSITION} ---
			
			
			/************************************************************
			 * Note : This function can be called as follows			*
			 *															*
			 *		  1. array_insert(<array), <value>, <position>);	*																									  			 *				for inserting the given position			*
			 *															*  
		     *		  2. array_insert(<array), <value>, <-position>);	*	
			 *				Will insert -position from the end			*												 			 			 *															*
			 *		  3. array_insert(<array), <value>);				*																		 			 *	    			Will insert at the end					*
			 *															*	
			 *															*
			 *															*
			 ************************************************************/
			 
			 
			 
			 
function array_insert(&$array,$element,$position=NULL) 
{
	  if(count($array) == 0) 
		{
			$array[] = $element;
		}
	 
	  elseif (is_numeric($position) && $position < 0)
		{
			if((count($array)+position) < 0) 
				{
					$array = array_insert($array,$element,0);
				}
			else
				{
					$array[count($array)+$position] = $element;
				}
	  
		}
	 
	 elseif (is_numeric($position) && isset($array[$position])) 
		{
			$part1 = array_slice($array,0,$position,true);
			$part2 = array_slice($array,$position,null,true);
			$array = array_merge($part1,array($position=>$element),$part2);
			
			foreach($array as $key=>$item)
			{
				if (is_null($item))
					{
						unset($array[$key]);
					}
			}
		}
	
	 elseif (is_null($position))
		 {
		   $array[] = $element;
		 }
	 elseif (!isset($array[$position]))
		 {
			$array[$position] = $element;
		 }
		
		$array = array_merge($array);
		return $array;
}


//=============================[ FORM VALIDATION FUNCTIONS ] ================================

								// Can be used as server side form validation 

			/********************************************************************
			 *			  Function to check the required fields					*
			 *				 													*
			 *				 parameters --->1.requiredFields as array			*
			 *								  like field name and 				*
			 *								  error display message				*
			 *								  									*
			 *								  ie. array("txtFirstName" 			*	
			 *										   => "Firstname required");*
			 *  								  								*
			 *								2. First error Message as string	*			
			 *			    													*
			 *				Return type	---> String, if any error or an empty 	*
			 *										 String						*
			 *																	*
			 * 				 Author			: Sandeep							*
			 *				 Created On		: 01/08/2011						* 	 
			 ********************************************************************/

function validateRequiredFields($requiredFields, $errorMsg=NULL,$errorLineBreak=false)
{
	 $errorOut ="";
	 $errorArray =	array();
	
	 foreach($requiredFields as $fieldName => $displayName)
		{
			if(!isset($_REQUEST[$fieldName]) || empty($_REQUEST[$fieldName]))
			{
				if(count($errorArray)> 0)
					array_push($errorArray," ". $displayName);
				else
					array_push($errorArray, $displayName);
			}
		}
		
	

	   if(count($errorArray)> 0)
		 {
			
			if($errorMsg!=NULL) // inserting the error message, if any at the first
				$errorArray=array_insert($errorArray, $errorMsg ." ", 0);
			
                            foreach($errorArray as $error)
                            {
                                if($errorLineBreak)
                                    $errorOut .= $error.'<br/>';
                            
                                else 
                                    $errorOut .= $error;
                            }
                            
                            
                        		
         }
		    		  
	
	return $errorOut;
}


//------------------------------------------------------------------------------------------

							/* FILED LENGTH CHECKING FUNCTION  */

			/********************************************************************
			 *			  Function to check the field Length					*
			 *				 													*
			 *				 parameters --->1. maxLengthFields as array			*
			 *								  like <fieldname|displaymsg> and 	*
			 *								  its maximum length				*
			 *								  									*
			 *								  ie. array("txtFirstName|FirstName"*	
			 *										   => 30);					*
			 *  								  								*
			 *								2. First error Message as string	*			
			 *			    													*
			 *				Return type	---> String, if any error or an empty 	*
			 *										 String						*
			 *																	*
			 * 				 Author			: Sandeep							*
			 *				 Created On		: 01/08/2011						* 	 
			 ********************************************************************/

function validateMaxLength($maxLengthFields, $errorMsg=NULL)
{
	 $errorOut ="";
	 $errorArray =	array();
	
	 foreach($maxLengthFields as $field => $maxlength)
		{
			$fieldAndDisplay	= explode("|", $field);
			
			$fieldName			= $fieldAndDisplay[0];
			$displayName		= $fieldAndDisplay[1];
			
			if(strlen(trim(cleanUpField($_REQUEST[$fieldName]))) > $maxlength)
			{
				if(count($errorArray)> 0)
					array_push($errorArray," & ". $displayName);
				else
					array_push($errorArray, $displayName);
			}
			
		}
	
	   if(count($errorArray)> 0)
		 {
			
			if($errorMsg!=NULL) // inserting the error message, if any at the first 
				$errorArray=array_insert($errorArray, $errorMsg, 0);
			
			foreach($errorArray as $error)
			{
				$errorOut .= $error.'<br/>';
			}
	     
			
		 }
	
	return $errorOut;
}

//============================================================================================

							/* INTEGER FIELD CHECKING FUNCTION  */

			/********************************************************************
			 *			  Function to check the integer field					*
			 *				 													*
			 *				 parameters --->1.integerFields as array			*
			 *								  like field name and 				*
			 *								  error display message				*
			 *								  									*
			 *								 ie. array("txtAge" =>"dismsg");	*	
			 *										   							*
			 *  								  								*
			 *								2. First error Message as string	*			
			 *			    													*
			 *				Return type	---> String, if any error or an empty 	*
			 *										 String						*
			 *																	*
			 * 				 Author			: Sandeep							*
			 *				 Created On		: 01/08/2011						* 	 
			 ********************************************************************/


function validateIntegerFields($integerFields, $errorMsg=NULL)
{
	 $errorOut ="";
	 $errorArray =	array();
	
	 foreach($integerFields as $fieldName => $displayName)
		{
			if(!filter_var($_REQUEST[$fieldName], FILTER_VALIDATE_INT)) 
			{
				if(count($errorArray)> 0)
					array_push($errorArray," & ". $displayName);
				else
					array_push($errorArray, $displayName);
			}
		}
		
	

	   if(count($errorArray)> 0)
		 {
			
			if($errorMsg!=NULL) // inserting the error message, if any at the first 
				$errorArray=array_insert($errorArray, $errorMsg, 0);
			
			foreach($errorArray as $error)
			{
				$errorOut .= $error.'<br/>';
			}
	     
			
		 }
	
	return $errorOut;
}


//============================================================================================

							/* NUMBER FIELD CHECKING FUNCTION  */

			/********************************************************************
			 *			  Function to check the number field					*
			 *				 													*
			 *				 parameters --->1.numberFields as array				*
			 *								  like field name and 				*
			 *								  error display message				*
			 *								  									*
			 *								 ie. array("txtSalary" =>"dismsg");	*	
			 *										   							*
			 *  								  								*
			 *								2. First error Message as string	*			
			 *			    													*
			 *				Return type	---> String, if any error or an empty 	*
			 *										 String						*
			 *																	*
			 * 				 Author			: Sandeep							*
			 *				 Created On		: 01/08/2011						* 	 
			 ********************************************************************/


function validateNumericFields($integerFields, $errorMsg=NULL)
{
	 $errorOut ="";
	 $errorArray =	array();
	
	 foreach($numberFields as $fieldName => $displayName)
		{
			if(!is_numeric($_REQUEST[$fieldName])) 
			{
				if(count($errorArray)> 0)
					array_push($errorArray," & ". $displayName);
				else
					array_push($errorArray, $displayName);
			}
		}
		
	

	   if(count($errorArray)> 0)
		 {
			
			if($errorMsg!=NULL) // inserting the error message, if any at the first 
				$errorArray=array_insert($errorArray, $errorMsg, 0);
			
			foreach($errorArray as $error)
			{
				$errorOut .= $error.'<br/>';
			}
	     
			
		 }
	
	return $errorOut;
}



//============================================================================================

							/* EMAIL FIELD CHECKING FUNCTION  */

			/********************************************************************
			 *			  Function to check the eMail field						*
			 *				 													*
			 *				 parameters --->1.emailFields as array				*
			 *								  like field name and 				*
			 *								  error display message				*
			 *								  									*
			 *								 ie. array("txtEmail" =>"dismsg");	*	
			 *										   							*
			 *  								  								*
			 *								2. First error Message as string	*			
			 *			    													*
			 *				Return type	---> String, if any error or an empty 	*
			 *										 String						*
			 *																	*
			 * 				 Author			: Sandeep							*
			 *				 Created On		: 01/08/2011						* 	 
			 ********************************************************************/


function validateEmailFields($emailFields, $errorMsg=NULL)
{
	 $errorOut ="";
	 $errorArray =	array();
	
	 foreach($emailFields as $fieldName => $displayName)
		{
			if(!filter_var($_REQUEST[$fieldName], FILTER_VALIDATE_EMAIL)) 
			{
				if(count($errorArray)> 0)
					array_push($errorArray," & ". $displayName);
				else
					array_push($errorArray, $displayName);
			}
		}
		
	

	   if(count($errorArray)> 0)
		 {
			
			if($errorMsg!=NULL) // inserting the error message, if any at the first 
				$errorArray=array_insert($errorArray, $errorMsg, 0);
			
			foreach($errorArray as $error)
			{
				$errorOut .= $error.'<br/>';
			}
	     
			
		 }
	
	return $errorOut;
}

//============================================================================================

							/* URL FIELD CHECKING FUNCTION  */

			/********************************************************************
			 *			  Function to check the eMail field						*
			 *				 													*
			 *				 parameters --->1.urlFields as array				*
			 *								  like field name and 				*
			 *								  error display message				*
			 *								  									*
			 *								 ie. array("txtUrl" =>"dismsg");	*	
			 *										   							*
			 *  								  								*
			 *								2. First error Message as string	*			
			 *			    													*
			 *				Return type	---> String, if any error or an empty 	*
			 *										 String						*
			 *																	*
			 * 				 Author			: Sandeep							*
			 *				 Created On		: 01/08/2011						* 	 
			 ********************************************************************/


function validateUrlFields($urlFields, $errorMsg=NULL)
{
	 $errorOut ="";
	 $errorArray =	array();
	
	 foreach($urlFields as $fieldName => $displayName)
		{
			if(!filter_var($_REQUEST[$fieldName], FILTER_VALIDATE_URL)) 
			{
				if(count($errorArray)> 0)
					array_push($errorArray," & ". $displayName);
				else
					array_push($errorArray, $displayName);
			}
		}
		
	

	   if(count($errorArray)> 0)
		 {
			
			if($errorMsg!=NULL) // inserting the error message, if any at the first 
				$errorArray=array_insert($errorArray, $errorMsg, 0);
			
			foreach($errorArray as $error)
			{
				$errorOut .= $error.'<br/>';
			}
	     
			
		 }
	
	return $errorOut;
}


//============================================================================================

							/* IP FIELD CHECKING FUNCTION  */

			/********************************************************************
			 *			  Function to check the IP field						*
			 *				 													*
			 *				 parameters --->1.ipFields as array					*
			 *								  like field name and 				*
			 *								  error display message				*
			 *								  									*
			 *								 ie. array("txtIP" =>"dismsg");		*	
			 *										   							*
			 *  								  								*
			 *								2. First error Message as string	*			
			 *			    													*
			 *				Return type	---> String, if any error or an empty 	*
			 *										 String						*
			 *																	*
			 * 				 Author			: Sandeep							*
			 *				 Created On		: 01/08/2011						* 	 
			 ********************************************************************/


function validateIpFields($ipFields, $errorMsg=NULL)
{
	 $errorOut ="";
	 $errorArray =	array();
	
	 foreach($ipFields as $fieldName => $displayName)
		{
			if(!filter_var($_REQUEST[$fieldName], FILTER_VALIDATE_IP)) 
			{
				if(count($errorArray)> 0)
					array_push($errorArray," & ". $displayName);
				else
					array_push($errorArray, $displayName);
			}
		}
		
	

	   if(count($errorArray)> 0)
		 {
			
			if($errorMsg!=NULL) // inserting the error message, if any at the first 
				$errorArray=array_insert($errorArray, $errorMsg, 0);
			
			foreach($errorArray as $error)
			{
				$errorOut .= $error.'<br/>';
			}
	     
			
		 }
	
	return $errorOut;
}





//==============================[FILTERING FUNCTIONS]=============================

							/* SANITISE STRING FUNCTION  */

			/********************************************************************
			 *			  Function to remove unwanted chars in a String			*
			 *				 													*
			 *				 parameters --->1.strField as String			   	*
			 *			    													*
			 *				 Return type---> String, after filtering			*
			 *										 String						*
			 *																	*
			 * 				 Author			: Sandeep							*
			 *				 Created On		: 01/08/2011						* 	 
			 ********************************************************************/


function sanitiseString($strField)
{
	$strOut = filter_var($strField, FILTER_SANITIZE_STRING);
	return $strOut;
}



//-------------------- FUNCTION TO CONVERT date format for inserting and reading from MySQL ----

//----For the second parameter pass 1 for mysql insert conversion  Y-mm-dd format 
//---- and 2 for  read to dd/mm/YYYY format
	
function dateConvert($date,$func)
{
	
	if($func==1) 
	{
		
                list($day,$month,$year)=preg_split('/[-\.\/]/',$date);
		$date="$year-$month-$day";
		return $date;
	}

	if($func==2) 
	{
		list($year,$month,$day)=preg_split('/[-\.\/]/',$date);
                $date="$day/$month/$year";
		return $date;
	
	}

}

// FUNCITON TO GET THE IP ADDRESS OF REQUEST CLIENT
function getRequestIPAddress()
{
    $ip = preg_replace('#[^0-9.]#', '', getenv('REMOTE_ADDR'));
    
    return $ip;
    
    
}


// ------ FUNCTION TO DOWN LOAD A FILE

function downloadFile($file, $name, $mime_type='')
{
 /*
 This function takes a path to a file to output ($file),  the filename that the browser will see ($name) and  the MIME type of the file ($mime_type, optional).
 */
 
 //Check the file premission
 if(!is_readable($file)) die('File not found or inaccessible!');
 
 $size = filesize($file);
 $name = rawurldecode($name);
 
 /* Figure out the MIME type | Check in array */
 $known_mime_types=array(
 	"pdf" => "application/pdf",
 	"txt" => "text/plain",
 	"html" => "text/html",
 	"htm" => "text/html",
	"exe" => "application/octet-stream",
	"zip" => "application/zip",
	"doc" => "application/msword",
	"xls" => "application/vnd.ms-excel",
	"ppt" => "application/vnd.ms-powerpoint",
	"gif" => "image/gif",
	"png" => "image/png",
	"jpeg"=> "image/jpg",
	"jpg" =>  "image/jpg",
	"php" => "text/plain"
 );
 
 if($mime_type==''){
	 $file_extension = strtolower(substr(strrchr($file,"."),1));
	 if(array_key_exists($file_extension, $known_mime_types)){
		$mime_type=$known_mime_types[$file_extension];
	 } else {
		$mime_type="application/force-download";
	 }
 }
 
 //turn off output buffering to decrease cpu usage
 @ob_end_clean(); 
 
 // required for IE, otherwise Content-Disposition may be ignored
 if(ini_get('zlib.output_compression'))
  ini_set('zlib.output_compression', 'Off');
 
 header('Content-Type: ' . $mime_type);
 header('Content-Disposition: attachment; filename="'.$name.'"');
 header("Content-Transfer-Encoding: binary");
 header('Accept-Ranges: bytes');
 
 /* The three lines below basically make the 
    download non-cacheable */
 header("Cache-control: private");
 header('Pragma: private');
 header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
 
 // multipart-download and download resuming support
 if(isset($_SERVER['HTTP_RANGE']))
 {
	list($a, $range) = explode("=",$_SERVER['HTTP_RANGE'],2);
	list($range) = explode(",",$range,2);
	list($range, $range_end) = explode("-", $range);
	$range=intval($range);
	if(!$range_end) {
		$range_end=$size-1;
	} else {
		$range_end=intval($range_end);
	}
	/*
	------------------------------------------------------------------------------------------------------
	//This application is developed by www.webinfopedia.com
	//visit www.webinfopedia.com for PHP,Mysql,html5 and Designing tutorials for FREE!!!
	------------------------------------------------------------------------------------------------------
 	*/
	$new_length = $range_end-$range+1;
	header("HTTP/1.1 206 Partial Content");
	header("Content-Length: $new_length");
	header("Content-Range: bytes $range-$range_end/$size");
 } else {
	$new_length=$size;
	header("Content-Length: ".$size);
 }
 
 /* Will output the file itself */
 $chunksize = 1*(1024*1024); //you may want to change this
 $bytes_send = 0;
 if ($file = fopen($file, 'r'))
 {
	if(isset($_SERVER['HTTP_RANGE']))
	fseek($file, $range);
 
	while(!feof($file) && 
		(!connection_aborted()) && 
		($bytes_send<$new_length)
	      )
	{
		$buffer = fread($file, $chunksize);
		print($buffer); //echo($buffer); // can also possible
		flush();
		$bytes_send += strlen($buffer);
	}
 fclose($file);
 } else
 //If no permissiion
 die('Error - can not open file.');
 //die
die();
}


			/* FUNCTION TO CHECK AJAX REQUEST : usage  is function isAJAX(__FILE__) */

function isAJAX($script) {
  $isAjax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) AND
  strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
  if(!$isAjax) {
	exit("Sorry Access denied!");
  }
}

//------------------------------------------ NUMBER TO WORDS ----------------------------

function convertNumberToWords($number) 
{

   $no =  $number; //round($number);
   
  if(strpos($number,".")==FALSE)
	  $number = $number . ".00";
   
   $pointString =substr((string)$number,strpos($number,".")+1);
   
   //return $pointString;
   
   if(strlen($pointString)==1)
	   $pointString .="0";
   $point = (int)$pointString;
  
   //$point = (int)substr($number,strpos($number,"."));   //abs(round($number - $no, 2) * 100);
    

   $hundred = null;
   $digits_1 = strlen($no);
   $i = 0;
   $str = array();
   $words = array('0' => '', '1' => 'One', '2' => 'Two',
    '3' => 'Three', '4' => 'Four', '5' => 'Five', '6' => 'Six',
    '7' => 'Seven', '8' => 'Eight', '9' => 'Nine',
    '10' => 'Ten', '11' => 'Eleven', '12' => 'Twelve',
    '13' => 'Thirteen', '14' => 'Fourteen',
    '15' => 'Fifteen', '16' => 'Sixteen', '17' => 'Seventeen',
    '18' => 'Eighteen', '19' =>'Nineteen', '20' => 'Twenty',
    '30' => 'Thirty', '40' => 'Forty', '50' => 'Fifty',
    '60' => 'Sixty', '70' => 'Seventy',
    '80' => 'Eighty', '90' => 'Ninety');
   $digits = array('', 'Hundred', 'Thousand', 'Lakh', 'Crore');
   while ($i < $digits_1) {
     $divider = ($i == 2) ? 10 : 100;
     $number = floor($no % $divider);
     $no = floor($no / $divider);
     $i += ($divider == 10) ? 1 : 2;
     if ($number) {
        $plural = (($counter = count($str)) && $number > 9) ? 's' : null;
        $hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
        $str [] = ($number < 21) ? $words[$number] .
            " " . $digits[$counter] . $plural . " " . $hundred
            :
            $words[floor($number / 10) * 10]
            . " " . $words[$number % 10] . " "
            . $digits[$counter] . $plural . " " . $hundred;
     } else $str[] = null;
  }
  $str = array_reverse($str);
  $result = implode('', $str);
  $points = ($point) ?
    ". " . $words[$point / 10] . " " . 
          $words[$point = $point % 10] : '';
	
  if($points=="")
	return $result . "Rupees . Zero Zero Paise";
   else
	{
	
		if(strlen($point)==1 && strpos($points," ") +1 =="")
			return $result . "Rupees  " . $points . " Zero Paise";
		else
			return $result . "Rupees  " . $points . " Paise";
	}	
  //return $result . "Rupees  " . $points . " Paise";
}


//-------------------------------------- FUNCTION TO FORMAT INDIAN STYLE MONEY ----------------------------

function moneyFormatIndia($num,$pointString="") {

   $explrestunits = "" ;
    if(strlen($num)>3){
        $lastthree = substr($num, strlen($num)-3, strlen($num));
        $restunits = substr($num, 0, strlen($num)-3); // extracts the last three digits
        $restunits = (strlen($restunits)%2 == 1)?"0".$restunits:$restunits; // explodes the remaining digits in 2's formats, adds a zero in the beginning to maintain the 2's grouping.
        $expunit = str_split($restunits, 2);
        for($i=0; $i<sizeof($expunit); $i++){
            // creates each of the 2's group and adds a comma to the end
            if($i==0)
            {
                $explrestunits .= (int)$expunit[$i].","; // if is first value , convert into integer
            }else{
                $explrestunits .= $expunit[$i].",";
            }
        }
        $thecash = $explrestunits.$lastthree;
    } else {
        $thecash = $num;
    }

	if(strlen($pointString>0))
		$thecash = (string) $thecash . "." .  $pointString;
        else
		$thecash = (string) $thecash . ".00";
	return $thecash; // writes the final format where $currency is the currency symbol.
}


//---------------------------------------- ADDING DAYS TO A GIVEN DATE AND returns Date in MySQL FORMAT -----------------------------

function addDateDays($mySQLFormatDate, $noOfDaysToAdd)
{
		$ed = strtotime('+' .$noOfDaysToAdd . ' days', strtotime($mySQLFormatDate));    
		$retDate = date('Y-m-d', $ed); 
		return $retDate;
	
}

//---------------------------------------- ADDING MONTHS TO A GIVEN DATE AND returns Date in MySQL FORMAT -----------------------------

function addDateMonths($mySQLFormatDate, $noOfMonthsToAdd)
{
		$ed = strtotime('+' .$noOfMonthsToAdd . ' months', strtotime($mySQLFormatDate));    
		$retDate = date('Y-m-d', $ed); 
		return $retDate;
}

//---------------------------------------- ADDING YEARS TO A GIVEN DATE AND returns Date in MySQL FORMAT -----------------------------

function addDateYears($mySQLFormatDate, $noOfYearsToAdd)
{
		$ed = strtotime('+' .$noOfYearsToAdd . ' years', strtotime($mySQLFormatDate));    
		$retDate = date('Y-m-d', $ed); 
		return $retDate;
	
}

//--------------------------------- FINDING DAYS LEFT FROM FUTURE DATE TO CURRENT DATE --------

function subtractDaysFromFutureToCurrent($mySQLFormatFutureDate)
{
    $eDate     = new DateTime($mySQLFormatFutureDate);
    $expiryDate= $eDate->format('Y-m-d');

     $now = time(); // or your date as well
     $your_date = strtotime($expiryDate);
     $datediff = $now - $your_date;
     return abs(floor($datediff/(60*60*24)));
     
    
}


//--------------------------- SUBSTRACT DAYS FROM TWO GIVEN Dates -------------------

function subtractDaysFromDate($mySQLFormatDate, $mySQLFormatFutureDate)
{
	
	 $eDate     = new DateTime($mySQLFormatFutureDate);
	 $expiryDate= $eDate->format('Y-m-d');
	
         $now = new DateTime($mySQLFormatDate); // or your date as well
	 $now = $now->format('Y-m-d');
	 $now  =strtotime($now);
         $your_date = strtotime($expiryDate);
         $datediff = $now - $your_date;
         return abs(floor($datediff/(60*60*24)));
     
    
}

//-------------- FUNCTION TO abstract a some words from a paragraph upto find the first full stop -----------
function abstractFromParagraph($content)
{
    $position = stripos ($content, "."); //find first dot position
   
    if($position) { //if there's a dot in our soruce text do
        $offset = $position + 1; //prepare offset
        $position2 = stripos ($content, ".", $offset); //find second dot using offset
        $first_two = substr($content, 0, $position2); //put two first sentences under $first_two

        return $first_two . '.'; //add a dot
    }

    else { // if no dot return blank
		return "";	
    }
	
}

//-------------- FUNCTION TO get some words from a given setence : default 10 -----------

function getWords($sentence, $count = 10) {
  preg_match("/(?:\w+(?:\W+|$)){0,$count}/", $sentence, $matches);
  return $matches[0];
}

//---------------- FUNCTION to replace HTML tags to space in a string --------------------------

function filterHTMLTags( $text )
{
    $text = preg_replace(
        array(
          // Remove invisible content
            '@<head[^>]*?>.*?</head>@siu',
            '@<style[^>]*?>.*?</style>@siu',
            '@<script[^>]*?.*?</script>@siu',
            '@<object[^>]*?.*?</object>@siu',
            '@<embed[^>]*?.*?</embed>@siu',
            '@<applet[^>]*?.*?</applet>@siu',
            '@<noframes[^>]*?.*?</noframes>@siu',
            '@<noscript[^>]*?.*?</noscript>@siu',
            '@<noembed[^>]*?.*?</noembed>@siu',
          // Add line breaks before and after blocks
            '@</?((address)|(blockquote)|(center)|(del))@iu',
            '@</?((div)|(h[1-9])|(ins)|(isindex)|(p)|(pre))@iu',
            '@</?((dir)|(dl)|(dt)|(dd)|(li)|(menu)|(ol)|(ul))@iu',
            '@</?((table)|(th)|(td)|(caption))@iu',
            '@</?((form)|(button)|(fieldset)|(legend)|(input))@iu',
            '@</?((label)|(select)|(optgroup)|(option)|(textarea))@iu',
            '@</?((frameset)|(frame)|(iframe))@iu',
        ),
        array(
            ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ',
            "\n\$0", "\n\$0", "\n\$0", "\n\$0", "\n\$0", "\n\$0",
            "\n\$0", "\n\$0",
        ),
        $text );
    return strip_tags( $text );
}

//--------- FOR my_json_encode (Customized function for Arabic (UTF-8) charecters showing)

function json_cb(&$item, $key) { 
    if (is_string($item)) $item = mb_encode_numericentity($item, array (0x80, 0xffff, 0, 0xffff), 'UTF-8'); 
}

function generateOTP($length)
	{
    
    $chars = "0123456789";
    $str= "";
    $size = strlen($chars);
    for ($i = 0; $i < $length; $i++) {
            $str .= $chars[ rand(0, $size - 1) ];
    }

    return $str;
  }

  // ------------- FUNCTION FOR encrypt and decrypt data --------------------------
 function crypt_data($string, $action = 'e') 
{
    $secret_key 	= "@#@ @@&&*$ bhufjg *@ !@#432 3783"; // 32bits

    $secret_iv 		= md5('sA*(DH');
    $secret_iv 		= md5($secret_iv);

    $output 		= false;
    $encrypt_method = "AES-256-CBC";
    $key 			= hash('sha256', $secret_key);
    $iv 			= substr(hash('sha256', $secret_iv), 0, 16);

 
    if ($action == 'e') {
        $output = base64_encode(openssl_encrypt($string, $encrypt_method, $key, 0, $iv));
    } elseif ($action == 'd') {
        $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
    }

    return $output;
} 

?>
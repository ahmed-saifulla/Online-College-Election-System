<?php

/*
*		This is a User Defined Helper :
		Author : Sandeep
		
		This can be used to send Email by using phpmailer plugin
		
		1) Put the mailer plugin files in the System-> libraries folder.
		2) Put the email_settings in the application->config folder.
		
		
		In the autoload.php  add send_email_helper
							 add email_settings in config array.
		
		
*/
if ( ! defined('BASEPATH')) exit('No direct script access allowed');


function sendEmail($messageTo, $messageToUserName="", $messageBody, $subject)
{
                  $CI =& get_instance();
                  $CI->load->library('phpmailer/phpmailer');
                  
                  
                $mail = new CI_PHPMailer();

                $mail->IsSMTP();
				
				//$mail->SMTPDebug = true; // for debugigng
				
				$mail->Mailer = 'smtp';
				$mail->IsHTML(true);
                $mail->SMTPAuth =true;
                $mail->SMTPAuth = $CI->config->item('SMTPAuth');
                $mail->Host = $CI->config->item('Host');
                $mail->Port = $CI->config->item('Port');
				
		
                $mail->Username = $CI->config->item('Username'); 
                $mail->Password = $CI->config->item('Password'); 
                
                $headers  ="From: TestingFrom\n";
				$headers .= "MIME-Version: 1.0\n";
				$headers .= "Content-type: text/html; charset=iso-8859-1 \n";
				
		      //  $mail->HeaderLine($header, $headers);
				
				$mail->SetFrom($CI->config->item('Username'), $subject);

				
				$mail->Subject =$subject;
                $mail->MsgHTML($messageBody);
                $mail->AddAddress($messageTo, $messageToUserName);
                
               
			   	return $mail->Send();


}

function sendCiEMail($messageTo, $messageBody, $subject)
{
	 $CI =& get_instance();
	 $host 			= 'ssl://smtp.gmail.com';
	 $port 			= '465';
	 $userName  	= 'ahsaifullah131@gmail.com';
	 $pass 			= 'gg*#15cs008isme'; 
      
	
	 
	
	$config = Array(
	'protocol' => 'smtp',
	'smtp_host' => $host,
	'smtp_port' => $port,
	'smtp_user' => $userName, // change it to yours
	'smtp_pass' => $pass, // change it to yours
	'mailtype' => 'html',
	'charset' => 'iso-8859-1',
	'wordwrap' => TRUE
	);
	$CI->load->library('email', $config);

     
	  
      $CI->email->set_newline("\r\n");
      $CI->email->from($userName); // change it to yours
      $CI->email->to($messageTo);// change it to yours
      $CI->email->subject($subject);
      $CI->email->message($messageBody);
     
	 if($CI->email->send())
     {
         return true;
     }
     else
    {
		return (show_error($CI->email->print_debugger()));
    }

}



?>

<?php
error_reporting(0);
echo "
    _  _   _____  __   __   __      ____   ___  
  _| || |_|  __ \/_ | / /   \ \    / /_ | / _ \ 
 |_  __  _| |__) || |/ /_    \ \  / / | || | | |
  _| || |_|  _  / | | '_ \    \ \/ /  | || | | |
 |_  __  _| | \ \ | | (_) |    \  /   | || |_| |
   |_||_| |_|  \_\|_|\___/      \/    |_(_)___/ 
                                                
PHP Console Mailer.
Please Edit The config Json File Before sending ! 
";
//check if config.json file exists
if(!file_exists("config.json")){
	echo "can not find config.json file ! exiting ...";
	exit();
}
//read config file 
$config = json_decode(file_get_contents("config.json"));
//set variables :
//------------------------------------------------------
$mailList      = $config->mailListeFile;
$letterFile    = $config->LetterFile;
$sendFromEmail = $config->senderFromEmail;
$sendFromName  = $config->senderFromName;
$Subject       = $config->Subject;
/*
$sleepTime     = $config->sleepTime;
$SleepAfter    = $config->SleepAfter;
$testEmail     = $config->testEmail;
$testAfter     = $config->testAfter;
*/
$totalEmails = count(file($mailList));
//-------------------------------------------------------
$detailesBeforeSend = "
MailList File   : $mailList ($totalEmails email)\n
Letter File     : $letterFile \n
Send From Email : $sendFromEmail \n
Send From Name  : $sendFromName \n
Subject         : $Subject \n
";
/*
Sleep Time      : $sleepTime seconds \n
Sleep After     : $SleepAfter emails \n
Test Email      : $testEmail \n
Test After      : $testAfter email sent\n
";
*/
//-------------------------------------------------------
if(isset($argv[1]) && $argv[1] == "send"){
	//Means start sending !
	//---------------------------------------------------
	//check if mail list file exists :
	if(!file_exists($mailList)){
		echo "can not find mail list file ! exiting ...";
		exit();
	}
	//check if letter file exists :
	if(!file_exists($letterFile)){
		echo "can not find letter file ! exiting ...";
		exit();
	}
	//show setting and send after 10seconds alert 
	echo $detailesBeforeSend;
	echo "The send will start in 10 seconds , please check your detailes  ! , if there is somthing wrong please click cntrl + c  to cancel ! \n\n";
	sleep(10);
	//start sending !
	$i = 1;
	$message = file_get_contents($letterFile);
	foreach(file($mailList) as $email){
		$headers  = "MIME-Version: 1.0" . "\r\n";
		$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
		$headers .= "From: $sendFromName<$sendFromEmail>"."\r\n";
		$headers .= "Return-Path: <$sendFromEmail>"."\r\n";
		$isSent = mail($email,$Subject,$message,$headers);
		$date = date("Y-m-d h:i:s");
		
		if(!$isSent){
			echo "\n[ $i / $totalEmails ][ $date ] Error -> email : $email";
		}else{
			echo "\n[ $i / $totalEmails ][ $date ] Sent  -> email : $email";
		}
		sleep(2);	
		$i++;
	}
}else{
	//Means run in safe mode to check config file !
	echo $detailesBeforeSend;
	echo "this is your config file , this script is running in safe mode! \n please run script with 'send' agrument to start sending , exemple (php send.php send)";
	
}
?>
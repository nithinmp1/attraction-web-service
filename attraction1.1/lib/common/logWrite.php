<?php
/**
	@File Name 		:	logWrite.php
	@Author 		:	Ramanathan M <ramanathan@dss.com.sg>
	@Created Date	:	2015-12-21 10:55 AM
	@Description	:	Success, error, input, output details will be logged using this function
*/
function logWrite($data,$fileName='CommonLog',$addDate='Y',$writeMode='a+')
{
	
	$logPath = $GLOBALS['CONF']['path']['basePath']."var/log/";
	
	if(strtoupper($addDate)=='N'){
		$logFileName = $fileName;
	}
	else{
		$todayDate   = date($GLOBALS['CONF']['site']['logDateFormat']);
		$logFileName = $fileName."_".$todayDate;
	}

	if(isset($GLOBALS['CONF']['userSettings']['userName'])){
		
		$logFolder = $logPath.strtolower($GLOBALS['CONF']['userSettings']['userName']);
		
		if(is_dir($logFolder) === false){
			mkdir($logFolder, 0777, true);
		}
		
		if(is_dir($logFolder) === true){
			$logPath = $logFolder."/";
		}
		else{
			$logFileName = $GLOBALS['CONF']['userSettings']['userName']."_".$logFileName;
		}
	}
	
	$logFileName = $logFileName.".txt";
	
	$logFilePath = $logPath.$logFileName;
	
	$controllerName = '';
	$loginId 		= '';
	
	$f = fopen($logFilePath,$writeMode);
			
	if(!is_array($data)){
		$data = "IP : ".$GLOBALS['CONF']['site']['userIp']." Time : ".date("H:i:s")." AGENT : ".$_SERVER['HTTP_USER_AGENT'].PHP_EOL.$data.PHP_EOL;
		fwrite($f,$data);
	}
	else{
		$string = "IP : ".$GLOBALS['CONF']['site']['userIp']." Time : ".date("H:i:s")." AGENT : ".$_SERVER['HTTP_USER_AGENT'].PHP_EOL;
		foreach ($data as $key => $val){
			$string .= $key." =>  ".$val.PHP_EOL;
		}
		fwrite($f,$string);
	}

	fclose($f);
}
?>
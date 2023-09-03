<?php

	ini_set("max_execution_time", "0");
	
	require_once "class.nusoap.php";
	require_once('userInfo.php');
	
	function getInput($_AuserInfo)
	{
		$_Ainput 						= array();
	
		$_Ainput['userName']			= $_AuserInfo['userName'];
		$_Ainput['action']				= 'LowFareSearchReq';
		$_Ainput['mode']				= 'TEST';
		
		$_Ainput['ADT']					= '1';
		$_Ainput['CHD']					= '0';
		$_Ainput['INF']					= '0';
		
		$_Ainput['sectorInfo']			= array
											(
												0 => array
														(
															'origin'		=> 'MAA',
															'destination'	=> 'SIN',
															'departureDate'	=> '2016-10-08',
														),
											);
											
		$_Ainput['currencyCode']		= 'SGD';
		$_Ainput['cabinClass']			= '';
		
		$_Ainput['preferredProviders']	= array("ACH","1G");
		$_Ainput['prohibitedCarriers']	= array("OD");
		
		$_Ainput['referenceId']			= 0;
		
		$_Ainput['hashKey']				= getSecureHash($_AuserInfo,$_Ainput);
		
		$_Ainput['returnType']			= 'JSON';
		
		// Optional
		
		$_Ainput['apiCredentials']		= array
											(
												'userName'		=> 'Universal API/uAPI3089026605-ee9b355b',
												'password'		=> '7Fz{}j5Kn9',
												'targetBranch'	=> 'P7025462',
												'application'	=> 'uAPI',
											);
											
		return $_Ainput;
	}
	
	$_AuserInfo	= getUserInfo();
	$_Ainput	= getInput($_AuserInfo);
	
	$postData	= json_encode($_Ainput);
	
	
	$url		= 'http://localhost/bridges/airline/travelportNew/Service.php';
	
	
	$client		= new nusoap_client($url);
	
	$postData	= $_Ainput;
	
	$postData	= $client->getSoapMessage('process', array('details' => $postData));
	
	
	$curl	  	= curl_init();

	curl_setopt($curl, CURLOPT_URL, $url);
	
	curl_setopt($curl, CURLOPT_TIMEOUT, 180);
	
	curl_setopt($curl, CURLOPT_HEADER, 0);
	
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
	
	curl_setopt($curl, CURLOPT_POST, 1);
	
	curl_setopt($curl, CURLOPT_POSTFIELDS, $postData); 

	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); 
	
	curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);
	
	curl_setopt($curl, CURLOPT_SSL_CIPHER_LIST, 'TLSv1');

	$str  = $_AuserInfo['userName'].':'.md5($_AuserInfo['password']);
	$auth = base64_encode($str);
	
	$httpHeader2 = array
					(
						"Content-Type: text/xml; charset=ISO-8859-1",
						"Authorization: Basic {$auth}",
						"Content-length: " . strlen($postData)
					);
	
	curl_setopt($curl, CURLOPT_HTTPHEADER, $httpHeader2);
	
	curl_setopt ($curl, CURLOPT_ENCODING, "gzip, deflate");
	
	$response = curl_exec($curl);

	if ($response === false) {
		$info = curl_getinfo($curl);
		curl_close($curl);
		die('error occured during curl exec. Additioanl info: ' . var_export($info));
	}
	
	curl_close($curl);
	
	echo "<pre>";print_r($response);
	
	$_Jresponse = "";
	$_Aresponse = array();
	
	if(!empty($response)){
		
		$startString = "[JRESP]";
		$endString   = "[/JRESP]";
		
		$startPos 	 = strpos($response,$startString);
		
		if($startPos !== false){
			
			$subResponse = substr($response, $startPos+strlen($startString),strlen($response));
			
			if(!empty($subResponse)){
				
				$endPos = strpos($subResponse,$endString);
				
				if($endPos){
					$_Jresponse  = substr($subResponse,0,$endPos);
				}
			}	
		}
	}	
	
	if(!empty($_Jresponse)){
		$_Aresponse = json_decode($_Jresponse,true);
	}
	
	
	echo "<pre>";print_r($_Aresponse);exit;

?>
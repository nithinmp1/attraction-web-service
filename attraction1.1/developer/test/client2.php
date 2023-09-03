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
	
	$url		= 'http://localhost/bridges/airline/travelportNew/Service.php';
	
	$client		= new nusoap_client($url);
	
	$client->setCredentials($_AuserInfo['userName'],md5($_AuserInfo['password']));
	
	$response	= $client->call('process', array('details' => $_Ainput));
	
	echo "<pre>";print_r($response);exit;

?>
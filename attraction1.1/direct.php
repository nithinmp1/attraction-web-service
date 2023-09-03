<?php

	ini_set("display_errors",1);

	ini_set("output_buffering", "4096");
	ini_set("implicit_flush", "1");
	ini_set("memory_limit", "10000M");
	ini_set("max_execution_time", "0");
	date_default_timezone_set("Asia/Calcutta");
	set_time_limit(600);

	require_once('lib/common/include.php');	// Required include file, which have all the files which is necessary for portal
	require_once('userInfo.php');
	error_reporting(E_ALL & ~E_NOTICE);

	function GetSecurityToken($_AuserInfo)
	{
		$_Ainput 						= array();
	
		$_Ainput['action']				= 'GetSecurityToken';
		$_Ainput['mode']				= 'TEST';
		
		$_Ainput['hashKey']				= '67d706fda09dcad1f882de5691a0fb0b86af1e8f';
		
		// Optional

		return $_Ainput;
	}
	
	function GetAttractionList($_AuserInfo)
	{
		$_Ainput 						= array();
	
		$_Ainput['userName']			= $_AuserInfo['userName'];
		$_Ainput['action']				= 'GetAttractionFirstList';//'GetAttractionFirstList';
		$_Ainput['mode']				= 'TEST';
		$_Ainput['cityId']				= '';
		$_Ainput['countryId']			= '1';
	//	$_Ainput['attractionid']		= '44';
		//$_Ainput['attractionId']		= '44';

		$_Ainput['postData']			= '';
		$_Ainput['currencyCode']		= 'SGD';
		$_Ainput['referenceId']			= 'XXXXXXXX';
		
		$_Ainput['hashKey']				= getSecureHash($_AuserInfo,$_Ainput);
		
		// Optional
		
		return $_Ainput;
	}

	function GetAttractionFirstList($_AuserInfo)
	{
		$_Ainput 						= array();
	
		$_Ainput['userName']			= $_AuserInfo['userName'];
		$_Ainput['action']				= 'GetAttractionFirstList';
		$_Ainput['mode']				= 'TEST';
		$_Ainput['hashKey']				= getSecureHash($_AuserInfo,$_Ainput);
		
		// Optional
		
		return $_Ainput;
	}
	function GetAttractionFirstListDetails($_AuserInfo)
	{
		$_Ainput 						= array();
	
		$_Ainput['userName']			= $_AuserInfo['userName'];
		$_Ainput['action']				= 'GetAttractionFirstListDetails';
		$_Ainput['mode']				= 'TEST';
		$_Ainput['uuid']				= 'd5a03ea2-e06e-5d01-84b7-94530b1059f7';
		$_Ainput['hashKey']				= getSecureHash($_AuserInfo,$_Ainput);
		$_Ainput['postData']			= '';
		
		// Optional
		
		return $_Ainput;
	}
	
	function GetProductsList()
	{
		$_Ainput 						= array();
	
		$_Ainput['action']				= 'products';//'GetAttractionFirstList';
		$_Ainput['mode']				= 'TEST';
		// Optional
		
		return $_Ainput;
	} 


	function GetSingleAttraction($_AuserInfo)
	{
		$_Ainput 						= array();
	
		$_Ainput['userName']			= $_AuserInfo['userName'];
		$_Ainput['action']				= 'GetSingleAttraction';
		$_Ainput['mode']				= 'TEST';
		$_Ainput['cityId']				= '';
		//$_Ainput['countryId']			= '1';
		$_Ainput['attractionId']		= '4';
		$_Ainput['uuid']				= 'd5a03ea2-e06e-5d01-84b7-94530b1059f7';
		$_Ainput['postData']			= '';
		$_Ainput['currencyCode']		= 'SGD';
		$_Ainput['referenceId']			= 'XXXXXXXX';
		
		$_Ainput['hashKey']				= getSecureHash($_AuserInfo,$_Ainput);
		
		// Optional
		
		return $_Ainput;
	}

	
	function GetTicketType($_AuserInfo)
	{
		$_Ainput 						= array();
	
		$_Ainput['userName']			= $_AuserInfo['userName'];
		$_Ainput['action']				= 'GetTicketType';
		$_Ainput['mode']				= 'TEST';
		$_Ainput['attractionId']		= '235';
		$_Ainput['securityToken']		= 'eyJhbGciOiJIUzI1NiJ9.eyJwcmluY2lwYWwiOm51bGwsInN1YiI6InJlc2VsbGVyQGdsb2JhbHRpeC5jb20iLCJleHAiOjE0OTk5MjYwNTksImlhdCI6MTQ5OTgzOTY1OSwicm9sZXMiOlsiUkVTRUxMRVJfQURNSU4iLCJSRVNFTExFUl9GSU5BTkNFIiwiUkVTRUxMRVJfT1BFUkFUSU9OUyJdfQ.k1yFW7HI5olrTHpREnQSmWs0Gr9bFm5HpjrXiSR-3D8';
		$_Ainput['postData']			= '';
		$_Ainput['currencyCode']		= 'SGD';
		$_Ainput['referenceId']			= 0;
		
		$_Ainput['hashKey']				= getSecureHash($_AuserInfo,$_Ainput);
		
		// Optional
		
		return $_Ainput;
	}
	
	function GetTicketDetails($_AuserInfo)
	{
		$_Ainput 						= array();
	
		$_Ainput['userName']			= $_AuserInfo['userName'];
		$_Ainput['action']				= 'GetTicketDetails';
		$_Ainput['mode']				= 'TEST';
		$_Ainput['attractionId']		= '4';
		$_Ainput['ticketTypeId']		= '4858';
		$_Ainput['reSellerId']			= '';
		//$_Ainput['securityToken']		= 'eyJhbGciOiJIUzI1NiJ9.eyJwcmluY2lwYWwiOm51bGwsInN1YiI6InJlc2VsbGVyQGdsb2JhbHRpeC5jb20iLCJleHAiOjE1MDAxMTAxNTAsImlhdCI6MTUwMDAyMzc1MCwicm9sZXMiOlsiUkVTRUxMRVJfQURNSU4iLCJSRVNFTExFUl9GSU5BTkNFIiwiUkVTRUxMRVJfT1BFUkFUSU9OUyJdfQ.chX5nHcpkxDGM_veTgcMFaxe1CWl8Ek4gjr_FKNYYww';
		$_Ainput['postData']			= '';
		$_Ainput['currencyCode']		= 'SGD';
		$_Ainput['referenceId']			= 0;
		
		$_Ainput['hashKey']				= getSecureHash($_AuserInfo,$_Ainput);
		
		// Optional
		
		return $_Ainput;
	}
	
	function GetBookingDetails($_AuserInfo)
	{
		$_Ainput 						= array();
	
		$_Ainput['userName']			= $_AuserInfo['userName'];
		$_Ainput['action']				= 'GetBookingDetails';
		$_Ainput['mode']				= 'TEST';
		//$_Ainput['booking_reference']	= 'CQAFRYRJGT';
		
		//$_Ainput['securityToken']		= 'eyJhbGciOiJIUzI1NiJ9.eyJwcmluY2lwYWwiOm51bGwsInN1YiI6InJlc2VsbGVyQGdsb2JhbHRpeC5jb20iLCJleHAiOjE1MDAwOTUwMjAsImlhdCI6MTUwMDAwODYyMCwicm9sZXMiOlsiUkVTRUxMRVJfQURNSU4iLCJSRVNFTExFUl9GSU5BTkNFIiwiUkVTRUxMRVJfT1BFUkFUSU9OUyJdfQ.cTeyz0yntwN32rK40vyLl2LiF0cmGPu7rS-1-sYb6eM';
		
			$_Ainput['booking_reference']	= 'CQAFRYRJGT';
		$_Ainput['securityToken']	= 'eyJhbGciOiJIUzI1NiJ9.eyJwcmluY2lwYWwiOm51bGwsInN1YiI6InJlc2VsbGVyQGdsb2JhbHRpeC5jb20iLCJpYXQiOjE2ODQzOTg1NTUsInJvbGVzIjpbIlJFU0VMTEVSX0FETUlOIiwiUkVTRUxMRVJfRklOQU5DRSIsIlJFU0VMTEVSX09QRVJBVElPTlMiXX0.WF5wMRJR0m4hQBcrMJrA8siYMfpbhbtgOLlB5gmCFX0';  
		
		
		$_Ainput['postData']			= '';
		$_Ainput['currencyCode']		= 'SGD';
		$_Ainput['referenceId']			= 0;
		
		$_Ainput['hashKey']				= getSecureHash($_AuserInfo,$_Ainput);
		
		// Optional
		
		return $_Ainput;
	}
	function PaymentTransaction($_AuserInfo)
	{
		$_Ainput 						= array();
	
		$_Ainput['userName']			= $_AuserInfo['userName'];
		$_Ainput['action']				= 'PaymentTransaction';
		$_Ainput['mode']				= 'TEST';

		$_Ainput['reSellerId']			= '';
		//$_Ainput['securityToken']		= 'eyJhbGciOiJIUzI1NiJ9.eyJwcmluY2lwYWwiOm51bGwsInN1YiI6InJlc2VsbGVyQGdsb2JhbHRpeC5jb20iLCJleHAiOjE1MDAwMzI5MzcsImlhdCI6MTQ5OTk0NjUzNywicm9sZXMiOlsiUkVTRUxMRVJfQURNSU4iLCJSRVNFTExFUl9GSU5BTkNFIiwiUkVTRUxMRVJfT1BFUkFUSU9OUyJdfQ.t0hIuBowdlti2jTRDEz06FVpRVAaILKxtglPFWHL5EQ';

		
		$_Ainput['postData']			=  '{
											  "ticketTypes":[
																								
												{
												  "index":0,
												  "id":38,
												  "fromResellerId":null,
												  "quantity":20,
												  "sellingPrice":null,
												  "redeemStart":"2017-07-19 00:00:00",
												  "redeemEnd":null
												},
												{
												  "index":1,
												  "id":683,
												  "fromResellerId":null,
												  "quantity":20,
												  "sellingPrice":null,
												  "redeemStart":"2017-07-19 00:00:00",
												  "redeemEnd":null
												}
												
											  ],
											  "customerName":"elavarasan",
											  "email":"elavarasan@dss.com.sg",
											  "paymentMethod":"CREDIT",
											  "isInstantRedeemAll":false
											}'; 
											

		$_Ainput['currencyCode']		= 'INR';
		$_Ainput['totalAmount']			= 10;
		$_Ainput['referenceId']			= 0;
		
		$_Ainput['hashKey']				= getSecureHash($_AuserInfo,$_Ainput);
		
		// Optional
		
		return $_Ainput;
	}
	function GetTicketID($_AuserInfo)
	{
		$_Ainput 						= array();
	
		$_Ainput['userName']			= $_AuserInfo['userName'];
		$_Ainput['action']				= 'GetTicketID';
		$_Ainput['mode']				= 'TEST';
		$_Ainput['referenceNumber']		= 'CQAFRYRJGT';
		$_Ainput['qrCode']				= 'IFCBT9';
		$_Ainput['postData']			= '';
		$_Ainput['currencyCode']		= 'SGD';
		$_Ainput['referenceId']			= 0;
		
		$_Ainput['hashKey']				= getSecureHash($_AuserInfo,$_Ainput);
		
		return $_Ainput;
	}//73078
	function CancelTickets($_AuserInfo)
	{
		$_Ainput 						= array();
	
		$_Ainput['userName']			= $_AuserInfo['userName'];
		$_Ainput['action']				= 'CancelTickets';
		$_Ainput['mode']				= 'TEST';
		$_Ainput['postData']			= '{"ticket_id": "314375"}';
		$_Ainput['currencyCode']		= 'SGD';
		$_Ainput['referenceId']			= 0;
		
		$_Ainput['hashKey']				= getSecureHash($_AuserInfo,$_Ainput);
		
		return $_Ainput;
	}
	
	function getVouchers($_AuserInfo)
	{
		$_Ainput 						= array();
		$_Ainput['userName']			= $_AuserInfo['userName'];
		$_Ainput['action']				= 'GetVouchers';
		$_Ainput['mode']				= 'TEST';
		$_Ainput['bookingReference']	= 'CQAFRYRJGT';
		//$_Ainput['securityToken']	= 'eyJhbGciOiJIUzI1NiJ9.eyJwcmluY2lwYWwiOm51bGwsInN1YiI6InJlc2VsbGVyQGdsb2JhbHRpeC5jb20iLCJpYXQiOjE2ODQzOTg1NTUsInJvbGVzIjpbIlJFU0VMTEVSX0FETUlOIiwiUkVTRUxMRVJfRklOQU5DRSIsIlJFU0VMTEVSX09QRVJBVElPTlMiXX0.WF5wMRJR0m4hQBcrMJrA8siYMfpbhbtgOLlB5gmCFX0';
		$_Ainput['referenceId']			= 0;
		$_Ainput['hashKey']				= getSecureHash($_AuserInfo,$_Ainput);
		return $_Ainput;
	}
	
	function GetAdminDisabledAttractions($_AuserInfo){
		
		$_Ainput 						= array();
		$_Ainput['userName']			= $_AuserInfo['userName'];
		$_Ainput['action']				= 'GetAdminDisabledAttractions';
		$_Ainput['mode']				= 'TEST';
		$_Ainput['supplierId']			= '';				//India
		$_Ainput['branchId']			= '';				//India
		$_Ainput['referenceId']			= 0;
		$_Ainput['hashKey']				= getSecureHash($_AuserInfo,$_Ainput);
		return $_Ainput;
	}
	
	/*function process(){
		$_Ainput	= GetProductsList(); 
		// $_AuserInfo	= GetSecurityToken($_AuserInfo);
		$_Ocontroller	= Controller::singleton();
		$_Aoutput		= $_Ocontroller->process($_Ainput);

		// echo "<pre>";print_r($_Ocontroller);die;
	}
*/
	function process() 
	{
		$_AuserInfo	= getUserInfo();
		// $_Ainput	= GetSecurityToken($_AuserInfo);
		// $_Ainput	= GetAttractionFirstList($_AuserInfo);  
		// $_Ainput	= GetAttractionFirstListDetails($_AuserInfo); 
		// $_Ainput	= GetProductsList($_AuserInfo); 
		$_Ainput	= GetSingleAttraction($_AuserInfo); 
		// print_r($_Ainput);die;
		// $_Ainput	= GetTicketType($_AuserInfo);
		//$_Ainput	= GetTicketDetails($_AuserInfo);
		//$_Ainput	= PaymentTransaction($_AuserInfo);
		///$_Ainput	= GetBookingDetails($_AuserInfo);
		//$_Ainput	= GetTicketID($_AuserInfo);
		//$_Ainput	= CancelTickets($_AuserInfo);
		//$_Ainput	= getVouchers($_AuserInfo);
		//$_Ainput	= GetAdminDisabledAttractions($_AuserInfo);
		
		 $_SERVER["PHP_AUTH_PW"] = md5($_AuserInfo['password']); 
		
		$_Ocontroller	= Controller::singleton();
		$_Aoutput		= $_Ocontroller->process($_Ainput);
		//var_dump($_Aoutput);die;
		
		echo "<pre>";
		print_r($_Ainput);
		print_r(($_Aoutput));die;
		//print_r(($_Aoutput));die;
		//echo json_encode($_Aoutput);exit;
	}
	
	 process();
    //test();
function test(){
	$curl = curl_init();
	$baseUrl ='https://api.demo.bemyguest.com.sg/v2/';

	/*****
	*** enable action which one needed
	*****/

	// $action = 'products';
	 $action = 'products/d5a03ea2-e06e-5d01-84b7-94530b1059f7';
	// $action = 'products/d5a03ea2-e06e-5d01-84b7-94530b1059f7/product-types';
	// $action = 'product-types/efedb1fc-f150-5eaa-bf6e-fc202f6114bd/price-lists';
	// $action = 'product-types/efedb1fc-f150-5eaa-bf6e-fc202f6114bd/price-lists/2023-08-23';
	// $action = 'config';
	// $action = 'bookings';
	// $action = 'bookings/204153bc-2d99-4691-91aa-1d981050d0cc/confirm';$putFlag = true;
	// $action = 'bookings/204153bc-2d99-4691-91aa-1d981050d0cc/cancel';$putFlag = true;
	// $action = 'bookings/204153bc-2d99-4691-91aa-1d981050d0cc/vouchers';
	// $action = 'bookings/204153bc-2d99-4691-91aa-1d981050d0cc/download-voucher/b93399a4-7c3d-4a9c-aa49-1d25c6c93e99';
	
	$method = 'GET';
	if ($action == 'bookings') {
		$method = 'POST';
		$input = [
			'message' => "",
			'productTypeUuid' => "efedb1fc-f150-5eaa-bf6e-fc202f6114bd",
			"customer" => [
				"salutation" => "Mr.",
				"lastName" => "Doe",
				"firstName" => "John",
				"email" => "john@sample.com",
				"phone" => "222333111",
			],
			"adults" => 1,
			"children" => 1,
			"seniors" => 0,
			"timeSlotUuid" => null, 
			"arrivalDate" => "2024-01-25", 
			"partnerReference" => null, 
		];
	}
	if(isset($putFlag) && $putFlag){
		$method = 'PUT';
	}

	$actionUrl = $baseUrl.$action;

	$options = [
		  CURLOPT_URL => $baseUrl.$action,
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => '',
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 0,
		  CURLOPT_CUSTOMREQUEST => $method,
		  CURLOPT_SSL_VERIFYPEER => false,
		  CURLOPT_HTTPHEADER => array(
		    'X-Authorization: 67d706fda09dcad1f882de5691a0fb0b86af1e8f',
		    'Content-Type: application/json',
		    'Accept: application/json'
		  )
	];

	if ($method == 'POST') {
		$options[CURLOPT_POSTFIELDS] = json_encode($input);
	}
	curl_setopt_array($curl, $options);

	$response = curl_exec($curl);
	if(isset($response) && $action == 'products/d5a03ea2-e06e-5d01-84b7-94530b1059f7') {
		$_output = [];
		$response = json_decode($response, true);
		foreach ($response as $key => $res) {
			# code...
			if($key != 'data'){
				continue;
			}
			$_output[] = [
				'id' => $res['uuid'],
				'title' => $res['title'],
	            'description' => $res['description'],
	            'hoursOfOperation' => [
	            	'start' => $res['businessHoursFrom'],
	            	'end' => $res['businessHoursTo']
	            	],
	            'images' => $res['photos'],
				];
		}
		$response = $_output;
	}
		$_finalOut = [
			'status' => 'Success',
			'Msg' => $action,
			'responseData' => $response
		];

	$error_msg = '';
	if (curl_errno($curl)) {
	    $error_msg = curl_error($curl);
	}

	curl_close($curl);
	echo "<pre>";
	print_r($_finalOut);
}
?>
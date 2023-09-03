<?php
$_Ainput = [
	'name' => 'test'
	];
$postData	= json_encode($_Ainput);
	
	
$url		= 'http://localhost/attraction1.1/views/GetAttractionFirstListXml.php';
$curl	  	= curl_init();

	curl_setopt($curl, CURLOPT_URL, $url);
	
	curl_setopt($curl, CURLOPT_TIMEOUT, 180);
	
	curl_setopt($curl, CURLOPT_HEADER, 0);
	
	curl_setopt($curl, CURLOPT_POST, 1);
	
	curl_setopt($curl, CURLOPT_POSTFIELDS, $postData); 

	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); 
	
	curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);
	
	curl_setopt($curl, CURLOPT_SSL_CIPHER_LIST, 'TLSv1');

	
	$httpHeader2 = [];
	
	curl_setopt($curl, CURLOPT_HTTPHEADER, $httpHeader2);
	
	curl_setopt ($curl, CURLOPT_ENCODING, "gzip, deflate");
	
	$response = curl_exec($curl);
	var_dump($response);die('here');
	if ($response === false) {
		$info = curl_getinfo($curl);
		curl_close($curl);
		die('error occured during curl exec. Additioanl info: ' . var_export($info));
	}
	
	curl_close($curl);
	
	echo "<pre>";print_r($response);
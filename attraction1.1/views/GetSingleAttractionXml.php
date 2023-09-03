<?php

function GetSingleAttractionXml($req)
{
	//https://sg-api.globaltix.com/api/attraction/get?id=<attraction_id>&rtf=false
	
	$_Ainput = $req->_Ainput;
	
	if($_Ainput['cityId']==''){
		$_Ainput['cityId']=1;  
	}
	if($_Ainput['userName'] !='Zaraholidays'){
		$xml='attraction/get?id='.$_Ainput['attractionId']."&rtf=false";// to get default all 

	}else{
		$xml='attraction/get?id='.$_Ainput['attractionId']."&rtf=false";  
	}
	
	$xml='/products/'.$_Ainput['uuid'].'/product-types';
//$xml='attraction/list?cityId='.$_Ainput['cityId'].'&countryId='.$_Ainput['countryId'].'&tab=Attractions';
	//$xml='attraction/list?cityId='.$_Ainput['cityId'].'&countryId='.$_Ainput['countryId'].'&tab=All';
	
	return $xml;
}
?>
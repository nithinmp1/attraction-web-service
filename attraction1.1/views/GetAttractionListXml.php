<?php

function GetAttractionListXml($req)
{
	
	
	$_Ainput = $req->_Ainput;
	
	if($_Ainput['cityId']==''){
		$_Ainput['cityId']=1;  
	}
	if($_Ainput['userName'] !='Zaraholidays'){
		$xml='attraction/list?cityId='.$_Ainput['cityId'].'&countryId='.$_Ainput['countryId'].'&categoryId=2';// to get default all 

	}else{
		$xml='attraction/list?cityId='.$_Ainput['cityId'].'&countryId='.$_Ainput['countryId'].'&categoryId=2'; 
	}
	//$xml='attraction/list?cityId='.$_Ainput['cityId'].'&countryId='.$_Ainput['countryId'].'&tab=Attractions';
	//$xml='attraction/list?cityId='.$_Ainput['cityId'].'&countryId='.$_Ainput['countryId'].'&tab=All';
	
	return $xml;
}
?>
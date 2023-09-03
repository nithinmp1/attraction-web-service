<?php

function GetAttractionInfoListXml($req) 
{
	
	
	$_Ainput = $req->_Ainput;
	

	if($_Ainput['userName'] !='Zaraholidays'){
		$xml='product/info?id='.$_Ainput['attractionId'];

	}else{
		$xml='product/info?id='.$_Ainput['attractionId'];
	}
	
	
	return $xml;
}
?>
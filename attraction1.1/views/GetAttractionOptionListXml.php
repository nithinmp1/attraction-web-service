<?php

function GetAttractionOptionListXml($req) 
{
	
	
	$_Ainput = $req->_Ainput;
	

	if($_Ainput['userName'] !='Zaraholidays'){
		$xml='product/options?id='.$_Ainput['attractionId'];

	}else{
		$xml='product/options?id='.$_Ainput['attractionId'];
	}
	
	
	return $xml;
}
?>
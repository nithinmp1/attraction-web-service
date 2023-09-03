<?php

function GetAttractionFirstListDetailsXml($req)
{
	$_Ainput = $req->_Ainput;

	if($_Ainput['userName'] !='Zaraholidays'){
		
		$xml='/products/'.$_Ainput['uuid']; 
		
		
		

	}else{
		
		$xml='/products/'.$_Ainput['uuid']; 
		
	}

	
	return $xml;
}



?>
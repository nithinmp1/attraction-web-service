<?php

function GetDisabledAttractions($req)
{
	$_Ainput = $req->_Ainput;
	$xml='?reference_number='.$_Ainput['bookingReference'];

	return $xml;
}
?>
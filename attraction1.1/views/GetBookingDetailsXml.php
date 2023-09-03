<?php

function GetBookingDetailsXml($req)
{
	$_Ainput = $req->_Ainput;

	$xml='transaction/getTransactionDetailsByReferenceNumber?reference_number='.$_Ainput['booking_reference'];

	return $xml;
}
?>
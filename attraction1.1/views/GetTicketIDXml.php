<?php

function GetTicketIDXml($req)
{
	$_Ainput = $req->_Ainput;
	$xml='transaction/getTransactionDetailsByReferenceNumberAndQRCode?qrcode='.$_Ainput['qrCode'].'&reference_number='.$_Ainput['referenceNumber'];

	return $xml;
}
?>
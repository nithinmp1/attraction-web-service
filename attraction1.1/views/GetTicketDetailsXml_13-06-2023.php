<?php

function GetTicketDetailsXml($req)
{
	$_Ainput = $req->_Ainput;

	$xml='ticketType/get?id='.$_Ainput['ticketTypeId'].'&fromResellerId='.$_Ainput['reSellerId'];

	return $xml;
}
?>
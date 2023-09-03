<?php

function GetTicketTypeXml($req)
{
	$_Ainput = $req->_Ainput;

	$xml='ticketType/list?attraction_id='.$_Ainput['attractionId'];

	return $xml;
}
?>
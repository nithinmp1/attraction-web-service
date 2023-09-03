<?php
/**
	@File Name 		:	conf.api.php
	@Author 		:	Elavarasan P 
	@Created Date	:	2017-07-10
	@Description	:	Declaring all web service api settings.
*/

	$CONF['api']['url']  = array
							(
								'TEST' => array
											(
												'attractionURL'	=> 'https://api.demo.bemyguest.com.sg/v2',
												'getVouchersURL'	=> 'https://uat-api.globaltix.com/api/transaction/generateTransactionPdf',
											),
								'LIVE' => array
											(
												'attractionURL'	=> 'https://sg-api.globaltix.com/api/',
												'getVouchersURL'	=> 'https://sg-api.globaltix.com/api/transaction/generateTransactionPdf',
											),
							);
							
	$CONF['api']['credentials'] = array
							(
								'TEST'	=> array
								(
									'userName'		=> 'reseller@globaltix.com',
									'password'		=> '12345',
									'token'			=> '67d706fda09dcad1f882de5691a0fb0b86af1e8f'
								//	https://uat-partner.globaltix.com/#/products

								),
								'LIVE'	=> array
								(
									'userName'  => 'easwar@gobudgetair.com__',
									'password'  => '$nugds@gba',
								),
								
								//https://partner.globaltix.com/#/products
								
							);
	
	$CONF['api']['payments']= array
							(
								'TEST' => array
												(
													"agentName" => "Elavarsan Test",
													"agentEmail" => "elavarasan@dss.com.sg"
												),
								'LIVE' => array
												(
													"agentName" => "Easwar Live",
													"agentEmail" => "live_@dss.com.sg"
												)
							);							
				
	$CONF['api']['actions'] = array
								(
									'GetAttractionFirstList' => array
									(
										'className'  	=> 'GetAttractionFirstList',
										'headerTpl' 	=> 'headerXml.php',
										'bodyTpl' 		=> 'GetAttractionFirstListXml.php',      
									),

									'GetAttractionFirstListDetails' => array
									(
										'className'  	=> 'GetAttractionFirstListDetails',
										'headerTpl' 	=> 'headerXml.php',
										'bodyTpl' 		=> 'GetAttractionFirstListDetailsXml.php',      
									),
									
									'GetAttractionOptionList' => array
									(
										'className'  	=> 'GetAttractionOptionList',
										'headerTpl' 	=> 'headerXml.php',
										'bodyTpl' 		=> 'GetAttractionOptionListXml.php',   
									),
									'GetAttractionInfoList' => array
									(
										'className'  	=> 'GetAttractionInfoList',
										'headerTpl' 	=> 'headerXml.php',
										'bodyTpl' 		=> 'GetAttractionInfoListXml.php',   
									),
									'GetSingleAttraction' => array
									(
										'className'  	=> 'GetSingleAttraction',
										'headerTpl' 	=> 'headerXml.php',
										'bodyTpl' 		=> 'GetSingleAttractionXml.php',      
									),
									'GetAttractionList' => array
									(
										'className'  	=> 'GetAttractionList',
										'headerTpl' 	=> 'headerXml.php',
										'bodyTpl' 		=> 'GetAttractionListXml.php',
									),
									'GetSecurityToken' => array
									(
										'className'  	=> 'GetSecurityToken',
										'headerTpl' 	=> 'headerXml.php',
										'bodyTpl' 		=> 'GetSecurityTokenXml.php',
									),
									'GetTicketType' => array
									(
										'className'  	=> 'GetTicketType',
										'headerTpl' 	=> 'headerXml.php',
										'bodyTpl' 		=> 'GetTicketTypeXml.php',
									),
									'GetTicketDetails' => array
									(
										'className'  	=> 'GetTicketDetails',
										'headerTpl' 	=> 'headerXml.php',
										'bodyTpl' 		=> 'GetTicketDetailsXml.php',
									),
									'PaymentTransaction' => array
									(
										'className'  	=> 'PaymentTransaction',
										'headerTpl' 	=> 'headerXml.php',
										'bodyTpl' 		=> 'PaymentTransactionXml.php',
									),
									'GetBookingDetails' => array
									(
										'className'  	=> 'GetBookingDetails',
										'headerTpl' 	=> 'headerXml.php',
										'bodyTpl' 		=> 'GetBookingDetailsXml.php',
									),
									'GetTicketID' => array
									(
										'className'  	=> 'GetTicketID',
										'headerTpl' 	=> 'headerXml.php',
										'bodyTpl' 		=> 'GetTicketIDXml.php',
									),
									'CancelTickets' => array
									(
										'className'  	=> 'CancelTickets',
										'headerTpl' 	=> 'headerXml.php',
										'bodyTpl' 		=> 'CancelTicketsXml.php',
									),
									'GetVouchers' => array
									(
										'className'  	=> 'GetVouchers',
										'headerTpl' 	=> 'headerXml.php',
										'bodyTpl' 		=> 'GetVouchersXml.php',
									),
									'GetAdminDisabledAttractions' => array
									(
										'className'  	=> 'GetAdminDisabledAttractions',
										'headerTpl' 	=> 'headerXml.php',
										'bodyTpl' 		=> 'GetDisabledAttractions.php',
									),
									

								);
								
	
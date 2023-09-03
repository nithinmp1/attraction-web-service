<?php
/**
	@File Name 		:	conf.api.php
	@Author 		:	Ramanathan M <ramanathan@dss.com.sg>
	@Created Date	:	2015-12-21 10:55 AM
	@Description	:	Declaring all web service api settings.
*/

	$CONF['api']['url']  = array
							(
								'TEST' => array
											(
												'airService'				=> 'https://apac.universal-api.pp.travelport.com/B2BGateway/connect/uAPI/AirService',
												'universalRecordService'	=> 'https://apac.universal-api.pp.travelport.com/B2BGateway/connect/uAPI/UniversalRecordService',
												'queuePlace'				=> 'https://apac.universal-api.pp.travelport.com/B2BGateway/connect/uAPI/GdsQueueService',
												
												'issueTicket'				=> 'http://218.188.88.88/AIR_WS_TKT/ws/AirService?wsdl',
											),
								'LIVE' => array
											(
												'airService'				=> 'https://apac.universal-api.travelport.com/B2BGateway/connect/uAPI/AirService',
												'universalRecordService'	=> 'https://apac.universal-api.travelport.com/B2BGateway/connect/uAPI/UniversalRecordService',
												'queuePlace'				=> 'https://apac.universal-api.travelport.com/B2BGateway/connect/uAPI/GdsQueueService',
												'issueTicket'				=> 'http://218.188.88.88:8083/AIR_WS_TKT/ws/AirService?wsdl',
											),
							);
							
	$CONF['api']['credentials'] = array
							(
								'TEST'	=> array
								(
									'userName'					=> 'Universal API/uAPI3089026605-ee9b355b',
									'password'					=> '7Fz{}j5Kn9',
									'travelMediaTargetBranch'	=> 'P7025462',
									'travelMediaPCC'			=> 'P7025462',
									'goBudgetAirTargetBranch'	=> 'P7025462',
									'goBudgetAirPCC'			=> 'P7025462',
									'queuePCC'					=> 'P7025462',
									'application'				=> 'uAPI',
									'AuthorizedBy'				=> 'GoBudgetair',
									'AgencyType'				=> 'Agency',
									'AgencyLocation'			=> 'SIN',
									'AgencyNumber'				=> '62247500',
									'AgencyText'				=> 'GoBudgetAir.com PTE LTD',
									'AreaCode'					=> '65',
									'LocationCode'				=> 'SIN',

<<<<<<< .mine
							),
							'LIVE'	=> array
							(
								'userName'					=> 'Universal API/uAPI2067147470-862cd8f3',
								'password'					=> 'aZ%69eB/}L',
								'travelMediaTargetBranch'	=> 'P2884620',
								'travelMediaPCC'			=> '8Z5H',
								'goBudgetAirTargetBranch'	=> 'P2835393',
								'goBudgetAirPCC'			=> '54KJ',
								'queuePCC'					=> '3BC0',
								'application'				=> 'uAPI',
								'AuthorizedBy'				=> 'GoBudgetair',
								'AgencyType'				=> 'Agency',
								'AgencyLocation'			=> 'SIN',
								'AgencyNumber'				=> '62247500',
								'AgencyText'				=> 'GoBudgetAir.com PTE LTD',
								'AreaCode'					=> '65',
								'LocationCode'				=> 'SIN',
							),
						),
						'payments' => array
						(
							'TEST' => array
							(
								'TR' => array
||||||| .r1367
							),
							'LIVE'	=> array
							(
								'userName'					=> 'Universal API/uAPI2067147470-862cd8f3',
								'password'					=> 'aZ%69eB/}L',
								'travelMediaTargetBranch'	=> 'P2884620___',
								'travelMediaPCC'			=> '8Z5H',
								'goBudgetAirTargetBranch'	=> 'P2835393___',
								'goBudgetAirPCC'			=> '54KJ',
								'queuePCC'					=> '3BC0',
								'application'				=> 'uAPI',
								'AuthorizedBy'				=> 'GoBudgetair',
								'AgencyType'				=> 'Agency',
								'AgencyLocation'			=> 'SIN',
								'AgencyNumber'				=> '62247500',
								'AgencyText'				=> 'GoBudgetAir.com PTE LTD',
								'AreaCode'					=> '65',
								'LocationCode'				=> 'SIN',
							),
						),
						'payments' => array
						(
							'TEST' => array
							(
								'TR' => array
=======
								),
								'LIVE'	=> array
>>>>>>> .r1470
								(
									'userName'					=> 'Universal API/uAPI2067147470-862cd8f3',
									'password'					=> 'aZ%69eB/}L',
									'travelMediaTargetBranch'	=> 'P2884620___',
									'travelMediaPCC'			=> '8Z5H',
									'goBudgetAirTargetBranch'	=> 'P2835393___',
									'goBudgetAirPCC'			=> '54KJ',
									'queuePCC'					=> '3BC0',
									'application'				=> 'uAPI',
									'AuthorizedBy'				=> 'GoBudgetair',
									'AgencyType'				=> 'Agency',
									'AgencyLocation'			=> 'SIN',
									'AgencyNumber'				=> '62247500',
									'AgencyText'				=> 'GoBudgetAir.com PTE LTD',
									'AreaCode'					=> '65',
									'LocationCode'				=> 'SIN',
								),
							);
	
	$CONF['api']['payments']= array
							(
								'TEST' => array
								(
									'TR' => array
									(
										'agencyId'	=> 'TETR123',
										'agencyPwd'	=> 'TETR123',
									),
									
								),
								'LIVE' => array
								(
									'TR' => array
									(
										'agencyId'	=> 'TASGAE5_',
										'agencyPwd'	=> 'Dss@2016#_',
									),
									'6E' => array
									(
										'agencyId'	=> 'TEST_6E',
										'agencyPwd'	=> 'Dss@TEST_6E',
									),
								),
							);
							
				
	$CONF['api']['actions'] = array
								(
									'LowFareSearchReq' => array
									(
										'className'  	=> 'LowFareSearchReq',
										'headerTpl' 	=> 'headerXml.tpl',
										'bodyTpl' 		=> 'LowFareSearchReqXml.tpl',
									),
									'AirPriceReq' => array
									(
										'className'  	=> 'AirPriceReq',
										'headerTpl' 	=> 'headerXml.tpl',
										'bodyTpl' 		=> 'AirPriceReqXml.tpl',
									),
									'SeatMapReq' => array
									(
										'className'  	=> 'SeatMapReq',
										'headerTpl' 	=> 'headerXml.tpl',
										'bodyTpl' 		=> 'SeatMapReqXml.tpl',
									),
									'AirCreateReservationReq' => array
									(
										'className'  	=> 'AirCreateReservationReq',
										'headerTpl' 	=> 'headerXml.tpl',
										'bodyTpl' 		=> 'AirCreateReservationReqXml.tpl',
									),
									'CancelPnrReq' => array
									(
										'className'  	=> 'CancelPnrReq',
										'headerTpl' 	=> 'headerEmptyXml.tpl',
										'bodyTpl' 		=> 'CancelPnrReqXml.tpl',
									),
									'RetrievePnrReq' => array
									(
										'className'  	=> 'RetrievePnrReq',
										'headerTpl' 	=> 'headerXml.tpl',
										'bodyTpl' 		=> 'RetrievePnrReqXml.tpl',
									),
									'AirPriceSellssrReq' => array
									(
										'className'  	=> 'AirPriceSellssrReq',
										'headerTpl' 	=> 'headerXml.tpl',
										'bodyTpl' 		=> 'AirPriceSellssrReqXml.tpl',
									),
									'AirFareRulesReq' => array
									(
										'className'  	=> 'AirFareRulesReq',
										'headerTpl' 	=> 'headerXml.tpl',
										'bodyTpl' 		=> 'AirFareRulesReqXml.tpl',
									),
									'AirTicketingReq' => array
									(
										'className'  	=> 'AirTicketingReq',
										'headerTpl' 	=> 'headerXml.tpl',
										'bodyTpl' 		=> 'AirTicketingReqXml.tpl',
									),
									'AirRetrieveDocumentReq' => array
									(
										'className'  	=> 'AirRetrieveDocumentReq',
										'headerTpl' 	=> 'headerXml.tpl',
										'bodyTpl' 		=> 'AirRetrieveDocumentReqXml.tpl',
									),
									'GdsQueuePlaceReq' => array
									(
										'className'  	=> 'GdsQueuePlaceReq',
										'headerTpl' 	=> 'headerXml.tpl',
										'bodyTpl' 		=> 'GdsQueuePlaceReqXml.tpl',
									),
									'UniversalRecordModifyReq' => array
									(
										'className'  	=> 'UniversalRecordModifyReq',
										'headerTpl' 	=> 'headerXml.tpl',
										'bodyTpl' 		=> 'UniversalRecordModifyReqXml.tpl',
									),
									'AirRePriceReq' => array
									(
										'className'  	=> 'AirRePriceReq',
										'headerTpl' 	=> 'headerXml.tpl',
										'bodyTpl' 		=> 'AirRePriceReqXml.tpl',
									),
									'UniversalRecordAddPrice' => array
									(
										'className'  	=> 'UniversalRecordAddPrice',
										'headerTpl' 	=> 'headerXml.tpl',
										'bodyTpl' 		=> 'UniversalRecordAddPriceXml.tpl',
									),
									'IssueTicket' => array
									(
										'className'  	=> 'IssueTicket',
										'headerTpl' 	=> 'headerEmptyXml.tpl',
										'bodyTpl' 		=> 'issueTicketXml.tpl',
									),
									'voidTicket' => array
									(
										'className'  	=> 'voidTicket',
										'headerTpl' 	=> 'headerEmptyXml.tpl',
										'bodyTpl' 		=> 'voidTicketXml.tpl',
									),
									'getTicketStatus' => array
									(
										'className'  	=> 'getTicketStatus',
										'headerTpl' 	=> 'headerEmptyXml.tpl',
										'bodyTpl' 		=> 'getTicketStatusXml.tpl',
									),
									
									

								);
								
	$CONF['api']['fareType'] = array
								(
									'6E' => array
											(
												'FareTypes'  => array
												(
													'Regular Fare' => array
													(
														'0' => 'IndiGo offers 15 kgs / 20 kgs (Domestic/International) Bangkok and Kathmandu & 30 kgs (Doha, Dubai, Muscat, Sharjah & Singapore) checked baggage allowance. Pre-book for a hassle-free travel up to 6 hours prior to your flight and save more',
														'1' => '7 kgs Hand Baggage (one piece only)',
														'2' => ' Refer to Conditions of Carriage for change/cancellation fee and detailed T&Cs',
													),
													'Flexible Fare' => array
													(
														'0' => 'No change fee',
														'1' => 'Complimentary Seat',
														'2' => 'IndiGo offers 15 kgs / 20 kgs (Domestic/International) Bangkok and Kathmandu & 30 kgs (Doha, Dubai, Muscat, Sharjah & Singapore) checked baggage allowance. Pre-book for a hassle-free travel up to 6 hours prior to your flight and save more.',
														'3' => '7 kgs Hand Baggage (one piece only)',
														'4' => 'Not available on connecting flights',
														'5' => 'Refer to Conditions of Carriage for applicable Cancellation Fee and detailed T&Cs',
														'6' => '6E upgrade is not available',
													),
													'Lite Fare' => array
													(
														'0' => 'No Checked Baggage Allowance',
														'1' => '7 kgs Hand Baggage (one piece only)',
														'2' => 'Not available for international flights',
														'3' => 'Refer to Conditions of Carriage for change/cancellation fee and detailed T&Cs',
														'4' => 'Light fare will be applicable only for bookings beyond 15 days from booking date',
														'5' => '6E upgrade is not available',
													),
												),
											)
								);
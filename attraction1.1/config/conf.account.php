<?php
/**
	@File Name 		:	conf.account.php
	@Author 		:	Ramanathan M <ramanathan@dss.com.sg>
	@Created Date	:	2015-12-21 10:55 AM
	@Description	:	Allowed account details.
*/

	$CONF['account']['users'] =	array
								(
									'GBAB2C' => array
									(
										'status'			=> 'ACTIVE',
										'password'			=> 'b2c@2win!',
										'salt'				=> 'b2c@gba!2win',
										'hashSettings'		=> array
																(
																	'validateSecureHash'=> 'Y',
																	'hashFormat'		=> 'userName|action|mode|ADT|CHD|INF|currencyCode|pnr|sectorInfo|salt',
																	'hashSeparator'		=> '|',
																	'encryptionType'	=> 'MD5',
																),
										'ipPatching'		=> 'Y',
										'allowedIps'		=> array
																(
																	'127.0.0.1',
																	'::1',
																),
										'forceConfigMode'	=> 'Y',
										'mode'				=> 'TEST', 
										'logFolder'			=> 'gbab2c', // Create a log folder in var/log
										'credentials'		=> array
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
										'payments'			=> array
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
																							'agencyId'	=> 'FSG0441_____',
																							'agencyPwd'	=> 'Dss@2017_____',
																						),
																			),
																),
									),
									'GBAB2B1' => array
									(
										'status'			=> 'ACTIVE',
										'password'			=> 'b2b@2win!',
										'salt'				=> 'b2b@gba!2win',
										'hashSettings'		=> array
																(
																	'validateSecureHash'=> 'Y',
																	'hashFormat'		=> 'userName|action|mode|ADT|CHD|INF|currencyCode|pnr|sectorInfo|salt',
																	'hashSeparator'		=> '|',
																	'encryptionType'	=> 'MD5',
																),
										'ipPatching'		=> 'Y',
										'allowedIps'		=> array
																(
																	'127.0.0.1',
																	'::1',
																),
										'forceConfigMode'	=> 'Y',
										'mode'				=> 'TEST',
										'logFolder'			=> 'gbab2b', // Create a log folder in var/log
										'credentials'		=> array
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

																				),
																	'LIVE'	=> array
																				(
																					'userName'					=> 'Universal API/uAPI2067147470-862cd8f3',
																					'password'					=> 'aZ%69eB/}L______',
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
										'payments'			=> array
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
																			),
																),
									),
									'GBAB2C_hkg' => array
									(
										'status'			=> 'ACTIVE',
										'password'			=> 'b2c@2win!',
										'salt'				=> 'b2c@gba!2win',
										'hashSettings'		=> array
																(
																	'validateSecureHash'=> 'Y',
																	'hashFormat'		=> 'userName|action|mode|ADT|CHD|INF|currencyCode|pnr|sectorInfo|salt',
																	'hashSeparator'		=> '|',
																	'encryptionType'	=> 'MD5',
																),
										'ipPatching'		=> 'Y',
										'allowedIps'		=> array
																(
																	'127.0.0.1',
																	'::1',
																),
										'forceConfigMode'	=> 'Y',
										'mode'				=> 'TEST', 
										'logFolder'			=> 'gbab2c', // This is for London server HKG
										'credentials'		=> array
																(
																	'TEST'	=> array
																				(
																					'userName'					=> 'Universal API/uAPI7203731846-2475cf8c__',
																					'password'					=> 'Zk7}8P*yD$__',
																					'travelMediaTargetBranch'	=> 'P2858133',
																					'travelMediaPCC'			=> '',
																					'goBudgetAirTargetBranch'	=> 'P2660010',
																					'goBudgetAirPCC'			=> '',
																					'queuePCC'					=> '',
																					'application'				=> 'uAPI',
																					'AuthorizedBy'				=> 'GoBudgetair',
																					'AgencyType'				=> 'Agency',
																					'AgencyLocation'			=> 'SIN',
																					'AgencyNumber'				=> '62247500',
																					'AgencyText'				=> 'GoBudgetAir.com PTE LTD',
																					'AreaCode'					=> '65',
																					'LocationCode'				=> 'SIN',

																				),
																	'LIVE'	=> array
																				(
																					'userName'					=> 'Universal API/uAPI7203731846-2475cf8c',
																					'password'					=> 'Zk7}8P*yD$',
																					'travelMediaTargetBranch'	=> 'P2858133',
																					'travelMediaPCC'			=> '63BK',
																					'goBudgetAirTargetBranch'	=> 'P2660010',
																					'goBudgetAirPCC'			=> '65Z2',
																					'queuePCC'					=> 'QKS',
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
										'payments'			=> array
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
																			),
																),
									),
								);
?>
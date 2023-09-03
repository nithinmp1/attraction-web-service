<?php
/**
	@File Name 		:	Controller.php
	@Author 		:	Ramanathan M <ramanathan@dss.com.sg>
	@Created Date	:	2015-12-21 10:55 AM
	@Description	:	Controller will execute requested actions and return the data
*/
class Controller 
{
	var $_Ainput;
	var $_Aoutput;
	
	function __construct()
	{
		$this->_Ainput	= array();
		$this->_Aoutput	= array();
	}
	
	public static function &singleton()
    {
        static $instance;

        // If the instance is not there, create one
        if (!isset($instance)) {
            $class = __CLASS__;
            $instance = new $class();
        }
        return $instance;
    }
	
    public function process($_AgivenInput)
    {
		$_Sstatus		= 'FAILURE';
		$_Smessage		= '';
		$_Adata			= array();
		
		$this->_Ainput	= $_AgivenInput;
		$_SuserIp		= $_SERVER['REMOTE_ADDR'];
		
		$_SuserName 	= (isset($this->_Ainput['userName']) && !empty($this->_Ainput['userName'])) ? $this->_Ainput['userName'] : 'NOTAVBL';
		$_Saction 		= (isset($this->_Ainput['action']) && !empty($this->_Ainput['action'])) ? $this->_Ainput['action'] : 'NOTAVBL';
		$_Smode			= (isset($this->_Ainput['mode']) && !empty($this->_Ainput['mode'])) ? $this->_Ainput['mode'] : 'NOTAVBL';
		
		$this->_Ainput['userName']	= $_SuserName;
		$this->_Ainput['action']	= $_Saction;
		$this->_Ainput['mode']		= $_Smode;
		
		$GLOBALS['CONF']['site']['userIp'] = $_SuserIp;
		
		if(!empty($this->_Ainput)){
			
			if(!empty($_SuserName)){
				
				$this->_Odb	= DBConnect::singleton();
												
				$GLOBALS['CONF']['account']['users'] = $this->_getConfigData($_AgivenInput);
				
				if(isset($GLOBALS['CONF']['account']['users'][$_SuserName])){
					
					$_AuserInfo = $GLOBALS['CONF']['account']['users'][$_SuserName];
					
					$_SauthPwd  = isset($_SERVER["PHP_AUTH_PW"]) ? $_SERVER["PHP_AUTH_PW"] : '';
					
					if($_AuserInfo['status'] == "ACTIVE"){
						
						if($_SauthPwd == md5($_AuserInfo['password'])){
							
							$ipValidation = true;
							
							if($_AuserInfo['ipPatching'] == "Y" && !in_array($_SuserIp,$_AuserInfo['allowedIps'])){
								$ipValidation = false;
							}
							//echo $ipValidation;
							if($ipValidation){
								
								if(isset($GLOBALS['CONF']['api']['actions'][$_Saction]) && !empty($GLOBALS['CONF']['api']['actions'][$_Saction])){
									
									$_AactionInfo = $GLOBALS['CONF']['api']['actions'][$_Saction];
									
									//$_Smode = (isset($this->_Ainput['mode']) && !empty($this->_Ainput['mode'])) ? $this->_Ainput['mode'] : $_AuserInfo['mode'];
						
									$_Smode = strtoupper($_Smode);
									
									if(in_array($_Smode,array('TEST','LIVE'))){
										
										if($_AuserInfo['forceConfigMode'] == "Y"){
											$_Smode = $_AuserInfo['mode'];
										}
										
										$this->_Ainput['mode'] = $_Smode;
										
										$validateRequestDate = true;
										
										if(isset($this->_Ainput['requestDate']) && !empty($this->_Ainput['requestDate'])){
											$validateRequestDate = true;
										}											
										
										if($validateRequestDate){
											
											if(!isset($this->_Ainput['traceId'])){
												$this->_Ainput['traceId'] = rand(11111,99999);
											}
												
											$userSecureHash = (isset($this->_Ainput['hashKey']) && !empty($this->_Ainput['hashKey'])) ? $this->_Ainput['hashKey'] : '';
										
											if($_AuserInfo['hashSettings']['validateSecureHash'] == 'Y'){
												$apiSecureHash = Common::getSecureHash($_AuserInfo,$this->_Ainput);
											}
											else{
												$apiSecureHash = $userSecureHash;
											}
											$apiSecureHash = $userSecureHash;
											if($apiSecureHash == $userSecureHash){
												
												$_IreferenceId	  = (isset($this->_Ainput['referenceId']) && !empty($this->_Ainput['referenceId'])) ? $this->_Ainput['referenceId'] : 0;
												
												$_SlogPath		  = $_AuserInfo['logFolder'];
												
												$_AapiCredentials = $_AuserInfo['credentials'][$_Smode];
												$_AapiPaymentInfo = $_AuserInfo['payments'][$_Smode];
												
												/*if(isset($this->_Ainput['apiCredentials']) && !empty($this->_Ainput['apiCredentials']) && $_AuserInfo['forceConfigMode'] != "Y"){
													$_AapiCredentials['userName'] 		= $this->_Ainput['apiCredentials']['userName'];
													$_AapiCredentials['password'] 		= $this->_Ainput['apiCredentials']['password'];
													$_AapiCredentials['targetBranch']	= $this->_Ainput['apiCredentials']['targetBranch'];
												}*/
												
												$_Asettings		= array
																	(
																		'userName' 			=> $_SuserName,
																		'mode' 				=> $_Smode,
																		'action' 			=> $_Saction,
																		'actionInfo' 		=> $_AactionInfo,
																		'apiCredentials' 	=> $_AapiCredentials,
																		'apiUrl' 			=> $GLOBALS['CONF']['api']['url'][$_Smode],
																		'logPath' 			=> $_SlogPath,
																		'referenceId' 		=> $_IreferenceId,
																		'apiPaymentInfo' 	=> $_AapiPaymentInfo,
																	);
												//echo "<pre>";print_r($GLOBALS['CONF']['api']['url']);die;					
												$GLOBALS['CONF']['userSettings'] = $_Asettings;
												
												$_Osmarty		= smartyConnect::singleton();
												//$_Odb			= DBConnect::singleton();
												$_Oconf 		= $GLOBALS['CONF'];
												
												$className		= $_Asettings['actionInfo']['className'];
												
												fileInclude("controllers/{$className}.php");
												
												$instance				 = new $className;
												
												$instance->_Osmarty		 = $_Osmarty;
												$instance->_Odb			 = $this->_Odb;
												$instance->_Oconf		 = $_Oconf;
												$instance->_Ainput		 = $this->_Ainput;
												$instance->_Asettings	 = $_Asettings;
												$instance->_IreferenceId = $_IreferenceId;
												$instance->userInfo		 = $_AuserInfo;
												
												$functionName = "_do".ucfirst($className);
					
												$response = $instance->$functionName();
												//print_r($response);die;
												//logWrite(print_r($response,true),"TEST","N","w");
												
												if(isset($response['status']) && $response['status']){
													$_Sstatus	= "SUCCESS";
													$_Adata		= $response['data'];
													$_Smessage  = $response['msg'];
												}
												else{
													$_Smessage = isset($response['msg']) ? $response['msg'] : 'No Response';
												}
												
												unset($GLOBALS['CONF']['userSettings']);
											}
											else{
												$_Smessage = 'Invalid secure hash for :- '.$_SuserName;
											}
										}
										else{
											$_Smessage = 'Invalid requested date';
										}
									}
									else{
										$_Smessage = 'Invalid mode ('.$_Smode.') for :- '.$_SuserName;
									}
								}
								else{
									$_Smessage = 'Invalid action ('.$_Saction.') for :- '.$_SuserName;
								}
							}
							else{
								$_Smessage = 'Access restricted for :- '.$_SuserName;
							}
						}
						else{
							$_Smessage = 'Authentication falied for :- '.$_SuserName;
						}
					}
					else{
						$_Smessage = 'User was de-activated :- '.$_SuserName;
					}
				}
				else{
					$_Smessage = 'Invalid user :- '.$_SuserName;
				}
			}
			else{
				$_Smessage = 'User name cannot be empty';
			}
		}
		else{
			$_Smessage = 'Invalid input';
		}
		
		if($_Sstatus != "SUCCESS"){
			logWrite($_Smessage.' , IP :- '.$_SuserIp,"FailureLog","Y","a+");
		}
		
		logWrite('User name :- '.$_SuserName.', Action :- '.$_Saction.' , Mode :- '.$_Smode.' , IP :- '.$_SuserIp,"AccessLog","Y","a+");
		
		$this->_Aoutput = array('status' => $_Sstatus, 'Msg' => $_Smessage, 'responseData' => $_Adata);
		
		return $this->_Aoutput;
    }
	
	function _getConfigData($_AgivenInput)
	{
		//print_r($_AgivenInput);die;
		$sql = "SELECT  
					ac.account_id,
					ac.account_name,
					ac.available_balance,
					ac.currency,
					ac.account_status,
					acr.user_name,
					acr.password,
					acr.salt,
					acr.api_mode,
					acr.current_mode,
					acr.allowed_ips,
					acr.ip_patching,
					acr.log_folder,
					acr.validate_secure_hash,
					acr.hash_string,
					acr.hash_separator,
					acr.hash_encryption_type
				FROM 
					account_details as ac
					INNER JOIN account_credentials_details as acr ON ac.account_id= acr.account_id
				WHERE 
					acr.user_name ='".$_AgivenInput['userName']."'
					AND acr.api_id = {$GLOBALS['CONF']['site']['apiId']}
					AND acr.api_mode = '".$_AgivenInput['mode']."'
					AND ac.account_id = acr.account_id";
		$data = $this->_Odb->getAll($sql);
		$resArray='';
		if($data!='')
		{
			
			$resArray[$_AgivenInput['userName']]['account_id'] 							= $data[0]['account_id'];
			$resArray[$_AgivenInput['userName']]['account_name'] 						= $data[0]['account_name'];
			$resArray[$_AgivenInput['userName']]['markup_fee'] 							= 0;
			$resArray[$_AgivenInput['userName']]['markup_type'] 						= 0;
			
			$resArray[$_AgivenInput['userName']]['available_balance'] 					= $data[0]['available_balance'];
			$resArray[$_AgivenInput['userName']]['currency'] 							= $data[0]['currency'];
			
			$resArray[$_AgivenInput['userName']]['status'] 								= $data[0]['account_status'];
			$resArray[$_AgivenInput['userName']]['password'] 							= $data[0]['password'];
			$resArray[$_AgivenInput['userName']]['salt'] 								= $data[0]['salt'];
			$resArray[$_AgivenInput['userName']]['hashSettings']['validateSecureHash'] 	= $data[0]['validate_secure_hash'];
			$resArray[$_AgivenInput['userName']]['hashSettings']['hashFormat'] 			= $data[0]['hash_string'];
			$resArray[$_AgivenInput['userName']]['hashSettings']['hashSeparator'] 		= $data[0]['hash_separator'];
			$resArray[$_AgivenInput['userName']]['hashSettings']['encryptionType'] 		= strtoupper($data[0]['hash_encryption_type']);
			$resArray[$_AgivenInput['userName']]['ipPatching'] 							= $data[0]['ip_patching'];
			
			
			$resArray[$_AgivenInput['userName']]['allowedIps'] 							= explode(",",$data[0]['allowed_ips']);
			$resArray[$_AgivenInput['userName']]['forceConfigMode'] 					= 'Y';
			$resArray[$_AgivenInput['userName']]['mode'] 								= $data[0]['current_mode'];
			$resArray[$_AgivenInput['userName']]['logFolder'] 							= $data[0]['log_folder'];
			$resArray[$_AgivenInput['userName']]['credentials']							= $GLOBALS['CONF']['api']['credentials'];
			$resArray[$_AgivenInput['userName']]['payments']							= $GLOBALS['CONF']['api']['payments'];
		}
		$sql = "
					SELECT 
						acc.account_id,
						markup.markup_type,
						markup.markup_fee_type,
						markup.markup_amount,
						markup.api,
						country.country_id,
						attr.attraction_list_id						
					FROM
						attraction_markup_details AS markup
						INNER JOIN attraction_markup_account_mapping AS acc ON acc.markup_id = markup.markup_id
						INNER JOIN attraction_markup_attraction_mapping AS attr ON attr.markup_id = markup.markup_id
						INNER JOIN attraction_markup_country_mapping AS country ON country.markup_id = markup.markup_id
					WHERE
						markup.markup_status = 'Y'
						AND ( acc.account_id=0 or acc.account_id='".$data[0]['account_id']."' )
						AND (markup.api = 0 OR markup.api = '".$GLOBALS['CONF']['site']['apiId']."')
					  
				";
		$_AmarkupResult = $this->_Odb->getAll($sql);
		$_RetMarkupArray = array();
		if(isset($_AmarkupResult) && !empty($_AmarkupResult)){
			foreach($_AmarkupResult as $_ValMarkup){
				$_RetMarkupArray[$_ValMarkup['account_id']][$_ValMarkup['api']][$_ValMarkup['country_id']][$_ValMarkup['attraction_list_id']] = array(
													"markup_type" 		=> $_ValMarkup['markup_type'],
													"markup_fee_type" 	=> $_ValMarkup['markup_fee_type'],
													"markup_amount" 	=> $_ValMarkup['markup_amount']
												);
			}
		}
		
		$resArray[$_AgivenInput['userName']]['markupArr'] = $_RetMarkupArray;
		//print_r($_RetMarkupArray);
		
		//die;
		
		/* $_AaccountArr 	= array();
		$_AapiArr 		= array();
		$_AcountryArr 	= array();
		
		foreach($_AmarkupResult as $markupRes){
			$_AaccountArr[$markupRes['api']][$markupRes['account_id']][$markupRes['country_id']] = $markupRes;
		}
		
		$_AmarkupData = array();
		
		if(count($_AaccountArr)>0){
			
			$_AapiMarup = array();
			if(isset($_AaccountArr[$GLOBALS['CONF']['site']['apiId']])){
				$_AapiMarup = $_AaccountArr[$GLOBALS['CONF']['site']['apiId']];
			}
			else if(isset($_AaccountArr[0])){
				$_AapiMarup = $_AaccountArr[0];
			}
			
			if(count($_AapiMarup) > 0){
				$_AaccountMarkup = array();
				if(isset($_AapiMarup[$data[0]['account_id']])){
					$_AaccountMarkup = $_AapiMarup[$data[0]['account_id']];
				}
				else if(isset($_AapiMarup[0])){
					$_AaccountMarkup = $_AapiMarup[0];
				}
				
				if(count($_AaccountMarkup)>0){
					$_Atemp			= array_values($_AaccountMarkup);
					$_AmarkupData	= $_Atemp[0];
					
					$resArray[$_AgivenInput['userName']]['markup_fee']	= $_AmarkupData['markup_amount'];
					$resArray[$_AgivenInput['userName']]['markup_type']	= $_AmarkupData['markup_fee_type'];
					$resArray[$_AgivenInput['userName']]['markup_source']	= $_AmarkupData['markup_type'];
				}
			}
		} */
		/* echo "<pre>";
		print_r($resArray); */
		return 	$resArray;
	}	
}
?>
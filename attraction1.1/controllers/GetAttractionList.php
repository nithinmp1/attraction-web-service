<?php
/**
	@File Name 		:	GetAttractionList.php
	@Author 		:	Elavarasan	P
	@Description	:	GetAttractionList service
*/
class GetAttractionList extends Execute
{
	function __construct()
	{
		parent::__construct();
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
	
	public function _modifyData()
	{
		$this->_SrequestUrl = $this->_Oconf['userSettings']['apiUrl']['attractionURL'];
		$this->_ApaxTypes  = array('ADULT','CHILD');
		
	}
	
    public function _doGetAttractionList()
	{
		$sellObj   						= controllerGet::getObject('GetSecurityToken',$this);
		$sellObj->_Ainput['action'] 	= 'GetSecurityToken';
		$_AgetTokenRes 					= $sellObj->_doGetSecurityToken();
		//$_AgetTokenRes['status']=true;
		if($_AgetTokenRes['status']==true)
		{
			$this->_securityToken = $_AgetTokenRes['data']['access_token'];
			$this->_Ainput['securityToken'] = $_AgetTokenRes['data']['access_token'];
		}
		else{
			$_AresponseArr =  array("status" => false, "msg"  => "Security Token Error", "data"	=>	'');
			return $_AresponseArr;
		}

		$this->_modifyData();
		$this->_setData();
		$_AsearchResult = $this->fun1();
		
		//$_AsearchResult = $this->_executeService();
		
			
		if($_AsearchResult!='')
		{
			$_AgetAttractionList = json_decode($_AsearchResult,true);
		}

		$_Areturn = $this->_getAttractionList($_AgetAttractionList, $this->_Ainput);
		
		
		return $_Areturn;
	}
	
	
	
	
	
	
	function _getAttractionList($_Aresponse, $_AinputData)
	{
		
		$_ApiIdIs		= $this->_Oconf['site']['apiId'];
		$_AccountIdIs = $this->_Oconf['account']['users'][$this->_Ainput['userName']]['account_id'];
		
		$_AresponseArr = array();
		if($_Aresponse['success']==1 && $_Aresponse['size']>0){
			/* 
			$_Smarkup_fee 		= $this->userInfo['markup_fee'];				//2;
			$_Smarkup_type 		= $this->userInfo['markup_type'];				//'percentage';
			$_Smarkup_source 	= $this->userInfo['markup_source'];	
			 */
			$_MarkupArray	 	= $this->userInfo['markupArr'];	
			/* echo "<pre>";
			print_r($_MarkupArray); */
			// This is for future use
			$_Smarkup_added 	= 'tax';										//base_fare, tax, 
			
			$_SreqCurrencyRate 	= $this->_getCurrencyRate($this->_Ainput['currencyCode']);
			$_Sconvertion_rate	= $_SreqCurrencyRate['value'];
			if($_Sconvertion_rate=='')
				$_Sconvertion_rate=1;
			$_Schild_markup_fee = 0;
			$_Sadult_markup_fee = 0;
			foreach($_Aresponse['data'] as $_AattractionKey => $_AattractionVal){
				$_Smarkup_fee 		= 0;
				$_Smarkup_type 		= '';	
				$_Smarkup_source 	= '';	
				if(empty($_AattractionVal['ticketTypes'])){
					continue;
				}
				$_MarkupValues		= Common::getMarkup($_MarkupArray, $_AccountIdIs, $_ApiIdIs, $this->_Ainput['countryId'], $_AattractionVal['id']);
				$_Schild_markup_fee = $_MarkupValues['child_markup_amount'];
				$_Sadult_markup_fee = $_MarkupValues['markup_amount'];
				$_Smarkup_type 		= $_MarkupValues['markup_fee_type'];	
				$_Smarkup_source 	= $_MarkupValues['markup_type'];
				
				$_AresponseArr[$_AattractionKey]['attractionID'] 		= $_AattractionVal['id'];
				$_AresponseArr[$_AattractionKey]['title'] 				= $_AattractionVal['title'];
				//$_AresponseArr[$_AattractionKey]['description'] 		= $_AattractionVal['description'].' '.$_AattractionVal['hoursOfOperation'];
				
				$_AattractionVal['description'] = str_replace("*","<br>",$_AattractionVal['description']);
				$_AattractionVal['description'] = str_replace("\n","<br>",$_AattractionVal['description']);
				$_AattractionVal['description'] = str_replace(" - ","<br> - ",$_AattractionVal['description']);
				$_AattractionVal['description'] = str_replace(':**',':**<br>',$_AattractionVal['description']);
				
				$_AattractionVal['hoursOfOperation'] = str_replace(':** -',':**<br>',$_AattractionVal['hoursOfOperation']);
				$_AattractionVal['hoursOfOperation'] = str_replace(' **',' <br>**',$_AattractionVal['hoursOfOperation']);
				//$_AattractionVal['hoursOfOperation'] = str_replace("*","<br>",$_AattractionVal['hoursOfOperation']);
				$_AattractionVal['hoursOfOperation'] = str_replace("\n","<br>",$_AattractionVal['hoursOfOperation']);
				$_AattractionVal['hoursOfOperation'] = str_replace(" - ","<br> - ",$_AattractionVal['hoursOfOperation']);
				
				 
				$_AresponseArr[$_AattractionKey]['description'] 		= $_AattractionVal['description'];
				$_AresponseArr[$_AattractionKey]['hoursOfOperation'] 	= $_AattractionVal['hoursOfOperation'];
				$_AresponseArr[$_AattractionKey]['tourInstruction'] 	= $_AattractionVal['hoursOfOperation'];
				$_AresponseArr[$_AattractionKey]['categoryId'] 			= $_AattractionVal['category']['id'];
				
				$_AresponseArr[$_AattractionKey]['description'] .="<br><br><b>Hours Of Operation</b><br>";
				$_AresponseArr[$_AattractionKey]['description'] .=$_AresponseArr[$_AattractionKey]['hoursOfOperation'];
				
				$_AresponseArr[$_AattractionKey]['imagePath'] 			= $this->_SrequestUrl.'image?name='.$_AattractionVal['imagePath'];
				
				$_AresponseArr[$_AattractionKey]['dateCreated'] 		= $_AattractionVal['dateCreated'];
				$_AresponseArr[$_AattractionKey]['lastUpdated'] 		= $_AattractionVal['lastUpdated'];
				
				if(!isset($_AattractionVal['country'][0])){
					$_AattractionVal['country'] = array($_AattractionVal['country']);
				}
				
				$_AresponseArr[$_AattractionKey]['country'] 		= $_AattractionVal['country'];
				
				if(!isset($_AattractionVal['city'][0])){
					$_AattractionVal['city'] = array($_AattractionVal['city']);
				}
				$_AresponseArr[$_AattractionKey]['city'] 		= $_AattractionVal['city'];
				
				if(!isset($_AattractionVal['merchant'][0])){
					$_AattractionVal['merchant'] = array($_AattractionVal['merchant']);
				}
				$_AresponseArr[$_AattractionKey]['merchant'] 		= $_AattractionVal['merchant'];
				
				if(!isset($_AattractionVal['ticketTypesAndPackages'][0])){
					$_AattractionVal['ticketTypesAndPackages'] = array($_AattractionVal['ticketTypesAndPackages']);
				}
				
				//$_AresponseArr[$_AattractionKey]['ticketTypesAndPackages'] 		= $_AattractionVal['ticketTypesAndPackages'];
				

				if(!isset($_AattractionVal['ticketTypes'][0])){
					$_AattractionVal['ticketTypes'] = array($_AattractionVal['ticketTypes']);
				}
				
				if(!isset($_AattractionVal['ticketTypes'][0]))
				{
					$_AattractionVal['ticketTypes'] =array($_AattractionVal['ticketTypes']);
				}
				$_AticketNameArr = array();
				$_AmergeArray=array();
				
					$_SattractionTypeRestrictionArr 	= $this->_attractionTypeRestriction();
					$resattrtype='';
					$impattrtypes='';
			if(!empty($_SattractionTypeRestrictionArr)){
					foreach($_SattractionTypeRestrictionArr as  $_AaccVal_1){	
					// echo "THTHTHTH";echo"<pre>";print_r($_AaccVal_1);					
							if(!empty($_AaccVal_1['ticketTypesid'])){
								 $resattrtype.= $_AaccVal_1['ticketTypesid'].",";
							}
					}
			
					
					$impattrtypes = explode(",",$resattrtype);
}					
				foreach($_AattractionVal['ticketTypes'] as $_AticketKey => $_AticketVal)
				{
					 if(!in_array($_AticketVal['id'],$impattrtypes)){
						
					if($_AticketVal['variation']['name']=="ADULT"){
						$_Smarkup_fee = $_Sadult_markup_fee;
					}else if($_AticketVal['variation']['name']=="CHILD"){
						$_Smarkup_fee = $_Schild_markup_fee;
					}
					$_AattractionVal = $_AticketVal;
					$_Aprice=0;
					$_AOriginalPrice=0;
					$_AsettlePrice=0;
					$_Aprice 			= round(($_AticketVal['price']*$_Sconvertion_rate),3);
					$_AOriginalPrice 	= round(($_AticketVal['originalPrice']*$_Sconvertion_rate),3);
					$_AsettlePrice 		= round(($_AticketVal['settlementPrice']*$_Sconvertion_rate),3);
					
					$_SmarkupPrice=0;
					if($_Smarkup_type=='percentage')
					{
						$_SmarkupPrice = round(((@$_Aprice*$_Smarkup_fee)/100),3);
					}
					else if($_Smarkup_type=='fixed')
					{
						if($_Smarkup_source=='TP')
						{
							$_SmarkupPrice=0;
							$_SmarkupPrice 	= round(($_Smarkup_fee * $_Sconvertion_rate),3);
						}
						else if($_Smarkup_source=='PP')
						{
							$_SmarkupPrice 	= round(($_Smarkup_fee * $_Sconvertion_rate),3);
						}
					}
					$_Aprice+=$_SmarkupPrice;
					
					
					$_AattractionVal['req_price'] 				= $_Aprice;
					$_AattractionVal['req_originalPrice'] 		= $_AOriginalPrice;
					$_AattractionVal['req_settlementPrice'] 	= $_AsettlePrice;
					$_AattractionVal['paxType'] 				= $_AticketVal['variation']['name'];
					$_AattractionVal['req_currency'] 			= $this->_Ainput['currencyCode'];
					$_AattractionVal['markupFare'] 			= $_SmarkupPrice.' '.$_Smarkup_type;
					if(in_array($_AattractionVal['paxType'],$this->_ApaxTypes))
					{
						if($_AticketVal['hasSeries']!=1)
						{
							if(!in_array($_AticketVal['name'],$_AticketNameArr)){
								$_AticketNameArr[] = $_AticketVal['name']; 
								$_AmergeArray[][]= $_AattractionVal;
								
							}else{
								$_AreqKey =array_search($_AticketVal['name'],$_AticketNameArr);
								$_AmergeArray[$_AreqKey][]= $_AattractionVal;
								
							}
						}
					}
				   }
				}

				$_AresponseArr[$_AattractionKey]['ticketTypes'] 		= $_AmergeArray;
				
				
			}
			
			/* attraction Restriction start */
			
			$_SattractionRestrictionArr 	= $this->_attractionRestriction();
			logWrite("\n Request \n ----------- \n".print_r($_AresponseArr,true)."\n","LogXML-attraction_1",'N','a+');
			
			//print_r($_SattractionRestrictionArr);
			
			$_AattractionDisplay = true;
			$_ArestrictAttractionIds =array();
			$_AresponseArrNew =array();
			
			if(!empty($_SattractionRestrictionArr)){
				
				foreach($_SattractionRestrictionArr as $_ArestrictKey => $_AestrictVal){
					
					if($_AestrictVal['status']=='I'){
						
						if($_AestrictVal['account_id']==0 || $_AestrictVal['account_id']==$_AccountIdIs){
							
							if(isset($_AestrictVal['attraction'][0]['attraction_id'])){
								
								if($_AestrictVal['attraction'][0]['attraction_id']==0){
								
									$_AattractionDisplay = false;
									//echo "one";
									
								}
							}
							else{
								
								if(!empty($_AestrictVal['accounts'])){
									
									foreach($_AestrictVal['attraction'] as $_AattKey => $_AattVal){
										
										$_ArestrictAttractionIds[] = $_AattVal['attraction_id'];
										//echo "two";
									}
								}

							}
							
						}
					}
					
				}
				logWrite("\n Request \n ----------- \n".print_r($_ArestrictAttractionIds,true)."\n","LogXML-attraction_ids",'N','a+');
				logWrite("\n Request \n ----------- \n".print_r($_AresponseArrNew,true)."\n","LogXML-AresponseArrNewNew",'N','a+');
				logWrite("\n Request \n ----------- \n".print_r($_SattractionRestrictionArr ,true)."\n","LogXML-_SattractionRestrictionArr",'N','a+');
				
				foreach($_SattractionRestrictionArr as $_ArestrictKey_1 => $_AestrictVal_1){
					
					//echo "Onetwo".$_AestrictVal_1['status'].$_AattractionDisplay;
					if($_AestrictVal_1['status']=='A' && $_AattractionDisplay==false){
						
						
						foreach($_AresponseArr as $_AresKey => $_AresVal){
							
							
							foreach($_AestrictVal['attraction'] as $_AattKey => $_AattVal){
									
								if($_AresVal['attractionID']==$_AattVal['attraction_id']){
									
									$_AresponseArrNew[] = $_AresVal;
								}
							}
						}

					}else if($_AestrictVal_1['status']=='I' && $_AattractionDisplay==true){

						
						if(!empty($_ArestrictAttractionIds)){
							$_AresponseArrNew = array();
							foreach($_AresponseArr as $_AresKey_1 => $_AresVal_1){
							
								if(!in_array($_AresVal_1['attractionID'],$_ArestrictAttractionIds)){
									
									$_AresponseArrNew[] = $_AresVal_1;
								}
								
										
										
							}
							
						}
						
						//$_AresponseArrNew = $_AresponseArr;
					}
				}
			}
			
			logWrite("\n Request \n ----------- \n".print_r($_AresponseArrNew,true)."\n","LogXML-responseArrNew",'N','a+');
			
			if(!empty($_AresponseArrNew)){
				
				$_AresponseArr = $_AresponseArrNew;
			}
			
			logWrite("\n Request \n ----------- \n".print_r($_AresponseArrNew,true)."\n","LogXML-responseArr1",'N','a+');
			/* $_AresponseArr['api_name'] = 'Globaltrix';
			$_AresponseArr['api_mw_id'] = 2;  */// dont remove this line ( by satish)
		return array("status"=>true, "msg"=>"GetAttractionList", "data"=>$_AresponseArr);
		}
		else{
			return array("status"=>false, "msg"=>"No GetAttractionList  ", "data"=>'');
		}
	}
	
	/**		Via Flight Segment Details		**/
	function _getCurrencyRate($_SreqCurrency)
	{
		$sql = "select value from `currency_converter`  where country='".$_SreqCurrency."' ";
		$data = $this->_Odb->getAll($sql);
		return $data[0];

	}
	function _attractionRestriction()
	{
		$_ApiIdIs		= $this->_Oconf['site']['apiId'];
		$_AccountIdIs = $this->_Oconf['account']['users'][$this->_Ainput['userName']]['account_id'];
		
		$sql = " SELECT markup.details_id,markup.status,markup.api_id FROM `attraction_api_management_details` AS markup where markup.api_id='$_ApiIdIs' and markup.status!='D' ";
		
		$apiManagementData = $this->_Odb->getAll($sql);
		//print_r($apiManagementData);
		
		
		
		foreach($apiManagementData as $_AdataKey => $_AdataVal){
			
			
			$accountsql = " SELECT * FROM `api_attraction_account_details` AS ad where ad.details_id=".$_AdataVal['details_id']." and (ad.account_id=".$_AccountIdIs." or ad.account_id='0') ";
			
			$accountdata = $this->_Odb->getAll($accountsql);
			$accountdataArr=array();
			$attractiondataArr=array();
			$attractionTypedataArr=array();
			$countrydataArr=array();
			foreach($accountdata as $_AaccKey => $_AaccVal){
				
				$accountdataArr[$_AaccVal['account_id']] =  $_AaccVal;
				$apiManagementData[$_AdataKey]['account_id'] =  $_AaccVal['account_id'];
			}
			$apiManagementData[$_AdataKey]['accounts'] = $accountdataArr;
			
			
			
			$attractionMappingsql = " SELECT * FROM `api_attraction_mapping_details` AS am where am.details_id=".$_AdataVal['details_id']." and am.ticket_type_ids=''";
			$attractionMappingdata = $this->_Odb->getAll($attractionMappingsql);
			
			foreach($attractionMappingdata as $_AaccKey_1 => $_AaccVal_1){
				
				$attractiondataArr[$_AaccVal_1['attraction_id']] =  $_AaccVal_1;
			}
			$apiManagementData[$_AdataKey]['attraction'] = $attractiondataArr;
			
			$attractionCountrysql = " SELECT * FROM `api_attraction_country_details` AS ac where ac.details_id=".$_AdataVal['details_id']." ";
			$attractionCountryData = $this->_Odb->getAll($attractionCountrysql);
			
			
			foreach($attractionCountryData as $_AaccKey => $_AaccVal){
				
				$countrydataArr[$_AaccVal['country_id']] =  $_AaccVal;
			}
			$apiManagementData[$_AdataKey]['country'] = $countrydataArr;
			
			
		}
		
		
		logWrite("\n Request \n ----------- \n".print_r($apiManagementData,true)."\n","LogXML-attraction",'N','a+');
		//print_r($apiManagementData);die;
		return $apiManagementData;

	}
	
	
	function _attractionTypeRestriction()
	{
		$_ApiIdIs		= $this->_Oconf['site']['apiId'];
		$_AccountIdIs = $this->_Oconf['account']['users'][$this->_Ainput['userName']]['account_id'];
		
		$sql = " SELECT markup.details_id,markup.status,markup.api_id FROM `attraction_api_management_details` AS markup where markup.api_id='$_ApiIdIs' and markup.status!='D' ";
		
		$apiManagementData = $this->_Odb->getAll($sql);
		//print_r($apiManagementData);
		
		
		
		foreach($apiManagementData as $_AdataKey => $_AdataVal){
			
			
			$accountsql = " SELECT * FROM `api_attraction_account_details` AS ad where ad.details_id=".$_AdataVal['details_id']." and (ad.account_id=".$_AccountIdIs." or ad.account_id='0') ";
			
			$accountdata = $this->_Odb->getAll($accountsql);
			/* $accountdataArr=array();
			$attractiondataArr=array();
			$attractionTypedataArr=array();
			$countrydataArr=array();
			foreach($accountdata as $_AaccKey => $_AaccVal){
				
				$accountdataArr[$_AaccVal['account_id']] =  $_AaccVal;
				$apiManagementData[$_AdataKey]['account_id'] =  $_AaccVal['account_id'];
			}
			$apiManagementData[$_AdataKey]['accounts'] = $accountdataArr;
			
			 */
			
			$attractionMappingsql = " SELECT * FROM `api_attraction_mapping_details` AS am where am.details_id=".$_AdataVal['details_id']." and am.ticket_type_ids!='' ";
			$attractionMappingdata = $this->_Odb->getAll($attractionMappingsql);
			
			foreach($attractionMappingdata as $_AaccKey_1 => $_AaccVal_1){	

				  $apiManagementData[$_AdataKey]['ticketTypesid'] = $_AaccVal_1['ticket_type_ids'];
						  
			}
			// $apiManagementData[$_AdataKey]['attraction'] = $attractiondataArr;
			// $apiManagementData[$_AdataKey]['ticketTypes'] = $attractionTypedataArr;
			/* $attractionCountrysql = " SELECT * FROM `api_attraction_country_details` AS ac where ac.details_id=".$_AdataVal['details_id']." ";
			$attractionCountryData = $this->_Odb->getAll($attractionCountrysql);			
			foreach($attractionCountryData as $_AaccKey => $_AaccVal){
				$countrydataArr[$_AaccVal['country_id']] =  $_AaccVal;
			}
			$apiManagementData[$_AdataKey]['country'] = $countrydataArr;
			 */
		}		
		
		//print_r($apiManagementData);die;
		return $apiManagementData;
	}
	
	function fun1()
	{
';
		
	return $xml;
	
	}
	
		
}
?>
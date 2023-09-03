<?php
/**
	@File Name 		:	GetAttractionList.php
	@Author 		:	Elavarasan	P
	@Description	:	GetAttractionList service
*/
class GetSingleAttraction extends Execute
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
		//$this->_ApaxTypes  = array('ADULT','CHILD','SENIOR_CITIZEN');
		$this->_ApaxTypes  = array('ADULT','CHILD');
		
	}
	
    public function _doGetSingleAttraction()
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
		//$_AsearchResult = $this->fun1(); 
		
		$_AsearchResult = $this->_executeService();
		
		
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
		if($_Aresponse['success']==1 ){
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
			
			$sellObj   						= controllerGet::getObject('GetAttractionOptionList',$this);
			$sellObj->_Ainput['action'] 	= 'GetAttractionOptionList';
			$_AGetAttractionOptionRes 		= $sellObj->_doGetAttractionOptionList();
			$_AGetAttractionOptionResArr=array();
			
			if($_AGetAttractionOptionRes['status']==1 ){
				$_AGetAttractionOptionResArr = $_AGetAttractionOptionRes['data']['data'];
				
			}	
			
			$sellObj   						= controllerGet::getObject('GetAttractionInfoList',$this);
			$sellObj->_Ainput['action'] 	= 'GetAttractionInfoList';
			$_AGetAttractionInfoRes 		= $sellObj->_doGetAttractionInfoList();
			$_AGetAttractionInfoResArr=array();
			
			if($_AGetAttractionInfoRes['status']==1 ){
				$_AGetAttractionInfoResArr = $_AGetAttractionInfoRes['data']['data'];
				
			}
			
			
			//$_AgetAttractionOption 			= $_AGetAttractionOptionRes;
				
			
			//foreach($_Aresponse['data'] as $_AattractionKey => $_AattractionVal)
			{
				//echo "<pre>";
				////print_r($_Aresponse['data']);
				$_AattractionKey = 0;
				$_AattractionVal = $_Aresponse['data'];
			
				$_Smarkup_fee 		= 0;
				$_Smarkup_type 		= '';	
				$_Smarkup_source 	= '';	
				/* if(empty($_AattractionVal['ticketTypes'])){
					continue;
				} */
				$_MarkupValues		= Common::getMarkup($_MarkupArray, $_AccountIdIs, $_ApiIdIs, $this->_Ainput['countryId'], $_AattractionVal['id']);
				$_Schild_markup_fee = $_MarkupValues['child_markup_amount'];
				$_Sadult_markup_fee = $_MarkupValues['markup_amount'];
				$_Smarkup_type 		= $_MarkupValues['markup_fee_type'];	
				$_Smarkup_source 	= $_MarkupValues['markup_type'];
				
				if(count($_Aresponse['data']>0)){
					$_AattractionVal['ticketTypes'] = $_Aresponse['data'];
				}

				/* if(!isset($_AattractionVal['ticketTypes'][0])){
					$_AattractionVal['ticketTypes'] = array($_AattractionVal['ticketTypes']);
				} */
				
				/* if(!isset($_AattractionVal['ticketTypes'][0]))
				{
					$_AattractionVal['ticketTypes'] =array($_AattractionVal['ticketTypes']);
				} */
				$_AticketNameArr = array();
				$_AmergeArray=array();
				
					$_SattractionTypeRestrictionArr 	= $this->_attractionTypeRestriction();
					$resattrtype='';
					$impattrtypes='';
			if(!empty($_SattractionTypeRestrictionArr))
			{
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
				if(!in_array($_AticketVal['id'],$impattrtypes))
				{
						
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
					$_AattractionVal['markupFare'] 				= $_SmarkupPrice.' '.$_Smarkup_type;
					$_AattractionVal['ticket_link_id'] 			= $_AticketVal['linkId'];
					$_AattractionVal['unavailableDays'] = '';
					if(isset($_AticketVal['ticketTypeGroup'])){
						
						if(isset($_AticketVal['ticketTypeGroup']['unavailableDays'])){
							$_AattractionVal['unavailableDays']= $_AticketVal['ticketTypeGroup']['unavailableDays'];
						}
					}
					
					foreach($_AGetAttractionOptionResArr as $_AoptionKey => $_AoptionVal){
						
						if($_AattractionVal['ticket_link_id']==$_AoptionVal['id']){
							
							
							$_AattractionVal['isCapacity'] 		= $_AoptionVal['isCapacity'];
							$_AattractionVal['timeSlot'] 		= $_AoptionVal['timeSlot'];
							$_AattractionVal['isCapacity'] 		= $_AoptionVal['isCapacity'];
							$_AattractionVal['advanceBooking'] 	= $_AoptionVal['advanceBooking'];
							$_AattractionVal['isadvanceBooking'] = 0;
							$_AattractionVal['advanceBookingDays'] = 0;
							$_AattractionVal['advanceBookingHours'] = 0;
							$_AattractionVal['advanceBookingMinutes'] = 0;
							if(isset($_AoptionVal['advanceBooking']['required']) && $_AoptionVal['advanceBooking']['required']==1){
								$_AattractionVal['isadvanceBooking']=1;
								$_AattractionVal['advanceBookingDays'] 		= $_AoptionVal['advanceBooking']['day'];
								$_AattractionVal['advanceBookingHours'] 	= $_AoptionVal['advanceBooking']['hour'];
								$_AattractionVal['advanceBookingMinutes'] 	= $_AoptionVal['advanceBooking']['minute'];
								
								
								
							}
							$_AattractionVal['visitDate'] 		= $_AoptionVal['visitDate'];
							$_AattractionVal['isCancellable'] 	= $_AoptionVal['isCancellable'];
							$_AattractionVal['cancellationPolicy'] 	= $_AoptionVal['cancellationPolicy'];
							$_AattractionVal['cancellationNotes']='';
							if(!empty($_AoptionVal['cancellationNotes'])){
								
								foreach($_AoptionVal['cancellationNotes'] as $_AcancelKey => $_AcancelVal){
									
									
									
									$_AattractionVal['cancellationNotes'] .= "<br/> - ".($_AcancelVal);
								}
								//$_AattractionVal['cancellationNotes'] 	= implode("<br/> ",$_AoptionVal['cancellationNotes']);
							}
							
							$_AattractionVal['questions'] 		= $_AoptionVal['questions'];
							$_AattractionVal['ticketValidity'] 	= $_AoptionVal['ticketValidity'];
							$_AattractionVal['definedDuration'] = $_AoptionVal['definedDuration'];
							$_AattractionVal['ticketFormat'] 	= $_AoptionVal['ticketFormat'];
							
						}
						
						
					}
					
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
				$_AresponseArr[$_AattractionKey]['attractionId'] 		= $this->_Ainput['attractionId']; 
				$_AresponseArr[$_AattractionKey]['attractionID'] 		= $this->_Ainput['attractionId'];  
				
				
			}
			$_AresponseArr[$_AattractionKey]['GetAttractionInfo'] 		= $_AGetAttractionInfoResArr;
			
			
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
		return array("status"=>true, "msg"=>"GetAttractionTicketType", "data"=>$_AresponseArr);    
		}
		else{
			return array("status"=>false, "msg"=>"No ticket type found  ", "data"=>'');
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
		$xml = '{"data":[{"id":135345,"hasSeries":false,"name":"Wings of Time – Standard (Open Dated) (PER PAX)","currency":"SGD","favorited":false,"price":11.2,"variation":{"name":"SENIOR_CITIZEN","customName":"PER PAX"},"issuanceLimit":null,"similarTicketId":null,"originalPrice":18.0,"settlementPrice":0.0,"merchantCurrency":"SGD","sourceName":"Mount Faber Leisure Group","sourceTitle":"Marketplace","ableToDistributeToGlobaltix":false,"from":null,"did":85949,"linkId":112678,"productGroupName":"Wings of Time – Standard (Open Dated)","similarTicket":null,"imagePath":null,"imagePathExt":"png","isVisitDateCompulsory":false,"description":"\nEffective from 3rd April 2023, Wings of Time will resume operations of two (2) daily shows, where the first show will be at 7:40pm and the second show at 8.40pm.\nStandard seating: Enjoy the show on wooden benches at various zones.\nGates will open 15 minutes prior to the start of the show\n","termsAndConditions":"\nGuests aged 4 years old and above will require a ticket.\nWheelchair accessible seats are available at the front row (not applicable for premium seats) of the Wings of Time seating gallery.\nTicket is valid for 6 months.\nNon-refundable, cancellation and exchange are allowed once e-tickets are issued. This is a rain or shine event.\nSeat is based on first come first serve.\n","questions":[],"isOpenDated":false,"maximumPax":null,"minimumPax":null,"visitDate":{"class":"com.globaltix.api.v1.VisitDateSettings","id":103975,"advanceBookingDays":null,"advanceBookingHours":null,"advanceBookingMinutes":null,"isAdvanceBooking":false,"isRequestVisitDate":false,"isVisitDateCompulsory":false,"ticketTypeGroup":{"class":"com.globaltix.api.v1.TicketTypeGroup","id":112678}},"ticketTypeGroup":{"useSimpleDistribution":true,"questions":[],"variants":[{"variantName":"ADULT","ticketTypeId":135343,"originalPrice":0.0,"originalMerchantPrice":0.0,"settlementRate":null,"merchantSettlementRate":null},{"variantName":"CHILD","ticketTypeId":135344,"originalPrice":0.0,"originalMerchantPrice":0.0,"settlementRate":null,"merchantSettlementRate":null},{"variantName":"SENIOR_CITIZEN","ticketTypeId":135345,"originalPrice":18.0,"originalMerchantPrice":18.0,"settlementRate":10.0,"merchantSettlementRate":10.0}],"inclusionsList":[{"class":"com.globaltix.api.v1.Inclusions","id":409965,"createdBy":"17397","dateCreated":"2022-06-09T08:48:55Z","isActive":true,"lastUpdated":"2023-04-18T09:01:50Z","lastUpdatedBy":"17719","placementOrder":0,"ticketTypeGroup":{"class":"com.globaltix.api.v1.TicketTypeGroup","id":112678},"value":"Standard Seat -Show Only (07:40pm / 08:40pm)"}],"merchantProductCode":null,"variation":{"name":"SENIOR_CITIZEN","customName":"PER PAX"},"demandType":"NON_PEAK","lastUpdated":"2023-04-18T09:01:49Z","isMerchantBarcodeOnly":true,"minimumPax":null,"barcodeBin":{"barcodeBinType":"NOT_APPLICABLE","offerCount":null,"purpose":null,"termsAndConditions":"Guests aged 4 years old and above will require a ticket.\nWheelchair accessible seats are available at the front row (not applicable for premium seats) of the Wings of Time seating gallery.\nTicket is valid for 6 months.\nNon-refundable, cancellation and exchange are allowed once e-tickets are issued. This is a rain or shine event.\nSeat is based on first come first serve.","emails":["ops-team@globaltix.com","ticketorder@globaltix.com"],"pluCode":null,"offerNo":null,"id":1871,"offerIdentifier":null,"sku":"01CAB010020HS","basePrice":null,"additionalInfos":[{"remark":null,"id":50514,"label":null,"class":"com.globaltix.api.v1.BarcodeBinAdditionalInfo"}],"barcodeOutputType":{"enumType":"gt.enumeration.BarcodeOutputType","name":"TEMPLATE"},"validFor":"Single Admission","format":"QR_CODE","barcodesLimitNotification":100,"packagePlu":null,"attraction":{"id":5369},"left":480,"validityPeriodText":null,"name":"Wings of Time – Standard","validityPeriodType":{"enumType":"gt.enumeration.PrintTicketValidityPeriodType","name":"HIDE"},"templateFilename":"TF20220926-MFLG-03.gsp","skipBarcodes":false,"status":{"enumType":"gt.enumeration.Status","name":"PUBLISHED"}},"customVariationName":"PER PAX","isCloudApi":false,"emailTrigger":0,"imagePathExt":"png","visitDate":{"isRequestVisitDate":false,"isVisitDateCompulsory":false,"isAdvanceBooking":false,"advanceBookingDays":null,"advanceBookingHours":null,"advanceBookingMinutes":null,"isOpenDated":false},"id":135345,"minimumSellingPrice":17.1,"ticketTypeFormat":"PDFVOUCHER","isAdvanceBooking":false,"lastUpdatedBy":"17719","publishEnd":null,"isSeparateEmail":false,"redeemStart":null,"emailSendOutType":"PDF","customName":1,"howToUseList":[{"class":"com.globaltix.api.v1.HowToUse","id":376572,"isActive":true,"placementOrder":2,"ticketTypeGroup":{"class":"com.globaltix.api.v1.TicketTypeGroup","id":112678},"value":"Use the code below QR code image to make your reservation in the website. Please present either mobile or printed voucher at Wings of Time concourse (in front of Fun Shop)."},{"class":"com.globaltix.api.v1.HowToUse","id":376571,"isActive":true,"placementOrder":1,"ticketTypeGroup":{"class":"com.globaltix.api.v1.TicketTypeGroup","id":112678},"value":"The guest must reservation show date and time in https://reservation.mountfaberleisure.com/"}],"minimumMerchantSellingPrice":17.1,"merchantSettlementRate":10.0,"gtPackageOnlyPrice":null,"maximumPax":null,"cancellationNotesSettings":[{"id":255939,"isActive":false,"placementOrder":2,"value":"No Amendment on Visit Date"},{"id":255940,"isActive":false,"placementOrder":3,"value":"Non-Refundable, Non-transferable & Non-Cancellable"},{"id":255941,"isActive":true,"placementOrder":1,"value":"Non-Refundable & No Cancellation"}],"isPrintEntryTicket":false,"name":"Wings of Time – Standard (Open Dated) (PER PAX)","isAddOn":0,"changeStatus":null,"status":{"enumType":"gt.enumeration.Status","name":"PUBLISHED"},"cancellationPolicySettings":{"class":"com.globaltix.api.v1.CancellationPolicy","id":98493,"cancellationNotes":[{"class":"com.globaltix.api.v1.CancellationNotes","id":255939},{"class":"com.globaltix.api.v1.CancellationNotes","id":255940},{"class":"com.globaltix.api.v1.CancellationNotes","id":255941}],"createdBy":"470","dateCreated":"2022-05-10T08:40:02Z","isActive":false,"lastUpdated":"2022-06-14T08:48:55Z","lastUpdatedBy":"17397","percentReturn":100.0,"refundDuration":0,"ticketTypeGroup":{"class":"com.globaltix.api.v1.TicketTypeGroup","id":112678}},"orderFulfillment":0,"originalPrice":18.0,"redeemEnd":null,"requireCustomerInfo":false,"applyCapacity":false,"description":"<ul>\n<li><span style=\"font-size: 12px;\">Effective from 3rd April 2023, Wings of Time will resume operations of two (2) daily shows, where the first show will be at 7:40pm and the second show at 8.40pm.<\u002fspan><\u002fli>\n<li><span style=\"background-color: transparent;\">Standard <\u002fspan><span style=\"background-color: transparent;\">seating: Enjoy the show on wooden benches at various zones.<\u002fspan><\u002fli>\n<li>Gates will open 15 minutes prior to the start of the show<\u002fli>\n<\u002ful>","settlementRate":11.2,"originalMerchantPrice":18.0,"termsAndConditions":"<ul>\n<li>Guests aged 4 years old and above will require a ticket.<\u002fli>\n<li>Wheelchair accessible seats are available at the front row (not applicable for premium seats) of the Wings of Time seating gallery.<\u002fli>\n<li>Ticket is valid for 6 months.<\u002fli>\n<li>Non-refundable, cancellation and exchange are allowed once e-tickets are issued. This is a rain or shine event.<\u002fli>\n<li>Seat is based on first come first serve.<\u002fli>\n<\u002ful>","allowMultiEntry":false,"publishStart":"2022-05-10T00:00:00","isRequestVisitDate":false,"dateCreated":"2022-05-10T08:40:02Z","currency":"SGD","isVisitDateCompulsory":false,"owner":null,"definedDuration":180,"additionalRestriction":false,"showTypeName":true,"isPrintReceipt":false,"linkId":112678,"attraction":{"id":5369,"title":"Wings of Time","timezoneOffset":480,"merchantName":"Mount Faber Leisure Group","merchantId":30,"country":"Singapore","countryId":1},"createdBy":"470","unavailableDays":"","series":[],"advanceBookingDays":null,"ticketValidity":"Duration","SKU":"01CAB010020HS","distributionMarkedUp":{"lastUpdatedBy":"8592","product":{"id":135345,"class":"com.globaltix.api.v1.Product"},"domesticMedium":0.2,"domesticLarge":0.2,"overseasLarge":0.2,"markUpType":{"enumType":"gt.enumeration.MarkUpType","name":"FIXED"},"lastUpdated":"2022-06-30T01:22:05Z","overseasMedium":0.2,"dateCreated":"2022-05-18T19:24:52Z","createdBy":"47","id":153,"overseasSmall":0.2,"class":"com.globaltix.api.v1.DistributionMarkedUp","ota":0.2,"domesticSmall":0.2}}},{"id":179934,"hasSeries":false,"name":"Wings of Time – Standard Dated - 7.40PM (PER PAX)","currency":"SGD","favorited":false,"price":11.2,"variation":{"name":"SENIOR_CITIZEN","customName":"PER PAX"},"issuanceLimit":null,"similarTicketId":null,"originalPrice":18.0,"settlementPrice":0.0,"merchantCurrency":"SGD","sourceName":"Mount Faber Leisure Group","sourceTitle":"Marketplace","ableToDistributeToGlobaltix":false,"from":null,"did":123183,"linkId":133926,"productGroupName":"Wings of Time – Standard Dated - 7.40PM","similarTicket":null,"imagePath":null,"imagePathExt":"png","isVisitDateCompulsory":true,"description":"\nEffective from 3rd April 2023, Wings of Time will resume operations of two (2) daily shows, where the first show will be at 7:40pm and the second show at 8.40pm.\nStandardseating: Enjoy the show on wooden benches at various zones.\nGates will open 15 minutes prior to the start of the show\n","termsAndConditions":"Valid on the selected dateGuests aged 4 years old and above will require a ticket.Wheelchair accessible seats are available at the front row (not applicable for premium seats) of the Wings of Time seating gallery.Non-refundable, cancellation and exchange are allowed once e-tickets are issued. This is a rain or shine event.Seat is based on first come first serve.","questions":[],"isOpenDated":false,"maximumPax":null,"minimumPax":null,"visitDate":{"class":"com.globaltix.api.v1.VisitDateSettings","id":124260,"advanceBookingDays":1,"advanceBookingHours":0,"advanceBookingMinutes":0,"isAdvanceBooking":true,"isRequestVisitDate":true,"isVisitDateCompulsory":true,"ticketTypeGroup":{"class":"com.globaltix.api.v1.TicketTypeGroup","id":133926}},"ticketTypeGroup":{"useSimpleDistribution":true,"questions":[],"variants":[{"variantName":"ADULT","ticketTypeId":179932,"originalPrice":0.0,"originalMerchantPrice":0.0,"settlementRate":null,"merchantSettlementRate":null},{"variantName":"CHILD","ticketTypeId":179933,"originalPrice":0.0,"originalMerchantPrice":0.0,"settlementRate":null,"merchantSettlementRate":null},{"variantName":"SENIOR_CITIZEN","ticketTypeId":179934,"originalPrice":18.0,"originalMerchantPrice":18.0,"settlementRate":null,"merchantSettlementRate":null}],"inclusionsList":[{"class":"com.globaltix.api.v1.Inclusions","id":537526,"createdBy":"470","dateCreated":"2023-04-03T13:45:45Z","isActive":true,"lastUpdated":"2023-04-18T09:01:27Z","lastUpdatedBy":"17719","placementOrder":0,"ticketTypeGroup":{"class":"com.globaltix.api.v1.TicketTypeGroup","id":133926},"value":"Standard Seat -Show Only (07:40pm)"}],"merchantProductCode":null,"variation":{"name":"SENIOR_CITIZEN","customName":"PER PAX"},"demandType":"NON_PEAK","lastUpdated":"2023-05-22T05:40:51Z","isMerchantBarcodeOnly":false,"minimumPax":null,"barcodeBin":null,"customVariationName":"PER PAX","isCloudApi":false,"emailTrigger":1,"imagePathExt":"png","visitDate":{"isRequestVisitDate":true,"isVisitDateCompulsory":true,"isAdvanceBooking":true,"advanceBookingDays":1,"advanceBookingHours":0,"advanceBookingMinutes":0,"isOpenDated":false},"id":179934,"minimumSellingPrice":17.1,"ticketTypeFormat":"SEPARATEEMAIL","isAdvanceBooking":true,"lastUpdatedBy":"470","publishEnd":"2023-06-30T23:59:59","isSeparateEmail":true,"redeemStart":"2023-04-04T00:00:00","emailSendOutType":"SEPERATEEMAIL","customName":1,"howToUseList":[{"class":"com.globaltix.api.v1.HowToUse","id":433928,"isActive":true,"placementOrder":1,"ticketTypeGroup":{"class":"com.globaltix.api.v1.TicketTypeGroup","id":133926},"value":"Your booking is confirmed. Final Ticket will be sent to you separately. Please present either mobile or printed Final Ticket for redemption."}],"minimumMerchantSellingPrice":17.1,"merchantSettlementRate":null,"gtPackageOnlyPrice":null,"maximumPax":null,"cancellationNotesSettings":[{"id":455532,"isActive":true,"placementOrder":1,"value":"Non-Refundable & No Cancellation"},{"id":455533,"isActive":false,"placementOrder":2,"value":"No Amendment on Visit Date"},{"id":455534,"isActive":false,"placementOrder":3,"value":"Non-Refundable, Non-transferable & Non-Cancellable"}],"isPrintEntryTicket":false,"name":"Wings of Time – Standard Dated - 7.40PM (PER PAX)","isAddOn":0,"changeStatus":null,"status":{"enumType":"gt.enumeration.Status","name":"PUBLISHED"},"cancellationPolicySettings":{"class":"com.globaltix.api.v1.CancellationPolicy","id":119745,"cancellationNotes":[{"class":"com.globaltix.api.v1.CancellationNotes","id":455532},{"class":"com.globaltix.api.v1.CancellationNotes","id":455533},{"class":"com.globaltix.api.v1.CancellationNotes","id":455534}],"createdBy":"470","dateCreated":"2023-04-04T05:45:45Z","isActive":false,"lastUpdated":"2023-04-18T08:25:51Z","lastUpdatedBy":"470","percentReturn":null,"refundDuration":null,"ticketTypeGroup":{"class":"com.globaltix.api.v1.TicketTypeGroup","id":133926}},"orderFulfillment":1,"originalPrice":18.0,"redeemEnd":"2023-06-30T23:59:59","requireCustomerInfo":false,"applyCapacity":false,"description":"<ul>\n<li>Effective from 3rd April 2023, Wings of Time will resume operations of two (2) daily shows, where the first show will be at 7:40pm and the second show at 8.40pm.<\u002fli>\n<li><span style=\"background-color: transparent;\">Standard&nbsp;<\u002fspan><span style=\"background-color: transparent;\">seating: Enjoy the show on wooden benches at various zones.<\u002fspan><\u002fli>\n<li>Gates will open 15 minutes prior to the start of the show<\u002fli>\n<\u002ful>","settlementRate":11.2,"originalMerchantPrice":18.0,"termsAndConditions":"<ul><li>Valid on the selected date<\u002fli><li>Guests aged 4 years old and above will require a ticket.<\u002fli><li>Wheelchair accessible seats are available at the front row (not applicable for premium seats) of the Wings of Time seating gallery.<\u002fli><li><span style=\"background-color: transparent;\">Non-refundable, cancellation and exchange are allowed once e-tickets are issued. This is a rain or shine event.<\u002fspan><br><\u002fli><li>Seat is based on first come first serve.<\u002fli><\u002ful>","allowMultiEntry":false,"publishStart":"2023-04-04T00:00:00","isRequestVisitDate":true,"dateCreated":"2023-04-04T05:45:45Z","currency":"SGD","isVisitDateCompulsory":true,"owner":null,"definedDuration":0,"additionalRestriction":false,"showTypeName":true,"isPrintReceipt":false,"linkId":133926,"attraction":{"id":5369,"title":"Wings of Time","timezoneOffset":480,"merchantName":"Mount Faber Leisure Group","merchantId":30,"country":"Singapore","countryId":1},"createdBy":"470","unavailableDays":"","series":[],"advanceBookingDays":1,"ticketValidity":"FixedDate","SKU":"01CAB010020JS","distributionMarkedUp":{"lastUpdatedBy":null,"product":{"id":179934,"class":"com.globaltix.api.v1.Product"},"domesticMedium":0.2,"domesticLarge":0.2,"overseasLarge":0.2,"markUpType":{"enumType":"gt.enumeration.MarkUpType","name":"FIXED"},"lastUpdated":"2023-04-18T08:27:23Z","overseasMedium":0.2,"dateCreated":"2023-04-18T08:27:23Z","createdBy":"17696","id":89987,"overseasSmall":0.2,"class":"com.globaltix.api.v1.DistributionMarkedUp","ota":0.2,"domesticSmall":0.2}}},{"id":179967,"hasSeries":false,"name":"Wings of Time – Standard Dated - 8.40PM (PER PAX)","currency":"SGD","favorited":false,"price":9.2,"variation":{"name":"SENIOR_CITIZEN","customName":"PER PAX"},"issuanceLimit":null,"similarTicketId":133926,"originalPrice":18.0,"settlementPrice":0.0,"merchantCurrency":"SGD","sourceName":"Mount Faber Leisure Group","sourceTitle":"Marketplace","ableToDistributeToGlobaltix":false,"from":null,"did":123184,"linkId":133937,"productGroupName":"Wings of Time – Standard Dated - 8.40PM","similarTicket":133926,"imagePath":null,"imagePathExt":"png","isVisitDateCompulsory":true,"description":"\nEffective from 3rd April 2023, Wings of Time will resume operations of two (2) daily shows, where the first show will be at 7:40pm and the second show at 8.40pm.\nStandardseating: Enjoy the show on wooden benches at various zones.\nGates will open 15 minutes prior to the start of the show\n","termsAndConditions":"Valid on the selected dateGuests aged 4 years old and above will require a ticket.Wheelchair accessible seats are available at the front row (not applicable for premium seats) of the Wings of Time seating gallery.Non-refundable, cancellation and exchange are allowed once e-tickets are issued. This is a rain or shine event.Seat is based on first come first serve.","questions":[],"isOpenDated":false,"maximumPax":null,"minimumPax":null,"visitDate":{"class":"com.globaltix.api.v1.VisitDateSettings","id":124271,"advanceBookingDays":1,"advanceBookingHours":0,"advanceBookingMinutes":0,"isAdvanceBooking":true,"isRequestVisitDate":true,"isVisitDateCompulsory":true,"ticketTypeGroup":{"class":"com.globaltix.api.v1.TicketTypeGroup","id":133937}},"ticketTypeGroup":{"useSimpleDistribution":true,"questions":[],"variants":[{"variantName":"ADULT","ticketTypeId":179965,"originalPrice":0.0,"originalMerchantPrice":0.0,"settlementRate":null,"merchantSettlementRate":null},{"variantName":"CHILD","ticketTypeId":179966,"originalPrice":0.0,"originalMerchantPrice":0.0,"settlementRate":null,"merchantSettlementRate":null},{"variantName":"SENIOR_CITIZEN","ticketTypeId":179967,"originalPrice":18.0,"originalMerchantPrice":18.0,"settlementRate":null,"merchantSettlementRate":null}],"inclusionsList":[{"class":"com.globaltix.api.v1.Inclusions","id":537559,"createdBy":"470","dateCreated":"2023-04-03T07:07:29Z","isActive":true,"lastUpdated":"2023-04-18T09:01:03Z","lastUpdatedBy":"17719","placementOrder":0,"ticketTypeGroup":{"class":"com.globaltix.api.v1.TicketTypeGroup","id":133937},"value":"Standard Seat -Show Only (08:40pm)"}],"merchantProductCode":null,"variation":{"name":"SENIOR_CITIZEN","customName":"PER PAX"},"demandType":"NON_PEAK","lastUpdated":"2023-05-22T05:41:03Z","isMerchantBarcodeOnly":false,"minimumPax":null,"barcodeBin":null,"customVariationName":"PER PAX","isCloudApi":false,"emailTrigger":1,"imagePathExt":"png","visitDate":{"isRequestVisitDate":true,"isVisitDateCompulsory":true,"isAdvanceBooking":true,"advanceBookingDays":1,"advanceBookingHours":0,"advanceBookingMinutes":0,"isOpenDated":false},"id":179967,"minimumSellingPrice":17.1,"ticketTypeFormat":"SEPARATEEMAIL","isAdvanceBooking":true,"lastUpdatedBy":"470","publishEnd":"2023-06-30T23:59:59","isSeparateEmail":true,"redeemStart":"2023-04-04T00:00:00","emailSendOutType":"SEPERATEEMAIL","customName":1,"howToUseList":[{"class":"com.globaltix.api.v1.HowToUse","id":433964,"isActive":true,"placementOrder":1,"ticketTypeGroup":{"class":"com.globaltix.api.v1.TicketTypeGroup","id":133937},"value":"Your booking is confirmed. Final Ticket will be sent to you separately. Please present either mobile or printed Final Ticket for redemption."}],"minimumMerchantSellingPrice":17.1,"merchantSettlementRate":null,"gtPackageOnlyPrice":null,"maximumPax":null,"cancellationNotesSettings":[{"id":455658,"isActive":true,"placementOrder":1,"value":"Non-Refundable & No Cancellation"},{"id":455660,"isActive":false,"placementOrder":3,"value":"Non-Refundable, Non-transferable & Non-Cancellable"},{"id":455659,"isActive":false,"placementOrder":2,"value":"No Amendment on Visit Date"}],"isPrintEntryTicket":false,"name":"Wings of Time – Standard Dated - 8.40PM (PER PAX)","isAddOn":0,"changeStatus":null,"status":{"enumType":"gt.enumeration.Status","name":"PUBLISHED"},"cancellationPolicySettings":{"class":"com.globaltix.api.v1.CancellationPolicy","id":119756,"cancellationNotes":[{"class":"com.globaltix.api.v1.CancellationNotes","id":455658},{"class":"com.globaltix.api.v1.CancellationNotes","id":455660},{"class":"com.globaltix.api.v1.CancellationNotes","id":455659}],"createdBy":"470","dateCreated":"2023-04-04T07:07:29Z","isActive":false,"lastUpdated":"2023-04-18T08:26:43Z","lastUpdatedBy":"470","percentReturn":null,"refundDuration":null,"ticketTypeGroup":{"class":"com.globaltix.api.v1.TicketTypeGroup","id":133937}},"orderFulfillment":1,"originalPrice":18.0,"redeemEnd":"2023-06-30T23:59:59","requireCustomerInfo":false,"applyCapacity":false,"description":"<ul>\n<li>Effective from 3rd April 2023, Wings of Time will resume operations of two (2) daily shows, where the first show will be at 7:40pm and the second show at 8.40pm.<\u002fli>\n<li><span style=\"background-color: transparent;\">Standard&nbsp;<\u002fspan><span style=\"background-color: transparent;\">seating: Enjoy the show on wooden benches at various zones.<\u002fspan><\u002fli>\n<li>Gates will open 15 minutes prior to the start of the show<\u002fli>\n<\u002ful>","settlementRate":9.2,"originalMerchantPrice":18.0,"termsAndConditions":"<ul><li>Valid on the selected date<\u002fli><li>Guests aged 4 years old and above will require a ticket.<\u002fli><li>Wheelchair accessible seats are available at the front row (not applicable for premium seats) of the Wings of Time seating gallery.<\u002fli><li><span style=\"background-color: transparent;\">Non-refundable, cancellation and exchange are allowed once e-tickets are issued. This is a rain or shine event.<\u002fspan><br><\u002fli><li>Seat is based on first come first serve.<\u002fli><\u002ful>","allowMultiEntry":false,"publishStart":"2023-04-04T00:00:00","isRequestVisitDate":true,"dateCreated":"2023-04-04T07:07:29Z","currency":"SGD","isVisitDateCompulsory":true,"owner":null,"definedDuration":0,"additionalRestriction":false,"showTypeName":true,"similarTicket":{"class":"com.globaltix.api.v1.TicketTypeGroup","id":133926,"_key":"0J,1,5369,,","additionalRestriction":false,"allowMultiEntry":false,"applyCapacity":false,"attraction":{"class":"com.globaltix.api.v1.Attraction","id":5369},"cancellationPolicy":{"class":"com.globaltix.api.v1.CancellationPolicy","id":119745},"cloudApi":false,"code":"0J","createdBy":null,"currency":{"class":"com.globaltix.api.v1.Currency","id":1},"customName":1,"dateCreated":"2023-04-04T05:45:45Z","demandType":{"enumType":"gt.enumeration.DemandType","name":"NON_PEAK"},"description":"<ul>\n<li>Effective from 3rd April 2023, Wings of Time will resume operations of two (2) daily shows, where the first show will be at 7:40pm and the second show at 8.40pm.<\u002fli>\n<li><span style=\"background-color: transparent;\">Standard&nbsp;<\u002fspan><span style=\"background-color: transparent;\">seating: Enjoy the show on wooden benches at various zones.<\u002fspan><\u002fli>\n<li>Gates will open 15 minutes prior to the start of the show<\u002fli>\n<\u002ful>","emailTrigger":1,"howToUse":[{"class":"com.globaltix.api.v1.HowToUse","id":433928}],"inclusions":[{"class":"com.globaltix.api.v1.Inclusions","id":537526}],"isAddOn":0,"isAdvanceSellingPeriod":true,"isOpenDated":false,"keywords":null,"lastUpdated":"2023-05-22T05:40:51Z","lastUpdatedBy":"470","multiEntryType":null,"multiEntryValue":null,"name":"Wings of Time – Standard Dated - 7.40PM","openItemType":null,"orderFulfillment":1,"products":[{"class":"com.globaltix.api.v1.Product","id":179932},{"class":"com.globaltix.api.v1.Product","id":179933},{"class":"com.globaltix.api.v1.Product","id":179934}],"questions":[],"requireCustomerEmail":false,"requireReceiptCode":false,"series":[],"showTypeName":true,"supplierInventory":[],"unavailableDays":"","visitDate":{"class":"com.globaltix.api.v1.VisitDateSettings","id":124260}},"isPrintReceipt":false,"linkId":133937,"attraction":{"id":5369,"title":"Wings of Time","timezoneOffset":480,"merchantName":"Mount Faber Leisure Group","merchantId":30,"country":"Singapore","countryId":1},"createdBy":"470","unavailableDays":"","series":[],"advanceBookingDays":1,"ticketValidity":"FixedDate","SKU":"01CAB010020KS","distributionMarkedUp":{"lastUpdatedBy":"17696","product":{"id":179967,"class":"com.globaltix.api.v1.Product"},"domesticMedium":0.2,"domesticLarge":0.2,"overseasLarge":0.2,"markUpType":{"enumType":"gt.enumeration.MarkUpType","name":"FIXED"},"lastUpdated":"2023-04-18T08:27:50Z","overseasMedium":0.2,"dateCreated":"2023-04-04T07:15:47Z","createdBy":"17696","id":86857,"overseasSmall":0.2,"class":"com.globaltix.api.v1.DistributionMarkedUp","ota":0.2,"domesticSmall":0.2}}},{"id":179973,"hasSeries":false,"name":"Wings of Time – Premium (Open Dated) (PER PAX)","currency":"SGD","favorited":false,"price":18.7,"variation":{"name":"SENIOR_CITIZEN","customName":"PER PAX"},"issuanceLimit":null,"similarTicketId":null,"originalPrice":23.0,"settlementPrice":0.0,"merchantCurrency":"SGD","sourceName":"Mount Faber Leisure Group","sourceTitle":"Marketplace","ableToDistributeToGlobaltix":false,"from":null,"did":123182,"linkId":133939,"productGroupName":"Wings of Time – Premium (Open Dated)","similarTicket":null,"imagePath":null,"imagePathExt":"png","isVisitDateCompulsory":false,"description":"\nEffective from 3rd April 2023, Wings of Time will resume operations of two (2) daily shows, where the first show will be at 7:40pm and the second show at 8.40pm.\nPremium seating: Get the best views and comfort on individual back-rested seats.\nGates will open 15 minutes prior to the start of the show\n","termsAndConditions":"Guests aged 4 years old and above will require a ticket.Ticket is valid for 6 months.Non-refundable, cancellation and exchange are allowed once e-tickets are issued. This is a rain or shine event.Seat is based on first come first serve.","questions":[],"isOpenDated":true,"maximumPax":null,"minimumPax":null,"visitDate":{"class":"com.globaltix.api.v1.VisitDateSettings","id":124273,"advanceBookingDays":null,"advanceBookingHours":null,"advanceBookingMinutes":null,"isAdvanceBooking":false,"isRequestVisitDate":false,"isVisitDateCompulsory":false,"ticketTypeGroup":{"class":"com.globaltix.api.v1.TicketTypeGroup","id":133939}},"ticketTypeGroup":{"useSimpleDistribution":true,"questions":[],"variants":[{"variantName":"ADULT","ticketTypeId":179971,"originalPrice":0.0,"originalMerchantPrice":0.0,"settlementRate":null,"merchantSettlementRate":null},{"variantName":"CHILD","ticketTypeId":179972,"originalPrice":0.0,"originalMerchantPrice":0.0,"settlementRate":null,"merchantSettlementRate":null},{"variantName":"SENIOR_CITIZEN","ticketTypeId":179973,"originalPrice":23.0,"originalMerchantPrice":23.0,"settlementRate":null,"merchantSettlementRate":null}],"inclusionsList":[{"class":"com.globaltix.api.v1.Inclusions","id":537568,"createdBy":"470","dateCreated":"2023-04-03T07:12:44Z","isActive":true,"lastUpdated":"2023-05-18T05:59:40Z","lastUpdatedBy":"9415","placementOrder":0,"ticketTypeGroup":{"class":"com.globaltix.api.v1.TicketTypeGroup","id":133939},"value":"Premium Seat -Show Only (07:40pm / 08:40pm)"}],"merchantProductCode":null,"variation":{"name":"SENIOR_CITIZEN","customName":"PER PAX"},"demandType":"NON_PEAK","lastUpdated":"2023-05-18T06:04:42Z","isMerchantBarcodeOnly":false,"minimumPax":null,"barcodeBin":null,"customVariationName":"PER PAX","isCloudApi":false,"emailTrigger":1,"imagePathExt":"png","visitDate":{"isRequestVisitDate":false,"isVisitDateCompulsory":false,"isAdvanceBooking":false,"advanceBookingDays":null,"advanceBookingHours":null,"advanceBookingMinutes":null,"isOpenDated":true},"id":179973,"minimumSellingPrice":20.7,"ticketTypeFormat":"SEPARATEEMAIL","isAdvanceBooking":false,"lastUpdatedBy":"470","publishEnd":null,"isSeparateEmail":true,"redeemStart":null,"emailSendOutType":"SEPERATEEMAIL","customName":1,"howToUseList":[{"class":"com.globaltix.api.v1.HowToUse","id":433972,"isActive":true,"placementOrder":0,"ticketTypeGroup":{"class":"com.globaltix.api.v1.TicketTypeGroup","id":133939},"value":"The guest must reservation show date and time in https://reservation.mountfaberleisure.com/"},{"class":"com.globaltix.api.v1.HowToUse","id":433973,"isActive":true,"placementOrder":1,"ticketTypeGroup":{"class":"com.globaltix.api.v1.TicketTypeGroup","id":133939},"value":"Your booking is confirmed. Final Ticket will be sent to you separately. Please present either mobile or printed Final Ticket for redemption."}],"minimumMerchantSellingPrice":20.7,"merchantSettlementRate":null,"gtPackageOnlyPrice":null,"maximumPax":null,"cancellationNotesSettings":[{"id":455680,"isActive":false,"placementOrder":2,"value":"No Amendment on Visit Date"},{"id":455679,"isActive":true,"placementOrder":1,"value":"Non-Refundable & No Cancellation"},{"id":455681,"isActive":false,"placementOrder":3,"value":"Non-Refundable, Non-transferable & Non-Cancellable"}],"isPrintEntryTicket":false,"name":"Wings of Time – Premium (Open Dated) (PER PAX)","isAddOn":0,"changeStatus":null,"status":{"enumType":"gt.enumeration.Status","name":"PUBLISHED"},"cancellationPolicySettings":{"class":"com.globaltix.api.v1.CancellationPolicy","id":119758,"cancellationNotes":[{"class":"com.globaltix.api.v1.CancellationNotes","id":455680},{"class":"com.globaltix.api.v1.CancellationNotes","id":455679},{"class":"com.globaltix.api.v1.CancellationNotes","id":455681}],"createdBy":"470","dateCreated":"2023-04-04T07:12:44Z","isActive":false,"lastUpdated":"2023-05-18T06:04:42Z","lastUpdatedBy":"470","percentReturn":null,"refundDuration":null,"ticketTypeGroup":{"class":"com.globaltix.api.v1.TicketTypeGroup","id":133939}},"orderFulfillment":1,"originalPrice":23.0,"redeemEnd":null,"requireCustomerInfo":false,"applyCapacity":false,"description":"<ul>\n<li><span style=\"font-size: 12px;\">Effective from 3rd April 2023, Wings of Time will resume operations of two (2) daily shows, where the first show will be at 7:40pm and the second show at 8.40pm.<\u002fspan><\u002fli>\n<li><span style=\"font-size: 12px;\">Premium seating: Get the best views and comfort on individual back-rested seats.<\u002fspan><\u002fli>\n<li>Gates will open 15 minutes prior to the start of the show<\u002fli>\n<\u002ful>","settlementRate":18.7,"originalMerchantPrice":23.0,"termsAndConditions":"<ul><li><span style=\"font-size: 12px;\">Guests aged 4 years old and above will require a ticket.<\u002fspan><\u002fli><li><span style=\"background-color: transparent;\">Ticket is valid for 6 months.<\u002fspan><br><\u002fli><li><span style=\"font-size: 12px;\">Non-refundable, cancellation and exchange are allowed once e-tickets are issued. This is a rain or shine event.<\u002fspan><\u002fli><li><span style=\"font-size: 12px;\">Seat is based on first come first serve.<br><\u002fspan><\u002fli><\u002ful>","allowMultiEntry":false,"publishStart":"2023-04-04T00:00:00","isRequestVisitDate":false,"dateCreated":"2023-04-04T07:12:44Z","currency":"SGD","isVisitDateCompulsory":false,"owner":null,"definedDuration":30,"additionalRestriction":false,"showTypeName":true,"isPrintReceipt":false,"linkId":133939,"attraction":{"id":5369,"title":"Wings of Time","timezoneOffset":480,"merchantName":"Mount Faber Leisure Group","merchantId":30,"country":"Singapore","countryId":1},"createdBy":"470","unavailableDays":"","series":[],"advanceBookingDays":null,"ticketValidity":"Duration","SKU":"01CAB010020LS","distributionMarkedUp":{"lastUpdatedBy":"9415","product":{"id":179973,"class":"com.globaltix.api.v1.Product"},"domesticMedium":0.2,"domesticLarge":0.2,"overseasLarge":0.2,"markUpType":{"enumType":"gt.enumeration.MarkUpType","name":"FIXED"},"lastUpdated":"2023-05-18T05:11:16Z","overseasMedium":0.2,"dateCreated":"2023-04-04T07:13:48Z","createdBy":"17696","id":86856,"overseasSmall":0.2,"class":"com.globaltix.api.v1.DistributionMarkedUp","ota":0.2,"domesticSmall":0.2}}}],"error":null,"size":null,"success":true}';
		
	return $xml;
	
	}
	
		
}
?>
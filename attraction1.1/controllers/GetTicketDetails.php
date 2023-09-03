<?php
/**
	@File Name 		:	GetTicketDetails.php
	@Author 		:	Elavarasan	P
	@Date			:   11-07-2017
	@Description	:	GetTicketDetails service
*/
class GetTicketDetails extends Execute
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
		
	}
	
    public function _doGetTicketDetails()
	{
		
		$_Bstatus  = true;
		$_Smessage = '';
		$_Adata	   = array();
		$sellObj   						= controllerGet::getObject('GetSecurityToken',$this);
		$sellObj->_Ainput['action'] 	= 'GetSecurityToken';
		$_AgetTokenRes 					= $sellObj->_doGetSecurityToken();

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
			$_AgetTicketDetails = json_decode($_AsearchResult,true);
		}

		$_Areturn = $this->_getTicketDetails($_AgetTicketDetails, $this->_Ainput);
		return $_Areturn;
	}
	
	function _getTicketDetails($_Aresponse, $_AinputData)
	{
		
		
		$_ApiIdIs		= $this->_Oconf['site']['apiId'];
		$_AccountIdIs = $this->_Oconf['account']['users'][$this->_Ainput['userName']]['account_id'];
		
		$_AresponseArr = array();
		if($_Aresponse['success']==1 && !empty($_Aresponse['data'])){  
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
				
					$_SattractionTypeRestrictionArr 	= array();
					$resattrtype='';
					$impattrtypes=array();
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
				//echo $this->_Ainput['ticketTypeId'].'---'.$_AticketVal['id'];
				//print_r($impattrtypes);
				if($this->_Ainput['ticketTypeId']!=$_AticketVal['id']){
					continue;
				}
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
					$_AattractionVal['ticket_link_id'] 			= $_AticketVal['linkId'];
					$_AattractionVal['productGroupName'] 		= '';
					$_AattractionVal['unavailableDays'] = '';
					if(isset($_AticketVal['ticketTypeGroup'])){
						
						if(isset($_AticketVal['ticketTypeGroup']['unavailableDays'])){
							$_AattractionVal['unavailableDays']= $_AticketVal['ticketTypeGroup']['unavailableDays'];
						}
						
						if(isset($_AticketVal['ticketTypeGroup']['description'])){
							
							$_AattractionVal['description'] = $_AticketVal['ticketTypeGroup']['description'];
							$_AattractionVal['termsAndConditions'] = $_AticketVal['ticketTypeGroup']['termsAndConditions'];
							
							//$_AattractionVal['termsAndConditions'] = ' <br>'.str_replace("HOW TO REDEEM","<br><b>HOW TO REDEEM</b>",$_AattractionVal['description']); 
							
							$_AattractionVal['termsAndConditions'] = $_AattractionVal['description']."<br>".$_AattractionVal['termsAndConditions'];
						}
						
					} 
					$_AattractionVal['PaxType'] = $_AticketVal['variation']['name']; 
					
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
							$_AmergeArray = $_AattractionVal;
						}
						
						
					}

				   }
				}
				
				//echo "<pre>";print_r($_AmergeArray);
		//echo "<pre>";print_r($_AattractionVal);
				/* $_AresponseArr[$_AattractionKey]['ticketTypes'] 		= $_AmergeArray;
				$_AresponseArr[$_AattractionKey]['attractionId'] 		= $this->_Ainput['attractionId']; 
				$_AresponseArr[$_AattractionKey]['attractionID'] 		= $this->_Ainput['attractionId'];   */
				
			}
			//$_AresponseArr[$_AattractionKey]['GetAttractionInfo'] 		= $_AGetAttractionInfoResArr;
			
			
			$_AresponseArrNew['ticketDetails']  = $_AmergeArray;
			
			$_AattractionDisplay = true;
			$_ArestrictAttractionIds =array();
			//$_AresponseArrNew =array();
			

		return array("status"=>true, "msg"=>"GetAttractionList", "data"=>$_AresponseArrNew);
		}
		else{
			return array("status"=>false, "msg"=>"No GetAttractionList  ", "data"=>'');
		}
		
		/* $_AresponseArr = array();
		if($_Aresponse['success']==1){
			
			$_Smarkup_fee 		= $this->userInfo['markup_fee'];				//2;
			$_Smarkup_type 		= $this->userInfo['markup_type'];				//'percentage';
			$_Smarkup_source 	= $this->userInfo['markup_source'];				// This is for future use
			$_Smarkup_added 	= 'tax';										//base_fare, tax, 
			
			$_SreqCurrencyRate 	= $this->_getCurrencyRate($this->_Ainput['currencyCode']);
			$_Sconvertion_rate	= $_SreqCurrencyRate['value'];
			if($_Sconvertion_rate=='')
				$_Sconvertion_rate=1;
			
			$_AresponseArr['attractionID'] 		= $this->_Ainput['attractionId'];
			$_AresponseArr['attractionName'] 	= $_Aresponse['data']['attraction']['title'];
			$_AresponseArr['ticketTypeID'] 		= $this->_Ainput['ticketTypeId'];
			$_AresponseArr['ticketTypeName'] 	= $_Aresponse['data']['name'];
			$_AresponseArr['ticketDescription'] = $_Aresponse['data']['description'].' '.$_Aresponse['data']['']['description'];
			$_AresponseArr['originalPrice'] 	= $_Aresponse['data']['originalPrice'];
			$_AresponseArr['settlementRate'] 	= $_Aresponse['data']['settlementRate'];
			$_AresponseArr['payableAmount'] 	= $_Aresponse['data']['payableAmount'];
			$_AresponseArr['currency'] 			= $_Aresponse['data']['currency'];
			$_AresponseArr['PaxType'] 			= $_Aresponse['data']['variation']['name'];

			$_AOriginalPrice 		= round(($_Aresponse['data']['originalPrice']*$_Sconvertion_rate),3);
			$_AsettlePrice 			= round(($_Aresponse['data']['settlementRate']*$_Sconvertion_rate),3);
			
			$_SmarkupPrice=0;
			if($_Smarkup_type=='percentage')
			{
				$_SmarkupPrice = round(((@$_AsettlePrice*$_Smarkup_fee)/100),3);
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
			$_AsettlePrice+=$_SmarkupPrice;
			
			$_AresponseArr['req_originalPrice'] 	= $_AOriginalPrice;
			$_AresponseArr['req_settlementPrice'] 	= $_AsettlePrice;
			$_AresponseArr['req_currency'] 			= $this->_Ainput['currencyCode'];
			$_AresponseArr['markupFare'] 			= $_SmarkupPrice.' '.$_Smarkup_type;
			$_AresponseArr['ticketDetails'] 		= $_Aresponse['data'];
			
			if($_AresponseArr['ticketDetails']['similarTicket']['description']){
				
				$_AresponseArr['ticketDetails']['termsAndConditions'] .= ' <br>'.str_replace("HOW TO REDEEM","<br><b>HOW TO REDEEM</b>",$_AresponseArr['ticketDetails']['similarTicket']['description']);
			}else{
					$_AresponseArr['ticketDetails']['termsAndConditions'] .= ' <br>'.str_replace("HOW TO REDEEM","<br><b>HOW TO REDEEM</b>",$_AresponseArr['ticketDetails']['description']); 
			}
					
			$_AresponseArr['ticketDetails']['termsAndConditions'] = "".$_AresponseArr['ticketDetails']['termsAndConditions'];
			
				
			
			
			$_Aone  	= array("(1.)","1.");
			$_Atwo  	= array("(2.)","2.");
			$_Athree  	= array("(3.)","3.");
			$_Afour  	= array("(4.)","4.");
			$_Afive  	= array("(5.)","5.");
			$_AoperatingHours 	= array("Operating Hours");
						
			$_AresponseArr['ticketDetails']['termsAndConditions'] = str_replace("How to redeem","<b>How to redeem</b>",$_AresponseArr['ticketDetails']['termsAndConditions']); 
			$_AresponseArr['ticketDetails']['termsAndConditions'] = str_replace("How To Get There","<b>How To Get There</b>",$_AresponseArr['ticketDetails']['termsAndConditions']); 
			$_AresponseArr['ticketDetails']['termsAndConditions'] = str_replace("INCLUDES","<b>INCLUDES</b>",$_AresponseArr['ticketDetails']['termsAndConditions']); 
			$_AresponseArr['ticketDetails']['termsAndConditions'] = str_replace("Redemption Procedure","<b>Redemption Procedure</b>",$_AresponseArr['ticketDetails']['termsAndConditions']); 
			
			
		}else
		{
			return array("status"=>false, "msg"=>"Get Ticket Details Error", "data"=>'');
		}
		
		return array("status"=>true, "msg"=>"GetTicketDetails", "data"=>$_AresponseArr); */
	}
	
	/**		Via Flight Segment Details		**/
	function _getCurrencyRate($_SreqCurrency)
	{
		$sql = "select value from `currency_converter`  where country='".$_SreqCurrency."' ";
		$data = $this->_Odb->getAll($sql);
		return $data[0];

	}
	function fun1()
	{
		$xml = '{"data":{"useSimpleDistribution":null,"questions":[],"inclusionsList":[{"class":"com.globaltix.api.v1.Inclusions","id":9072,"createdBy":"6907","dateCreated":"2019-02-14T08:50:35Z","isActive":false,"lastUpdated":"2019-02-14T08:50:35Z","lastUpdatedBy":null,"placementOrder":1,"ticketTypeGroup":{"class":"com.globaltix.api.v1.TicketTypeGroup","id":16318},"value":"1 Standard Admission Ticket"}],"merchantProductCode":null,"variation":{"enumType":"gt.enumeration.Variation","name":"ADULT"},"lastUpdated":"2019-02-14T08:50:35Z","isMerchantBarcodeOnly":false,"minimumPax":null,"barcodeBin":null,"emailTrigger":1,"visitDate":{"isRequestVisitDate":true,"isVisitDateCompulsory":true,"isAdvanceBooking":null,"advanceBookingDays":null},"id":20124,"minimumSellingPrice":null,"ticketTypeFormat":"SEPARATEEMAIL","lastUpdatedBy":"6907","isOpenDated":false,"publishEnd":null,"isSeparateEmail":true,"redeemStart":null,"emailSendOutType":"SEPERATEEMAIL","customName":1,"howToUseList":[{"class":"com.globaltix.api.v1.HowToUse","id":10857,"isActive":false,"placementOrder":2,"ticketTypeGroup":{"class":"com.globaltix.api.v1.TicketTypeGroup","id":16318},"value":"Please meet at the pick-up location."},{"class":"com.globaltix.api.v1.HowToUse","id":10858,"isActive":false,"placementOrder":3,"ticketTypeGroup":{"class":"com.globaltix.api.v1.TicketTypeGroup","id":16318},"value":"Voucher must be printed out."},{"class":"com.globaltix.api.v1.HowToUse","id":10856,"isActive":false,"placementOrder":1,"ticketTypeGroup":{"class":"com.globaltix.api.v1.TicketTypeGroup","id":16318},"value":"Please present either mobile or printed voucher for entry."}],"payableToMerchant":0,"merchantSettlementRate":null,"gtPackageOnlyPrice":null,"maximumPax":null,"cancellationNotesSettings":[{"id":3946,"isActive":false,"placementOrder":1,"value":"Non-Refundable & No Cancellation"}],"simpleDistributionSpecialPrices":[],"name":"Wings of Time 7.40 PM Standard Seat (Fixed Date)","isAddOn":0,"changeStatus":null,"status":{"enumType":"gt.enumeration.Status","name":"PUBLISHED"},"cancellationPolicySettings":{"class":"com.globaltix.api.v1.CancellationPolicy","id":3684,"cancellationNotes":[{"class":"com.globaltix.api.v1.CancellationNotes","id":3946}],"createdBy":"6907","dateCreated":"2019-02-14T08:50:35Z","isActive":false,"lastUpdated":"2019-02-14T08:50:35Z","lastUpdatedBy":"6907","percentReturn":100.0,"refundDuration":100,"ticketTypeGroup":{"class":"com.globaltix.api.v1.TicketTypeGroup","id":16318}},"orderFulfillment":0,"originalPrice":18.0,"redeemEnd":null,"applyCapacity":false,"description":"Your booking is confirmed and your ticket will be sent to you within 2 hours.\n\nYou may secure your booking up to 40 days in advance.","settlementRate":9.5,"payableAmount":9.5,"termsAndConditions":"Non-refundable & non-cancellation","publishStart":"2018-03-23T00:00:00","dateCreated":"2018-03-23T09:16:32Z","currency":"SGD","owner":null,"definedDuration":90,"showTypeName":null,"simpleDistribution":null,"linkId":16318,"attraction":{"id":6840,"title":"Wings of Time","timezoneOffset":480,"merchantName":"Wings of Time"},"createdBy":"5316","series":[],"SKU":"01WOT0100000A","did":29500602},"error":null,"size":null,"success":true}';
		
	return $xml;
	
	}
	
		
}
?>
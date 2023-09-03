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
		$_AresponseArr = array();
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
			$_AresponseArr['ticketDescription'] = $_Aresponse['data']['description'];
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
			
		}else
		{
			return array("status"=>false, "msg"=>"Get Ticket Details Error", "data"=>'');
		}
		
		return array("status"=>true, "msg"=>"GetTicketDetails", "data"=>$_AresponseArr);
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
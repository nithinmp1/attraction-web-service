<?php
/**
	@File Name 		:	PaymentTransaction.php
	@Author 		:	Elavarasan	P
	@Date			:   11-07-2017
	@Description	:	PaymentTransaction service
*/
class PaymentTransaction extends Execute
{
	public $paymentAgentName 	= "";
	public $paymentAgentEmail 	= "";
	function __construct(){
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
		$this->paymentAgentName 	= $this->_Oconf['api']['payments'][$this->_Ainput['mode']]['agentName'];
		$this->paymentAgentEmail 	= $this->_Oconf['api']['payments'][$this->_Ainput['mode']]['agentEmail'];
		$this->_SrequestUrl = $this->_Oconf['userSettings']['apiUrl']['attractionURL'];
		
		$this->_Ainput['apiCurrencyCode']='SGD';
		$this->_AbaseCurrency 	= $this->_Ainput['apiCurrencyCode'];
		$this->_AbaseConRate	= 1;
		$this->_AapiConRate		= 1;
		if($this->_Ainput['currencyCode']== '')
			$this->_Ainput['currencyCode']='SGD';
		
		$this->_TotalPax		= 0;
		if(isset($this->_Ainput['postData']) && !empty($this->_Ainput['postData'])){
			
			$_PostDataArray = json_decode($this->_Ainput['postData'], true);
			
			foreach($_PostDataArray['ticketTypes'] as $_ValIs){
				$this->_TotalPax += $_ValIs['quantity'];
			}
			$_PostDataArray["customerName"] = $this->paymentAgentName;
			$_PostDataArray["email"]		= $this->paymentAgentEmail;
			
			$this->_Ainput['postData'] = json_encode($_PostDataArray);
		}
		
	}
	
    public function _doPaymentTransaction()
	{
		
		$_Bstatus  = true;
		$_Smessage = '';
		$_Adata	   = array();
		
		$_BbalaceCheck = $this->_checkUserBalance($this->_Ainput['totalAmount'],$this->_Ainput['currencyCode']);
		
		if(!$_BbalaceCheck)
		{
				$_AreturnArray =	array
				(
					"status" => false,
					"msg"	 => "Insufficient balance",
					"data" 	 => array()
				);
				return $_AreturnArray;
		}
			
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
			$_ApaymentTransaction = json_decode($_AsearchResult,true);
		}

		$_Areturn = $this->_paymentTransaction($_ApaymentTransaction, $this->_Ainput);
		return $_Areturn;
	}
	function _checkUserBalance($_IbookingAmount,$_SbookingCurrency)
	{
		
		$sqlAccount = "SELECT
								(credit_limit + available_balance) as userBalance,
								currency
					   FROM
								account_details
					   WHERE
								account_id = '".$this->userInfo['account_id']."'
								LIMIT 1";
								
		$_Aresult = $this->_Odb->getAll($sqlAccount);
		
		if(isset($_Aresult[0]['userBalance']) && $_Aresult[0]['userBalance'] > 0){
			
			$_AbookingExchangeRate  = $this->_getCurrencyRate($_SbookingCurrency);
			$_IbookingBaseAmount	= ($_IbookingAmount/$_AbookingExchangeRate['value']);
			$_IbookingBaseAmount	= round($_IbookingBaseAmount,3);
			
			$_AuserExchangeRate		= $this->_getCurrencyRate($_Aresult[0]['currency']);
			$_IuserBaseAmount		= ($_Aresult[0]['userBalance']/$_AuserExchangeRate['value']);
			$_IuserBaseAmount		= round($_IuserBaseAmount,3);
			
			if($_IuserBaseAmount > $_IbookingBaseAmount){
				return true;
			}
		}
		
		return false;
	}
	function _paymentTransaction($_Aresponse, $_AinputData)
	{
		$_AresponseArr = array();
		if($_Aresponse['success']==1){
			
			$_Smarkup_fee 		= 0;				//2;
			$_Smarkup_type 		= "";				//'percentage';
			$_Smarkup_source 	= "";				// This is for future use 
			
			/* $_MarkupValues		= Common::getMarkup($_MarkupArray, $_AaccountId, $_AapiId, $_CountryIdIs, $_AticketVal['attraction']['id']);
			$_Smarkup_fee 		= $_MarkupValues['markup_amount'];
			$_Smarkup_type 		= $_MarkupValues['markup_fee_type'];	
			$_Smarkup_source 	= $_MarkupValues['markup_type']; */
				
			$_Smarkup_added 	= 'tax';										//base_fare, tax, 
			
			$_SreqCurrencyRate 	= $this->_getCurrencyRate($this->_Ainput['currencyCode']);
			$_Sconvertion_rate	= $_SreqCurrencyRate['value'];
			if($_Sconvertion_rate=='')
				$_Sconvertion_rate=1;
			
			$this->_storeBookingInfo($_Aresponse);
			
			$_AresultArr['reference_number']= $_Aresponse['data']['reference_number'];
			$_AresultArr['bookingId'] 		= $_Aresponse['data']['id'];
			$_AresultArr['bookingDate'] 	= $_Aresponse['data']['time'];
			$_AresultArr['customerName'] 	= $_Aresponse['data']['customerName'];
			$_AresultArr['customerEmail'] 	= $_Aresponse['data']['email'];
			$_AresultArr['paymentStatus'] 	= $_Aresponse['data']['paymentStatus']['name'];
			$_AresultArr['paymentMethod'] 	= $_Aresponse['data']['paymentMethod']['name'];
			$_AresultArr['resellerId']	 	= $_Aresponse['data']['reseller']['id'];
			$_AresultArr['resellerName']	= $_Aresponse['data']['reseller']['name'];
			$_AresultArr['apiCurrency']	 	= $_Aresponse['data']['currency'];
			
			
			if(isset($_Aresponse['data']['tickets']))
			{
				$_MarkupArray	 	= $this->userInfo['markupArr'];	
				$_CountryIdIs 		= $_Aresponse['data']['reseller']['country']['id'];
				$_AaccountId		= $this->userInfo['account_id'];
				$_AapiId 			= $this->_Oconf['site']['apiId'];
				$_AticketsArr = array();
				foreach($_Aresponse['data']['tickets'] as $_AticektKey => $_AticketVal)
				{
					$_MarkupValues		= Common::getMarkup($_MarkupArray, $_AaccountId, $_AapiId, $_CountryIdIs, $_AticketVal['attraction']['id']);
					$_Smarkup_fee 		= $_MarkupValues['markup_amount'];
					$_Smarkup_type 		= $_MarkupValues['markup_fee_type'];	
					$_Smarkup_source 	= $_MarkupValues['markup_type'];
					
					
					$_AbookingPrice 		= round(($_AticketVal['checkoutPrice']*$_Sconvertion_rate),3);
					//$_AsettlePrice 			= round(($_Aresponse['data']['settlementRate']*$_Sconvertion_rate),3);
					
					$_SmarkupPrice=0;
					if($_Smarkup_type=='percentage')
					{
						$_SmarkupPrice = round(((@$_AbookingPrice*$_Smarkup_fee)/100),3);
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
					$_AbookingPrice+=$_SmarkupPrice;
					$_AticketsArr[$_AticektKey]['pnrID'] 				= $_AticketVal['id'];
					$_AticketsArr[$_AticektKey]['pnr'] 					= $_AticketVal['code'];
					$_AticketsArr[$_AticektKey]['paxType'] 				= $_AticketVal['variation']['name'];
					$_AticketsArr[$_AticektKey]['reqBookingPrice'] 		= $_AbookingPrice;
					$_AticketsArr[$_AticektKey]['markupFare'] 			= $_SmarkupPrice.' '.$_Smarkup_type;
					$_AticketsArr[$_AticektKey]['reqCurrency'] 			= $this->_Ainput['currencyCode'];	
					$_AticketsArr[$_AticektKey]['ticektId'] 			= $_AticketVal['product']['id'];
					$_AticketsArr[$_AticektKey]['ticektName'] 			= $_AticketVal['name'];	
					$_AticketsArr[$_AticektKey]['ticektDescription'] 	= $_AticketVal['description'];	
					$_AticketsArr[$_AticektKey]['attractionId'] 		= $_AticketVal['attraction']['id'];
					$_AticketsArr[$_AticektKey]['attractionName'] 		= $_AticketVal['attractionTitle'];					
					$_AticketsArr[$_AticektKey]['merchantId'] 			= $_AticketVal['merchant']['id'];
					$_AticketsArr[$_AticektKey]['merchantName'] 		= $_AticketVal['merchantName'];
					$_AticketsArr[$_AticektKey]['resellerName'] 		= $_AticketVal['resellerName'];
					$_AticketsArr[$_AticektKey]['redeemStart'] 			= $_AticketVal['redeemStart'];
					$_AticketsArr[$_AticektKey]['redeemEnd'] 			= $_AticketVal['redeemEnd'];
					$_AticketsArr[$_AticektKey]['quantityAvailable'] 	= $_AticketVal['quantity_available'];
					$_AticketsArr[$_AticektKey]['quantityTotal'] 		= $_AticketVal['quantity_total'];
					

					
					$_AticketsArr[$_AticektKey]['details'] 	= $_AticketVal;
					
					
					
				}
				$_AresultArr['tickets']=$_AticketsArr;
			}
			
			$_AresponseArr['bookingResponse'] 	= $_AresultArr;
			
		}else
		{
			return array("status"=>false, "msg"=>"Ticket Booking Error", "data"=>'');
		}
		
		return array("status"=>true, "msg"=>"Ticket Booking Response", "data"=>$_AresponseArr);
	}
	
	/**		Via Flight Segment Details		**/
	function _getCurrencyRate($_SreqCurrency)
	{
		$sql = "select value from `currency_converter`  where country='".$_SreqCurrency."' ";
		$data = $this->_Odb->getAll($sql);
		return $data[0];

	}
	function _storeBookingInfo($_AattractionRes)
	{
		
		/* $_Smarkup_fee 		= $this->userInfo['markup_fee'];		//2;
		$_Smarkup_type 		= $this->userInfo['markup_type'];		//'percentage' => TP, 'fixed' => TP/PP
		$_Smarkup_source 	= $this->userInfo['markup_source'];		// This is for future use  TP/PP */
		$_Smarkup_added 	= 'base_fare';
		
		$_Sconvertion_rate 	= $this->_getCurrencyRate($this->_Ainput['currencyCode']);
		$_Aconvertion_rate	= $_Sconvertion_rate['value'];
		if($_Aconvertion_rate=='')
			$_Aconvertion_rate=1;
		
		$_AcreditDebitCurrencyRateArr 	= $this->_getCurrencyRate($this->userInfo['currency']);
		$_AcreditDebitCurrencyRate  	= $_AcreditDebitCurrencyRateArr['value'];

		$_AapiId 		= $this->_Oconf['site']['apiId'];
		$_AaccountId	= $this->userInfo['account_id'];
		$_AtraceId 		= @$this->_Ainput['traceId'];
		
		$_AreqCurrency 	= @$this->_Ainput['currencyCode'];
		$_AreqMode 		= @$this->_Ainput['mode'];
		$_AapiProvider 	= 'Attraction';
		

		$_AreferenceNumber	= $_AattractionRes['data']['reference_number'];
		$_AbookingDate 		= $_AattractionRes['data']['time'];
		$_AbookingId 		= $_AattractionRes['data']['id'];
		$_AcustomerName 	= $_AattractionRes['data']['customerName'];
		$_AcustomerEmail 	= $_AattractionRes['data']['email'];
		$_AmobileNumber 	= $_AattractionRes['data']['mobileNumber'];
		$_AmobilePrefix 	= $_AattractionRes['data']['mobilePrefix'];
		$_ApassportNumber 	= $_AattractionRes['data']['passportNumber'];
		$_ApaymentStatus 	= $_AattractionRes['data']['paymentStatus']['name'];
		$_ApaymentMethod 	= $_AattractionRes['data']['paymentMethod']['name'];
		$_AresellerId	 	= $_AattractionRes['data']['reseller']['id'];
		$_AresellerName		= $_AattractionRes['data']['reseller']['name'];
		$_Acurrency	 		= $_AattractionRes['data']['currency'];
		
		/* customer info */
		
		$customer_name					= "";
		$customer_email					= "";
		$customer_mobile_number			= "";
		$customer_mobile_prefix			= ""; 
		$customer_address				= "";
		$customer_city					= "";
		$customer_postal_code			= "";
		$customer_state					= "";
		
		$_CustomerInfo					= $this->_Ainput['customer'];
		
		if(isset($_CustomerInfo) && !empty($_CustomerInfo)){
			$customer_name					= ( isset($_CustomerInfo['name']) && $_CustomerInfo['name']!="")?$_CustomerInfo['name']:"";
			$customer_email					= ( isset($_CustomerInfo['email']) && $_CustomerInfo['email']!="")?$_CustomerInfo['email']:"";
			$customer_mobile_number			= ( isset($_CustomerInfo['mobile']) && $_CustomerInfo['mobile']!="")?$_CustomerInfo['mobile']:"";
			$customer_mobile_prefix			= ( isset($_CustomerInfo['mobile_country_code']) && $_CustomerInfo['mobile_country_code']!="")?$_CustomerInfo['mobile_country_code']:"";
			$customer_address				= ( isset($_CustomerInfo['address']) && $_CustomerInfo['address']!="")?$_CustomerInfo['address']:"";
			$customer_city					= ( isset($_CustomerInfo['city']) && $_CustomerInfo['city']!="")?$_CustomerInfo['city']:"";
			$customer_postal_code			= ( isset($_CustomerInfo['postal_code']) && $_CustomerInfo['postal_code']!="")?$_CustomerInfo['postal_code']:"";
			$customer_state					= ( isset($_CustomerInfo['state']) && $_CustomerInfo['state']!="")?$_CustomerInfo['state']:"";
		}
		
		$_AreqCurrency 	= @$this->_Ainput['currencyCode'];
		$_AbaseCurrency = @$this->_AbaseCurrency;				//SGD
		$_AapiCurrency 	= @$_Acurrency;
		
		$_AreqConRate 	= @$_Aconvertion_rate;
		$_AbaseConRate 	= @$this->_AbaseConRate;				//SGD
		$_AapiConRate 	= @$this->_getCurrencyRate($_AapiCurrency);
		$_AapiConRate	= $_AapiConRate['value'];

		
		$_AreqDiscount 	= 0;
		$_AbaseDiscount = 0;									//SGD
		$_AapiDiscount	= 0;
		if(isset($_AattractionRes['data']['tickets']))
		{
			$_AticketsArr = array();
			$_AapiBaseFareTotal	= 0;
			$_AapiTaxFareTotal	= 0;
			$_AapiTotFareTotal	= 0;
			
			$_AreqBaseFareTotal	= 0;
			$_AapiBaseFareTotal	= 0;
			$_AbaseBaseFareTotal= 0;
			
			$_AreqTotFareTotal	= 0;
			$_SreqMarkupTot 	= 0;
			$_SbaseMarkupTot	= 0;
			$_AapiTotal			= 0;
			$_AmarkupInfo 		='';
			$_AbaseMarkup		='';
			$_AreqTax			='';
			$_AbaseTax			='';
			$_AapiTax			='';
			$_AreqOtherCharge	='';
			$_AbaseOtherCharge	='';
			$_AapiOtherCharge	='';
			$_ApaxFareArrSql	='';
			$_AbookingId='#FDRFD$#_booking';
			$_MarkupArray	 	= $this->userInfo['markupArr'];	
			
			$_CountryIdIs = $_AattractionRes['data']['reseller']['country']['id'];
			$_AreqTotFareRes = 0;
			foreach($_AattractionRes['data']['tickets'] as $_AticektKey => $_AticketVal)
			{
				$_AbookingPrice=0;
				$_SmarkupPrice=0;
				$_Smarkup_fee 		= 0;
				$_Smarkup_type 		= '';	
				$_Smarkup_source 	= '';
				
				$_MarkupValues		= Common::getMarkup($_MarkupArray, $_AaccountId, $_AapiId, $_CountryIdIs, $_AticketVal['attraction']['id']);
				$_Smarkup_fee 		= $_MarkupValues['markup_amount'];
				$_Smarkup_type 		= $_MarkupValues['markup_fee_type'];	
				$_Smarkup_source 	= $_MarkupValues['markup_type'];
				
				$_AapiConvertionPrice 	= $_AticketVal['checkoutPrice'];
				
				$_AbaseConvertionPrice	= round(($_AapiConvertionPrice/$_AapiConRate),3);       //SGD

				$_AreqConvertionPrice 	= round(($_AbaseConvertionPrice*$_Aconvertion_rate),3);
				
				if($_Smarkup_type=='percentage')
				{
					$_SmarkupPrice = round(((@$_AreqConvertionPrice*$_Smarkup_fee)/100),3);
					$_SbaseMarkupPrice = round(((@$_AbaseConvertionPrice*$_Smarkup_fee)/100),3);
				}
				else if($_Smarkup_type=='fixed')
				{
					if($_Smarkup_source=='TP'){
						//$_SmarkupPrice=0;
						$_SmarkupPrice 	= round(($_Smarkup_fee * $_Aconvertion_rate),3);
						$_SbaseMarkupPrice = round(($_Smarkup_fee * $_AbaseConRate),3);
					}else if($_Smarkup_source=='PP'){
						$_SmarkupPrice 	= round(( ($_Smarkup_fee * $this->_TotalPax) * $_Aconvertion_rate),3);
						$_SbaseMarkupPrice = round((($_Smarkup_fee * $this->_TotalPax) * $_AbaseConRate),3);
					}
				}
				
				$_AbookingPrice=$_AreqConvertionPrice+$_SmarkupPrice;
				
				$_ApnrID 				= $_AticketVal['id'];
				$_Apnr 					= $_AticketVal['code'];
				$paxType 				= $_AticketVal['variation']['name'];
				$_AreqBookingPrice 		= $_AbookingPrice;
				$_AmarkupFare 			= $_SmarkupPrice.' '.$_Smarkup_type;
				$_AreqCurrency 			= $this->_Ainput['currencyCode'];	
				$_AticektId 			= $_AticketVal['product']['id'];
				$_AticektName 			= $_AticketVal['name'];	
				$_AticektDescription 	= $_AticketVal['description'];	
				$_AattractionId 		= $_AticketVal['attraction']['id'];
				$_AattractionName 		= $_AticketVal['attractionTitle'];					
				$_AmerchantId 			= $_AticketVal['merchant']['id'];
				$_AmerchantName 		= $_AticketVal['merchantName'];
				$_AresellerName 		= $_AticketVal['resellerName'];
				$_AredeemStart 			= $_AticketVal['redeemStart'];
				$_AredeemEnd 			= $_AticketVal['redeemEnd'];
				$_AquantityAvailable 	= $_AticketVal['quantity_available'];
				$_AquantityTotal 		= $_AticketVal['quantity_total'];
				
				$_AapiBaseFare 		= ($_AapiConvertionPrice);
				$_AapiBaseFareTotal	+=$_AapiBaseFare;
				$_AapiTotFareTotal 	= $_AapiBaseFareTotal;

				$_AreqBaseFare 		= $_AreqConvertionPrice;
				$_AreqBaseFareTotal	+=$_AreqBaseFare;
				//$_AreqTotFareTotal 	= $_AreqBaseFareTotal;
				
				$_AreqTotFare 		= $_AbookingPrice;
				$_AreqTotFareRes	+=$_AreqTotFare;
				$_AreqTotFareTotal 	= $_AreqTotFareRes;
				
				//$_AbaseBaseFare 	= $_AbookingConvertionPrice;
				$_AbaseBaseFareTotal+=$_AbaseConvertionPrice;
				$_AbaseTotFareTotal = $_AbaseBaseFareTotal;
				
				$_AreqMarkup 	= @$_SmarkupPrice;
				$_AbaseMarkup 	= @$_SbaseMarkupPrice;						//SGD
				
				$_SreqMarkupTot	+=$_AreqMarkup;
				$_SbaseMarkupTot+=$_AbaseMarkup;
				
				if($paxType=='ADULT')
				{
					$_ApaxType = '1';
				}
				if($paxType=='CHILD')
				{
					$_ApaxType = '2';
				}
				if($_AticektKey>0)
				{
					$_ApaxFareArrSql.=",";
				}
						
				$_ApaxFareArrSql.='(NULL, 
					"'.$_AbookingId.'",
					"'.$_ApaxType.'",
					"'.$_ApnrID.'", 
					"'.$_Apnr.'",
					"'.$_AticektId.'",
					"'.$_AticektName.'",
					"'.$_AticektDescription.'", 
					"'.$_AattractionId.'",
					"'.$_AattractionName.'", 
					"'.$_AmerchantId.'",
					"'.$_AmerchantName.'",
					"'.$_AredeemStart.'",
					"'.$_AredeemEnd.'",
					"'.$_AquantityAvailable.'",
					"'.$_AquantityTotal.'",
					
					"'.$_AreqCurrency.'",
					 "'.$_AreqConRate.'",
					 "'.$_AreqMarkup.'",
					 "'.$_AmarkupInfo.'",
					 "'.$_AreqDiscount.'",
					 "'.$_AreqBaseFare.'",
					 "'.$_AreqTax.'",
					 "'.$_AreqOtherCharge.'",
					 "'.$_AbookingPrice.'",
					 
					 "'.$_AbaseCurrency.'",
					 "'.$_AbaseConRate.'",
					 "'.$_AbaseMarkup.'",
					 "'.$_AbaseDiscount.'",
					 "'.$_AbaseConvertionPrice.'",
					 "'.$_AbaseTax.'",
					 "'.$_AbaseOtherCharge.'",
					 "'.$_AbaseConvertionPrice.'",
					 
					 "'.$_AapiCurrency.'",
					 "'.$_AapiConRate.'",
					 "'.$_AapiBaseFare.'",
					 "'.$_AapiTax.'",
					 "'.$_AreqOtherCharge.'",
					 "'.$_AapiBaseFare.'",
					 1)';
				
			}
			$_AmarkupInfo	='';
			$_AreqTax		='';
			$_AbaseTax		='';
			$_AbaseOtherCharge='';
			$_AapiOtherCharge='';
			$_AreqOtherCharge='';
			
			$_ScreditDebitCurrencyValue = round(($_AreqTotFareTotal * $_AcreditDebitCurrencyRate),3);//die;
						
			$sql = 'INSERT INTO `attraction_booking_details` 
					(`booking_details_id`, 
					`trace_id`, 
					`account_id`, 
					`api_id`, 
					`api_mode`, 
					`api_provider`, 
					`booking_pnr`, 
					`name`, 
					`email`, 
					`mobile_number`, 
					`mobile_prefix`, 
					`address`, 
					`city`, 
					`postal_code`, 
					`state`, 
					`passportNumber`, 
					`payment_status`, 
					`payment_method`, 
					`reseller_id`, 
					`reseller_name`, 
					`currency`, 
					`exchange_rate`, 
					`markup`, 
					`markup_info`, 
					`discount`, 
					`base_fare`, 
					`tax`, 
					`other_charges`, 
					`total_fare`, 
					`default_currency`, 
					`default_exchange_rate`, 
					`default_markup`, 
					`default_discount`, 
					`default_base_fare`, 
					`default_tax`, 
					`default_other_charges`, 
					`default_total_fare`, 
					`api_currency`, 
					`api_exchange_rate`, 
					`api_base_fare`, 
					`api_tax`, 
					`api_other_charges`, 
					`api_total_fare`, 
					`payment_agent_name`,
					`payment_agent_email`,
					`created_date`, 
					`last_updated_date`
					) 
					
 						
		
				VALUES (NULL, 
					 "'.$_AtraceId.'",
					 "'.$_AaccountId.'",
					 "'.$_AapiId.'",
					 "'.$_AreqMode.'",
					 "'.$_AapiProvider.'",
					 "'.$_AreferenceNumber.'",
					 					 
					 "'.$customer_name.'",
					 "'.$customer_email.'",
					 "'.$customer_mobile_number.'",
					 "'.$customer_mobile_prefix.'",
					 "'.$customer_address.'",
					 "'.$customer_city.'",
					 "'.$customer_postal_code.'",
					 "'.$customer_state.'",
					 
					 "'.$_ApassportNumber.'",
					 "'.$_ApaymentStatus.'",
					 "'.$_ApaymentMethod.'",
					 "'.$_AresellerId.'",
					 "'.$_AresellerName.'",

					 "'.$_AreqCurrency.'",
					 "'.$_AreqConRate.'",
					 "'.$_SreqMarkupTot.'",
					 "'.$_AmarkupInfo.'",
					 "'.$_AreqDiscount.'",
					 "'.$_AreqBaseFareTotal.'",
					 "'.$_AreqTax.'",
					 "'.$_AreqOtherCharge.'",
					 "'.$_AreqTotFareTotal.'",
					 
					 "'.$_AbaseCurrency.'",
					 "'.$_AbaseConRate.'",
					 "'.$_SbaseMarkupTot.'",
					 "'.$_AbaseDiscount.'",
					 "'.$_AbaseBaseFareTotal.'",
					 "'.$_AbaseTax.'",
					 "'.$_AbaseOtherCharge.'",
					 "'.$_AbaseTotFareTotal.'",
					 
					 "'.$_AapiCurrency.'",
					 "'.$_AapiConRate.'",
					 "'.$_AapiBaseFareTotal.'",
					 "'.$_AapiTax.'",
					 "'.$_AreqOtherCharge.'",
					 "'.$_AapiTotFareTotal.'",
					 "'.$this->paymentAgentName.'",
					 "'.$this->paymentAgentEmail.'",
					 now(),
					 now())';
					 
			$queryArr['id'] = 'booking_details_id';
			$queryArr['table'] = 'attraction_booking_details';
			$_AbookingId = $this->_Odb->query($sql,$queryArr);
			$_AmodeOfPayment	= "Attraction booking charge (".$_AreqMode.")";
			
			
			$_ScreditDepitSql = "INSERT INTO `account_credit_debit` (
			`account_credit_debit_id`, 
			`account_id`, 
			`booking_id`, 
			`trancation_amount`, 
			`transaction_type`, 
			`mode_of_payment`, 
			`mode`, 
			`credit_debit_date`, 
			`transaction_ref_no`, 
			`credit_debit_status`, 
			`transaction_currency`, 
			`exchange_rate`, 
			`created_date`, 
			`last_updated_by`, 
			`last_update_date`) 
		VALUES (
			NULL, 
			'".$_AaccountId."',
			'".$_AbookingId."',
			'".$_ScreditDebitCurrencyValue."', 
			'debit', 
			'attractionBooking', 
			'".$_AmodeOfPayment."',
			now(), 
			'".$_AreferenceNumber."', 
			'1', 
			'".$this->userInfo['currency']."', 
			'".$_AcreditDebitCurrencyRate."', 
			now(), 
			'1', 
			now())";
		
		$queryArr['id'] 	= 'account_credit_debit_id';
		$queryArr['table'] 	= 'account_credit_debit';
		$_BaccountCreditDebitId = $this->_Odb->query($_ScreditDepitSql,$queryArr);

		$_BupdateAvailBalSql = "UPDATE `account_details` SET `available_balance` = `available_balance`-".$_ScreditDebitCurrencyValue.", last_updated_date=now() WHERE `account_id` = '".$this->userInfo['account_id']."' "; 
		$queryArr='';
		
		$_BavailBalanceId = $this->_Odb->query($_BupdateAvailBalSql,$queryArr);
		
			
			$_ApassSql = 'INSERT INTO `attraction_passenger_details` 
						(`passenger_details_id`, 
						`booking_details_id`, 
						`pax_type`, 
						`ticket_number`, 
						`pnr`, 
						`ticket_id`, 
						`ticket_name`, `ticket_description`, `attraction_id`, `attraction_name`, `merchant_id`, `merchant_name`, `redeem_start`, `redeem_end`, `quantity_available`, `quantity_total`, `currency`, `exchange_rate`, `markup`, `markup_info`, `discount`, `base_fare`, `tax`, `other_charges`, `total_fare`, `default_currency`, `default_exchange_rate`, `default_markup`, `default_discount`, `default_base_fare`, `default_tax`, `default_other_charges`, `default_total_fare`, `api_currency`, `api_exchange_rate`, `api_base_fare`, `api_tax`, `api_other_charges`, `api_total_fare`, `status`)
						
					VALUES '.str_replace("#FDRFD$#_booking",$_AbookingId,$_ApaxFareArrSql);
					$queryArr['id'] = 'passenger_details_id';
					$queryArr['table'] = 'attraction_passenger_details';
					$passenger_details_id = $this->_Odb->query($_ApassSql,$queryArr);
					
					
				
		}
	}
	function fun1()
	{
		$xml = '{
  "data":{
    "id":16387,
    "time":"2017-07-12T11:54:58Z",
    "currency":"USD",
    "creditCardCurrency":null,
    "creditCardAmount":null,
    "amount":0.44,
    "reference_number":"BI302DKB",
    "alternateEmail":null,
    "email":"elavarasan@dss.com.sg",
    "customerName":"elavarasan",
    "groupBooking":false,
    "groupName":null,
    "groupNoOfMember":0,
    "isSingleCodeForGroup":false,
    "mobileNumber":null,
    "mobilePrefix":null,
    "passportNumber":null,
    "paymentStatus":{
      "enumType":"gt.enumeration.PaymentStatus",
      "name":"PAID"
    },
    "paymentMethod":{
      "enumType":"gt.enumeration.PaymentMethod",
      "name":"CREDIT"
    },
    "remarks":null,
    "reseller":{
      "class":"com.globaltix.api.v1.Reseller",
      "id":49,
      "code":"RED",
      "commissionBasedAgent":null,
      "country":{
        "class":"com.globaltix.api.v1.Country",
        "id":1
      },
      "createBy":{
        "class":"com.globaltix.api.v1.User",
        "id":124
      },
      "createdBy":null,
      "credit":{
        "class":"com.globaltix.api.v1.Credit",
        "id":49
      },
      "creditCardPaymentOnly":false,
      "customEmailAPI":null,
      "customEmailFilename":"uat_reseller_demo1.gsp",
      "customEmailType":{
        "enumType":"gt.enumeration.CustomEmailType",
        "name":"EMAIL_TEMPLATE"
      },
      "dateCreated":"2016-04-25T14:37:11Z",
      "emailConfig":{
        "class":"com.globaltix.api.v1.EmailConfig",
        "id":13
      },
      "hasBeenNotifiedLowCreditLimit":false,
      "internalEmail":"emmanuel@globaltix.com",
      "isMerchantBarcodeOnly":true,
      "isSubAgentOnly":false,
      "lastUpdated":"2017-07-05T10:30:17Z",
      "lastUpdatedBy":"116",
      "lowCreditLimit":1500.0,
      "mobileNumber":"546546",
      "name":"Reseller Demo",
      "notifyLowCredit":true,
      "notifyLowCreditEmail":"emmanuel@globaltix.com",
      "onlineStore":{
        "class":"com.globaltix.api.v1.Reseller",
        "id":2162
      },
      "ownMerchant":{
        "class":"com.globaltix.api.v1.Merchant",
        "id":126
      },
      "presetGroups":[
        {
          "class":"com.globaltix.api.v1.PresetGroup",
          "id":9
        }
      ],
      "primaryPresetGroup":{
        "class":"com.globaltix.api.v1.PresetGroup",
        "id":9
      },
      "sendCustomEmail":false,
      "size":{
        "enumType":"gt.enumeration.Size",
        "name":"Small"
      },
      "status":{
        "enumType":"gt.enumeration.Status",
        "name":"PUBLISHED"
      },
      "subAgentGroups":[
        {
          "class":"com.globaltix.api.v1.SubAgentGroup",
          "id":196
        },
        {
          "class":"com.globaltix.api.v1.SubAgentGroup",
          "id":195
        },
        {
          "class":"com.globaltix.api.v1.SubAgentGroup",
          "id":194
        },
        {
          "class":"com.globaltix.api.v1.SubAgentGroup",
          "id":193
        }
      ],
      "transactionFee":0.22
    },
    "tickets":[
      {
        "id":72926,
        "code":"1WVIVU",
        "redeemed":false,
        "termsAndConditions":"Nam in nisl consequat, aliquet nunc luctus, ultrices neque. Vivamus aliquam diam mattis euismod vulputate. Praesent vulputate risus mauris, vel congue ex sollicitudin vitae. Vivamus consectetur enim arcu, ultricies sagittis mauris convallis eu. Duis at eros metus. In non tristique ligula.",
        "name":"Demo Ticket (Direct Entry - SF)",
        "reseller":49,
        "description":"Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam eget ante nec magna aliquam commodo vulputate at lacus. Donec vel arcu ultrices quam semper pretium. Integer sed ante eget orci semper accumsan in sit amet enim. Nulla facilisi. Suspendisse gravida sapien lorem, quis viverra elit molestie quis.",
        "isOpenDated":null,
        "variation":{
          "enumType":"gt.enumeration.Variation",
          "name":"ADULT"
        },
        "attractionTitle":"Demo Attraction",
        "attraction":{
          "id":113
        },
        "sellingPrice":null,
        "paidAmount":0.22,
        "checkoutPrice":25.22,
        "product":{
          "id":590,
          "hasSeries":false,
          "publishStart":"2017-03-15T16:00:00Z",
          "publishEnd":null
        },
        "qrcode":"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\n2+BcWp/7fHUAAAAASUVORK5CYII=",
        "eventTime":null,
        "type":{
          "enumType":"gt.enumeration.IssuedTicketType",
          "name":"TICKETTYPE"
        },
        "choicesLeft":null,
        "choicesTotal":null,
        "isChoicePass":null,
        "validityPeriod":null,
        "distributedByGlobaltix":false,
        "isTimePass":null,
        "definedDuration":89,
        "redeemStart":"2017-07-12T19:54:58",
        "redeemEnd":"2017-10-09T19:54:58",
        "level":1,
        "quantity_total":1,
        "quantity_available":0,
        "status":{
          "enumType":"gt.enumeration.IssuedTicketStatus",
          "name":"REDEEMED"
        },
        "displayStatus":{
          "enumType":"gt.enumeration.IssuedTicketStatus",
          "name":"REDEEMED"
        },
        "parent":null,
        "transaction":{
          "id":16387,
          "referenceNumber":"BI302DKB",
          "time":"2017-07-12T11:54:58Z"
        },
        "fromReseller":{
          "id":null,
          "name":null
        },
        "r1":{
          "id":null,
          "name":null
        },
        "merchantName":"Merchant Demo",
        "merchant":{
          "id":34,
          "name":"Merchant Demo"
        },
        "questions":"",
        "answers":"",
        "resellerName":"Reseller Demo",
        "subAgentName":null,
        "customerName":"elavarasan",
        "customerEmail":"elavarasan@dss.com.sg",
        "customerMobileNumber":null,
        "dateIssued":"2017-07-12T11:54:58Z",
        "lastUpdated":"2017-07-12T11:54:58Z",
        "dateRedeemed":"2017-07-12T11:54:58Z",
        "useBin":null,
        "redemptions":[
          {
            "id":3608,
            "time":"2017-07-12T11:54:58Z",
            "code":"1WVIVU",
            "quantity":1,
            "ticket":{
              "_ref":"../../../..",
              "class":"com.globaltix.api.v1.Ticket"
            },
            "remark":null,
            "operator":{
              "id":125,
              "firstname":"Merchant",
              "lastname":"Demo",
              "username":"merchant@globaltix.com",
              "merchant":{
                "class":"com.globaltix.api.v1.Merchant",
                "id":34,
                "GTA":true,
                "code":"MER",
                "companyName":"Merchant Demo",
                "contactPerson":"Emmanuel",
                "country":{
                  "class":"com.globaltix.api.v1.Country",
                  "id":1
                },
                "createBy":{
                  "class":"com.globaltix.api.v1.User",
                  "id":125
                },
                "createdBy":null,
                "dailyRedemptionCount":0,
                "dateCreated":"2016-04-25T14:42:13Z",
                "internalEmail":"emmanuel@globaltix.com",
                "isCreatedByReseller":null,
                "isPasswordReprint":false,
                "lastUpdated":"2017-05-26T08:11:40Z",
                "lastUpdatedBy":"1",
                "mobileNumber":"123456789",
                "ownReseller":null,
                "size":{
                  "enumType":"gt.enumeration.Size",
                  "name":"Small"
                },
                "status":{
                  "enumType":"gt.enumeration.Status",
                  "name":"PUBLISHED"
                },
                "transactionFee":null
              },
              "reseller":null,
              "backoffice":null,
              "currency":{
                "code":"USD",
                "description":"Singapore Dollar",
                "markup":0.00,
                "roundingUp":0.01,
                "creditCardFee":3.00
              },
              "isProxyUser":false,
              "GTA":true
            },
            "barcode":{
              "id":8111,
              "code":"DemoTicket(DE-SF)_100054",
              "start":"2017-03-14T16:00:00Z",
              "end":"2017-10-15T16:00:00Z",
              "bin":{
                "id":56,
                "left":46,
                "attraction":{
                  "id":113
                },
                "name":"Demo Attraction - SF",
                "sku":"DEMOSF001",
                "skipBarcodes":false,
                "format":"EAN_128",
                "termsAndConditions":"Tnc",
                "barcodesLimitNotification":0,
                "emails":[
                  "emmanuel@globaltix.com"
                ],
                "validityPeriodType":{
                  "enumType":"gt.enumeration.PrintTicketValidityPeriodType",
                  "name":"HIDE"
                },
                "validityPeriodText":null,
                "validFor":"Valid for single entry",
                "additionalInfos":[
                  {
                    "class":"com.globaltix.api.v1.BarcodeBinAdditionalInfo",
                    "id":125,
                    "label":null,
                    "remark":null
                  }
                ],
                "barcodeOutputType":{
                  "enumType":"gt.enumeration.BarcodeOutputType",
                  "name":"SUPPLIER_FILE"
                },
                "templateFilename":null
              },
              "used":true
            }
          }
        ],
        "promoCode":null,
        "dateRevoked":null,
        "country":null,
        "city":null
      },
      {
        "id":72927,
        "code":"CGRUIG",
        "redeemed":false,
        "termsAndConditions":"valid for one adult",
        "name":"Standard Admission",
        "reseller":49,
        "description":"Valid for one person",
        "isOpenDated":false,
        "variation":{
          "enumType":"gt.enumeration.Variation",
          "name":"ADULT"
        },
        "attractionTitle":"Demo Attraction",
        "attraction":{
          "id":113
        },
        "sellingPrice":null,
        "paidAmount":0.22,
        "checkoutPrice":25.22,
        "product":{
          "id":123,
          "hasSeries":false,
          "publishStart":"2016-04-24T16:00:00Z",
          "publishEnd":null
        },
        "qrcode":"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",
        "eventTime":null,
        "type":{
          "enumType":"gt.enumeration.IssuedTicketType",
          "name":"TICKETTYPE"
        },
        "choicesLeft":null,
        "choicesTotal":null,
        "isChoicePass":null,
        "validityPeriod":null,
        "distributedByGlobaltix":false,
        "isTimePass":null,
        "definedDuration":200,
        "redeemStart":"2017-07-12T19:54:58",
        "redeemEnd":"2018-01-28T19:54:58",
        "level":1,
        "quantity_total":1,
        "quantity_available":1,
        "status":{
          "enumType":"gt.enumeration.IssuedTicketStatus",
          "name":"VALID"
        },
        "displayStatus":{
          "enumType":"gt.enumeration.IssuedTicketStatus",
          "name":"VALID"
        },
        "parent":null,
        "transaction":{
          "id":16387,
          "referenceNumber":"BI302DKB",
          "time":"2017-07-12T11:54:58Z"
        },
        "fromReseller":{
          "id":null,
          "name":null
        },
        "r1":{
          "id":null,
          "name":null
        },
        "merchantName":"Merchant Demo",
        "merchant":{
          "id":34,
          "name":"Merchant Demo"
        },
        "questions":"",
        "answers":"",
        "resellerName":"Reseller Demo",
        "subAgentName":null,
        "customerName":"elavarasan",
        "customerEmail":"elavarasan@dss.com.sg",
        "customerMobileNumber":null,
        "dateIssued":"2017-07-12T11:54:58Z",
        "lastUpdated":"2017-07-12T11:54:58Z",
        "dateRedeemed":null,
        "useBin":null,
        "redemptions":null,
        "promoCode":null,
        "dateRevoked":null,
        "country":null,
        "city":null
      }
    ]
  },
  "error":null,
  "size":null,
  "success":true
}';
		
	return $xml;
	
	}
	
		
}
?>
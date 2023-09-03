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
		
		
		
		if(isset($this->_Ainput['customer']) && !empty($this->_Ainput['customer'])){
			
			$_CustomerInfo					= $this->_Ainput['customer'];
			
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
				$paxType 				= $_AticketVal['variation']['name'];
				$_AquantityTotal 		= $_AticketVal['quantity_total'];
				$_AbookingPrice=0;
				$_SmarkupPrice=0;
				$_Smarkup_fee 		= 0;
				$_Smarkup_type 		= '';	
				$_Smarkup_source 	= '';
				
				$_MarkupValues		= Common::getMarkup($_MarkupArray, $_AaccountId, $_AapiId, $_CountryIdIs, $_AticketVal['attraction']['id']);
				$_Smarkup_fee 		= $_MarkupValues['markup_amount'];
				$_Smarkup_type 		= $_MarkupValues['markup_fee_type'];	
				$_Smarkup_source 	= $_MarkupValues['markup_type'];
				
				$_AapiConvertionPrice 	= round( ($_AticketVal['checkoutPrice'] * $_AquantityTotal), 3);
				$_AbaseConvertionPrice	= round( ( ( $_AapiConvertionPrice/$_AapiConRate ) ), 3);       //SGD
				$_AreqConvertionPrice 	= round( ( ( $_AbaseConvertionPrice*$_Aconvertion_rate ) ), 3);
				
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
						$_SmarkupPrice 	= round(( ($_Smarkup_fee * $_AquantityTotal) * $_Aconvertion_rate),3);
						$_SbaseMarkupPrice = round((($_Smarkup_fee * $_AquantityTotal) * $_AbaseConRate),3);
					}
				}
				
				$_AbookingPrice=$_AreqConvertionPrice+$_SmarkupPrice;
				
				$_ApnrID 				= $_AticketVal['id'];
				$_Apnr 					= $_AticketVal['code'];				
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
	function fun1(){
		$xml = '{"data":{"id":17094,"time":"2017-08-16T06:43:58Z","currency":"SGD","creditCardCurrency":null,"creditCardAmount":null,"amount":34.0,"reference_number":"L5UOI7QM","alternateEmail":null,"email":"test_@dss.com.sg","customerName":"Easwar Test","groupBooking":false,"groupName":null,"groupNoOfMember":0,"isSingleCodeForGroup":false,"mobileNumber":null,"mobilePrefix":null,"passportNumber":null,"paymentStatus":{"enumType":"gt.enumeration.PaymentStatus","name":"PAID"},"paymentMethod":{"enumType":"gt.enumeration.PaymentMethod","name":"CREDIT"},"remarks":null,"reseller":{"class":"com.globaltix.api.v1.Reseller","id":49,"code":"RED","commissionBasedAgent":null,"country":{"class":"com.globaltix.api.v1.Country","id":1},"createBy":{"class":"com.globaltix.api.v1.User","id":124},"createdBy":null,"credit":{"class":"com.globaltix.api.v1.Credit","id":49},"creditCardPaymentOnly":false,"customEmailAPI":null,"customEmailFilename":"uat_reseller_demo1.gsp","customEmailType":{"enumType":"gt.enumeration.CustomEmailType","name":"EMAIL_TEMPLATE"},"dateCreated":"2016-04-25T14:37:11Z","emailConfig":{"class":"com.globaltix.api.v1.EmailConfig","id":13},"hasBeenNotifiedLowCreditLimit":true,"internalEmail":"emmanuel@globaltix.com","isMerchantBarcodeOnly":true,"isSubAgentOnly":false,"lastUpdated":"2017-08-16T01:00:00Z","lastUpdatedBy":null,"lowCreditLimit":1500.0,"mobileNumber":"546546","name":"Reseller Demo","notifyLowCredit":true,"notifyLowCreditEmail":"emmanuel@globaltix.com","onlineStore":{"class":"com.globaltix.api.v1.Reseller","id":2162},"ownMerchant":{"class":"com.globaltix.api.v1.Merchant","id":126},"presetGroups":[{"class":"com.globaltix.api.v1.PresetGroup","id":9}],"primaryPresetGroup":{"class":"com.globaltix.api.v1.PresetGroup","id":9},"sendCustomEmail":false,"size":{"enumType":"gt.enumeration.Size","name":"Small"},"status":{"enumType":"gt.enumeration.Status","name":"PUBLISHED"},"subAgentGroups":[{"class":"com.globaltix.api.v1.SubAgentGroup","id":195},{"class":"com.globaltix.api.v1.SubAgentGroup","id":196},{"class":"com.globaltix.api.v1.SubAgentGroup","id":193},{"class":"com.globaltix.api.v1.SubAgentGroup","id":194}],"transactionFee":0.22},"tickets":[{"id":74280,"code":"SW4DJP","redeemed":false,"termsAndConditions":"Valid for adult admission","name":"Normal Admission","reseller":49,"description":"- This is not your ticket. Proceed to S.E.A. Aquarium Guest Services Window between 10.00am to 6.00pm to redeem for admission tickets. \n-Identification may be required during redemption. Corporate offers will require staff pass or student pass for verification.\n- Ticket has to be used on the date of redemption.\n- This voucher and/or the redeemed ticket(s)’ validity is three (3) months from the date of order. Strictly no extension allowed.\n- Redeemed tickets are valid for single-day use at S.E.A. Aquarium during its normal operating hours; not valid for special events or separately ticketed events. Refer to www.rwsentosa.com for the park’s operating hours.\n- This voucher and/or the redeemed ticket(s) is not exchangeable for cash and cannot be used in conjunction with any promotion.","isOpenDated":false,"variation":{"enumType":"gt.enumeration.Variation","name":"ADULT"},"attractionTitle":"S.E.A. Aquarium (UAT)","attraction":{"id":20},"sellingPrice":null,"paidAmount":12.0,"checkoutPrice":12.0,"product":{"id":41,"hasSeries":false,"publishStart":"2016-03-26T16:00:00Z","publishEnd":null},"qrcode":"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","eventTime":null,"type":{"enumType":"gt.enumeration.IssuedTicketType","name":"TICKETTYPE"},"choicesLeft":null,"choicesTotal":null,"isChoicePass":null,"validityPeriod":null,"distributedByGlobaltix":true,"isTimePass":null,"definedDuration":90,"redeemStart":"2017-08-16T14:43:58","redeemEnd":"2017-11-14T14:43:58","level":1,"quantity_total":2,"quantity_available":2,"status":{"enumType":"gt.enumeration.IssuedTicketStatus","name":"VALID"},"displayStatus":{"enumType":"gt.enumeration.IssuedTicketStatus","name":"VALID"},"parent":null,"transaction":{"id":17094,"referenceNumber":"L5UOI7QM","time":"2017-08-16T06:43:58Z"},"fromReseller":{"id":null,"name":null},"r1":{"id":null,"name":null},"merchantName":"Resorts World Sentosa (UAT)","merchant":{"id":12,"name":"Resorts World Sentosa (UAT)"},"questions":"","answers":"","resellerName":"Reseller Demo","subAgentName":null,"customerName":"Easwar Test","customerEmail":"test_@dss.com.sg","customerMobileNumber":null,"dateIssued":"2017-08-16T06:43:58Z","lastUpdated":"2017-08-16T06:43:58Z","dateRedeemed":null,"useBin":null,"redemptions":null,"promoCode":null,"dateRevoked":null,"country":null,"city":null},{"id":74281,"code":"BIK5QH","redeemed":false,"termsAndConditions":"Valid for child admission","name":"Normal Admission","reseller":49,"description":"- This is not your ticket. Proceed to S.E.A. Aquarium Guest Services Window between 10.00am to 6.00pm to redeem for admission tickets. \n-Identification may be required during redemption. Corporate offers will require staff pass or student pass for verification.\n- Ticket has to be used on the date of redemption.\n- This voucher and/or the redeemed ticket(s)’ validity is three (3) months from the date of order. Strictly no extension allowed.\n- Redeemed tickets are valid for single-day use at S.E.A. Aquarium during its normal operating hours; not valid for special events or separately ticketed events. Refer to www.rwsentosa.com for the park’s operating hours.\n- This voucher and/or the redeemed ticket(s) is not exchangeable for cash and cannot be used in conjunction with any promotion.","isOpenDated":false,"variation":{"enumType":"gt.enumeration.Variation","name":"CHILD"},"attractionTitle":"S.E.A. Aquarium (UAT)","attraction":{"id":20},"sellingPrice":null,"paidAmount":5.0,"checkoutPrice":5.0,"product":{"id":42,"hasSeries":false,"publishStart":"2016-03-26T16:00:00Z","publishEnd":null},"qrcode":"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\nAAAAAElFTkSuQmCC","eventTime":null,"type":{"enumType":"gt.enumeration.IssuedTicketType","name":"TICKETTYPE"},"choicesLeft":null,"choicesTotal":null,"isChoicePass":null,"validityPeriod":null,"distributedByGlobaltix":true,"isTimePass":null,"definedDuration":90,"redeemStart":"2017-08-16T14:43:58","redeemEnd":"2017-11-14T14:43:58","level":1,"quantity_total":2,"quantity_available":2,"status":{"enumType":"gt.enumeration.IssuedTicketStatus","name":"VALID"},"displayStatus":{"enumType":"gt.enumeration.IssuedTicketStatus","name":"VALID"},"parent":null,"transaction":{"id":17094,"referenceNumber":"L5UOI7QM","time":"2017-08-16T06:43:58Z"},"fromReseller":{"id":null,"name":null},"r1":{"id":null,"name":null},"merchantName":"Resorts World Sentosa (UAT)","merchant":{"id":12,"name":"Resorts World Sentosa (UAT)"},"questions":"","answers":"","resellerName":"Reseller Demo","subAgentName":null,"customerName":"Easwar Test","customerEmail":"test_@dss.com.sg","customerMobileNumber":null,"dateIssued":"2017-08-16T06:43:58Z","lastUpdated":"2017-08-16T06:43:58Z","dateRedeemed":null,"useBin":null,"redemptions":null,"promoCode":null,"dateRevoked":null,"country":null,"city":null}]},"error":null,"size":null,"success":true}';
		return $xml;
	}
	
		
}
?>
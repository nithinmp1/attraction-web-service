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
		$this->_DapiTopupDebit = 0;
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
			$_PostDataArray["customerName"] = $this->_Ainput['customer']['name'];
			$_PostDataArray["email"]		= $this->paymentAgentEmail;
			
			$this->_Ainput['postData'] = json_encode($_PostDataArray);
		}	
		
	}
	
    public function _doPaymentTransaction()
	{
		/* $_AreturnArray =	array
				(
			"status" => false,
			"msg"	 => "Insufficient balance",
			"data" 	 => array()
		);
		return $_AreturnArray; */
				
		$_Bstatus  = true;
		$_Smessage = '';
		$_Adata	   = array();
		
		//$_BbalaceCheck = $this->_checkUserBalance($this->_Ainput['totalAmount'],$this->_Ainput['currencyCode']);
		$_BbalaceCheck = Common::checkBalance( $this->_Ainput['totalAmount'], $this->_Ainput['currencyCode'] , $this);
		
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
				
				$_ApdfVoucher = array();
				foreach($_Aresponse['data']['tickets'] as $_AticektKey => $_AticketVal)
				{
					$_MarkupValues		= Common::getMarkup($_MarkupArray, $_AaccountId, $_AapiId, $_CountryIdIs, $_AticketVal['attraction']['id']);
					
					$_Schild_markup_fee = $_MarkupValues['child_markup_amount'];
					$_Sadult_markup_fee = $_MarkupValues['markup_amount'];
					$_Smarkup_type 		= $_MarkupValues['markup_fee_type'];	
					$_Smarkup_source 	= $_MarkupValues['markup_type'];

					if($_AticketVal['variation']['name']=="ADULT"){
						$_Smarkup_fee = $_Sadult_markup_fee;
					}else if($_AticketVal['variation']['name']=="CHILD"){
						$_Smarkup_fee = $_Schild_markup_fee;
					}
					
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
					//$_ApdfVoucher[] = strtolower($_AticketVal['ticketFormat']);
					
					
				}
				/* $_AgetVouchers='';
				if(in_array('pdfvoucher',$_ApdfVoucher)){

					$sellObj   								= controllerGet::getObject('GetVouchers',$this);
					$sellObj->_Ainput['action'] 			= 'GetVouchers';
					$sellObj->_Ainput['bookingReference'] 	= $_Aresponse['data']['reference_number'];
					$_AgetVouchers 							= $sellObj->_doGetVouchers();
					
				} */
				$_AresultArr['tickets']=$_AticketsArr;
				$_AresultArr['securityToken'] = $this->_Ainput['securityToken'];
				
				if(!empty($_AgetVouchers)){
					//$_AresultArr['GetVouchers']	= $_AgetVouchers;
				}
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
		$_AtraceId 		= @$this->_Ainput['referenceId'];
		
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
				$_Schild_markup_fee = $_MarkupValues['child_markup_amount'];
				$_Sadult_markup_fee = $_MarkupValues['markup_amount'];
				$_Smarkup_type 		= $_MarkupValues['markup_fee_type'];	
				$_Smarkup_source 	= $_MarkupValues['markup_type'];
				
				if($paxType=="ADULT"){
					$_Smarkup_fee = $_Sadult_markup_fee;
				}else if($paxType=="CHILD"){
					$_Smarkup_fee = $_Schild_markup_fee;
				}
				
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
					"'.mysql_real_escape_string($_AticektName).'",
					"'.mysql_real_escape_string($_AticektDescription).'", 
					"'.$_AattractionId.'",
					"'.mysql_real_escape_string($_AattractionName).'", 
					"'.$_AmerchantId.'",
					"'.mysql_real_escape_string($_AmerchantName).'",
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
			$this->_DapiTopupDebit = $_AbaseBaseFareTotal;
			
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
			
			
			Common::updateBalance(
									$_ScreditDebitCurrencyValue,
									$this->_DapiTopupDebit,
									$_AbookingId,
									$_AmodeOfPayment,
									$_AreferenceNumber,
									$this->userInfo['currency'],
									$_AcreditDebitCurrencyRate,
									$this
								);
			
			
			/* $_ScreditDepitSql = "INSERT INTO `account_credit_debit` (
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
		 */
		
			
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
		$xml = '{"data":{"id":"21942","time":"2018-06-28T14:02:29Z","currency":"SGD","creditCardCurrency":"","creditCardAmount":"","amount":"35","reference_number":"LIDGAKS2GT","alternateEmail":"","email":"elavarasan@dss.com.sg","customerName":"Mr Elavarasan Palani","groupBooking":"","groupName":"","groupNoOfMember":"0","isSingleCodeForGroup":"","mobileNumber":"","mobilePrefix":"","passportNumber":"","paymentStatus":{"enumType":"gt.enumeration.PaymentStatus","name":"PAID"},"paymentMethod":{"enumType":"gt.enumeration.PaymentMethod","name":"CREDIT"},"remarks":"","reseller":{"class":"com.globaltix.api.v1.Reseller","id":"49","code":"RED","commissionBasedAgent":"","country":{"class":"com.globaltix.api.v1.Country","id":"1"},"createBy":{"class":"com.globaltix.api.v1.User","id":"124"},"createdBy":"","credit":{"class":"com.globaltix.api.v1.Credit","id":"49"},"creditCardPaymentOnly":"","customEmailAPI":"","customEmailFilename":"uat_reseller_demo1.gsp","customEmailType":{"enumType":"gt.enumeration.CustomEmailType","name":"EMAIL_TEMPLATE"},"dateCreated":"2016-04-25T14:37:11Z","emailConfig":{"class":"com.globaltix.api.v1.EmailConfig","id":"13"},"externalApiKey":"cdqu60CykKeca1Qc000VXwgchV000L2fNOOf0bv9gPp","externalResellerEmail":"emmanuel@globaltix.com","externalResellerId":"49","externalResellerName":"Emman","externalSupplierId":"1004","hasBeenNotifiedLowCreditLimit":"1","internalEmail":"","isExternalPartner":"1","isMerchantBarcodeOnly":"1","isSubAgentOnly":"","lastUpdated":"2018-06-28T03:54:37Z","lastUpdatedBy":"116","lowCreditLimit":"1500","mobileNumber":"546546","name":"Reseller Demo","notifyLowCredit":"1","notifyLowCreditEmail":"emmanuel@globaltix.com","onlineStore":{"class":"com.globaltix.api.v1.Reseller","id":"2162"},"ownMerchant":{"class":"com.globaltix.api.v1.Merchant","id":"126"},"presetGroups":[{"class":"com.globaltix.api.v1.PresetGroup","id":"9"}],"primaryPresetGroup":{"class":"com.globaltix.api.v1.PresetGroup","id":"9"},"sendCustomEmail":"","size":{"enumType":"gt.enumeration.Size","name":"Small"},"status":{"enumType":"gt.enumeration.Status","name":"PUBLISHED"},"subAgentGroups":[{"class":"com.globaltix.api.v1.SubAgentGroup","id":"195"},{"class":"com.globaltix.api.v1.SubAgentGroup","id":"194"},{"class":"com.globaltix.api.v1.SubAgentGroup","id":"193"},{"class":"com.globaltix.api.v1.SubAgentGroup","id":"196"}],"transactionFee":"0.22"},"tickets":[{"id":"79879","code":"GTKLTMVI","redeemed":"","termsAndConditions":"tnc","name":"ACW - Direct Entry","reseller":"49","description":"test","isOpenDated":"","variation":{"enumType":"gt.enumeration.Variation","name":"ADULT"},"attractionTitle":"Adventure Cove Waterpark (UAT)","attraction":{"id":"19"},"sellingPrice":"","paidAmount":"35","checkoutPrice":"35","product":{"id":"4085","hasSeries":"","publishStart":"2017-07-12T16:00:00Z","publishEnd":""},"qrcode":"iVBORw0KGgoAAAANSUhEUgAAAJYAAACWCAIAAACzY+a1AAAGC0lEQVR42u3c\/U8TdxzAcf89EhON","eventTime":"","type":{"enumType":"gt.enumeration.IssuedTicketType","name":"TICKETTYPE"},"choicesLeft":"","choicesTotal":"","isChoicePass":"","validityPeriod":"","distributedByGlobaltix":"1","isTimePass":"","definedDuration":"90","redeemStart":"2018-06-28T22:02:30","redeemEnd":"2018-09-26T22:02:30","level":"1","quantity_total":"1","quantity_available":"0","status":{"enumType":"gt.enumeration.IssuedTicketStatus","name":"REDEEMED"},"displayStatus":{"enumType":"gt.enumeration.IssuedTicketStatus","name":"REDEEMED"},"parent":"","transaction":{"id":"21942","referenceNumber":"LIDGAKS2GT","time":"2018-06-28T14:02:29Z"},"fromReseller":{"id":"","name":""},"r1":{"id":"","name":""},"merchantName":"Resorts World Sentosa (UAT)","merchant":{"id":"12","name":"Resorts World Sentosa (UAT)"},"questions":"","answers":"","resellerName":"Reseller Demo","subAgentName":"","customerName":"Mr Elavarasan Palani","customerEmail":"elavarasan@dss.com.sg","customerMobileNumber":"","dateIssued":"2018-06-28T14:02:29Z","lastUpdated":"2018-06-28T14:02:32Z","dateRedeemed":"2018-06-28T14:02:30Z","useBin":"","redemptions":[{"id":"5817","time":"2018-06-28T14:02:32Z","code":"GTKLTMVI","quantity":"1","ticket":{"_ref":"..\/..\/..\/..","class":"com.globaltix.api.v1.Ticket"},"remark":"","operator":{"id":"67","firstname":"","lastname":"","username":"rwsentosa@globaltix.com","merchant":{"class":"com.globaltix.api.v1.Merchant","id":"12","GTA":"","code":"RWS","companyName":"Resorts World Sentosa (UAT)","contactPerson":"Ng Han Xiang","country":{"class":"com.globaltix.api.v1.Country","id":"1"},"createBy":{"class":"com.globaltix.api.v1.User","id":"67"},"createdBy":"","dailyRedemptionCount":"0","dateCreated":"2016-03-27T04:13:36Z","internalEmail":"emmanuel@globaltix.com","internalInfo":"","isCreatedByReseller":"","isPasswordReprint":"","lastUpdated":"2017-12-13T07:59:49Z","lastUpdatedBy":"68","mobileNumber":"90625785","ownReseller":{"class":"com.globaltix.api.v1.Reseller","id":"2280"},"size":{"enumType":"gt.enumeration.Size","name":"Large"},"status":{"enumType":"gt.enumeration.Status","name":"PUBLISHED"},"transactionFee":""},"reseller":"","backoffice":"","currency":{"code":"SGD","description":"Singapore Dollar","markup":"0","roundingUp":"0.01","creditCardFee":"3"},"isProxyUser":""},"barcode":{"id":"80226","code":"ACWDEMO00000196","start":"2017-07-11T16:00:00Z","end":"2018-07-12T15:59:59Z","bin":{"id":"13","left":"398","attraction":{"id":"19"},"name":"Adventure Cove Waterpark Adult","sku":"ACWUAT0001","skipBarcodes":"","format":"EAN_128","termsAndConditions":"VALID FOR ENTRY ONLY DURING STATED VALIDITY PERIOD\u2022 NO OUTSIDE FOOD OR BEVERAGES PERMITTED \u2022 NON-TRANSFERABLE \u2022NOT FOR SALE OR EXCHANGE \u2022 NON-REFUNDABLE, EVEN IN CASES OF INCLEMENT WEATHER \u2022 VOID IF ALTERED TAMPERED OR DEFACED \u2022 HANDSTAMP & TICKET REQUIRED FOR SAME DAY RE-ENTRY\u2022 NOT VAILD DURING SPECIAL EVENTS \u2022PARK OPERATING HOURS ARE SUBJECTED TO CHANGE WITHOUT PRIOR NOTICE, GUEST MAY VISIT WWW.RWSENTOSA.COM FOR UPDATES PRIOR TO VISIT. TICKET(S) WILL BE BASED ON THE FOLLOWING AGE REQUIREMENT: CHILD (4-12 YRS OLD), ADULT (13-59 YRS OLD) & SENIOR (60 YRS AND ABOVE). ADMISSIONS TO ADVENTURE COVE WATERPARK ARE SUBJECT TO ADVENTURE COVE WATERPARK RULES AND REGULATIONS, WHICH ARE AVAILABLE ON WWW.RWSENTOSA.COM\/ATTRACTIONS-TERMS","barcodesLimitNotification":"200","emails":["desiree@globaltix.com","desireehimyi@gmail.com"],"validityPeriodType":{"enumType":"gt.enumeration.PrintTicketValidityPeriodType","name":"DATE"},"validityPeriodText":"","validFor":"Single entry for one guest","additionalInfos":[{"class":"com.globaltix.api.v1.BarcodeBinAdditionalInfo","id":"352","label":"","remark":""}],"barcodeOutputType":{"enumType":"gt.enumeration.BarcodeOutputType","name":"TEMPLATE"},"templateFilename":"_ACW_Admission_TF_001.gsp"},"used":"1"}}],"promoCode":"","dateRevoked":"","country":"","city":"","ticketFormat":"PDFVOUCHER"}],"isContainVoucher":"1","otherInfo":""},"error":"","size":"","success":"1"}';
		return $xml;
	}
	
		
}
?>
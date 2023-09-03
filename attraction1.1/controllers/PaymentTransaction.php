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
			$_PostDataArray["email"] 		= $this->_Ainput['customer']['email']; //Currently we pass customer email.
			//$_PostDataArray["email"]		= $this->paymentAgentEmail; 
			
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
		
		//echo $_AsearchResult;
		if($_AsearchResult!='')
		{
			
			$_AsearchResult = str_replace('""""','""',$_AsearchResult);          
			$_ApaymentTransaction = json_decode($_AsearchResult,true);
		}

		//echo "<pre>";print_r($_ApaymentTransaction);die;
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
			
			if($this->_Ainput['userName']!='GBAB2C' && $this->_Ainput['userName']!='thanjaitravels' ){
				$this->_storeBookingInfo($_Aresponse);  
			}
			
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
			
			$_AresultArr['eTicketUrl'] =  $_Aresponse['data']['eTicketUrl'];
			$_AresultArr['viewTicketUrl'] =  $_Aresponse['data']['viewTicketUrl'];
			$_AresultArr['isContainVoucher'] =  $_Aresponse['data']['isContainVoucher'];
			$_AresultArr['isTicketsReady'] =  $_Aresponse['data']['isTicketsReady'];
			
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
			//echo $this->userInfo['currency'].'--'.$_AreqCurrency.'~~~';
			
			if($this->userInfo['currency']!=$_AreqCurrency){
				
				$_ScreditDebitCurrencyValue = round(($_AreqTotFareTotal * $_AcreditDebitCurrencyRate),3);//die;
				
			}else{
				$_ScreditDebitCurrencyValue = round(($_AreqTotFareTotal),3);//die;
			}			
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
			//echo $_ScreditDebitCurrencyValue.'--'.$this->_DapiTopupDebit.'--'.$_AbookingId.'--'.$_AmodeOfPayment.'--'.$_AreferenceNumber.'--'.$this->userInfo['currency'].'--'.$_AcreditDebitCurrencyRate;
			
			//echo $_AcreditDebitCurrencyRate;
			
			//die;
			
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
		/* $xml = '{"data":{"id":35984,"time":"2019-08-19T07:21:19Z","currency":"SGD","creditCardCurrency":null,"creditCardAmount":null,"amount":13.0,"reference_number":"MLQICIMKGT","alternateEmail":null,"email":"elavarasan@dss.com.sg","customerName":"Mr Elavarasan Palani","groupBooking":false,"groupName":null,"groupNoOfMember":0,"isSingleCodeForGroup":false,"mobileNumber":null,"mobilePrefix":null,"passportNumber":null,"paymentStatus":{"enumType":"gt.enumeration.PaymentStatus","name":"PAID"},"paymentMethod":{"enumType":"gt.enumeration.PaymentMethod","name":"CREDIT"},"remarks":null,"reseller":{"class":"com.globaltix.api.v1.Reseller","id":49,"attachmentLogoUrl":null,"code":"RED","commissionBasedAgent":null,"country":{"class":"com.globaltix.api.v1.Country","id":1},"createBy":{"class":"com.globaltix.api.v1.User","id":124},"createdBy":null,"credit":{"class":"com.globaltix.api.v1.Credit","id":49},"creditCardPaymentOnly":false,"customEmailAPI":null,"customEmailFilename":"uat_reseller_demo_7_v2-b.01.gsp","customEmailType":{"enumType":"gt.enumeration.CustomEmailType","name":"EMAIL_TEMPLATE"},"dateCreated":"2016-04-25T14:37:11Z","emailConfig":{"class":"com.globaltix.api.v1.EmailConfig","id":13},"emailLogoUrl":"https://s3-ap-southeast-1.amazonaws.com/gt-email-attachment/assets/email/images/confirmation/partner/voyagin-1.png","externalApiKey":"cdqu60CykKeca1Qc000VXwgchV000L2fNOOf0bv9gPp","externalResellerEmail":"emmanuel@globaltix.com","externalResellerId":49,"externalResellerName":"Emman","externalSupplierId":1004,"hasBeenNotifiedLowCreditLimit":false,"internalEmail":"devteam@globaltix.com","isAttachmentLogo":null,"isEmailLogo":false,"isExternalPartner":true,"isMerchantBarcodeOnly":true,"isSubAgentOnly":false,"lastUpdated":"2019-02-12T12:17:58Z","lastUpdatedBy":"116","lowCreditLimit":1500.0,"mobileNumber":"546546","name":"Reseller Demo","notifyLowCredit":true,"notifyLowCreditEmail":"emmanuel@globaltix.com","onlineStore":{"class":"com.globaltix.api.v1.Reseller","id":2162},"ownMerchant":{"class":"com.globaltix.api.v1.Merchant","id":126},"presetGroups":[{"class":"com.globaltix.api.v1.PresetGroup","id":9}],"primaryPresetGroup":{"class":"com.globaltix.api.v1.PresetGroup","id":9},"sendCustomEmail":false,"size":{"enumType":"gt.enumeration.Size","name":"Small"},"status":{"enumType":"gt.enumeration.Status","name":"PUBLISHED"},"subAgentGroups":[{"class":"com.globaltix.api.v1.SubAgentGroup","id":194},{"class":"com.globaltix.api.v1.SubAgentGroup","id":196},{"class":"com.globaltix.api.v1.SubAgentGroup","id":195},{"class":"com.globaltix.api.v1.SubAgentGroup","id":193}],"transactionFee":0.22},"tickets":[{"id":104989,"code":"GTHADZCR","redeemed":false,"termsAndConditions":"VALID FOR ONE ADULT ADMISSION ONLY ON THE DAY OF ENTRY • VALID FOR 3 MONTHS FROM THE DATE OF PURCHASE • NO OUTSIDE FOOD OR BEVERAGES PERMITTED • NON-TRANSFERABLE • NOT FOR SALE OR EXCHANGE • NON-REFUNDABLE, EVEN IN CASES OF INCLEMENT WEATHER • VOID IF ALTERED TAMPERED OR DEFACED • HANDSTAMP & TICKET REQUIRED FOR SAME DAY RE-ENTRY• NOT VAILD DURING SPECIAL EVENTS • PARK OPERATING HOURS ARE SUBJECTED TO CHANGE WITHOUT PRIOR NOTICE, GUEST MAY VISIT WWW.RWSENTOSA.COM FOR UPDATES PRIOR TO VISIT. TICKET(S) WILL BE BASED ON THE FOLLOWING AGE REQUIREMENT: CHILD (4-12 YRS OLD), ADULT (13-59 YRS OLD) & SENIOR (60 YRS AND ABOVE). ADMISSIONS TO UNIVERSAL STUDIOS SINGAPORE ARE SUBJECT TO UNIVERSAL STUDIOS SINGAPORE RULES AND REGULATIONS, WHICH ARE AVAILABLE ON WWW.RWSENTOSA.COM/ATTRACTIONS-TERMS","name":"Normal Admission","reseller":49,"description":"- Ticket is valid for 3 months from date of issue.","isOpenDated":false,"variation":{"enumType":"gt.enumeration.Variation","name":"ADULT"},"attractionTitle":"Universal Studios Singapore (UAT)","attraction":{"id":21},"sellingPrice":null,"paidAmount":13.0,"checkoutPrice":13.0,"product":{"id":43,"hasSeries":false,"publishStart":"2016-03-26T16:00:00Z","publishEnd":null,"sku":"012RWS01200A"},"qrcode":"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\nAElFTkSuQmCC","eventTime":null,"type":{"enumType":"gt.enumeration.IssuedTicketType","name":"TICKETTYPE"},"choicesLeft":null,"choicesTotal":null,"isChoicePass":null,"validityPeriod":null,"distributedByGlobaltix":true,"isTimePass":null,"definedDuration":89,"redeemStart":"2019-08-19T15:21:19","redeemEnd":"2019-11-16T15:21:19","level":1,"quantity_total":1,"quantity_available":0,"status":{"enumType":"gt.enumeration.IssuedTicketStatus","name":"REDEEMED"},"displayStatus":{"enumType":"gt.enumeration.IssuedTicketStatus","name":"REDEEMED"},"parent":null,"transaction":{"id":35984,"referenceNumber":"MLQICIMKGT","time":"2019-08-19T07:21:19Z"},"fromReseller":{"id":null,"name":null},"r1":{"id":null,"name":null},"merchantName":"Resorts World Sentosa (UAT)","merchant":{"id":12,"name":"Resorts World Sentosa (UAT)"},"questions":"","answers":"","resellerName":"Reseller Demo","subAgentName":null,"customerName":"Mr Elavarasan Palani","customerEmail":"elavarasan@dss.com.sg","customerMobileNumber":null,"dateIssued":"2019-08-19T07:21:19Z","lastUpdated":"2019-08-19T07:21:19Z","dateRedeemed":"2019-08-19T07:21:19Z","useBin":null,"redemptions":[{"id":9256,"time":"2019-08-19T07:21:19Z","code":"GTHADZCR","quantity":1,"ticket":{"_ref":"../../../..","class":"com.globaltix.api.v1.Ticket"},"remark":null,"operator":{"id":67,"firstname":"rWS","lastname":"Admin","username":"rwsentosa@globaltix.com","merchant":{"class":"com.globaltix.api.v1.Merchant","id":12,"GTA":false,"code":"RWS","companyName":"Resorts World Sentosa (UAT)","contactPerson":"Ng Han Xiang","country":{"class":"com.globaltix.api.v1.Country","id":1},"createBy":{"class":"com.globaltix.api.v1.User","id":67},"createdBy":null,"dailyRedemptionCount":0,"dateCreated":"2016-03-27T04:13:36Z","gridTabs":[],"internalEmail":"emmanuel@globaltix.com","internalInfo":null,"inventories":[],"inventoryCategories":[],"isCreatedByReseller":null,"isPasswordReprint":false,"lastUpdated":"2018-07-31T09:26:05Z","lastUpdatedBy":"116","mobileNumber":"90625785","orders":[],"ownReseller":{"class":"com.globaltix.api.v1.Reseller","id":2280},"paymentConfigs":[],"posSettings":[],"size":{"enumType":"gt.enumeration.Size","name":"Large"},"status":{"enumType":"gt.enumeration.Status","name":"PUBLISHED"},"transactionFee":null},"reseller":null,"backoffice":null,"currency":{"code":"SGD","description":"Singapore Dollar","markup":0.00,"roundingUp":0.01,"creditCardFee":3.00},"isProxyUser":false},"barcode":{"id":206280,"code":"USSDEMOC00002042","start":"2019-05-02T16:00:00Z","end":"2022-05-03T15:59:59Z","bin":{"id":17,"left":1012,"attraction":{"id":21},"name":"Universal Studios Singapore Adult","sku":null,"skipBarcodes":false,"format":"EAN_128","termsAndConditions":"VALID FOR ENTRY ONLY DURING STATED VALIDITY PERIOD• NO OUTSIDE FOOD OR BEVERAGES PERMITTED • NON-TRANSFERABLE •NOT FOR SALE OR EXCHANGE • NON-REFUNDABLE, EVEN IN CASES OF INCLEMENT WEATHER • VOID IF ALTERED TAMPERED OR DEFACED • HANDSTAMP & TICKET REQUIRED FOR SAME DAY RE-ENTRY• NOT VAILD DURING SPECIAL EVENTS • PARK OPERATING HOURS ARE SUBJECTED TO CHANGE WITHOUT PRIOR NOTICE, GUEST MAY VISIT WWW.RWSENTOSA.COM FOR UPDATES PRIOR TO VISIT. TICKET(S) WILL BE BASED ON THE FOLLOWING AGE REQUIREMENT: CHILD (4-12 YRS OLD), ADULT (13-59 YRS OLD) & SENIOR (60 YRS AND ABOVE). ADMISSIONS TO UNIVERSAL STUDIOS SINGAPORE ARE SUBJECT TO UNIVERSAL STUDIOS SINGAPORE RULES AND REGULATIONS, WHICH ARE AVAILABLE ON WWW.RWSENTOSA.COM/ATTRACTIONS-TERMS","barcodesLimitNotification":200,"emails":["desireehimyi@gmail.com","desiree@globaltix.com"],"validityPeriodType":{"enumType":"gt.enumeration.PrintTicketValidityPeriodType","name":"DATE"},"validityPeriodText":null,"validFor":"Single admission for one guest only","additionalInfos":[{"class":"com.globaltix.api.v1.BarcodeBinAdditionalInfo","id":18,"label":null,"remark":null}],"barcodeOutputType":{"enumType":"gt.enumeration.BarcodeOutputType","name":"EMAIL"},"templateFilename":null},"used":true}}],"promoCode":null,"dateRevoked":null,"country":null,"city":null,"ticketFormat":"BARCODE","visitDate":null}],"isContainVoucher":false,"otherInfo":null,"eTicketUrl":"https://s3-ap-southeast-1.amazonaws.com/globaltix/uat-etickets/download/TUxRSUNJTUtHVF8xNTY2MTk5Mjc5Nzk1.pdf","isGrabPayPurchase":false},"error":null,"size":null,"success":true}'; */
		
		
		$xml = '{
  "data": {
    "id": 5301001,
    "time": "2023-06-05T09:36:15Z",
    "currency": "SGD",
    "creditCardCurrency": null,
    "creditCardAmount": null,
    "amount": 85.5,
    "reference_number": "UI86W18HGT",
    "alternateEmail": null,
    "email": "inbound@saratnt.sg",
    "customerName": "Ms Lena Sara",
    "groupBooking": false,
    "groupName": null,
    "groupNoOfMember": 0,
    "isSingleCodeForGroup": false,
    "mobileNumber": null,
    "mobilePrefix": null,
    "passportNumber": null,
    "paymentStatus": {
      "enumType": "gt.enumeration.PaymentStatus",
      "name": "PAID"
    },
    "paymentMethod": {
      "enumType": "gt.enumeration.PaymentMethod",
      "name": "CREDIT"
    },
    "paymentProvider": null,
    "paymentTransactionId": null,
    "remarks": null,
    "reseller": {
      "class": "com.globaltix.api.v1.Reseller",
      "id": 1127,
      "accountManager": {
        "class": "com.globaltix.api.v1.User",
        "id": 10914
      },
      "attachmentLogoUrl": null,
      "code": "GOB",
      "commissionBasedAgent": null,
      "country": {
        "class": "com.globaltix.api.v1.Country",
        "id": 1
      },
      "createBy": {
        "class": "com.globaltix.api.v1.User",
        "id": 3133
      },
      "createdBy": null,
      "credit": {
        "class": "com.globaltix.api.v1.Credit",
        "id": 1127
      },
      "creditCardFee": 3,
      "creditCardPaymentOnly": null,
      "customEmailAPI": null,
      "customEmailFilename": null,
      "customEmailType": null,
      "dateCreated": "2017-06-12T02:16:21Z",
      "emailConfig": null,
      "emailLogoUrl": null,
      "externalReseller": [],
      "hasBeenNotifiedLowCreditLimit": false,
      "headquarters": {
        "class": "com.globaltix.api.v1.Country",
        "id": 1
      },
      "internalEmail": null,
      "isAttachmentLogo": null,
      "isEmailLogo": null,
      "isMerchantBarcodeOnly": true,
      "isSubAgentOnly": false,
      "lastUpdated": "2022-10-05T08:04:34Z",
      "lastUpdatedBy": "3214",
      "lowCreditLimit": 0,
      "mainReseller": true,
      "mobileNumber": "98527675",
      "monthlyFee": null,
      "name": "go Budget air",
      "noAttachmentPurchase": false,
      "noCustomerEmail": false,
      "notifyLowCredit": false,
      "notifyLowCreditEmail": null,
      "onlineStore": {
        "class": "com.globaltix.api.v1.Reseller",
        "id": 1131
      },
      "ownMerchant": {
        "class": "com.globaltix.api.v1.Merchant",
        "id": 436
      },
      "paymentProcessingFee": null,
      "pos": {
        "class": "com.globaltix.api.v1.Reseller",
        "id": 8036
      },
      "presetGroups": [
        {
          "class": "com.globaltix.api.v1.PresetGroup",
          "id": 7
        }
      ],
      "primaryPresetGroup": {
        "class": "com.globaltix.api.v1.PresetGroup",
        "id": 7
      },
      "salesCommission": null,
      "sendCustomEmail": null,
      "size": {
        "enumType": "gt.enumeration.Size",
        "name": "Medium"
      },
      "status": {
        "enumType": "gt.enumeration.Status",
        "name": "PUBLISHED"
      },
      "subAgentGroups": [
        {
          "class": "com.globaltix.api.v1.SubAgentGroup",
          "id": 4001
        },
        {
          "class": "com.globaltix.api.v1.SubAgentGroup",
          "id": 4002
        },
        {
          "class": "com.globaltix.api.v1.SubAgentGroup",
          "id": 4003
        },
        {
          "class": "com.globaltix.api.v1.SubAgentGroup",
          "id": 4004
        }
      ],
      "transactionExpire": 7200,
      "transactionFee": 0.22,
      "transactionFeeCap": null,
      "transactionFeeType": {
        "enumType": "gt.enumeration.TransactionFeeType",
        "name": "FIXED"
      },
      "useCallback": null,
      "useCase": {
        "enumType": "gt.enumeration.AccountUseCase",
        "name": "DEFAULT"
      },
      "webhook": []
    },
    "tickets": [
      {
        "id": 24234815,
        "code": "GTU0VAMH",
        "redeemed": false,
        "termsAndConditions": "<ul>\n<li>Child Age: 4 years to 12 years old.</li>\n<li>Free admission for children below 4 years old. We reserve the right to request for presentation of documents for verification of age.&nbsp;</li>\n<li>Both the Mount Faber Line and Sentosa Line have to be used on the same day of redemption.</li>\n<li>Cable Car Sky Pass refers to one round trip on Mount Faber Line and Sentosa Line and is valid for same-day use only.</li>\n</ul>\n<div>\n<p><b>Following the latest government announcement on the lifting of COVID-19 Safe Management Measures, please take note of the following guidelines that will be implemented at our premises from April 26, 2022:</b><br></p><ul><li>No limit of group size. Sharing of cabin is allowed</li><li>Maximum capacity 8 pax per cabin</li><li>This activity required to wear mask</li><li>No need required Vaccination-Differentiated Safe Management Measures (VDS)</li><li>No need required TraceTogether &amp; SafeEntry check-in</li><li>No need safe distancing required</li></ul><p></p>\n<p><b>In line with the latest announcement by the Singapore Multi-Ministry Taskforce, please note that the following persons will be allowed onboard the Singapore Cable Car from 13 October 2021:</b><br></p><ul><li>Fully vaccinated individuals</li><li>Children aged 12 years and below</li><li>Unvaccinated individuals that have obtained a valid negative Covid-19 pre-event test result (taken at least 24 hours before boarding)</li><li>&nbsp;Individuals who have recovered from Covid-19 within the last 270 days</li><li>Please be informed that Singapore Cable Car will be resuming operations from 8 October 2021.&nbsp;</li><li>Singapore Cable Car (Mount Faber Line and Sentosa Line) operating hours 8.45 am to 9.30 pm daily with last boarding at 9pm</li><li>Cable Car Sky Network Stations: - Mount Faber Line: Mount Faber Station - Harbourfront Station - Sentosa Station - Sentosa Line: Siloso Point Station - Imbiah Lookout Station - Merlion Station.</li></ul><p></p>\n</div>",
        "name": "Cable Car Sky Pass - Round Trip (Direct Entry)",
        "reseller": 1127,
        "description": null,
        "isOpenDated": true,
        "variation": {
          "enumType": "gt.enumeration.Variation",
          "name": "ADULT"
        },
        "attractionTitle": "Singapore Cable Car",
        "location": "109 Mount Faber Rd, Mount Faber Peak, Singapore 099203",
        "postalCode": "099203",
        "attractionImagePath": "3a4185e5-81fb-47b2-81d2-4a8463f571ec",
        "attraction": {
          "id": 110
        },
        "sellingPrice": null,
        "paidAmount": 17.1,
        "checkoutPrice": 17.1,
        "payToMerchant": 17,
        "posItemId": null,
        "product": {
          "customVariationName": null,
          "id": 133879,
          "hasSeries": false,
          "publishStart": "2022-04-10T16:00:00Z",
          "publishEnd": null,
          "sku": "01CAB0100ZA",
          "merchantProductCode": null,
          "multiEntryType": null,
          "multiEntryValue": null,
          "isPrintEntryTicket": false,
          "requireReceiptCode": false,
          "printTemplateId": null,
          "originalPrice": 35,
          "isRequestVisitDate": false,
          "cloudApi": false
        },
        "qrcode": "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\nzCHNinoRHQAAAABJRU5ErkJggg==",
        "eventTime": null,
        "type": {
          "enumType": "gt.enumeration.IssuedTicketType",
          "name": "TICKETTYPE"
        },
        "choicesLeft": null,
        "choicesTotal": null,
        "isChoicePass": null,
        "validityPeriod": null,
        "distributedByGlobaltix": true,
        "isTimePass": null,
        "definedDuration": 180,
        "redeemStart": "2023-06-05T17:36:15",
        "redeemEnd": "2023-12-02T23:59:59",
        "level": 1,
        "quantity_total": 1,
        "quantity_available": 0,
        "status": {
          "enumType": "gt.enumeration.IssuedTicketStatus",
          "name": "REDEEMED"
        },
        "displayStatus": {
          "enumType": "gt.enumeration.IssuedTicketStatus",
          "name": "REDEEMED"
        },
        "parent": null,
        "transaction": {
          "id": 5301001,
          "referenceNumber": "UI86W18HGT",
          "time": "2023-06-05T09:36:15Z",
          "paymentMethod": "CREDIT"
        },
        "fromReseller": {
          "id": null,
          "name": null
        },
        "r1": {
          "id": null,
          "name": null
        },
        "merchantName": "Mount Faber Leisure Group",
        "merchant": {
          "id": 30,
          "name": "Mount Faber Leisure Group"
        },
        "questions": null,
        "answers": null,
        "resellerName": "go Budget air",
        "subAgentName": null,
        "customerName": "Ms Lena Sara",
        "customerEmail": "inbound@saratnt.sg",
        "customerMobileNumber": null,
        "dateIssued": "2023-06-05T09:36:15Z",
        "lastUpdated": "2023-06-05T09:36:15Z",
        "dateRedeemed": "2023-06-05T09:36:15Z",
        "useBin": null,
        "redemptions": [
          {
            "id": 12130232,
            "time": "2023-06-05T09:36:15Z",
            "code": "GTU0VAMH",
            "quantity": 1,
            "ticket": {
              "_ref": "../../../..",
              "class": "com.globaltix.api.v1.Ticket"
            },
            "remark": null,
            "operator": {
              "id": 140,
              "firstname": "Faber Peak",
              "lastname": "MFLG",
              "username": "faberpeak@mountfaber.com.sg",
              "merchant": {
                "class": "com.globaltix.api.v1.Merchant",
                "id": 30,
                "GTA": false,
                "accountManager": null,
                "code": "CAB",
                "companyName": "Mount Faber Leisure Group",
                "contactPerson": "Susan Kuan",
                "country": {
                  "class": "com.globaltix.api.v1.Country",
                  "id": 1
                },
                "createBy": {
                  "class": "com.globaltix.api.v1.User",
                  "id": 140
                },
                "createdBy": null,
                "customTemplateName": null,
                "dailyRedemptionCount": 0,
                "dateCreated": "2016-04-22T09:25:38Z",
                "discountReference": [],
                "emailSettings": null,
                "empApiKey": null,
                "externalMerchant": [],
                "grabSettlementId": null,
                "gridTabs": [],
                "headquarter": {
                  "class": "com.globaltix.api.v1.Country",
                  "id": 1
                },
                "internalEmail": "EMpnK2m+tasks@s.freedcamp.com",
                "internalInfo": "Under GAADIT (01 Apr19-31 Mar20):\nRevenue Tier (CC, WOT, Merlion Products):\nTier 1: $450,000 - $649,999: 2.5% payout of total revenue\nTier 2: $650,000 - $799,999: 3% payout of total revenue\n** Payout at the end of 31 Mar20\n\nSky Dining Revenue Tier (01 Apr19-31Mar20):\nTier 1: $40,000 - $44,999: $1,000 nett payout\nTier 2: $45,000 - $59,999: 3% payout of total revenue\n** All payout at the end of 31 Mar20\n\nStandard Seat (07:40pm Show) & Standard Seat (08:40pm Show) - To buy from WOT portal\nPremium Seat - To buy from Sentosa B2B portal\n\nLogin: gt-enquiry@globaltix.com\nPW: 12345",
                "inventories": [],
                "inventoryCategories": [],
                "isCreatedByReseller": null,
                "isPasswordReprint": true,
                "lastUpdated": "2021-11-06T03:54:13Z",
                "lastUpdatedBy": "16735",
                "mainMerchant": true,
                "mobileNumber": "63779688",
                "orders": [],
                "ownReseller": {
                  "class": "com.globaltix.api.v1.Reseller",
                  "id": 1295
                },
                "paymentConfigs": [],
                "posSettings": [
                  {
                    "class": "com.globaltix.api.v1.PosSetting",
                    "id": 1464
                  },
                  {
                    "class": "com.globaltix.api.v1.PosSetting",
                    "id": 1462
                  },
                  {
                    "class": "com.globaltix.api.v1.PosSetting",
                    "id": 1478
                  },
                  {
                    "class": "com.globaltix.api.v1.PosSetting",
                    "id": 1469
                  },
                  {
                    "class": "com.globaltix.api.v1.PosSetting",
                    "id": 1463
                  },
                  {
                    "class": "com.globaltix.api.v1.PosSetting",
                    "id": 1467
                  },
                  {
                    "class": "com.globaltix.api.v1.PosSetting",
                    "id": 1468
                  },
                  {
                    "class": "com.globaltix.api.v1.PosSetting",
                    "id": 1455
                  },
                  {
                    "class": "com.globaltix.api.v1.PosSetting",
                    "id": 1453
                  },
                  {
                    "class": "com.globaltix.api.v1.PosSetting",
                    "id": 1473
                  },
                  {
                    "class": "com.globaltix.api.v1.PosSetting",
                    "id": 1471
                  },
                  {
                    "class": "com.globaltix.api.v1.PosSetting",
                    "id": 1458
                  },
                  {
                    "class": "com.globaltix.api.v1.PosSetting",
                    "id": 1454
                  },
                  {
                    "class": "com.globaltix.api.v1.PosSetting",
                    "id": 1456
                  },
                  {
                    "class": "com.globaltix.api.v1.PosSetting",
                    "id": 1477
                  },
                  {
                    "class": "com.globaltix.api.v1.PosSetting",
                    "id": 1457
                  },
                  {
                    "class": "com.globaltix.api.v1.PosSetting",
                    "id": 1465
                  },
                  {
                    "class": "com.globaltix.api.v1.PosSetting",
                    "id": 1479
                  },
                  {
                    "class": "com.globaltix.api.v1.PosSetting",
                    "id": 1472
                  },
                  {
                    "class": "com.globaltix.api.v1.PosSetting",
                    "id": 1470
                  },
                  {
                    "class": "com.globaltix.api.v1.PosSetting",
                    "id": 1476
                  },
                  {
                    "class": "com.globaltix.api.v1.PosSetting",
                    "id": 1466
                  },
                  {
                    "class": "com.globaltix.api.v1.PosSetting",
                    "id": 1480
                  },
                  {
                    "class": "com.globaltix.api.v1.PosSetting",
                    "id": 1459
                  },
                  {
                    "class": "com.globaltix.api.v1.PosSetting",
                    "id": 1461
                  },
                  {
                    "class": "com.globaltix.api.v1.PosSetting",
                    "id": 1452
                  },
                  {
                    "class": "com.globaltix.api.v1.PosSetting",
                    "id": 1474
                  },
                  {
                    "class": "com.globaltix.api.v1.PosSetting",
                    "id": 1451
                  },
                  {
                    "class": "com.globaltix.api.v1.PosSetting",
                    "id": 1460
                  },
                  {
                    "class": "com.globaltix.api.v1.PosSetting",
                    "id": 1475
                  }
                ],
                "printTemplates": [],
                "size": {
                  "enumType": "gt.enumeration.Size",
                  "name": "Large"
                },
                "status": {
                  "enumType": "gt.enumeration.Status",
                  "name": "PUBLISHED"
                },
                "supplierApi": null,
                "transactionFee": 0.22
              },
              "supplierApi": null,
              "reseller": null,
              "backoffice": null,
              "currency": {
                "code": "SGD",
                "description": "Singapore Dollar",
                "markup": 1.5,
                "roundingUp": 0.01,
                "creditCardFee": 3
              },
              "isProxyUser": false,
              "isUsing2FA": false
            },
            "barcode": {
              "id": 6605863,
              "code": "PRF2X11RY02MM5",
              "start": "2023-06-01T16:00:00Z",
              "end": "2023-11-30T15:59:59Z",
              "bin": {
                "id": 1764,
                "left": 437,
                "attraction": {
                  "id": 110
                },
                "name": "Cable Car Sky Pass (Direct Entry) -  Adult",
                "sku": "01CAB0100ZA",
                "skipBarcodes": false,
                "format": "QR_CODE",
                "termsAndConditions": "Valid for Adult.\n    Ticket is valid for 6 months.\n    Non-refundable, cancellation and exchange are allowed once e-tickets are issued.\n    Change for the ticket at the ticketing counter",
                "barcodesLimitNotification": 400,
                "emails": [
                  "ticketorder@globaltix.com",
                  "ops-team@globaltix.com"
                ],
                "validityPeriodType": {
                  "enumType": "gt.enumeration.PrintTicketValidityPeriodType",
                  "name": "HIDE"
                },
                "validityPeriodText": null,
                "validFor": "Single Admission",
                "additionalInfos": [
                  {
                    "class": "com.globaltix.api.v1.BarcodeBinAdditionalInfo",
                    "id": 50651,
                    "label": null,
                    "remark": null
                  }
                ],
                "barcodeOutputType": {
                  "enumType": "gt.enumeration.BarcodeOutputType",
                  "name": "TEMPLATE"
                },
                "templateFilename": "TF20220422-MFLG-03.gsp",
                "status": {
                  "enumType": "gt.enumeration.Status",
                  "name": "PUBLISHED"
                },
                "barcodeBinType": "NOT_APPLICABLE",
                "offerCount": null,
                "offerNo": null,
                "pluCode": null,
                "offerIdentifier": null,
                "basePrice": null,
                "packagePlu": null,
                "purpose": null
              },
              "used": true,
              "bookingNo": null,
              "barcodeAdditionalInformation": []
            }
          }
        ],
        "promoCode": null,
        "dateRevoked": null,
        "country": null,
        "city": null,
        "ticketFormat": "PDFVOUCHER",
        "visitDate": null,
        "reservation": null,
        "channelName": null,
        "revokeRemarks": null,
        "childrenTix": [],
        "seatInfos": {},
        "additionalDetails": [
          {
            "class": "com.globaltix.api.v1.TicketAdditionalDetails",
            "id": 78788209,
            "infoType": {
              "enumType": "gt.enumeration.TicketInfoType",
              "name": "OTHERS"
            },
            "name": "advance_booking_minutes",
            "ticket": {
              "class": "com.globaltix.api.v1.Ticket",
              "id": 24234815
            },
            "value": "null"
          },
          {
            "class": "com.globaltix.api.v1.TicketAdditionalDetails",
            "id": 78788210,
            "infoType": {
              "enumType": "gt.enumeration.TicketInfoType",
              "name": "OTHERS"
            },
            "name": "advance_booking_hours",
            "ticket": {
              "class": "com.globaltix.api.v1.Ticket",
              "id": 24234815
            },
            "value": "null"
          }
        ]
      },
      {
        "id": 24234816,
        "code": "GTCX255P",
        "redeemed": false,
        "termsAndConditions": "<ul>\n<li>Child Age: 4 years to 12 years old.</li>\n<li>Free admission for children below 4 years old. We reserve the right to request for presentation of documents for verification of age.&nbsp;</li>\n<li>Both the Mount Faber Line and Sentosa Line have to be used on the same day of redemption.</li>\n<li>Cable Car Sky Pass refers to one round trip on Mount Faber Line and Sentosa Line and is valid for same-day use only.</li>\n</ul>\n<div>\n<p><b>Following the latest government announcement on the lifting of COVID-19 Safe Management Measures, please take note of the following guidelines that will be implemented at our premises from April 26, 2022:</b><br></p><ul><li>No limit of group size. Sharing of cabin is allowed</li><li>Maximum capacity 8 pax per cabin</li><li>This activity required to wear mask</li><li>No need required Vaccination-Differentiated Safe Management Measures (VDS)</li><li>No need required TraceTogether &amp; SafeEntry check-in</li><li>No need safe distancing required</li></ul><p></p>\n<p><b>In line with the latest announcement by the Singapore Multi-Ministry Taskforce, please note that the following persons will be allowed onboard the Singapore Cable Car from 13 October 2021:</b><br></p><ul><li>Fully vaccinated individuals</li><li>Children aged 12 years and below</li><li>Unvaccinated individuals that have obtained a valid negative Covid-19 pre-event test result (taken at least 24 hours before boarding)</li><li>&nbsp;Individuals who have recovered from Covid-19 within the last 270 days</li><li>Please be informed that Singapore Cable Car will be resuming operations from 8 October 2021.&nbsp;</li><li>Singapore Cable Car (Mount Faber Line and Sentosa Line) operating hours 8.45 am to 9.30 pm daily with last boarding at 9pm</li><li>Cable Car Sky Network Stations: - Mount Faber Line: Mount Faber Station - Harbourfront Station - Sentosa Station - Sentosa Line: Siloso Point Station - Imbiah Lookout Station - Merlion Station.</li></ul><p></p>\n</div>",
        "name": "Cable Car Sky Pass - Round Trip (Direct Entry)",
        "reseller": 1127,
        "description": null,
        "isOpenDated": true,
        "variation": {
          "enumType": "gt.enumeration.Variation",
          "name": "ADULT"
        },
        "attractionTitle": "Singapore Cable Car",
        "location": "109 Mount Faber Rd, Mount Faber Peak, Singapore 099203",
        "postalCode": "099203",
        "attractionImagePath": "3a4185e5-81fb-47b2-81d2-4a8463f571ec",
        "attraction": {
          "id": 110
        },
        "sellingPrice": null,
        "paidAmount": 17.1,
        "checkoutPrice": 17.1,
        "payToMerchant": 17,
        "posItemId": null,
        "product": {
          "customVariationName": null,
          "id": 133879,
          "hasSeries": false,
          "publishStart": "2022-04-10T16:00:00Z",
          "publishEnd": null,
          "sku": "01CAB0100ZA",
          "merchantProductCode": null,
          "multiEntryType": null,
          "multiEntryValue": null,
          "isPrintEntryTicket": false,
          "requireReceiptCode": false,
          "printTemplateId": null,
          "originalPrice": 35,
          "isRequestVisitDate": false,
          "cloudApi": false
        },
        "qrcode": "iVBORw0KGgoAAAANSUhEUgAAAJYAAACWCAIAAACzY+a1AAAF/UlEQVR42u3a609TZxzAcf89EhON\nvlmyN8uSJcuS7c0yo3FTE+dtOkRugobRlnuBXrm0XNsCKiK0hSltwQJCC1iFXrm23X7YjezF4hKk\n7Tns+ws0p+c8zzlPn895zjm/POfUH4TK49TBv/Li39taqAMV7OjH0ngIIYQQQgghhBBCCCFUKGHh\n0po8EBbs6EroJQghhBBCCCGEEEIIIVQTYcGyvZNXMn+9BCGEEEIIIYQQQgghhBAef74FIYQQQggh\nhBBCCCGEEEL4SVoKzF8hhBBCCCGEEEIIIYQQQoW+wabAd914CRFCCCGEEEIIIYQQQgiLHydvCil/\nvQQhhBBCCCGEEEIIIYTFJ1RLKHCqSxHdAiGEEEIIIYQQQgghhCoiVEu2V9zErsD9CSGEEEIIIYQQ\nQgghhAolLNgsjFoSUMX2EoQQQgghhBBCCCGEJ4/wMNKZrNsfWVmLKp1QgflWUcCy2Uw6vbe7l0pt\nbWzEVuLJZJcr2NjjfzUXLmSme5S8UMmEoyMj+ta2/r6+bDbr9XhyK5eXl1tbWjr07clk0u/3NzY0\njI2OyfpMJtNt7ZKFeDwefB2UhelFi3fBtPJuenVz1rcykM7sr0cDkdi8bNrZTQ9PvOlyzDZbJ2qa\nBu/WmA3DX7bZP9OYz9W0nn6gLem0NfxmmraNBuKJBIRHbNzgwMD4s2eyIE4Bv1+n1eZ4HlZViVYq\nlSovK7NaLOFQqLqyUoydDseN6z+vra6GVlakrhQOhIZHXtYsrD8Ty7mw66lPY5+6tZfelk3JrT2N\n5WVN2/PS+qEblZYf77a22D5vtp2rN50RwnJticGmrdWPr4TXP/IbIfyPxtXX1aXTaZPBKH9jo6M5\nwhcTEx63O1egUaczdHRUV1ZdvHAhkUhcvnjJYjaXlZYeEq5t+ibmWkLvZ4Qwk00bnv4QCDlydTOZ\nbHA50tzlKdM4blZZf7rX1tj9RYvtvOZvQqOttqrJKWcMhEdv3PPx8Z7u7t3dXZfDaevt1Wo0spxM\nJARJhmA4HK6prpZRuLi4KJ/Gzk67zRaNRh/XPpJRa++1SeF/Es4sdXuCRhmF27uxw8Z7ZsMPtM5b\n1V1XftVrrV8dEJrP1LadLteVNJvv/PKo19g/MzO3DuHR74VzgUC7Xp+7C7qnpmSQ+Xy+WDRqNpr6\n7H37+/tyX7SYTIIdCATkWirFNjY2gsGgFOiyWrd2ou/iwdTO5vvE0tLbF/LAEk2FN5PLh/t3TCyU\n61y3H/ZcLW2vN33TYj+vNZ8VwgpdSYPh6vUK4wOdc/CpH8IjNu7N0tL8/Lzb7Z599UqoXE6n1+uN\nRCJDg4N+n+/3mRnfrE+edxaCwckXk3LllPulrJn2eqWuFBZXqTXidD0ZGxtxuaSYx+PxerxS5q9n\nJXeozuCpaBy9U9t77X5HXed3rUJoOftIf7qioaTJdPnafX2LeSy8+lbphJ+49/wl13IlHOjvFyQx\ncAwPNzc22W32ra0tGZeyZn5uXu6Ohs5OcZVhajaZ5KtQWUxmGZ3yKVdXq9mi02jkmWhqcrJBq2tv\n08t+hoeGckexuoJ1Rm9l09i9x/ablSaN8Ypp+GtD/7cdtu87ei49megMvH4jh8sN7uLOVamVMJcn\nbG9vC4l0pTzaZNKZg4z7Q8ga2br7IWThYOuHT1mfq5j7movc8s7OzuFOJGLxVHjt3dvI+42NzVgs\nJimK1JUyssO9vT0pqZzpRrUSKmoaGUIIIYQQQgghVDChAvPCgk105OOkzIcWhBBCCCGEEEIIIYQQ\nKppQLVHgrlF+ogwhhBBCCCGEEEIIIYRKIVR1Ylfcc0UJjYcQQgghhBBCCCGEEEKFEha3v4q7T3VN\ndUEIIYQQQgghhBBCCKGaCPPx2xRYsmA/81hOCwghhBBCCCGEEEIIIYTw+I+ej+oFm8D63+WFEEII\nIYQQQgghhBBCqJa8UC2nGoQQQgghhBBCCCGEEJ5kQrW8wVbcns3HgT5SHUIIIYQQQgghhBBCCBVK\nWNxQ4Gmh2H1CCCGEEEIIIYQQQghh8QkJVQeEqo8/AfMbkReUcJ7tAAAAAElFTkSuQmCC",
        "eventTime": null,
        "type": {
          "enumType": "gt.enumeration.IssuedTicketType",
          "name": "TICKETTYPE"
        },
        "choicesLeft": null,
        "choicesTotal": null,
        "isChoicePass": null,
        "validityPeriod": null,
        "distributedByGlobaltix": true,
        "isTimePass": null,
        "definedDuration": 180,
        "redeemStart": "2023-06-05T17:36:15",
        "redeemEnd": "2023-12-02T23:59:59",
        "level": 1,
        "quantity_total": 1,
        "quantity_available": 0,
        "status": {
          "enumType": "gt.enumeration.IssuedTicketStatus",
          "name": "REDEEMED"
        },
        "displayStatus": {
          "enumType": "gt.enumeration.IssuedTicketStatus",
          "name": "REDEEMED"
        },
        "parent": null,
        "transaction": {
          "id": 5301001,
          "referenceNumber": "UI86W18HGT",
          "time": "2023-06-05T09:36:15Z",
          "paymentMethod": "CREDIT"
        },
        "fromReseller": {
          "id": null,
          "name": null
        },
        "r1": {
          "id": null,
          "name": null
        },
        "merchantName": "Mount Faber Leisure Group",
        "merchant": {
          "id": 30,
          "name": "Mount Faber Leisure Group"
        },
        "questions": null,
        "answers": null,
        "resellerName": "go Budget air",
        "subAgentName": null,
        "customerName": "Ms Lena Sara",
        "customerEmail": "inbound@saratnt.sg",
        "customerMobileNumber": null,
        "dateIssued": "2023-06-05T09:36:15Z",
        "lastUpdated": "2023-06-05T09:36:15Z",
        "dateRedeemed": "2023-06-05T09:36:15Z",
        "useBin": null,
        "redemptions": [
          {
            "id": 12130233,
            "time": "2023-06-05T09:36:15Z",
            "code": "GTCX255P",
            "quantity": 1,
            "ticket": {
              "_ref": "../../../..",
              "class": "com.globaltix.api.v1.Ticket"
            },
            "remark": null,
            "operator": {
              "id": 140,
              "firstname": "Faber Peak",
              "lastname": "MFLG",
              "username": "faberpeak@mountfaber.com.sg",
              "merchant": {
                "class": "com.globaltix.api.v1.Merchant",
                "id": 30,
                "GTA": false,
                "accountManager": null,
                "code": "CAB",
                "companyName": "Mount Faber Leisure Group",
                "contactPerson": "Susan Kuan",
                "country": {
                  "class": "com.globaltix.api.v1.Country",
                  "id": 1
                },
                "createBy": {
                  "class": "com.globaltix.api.v1.User",
                  "id": 140
                },
                "createdBy": null,
                "customTemplateName": null,
                "dailyRedemptionCount": 0,
                "dateCreated": "2016-04-22T09:25:38Z",
                "discountReference": [],
                "emailSettings": null,
                "empApiKey": null,
                "externalMerchant": [],
                "grabSettlementId": null,
                "gridTabs": [],
                "headquarter": {
                  "class": "com.globaltix.api.v1.Country",
                  "id": 1
                },
                "internalEmail": "EMpnK2m+tasks@s.freedcamp.com",
                "internalInfo": "Under GAADIT (01 Apr19-31 Mar20):\nRevenue Tier (CC, WOT, Merlion Products):\nTier 1: $450,000 - $649,999: 2.5% payout of total revenue\nTier 2: $650,000 - $799,999: 3% payout of total revenue\n** Payout at the end of 31 Mar20\n\nSky Dining Revenue Tier (01 Apr19-31Mar20):\nTier 1: $40,000 - $44,999: $1,000 nett payout\nTier 2: $45,000 - $59,999: 3% payout of total revenue\n** All payout at the end of 31 Mar20\n\nStandard Seat (07:40pm Show) & Standard Seat (08:40pm Show) - To buy from WOT portal\nPremium Seat - To buy from Sentosa B2B portal\n\nLogin: gt-enquiry@globaltix.com\nPW: 12345",
                "inventories": [],
                "inventoryCategories": [],
                "isCreatedByReseller": null,
                "isPasswordReprint": true,
                "lastUpdated": "2021-11-06T03:54:13Z",
                "lastUpdatedBy": "16735",
                "mainMerchant": true,
                "mobileNumber": "63779688",
                "orders": [],
                "ownReseller": {
                  "class": "com.globaltix.api.v1.Reseller",
                  "id": 1295
                },
                "paymentConfigs": [],
                "posSettings": [
                  {
                    "class": "com.globaltix.api.v1.PosSetting",
                    "id": 1464
                  },
                  {
                    "class": "com.globaltix.api.v1.PosSetting",
                    "id": 1462
                  },
                  {
                    "class": "com.globaltix.api.v1.PosSetting",
                    "id": 1478
                  },
                  {
                    "class": "com.globaltix.api.v1.PosSetting",
                    "id": 1469
                  },
                  {
                    "class": "com.globaltix.api.v1.PosSetting",
                    "id": 1463
                  },
                  {
                    "class": "com.globaltix.api.v1.PosSetting",
                    "id": 1467
                  },
                  {
                    "class": "com.globaltix.api.v1.PosSetting",
                    "id": 1468
                  },
                  {
                    "class": "com.globaltix.api.v1.PosSetting",
                    "id": 1455
                  },
                  {
                    "class": "com.globaltix.api.v1.PosSetting",
                    "id": 1453
                  },
                  {
                    "class": "com.globaltix.api.v1.PosSetting",
                    "id": 1473
                  },
                  {
                    "class": "com.globaltix.api.v1.PosSetting",
                    "id": 1471
                  },
                  {
                    "class": "com.globaltix.api.v1.PosSetting",
                    "id": 1458
                  },
                  {
                    "class": "com.globaltix.api.v1.PosSetting",
                    "id": 1454
                  },
                  {
                    "class": "com.globaltix.api.v1.PosSetting",
                    "id": 1456
                  },
                  {
                    "class": "com.globaltix.api.v1.PosSetting",
                    "id": 1477
                  },
                  {
                    "class": "com.globaltix.api.v1.PosSetting",
                    "id": 1457
                  },
                  {
                    "class": "com.globaltix.api.v1.PosSetting",
                    "id": 1465
                  },
                  {
                    "class": "com.globaltix.api.v1.PosSetting",
                    "id": 1479
                  },
                  {
                    "class": "com.globaltix.api.v1.PosSetting",
                    "id": 1472
                  },
                  {
                    "class": "com.globaltix.api.v1.PosSetting",
                    "id": 1470
                  },
                  {
                    "class": "com.globaltix.api.v1.PosSetting",
                    "id": 1476
                  },
                  {
                    "class": "com.globaltix.api.v1.PosSetting",
                    "id": 1466
                  },
                  {
                    "class": "com.globaltix.api.v1.PosSetting",
                    "id": 1480
                  },
                  {
                    "class": "com.globaltix.api.v1.PosSetting",
                    "id": 1459
                  },
                  {
                    "class": "com.globaltix.api.v1.PosSetting",
                    "id": 1461
                  },
                  {
                    "class": "com.globaltix.api.v1.PosSetting",
                    "id": 1452
                  },
                  {
                    "class": "com.globaltix.api.v1.PosSetting",
                    "id": 1474
                  },
                  {
                    "class": "com.globaltix.api.v1.PosSetting",
                    "id": 1451
                  },
                  {
                    "class": "com.globaltix.api.v1.PosSetting",
                    "id": 1460
                  },
                  {
                    "class": "com.globaltix.api.v1.PosSetting",
                    "id": 1475
                  }
                ],
                "printTemplates": [],
                "size": {
                  "enumType": "gt.enumeration.Size",
                  "name": "Large"
                },
                "status": {
                  "enumType": "gt.enumeration.Status",
                  "name": "PUBLISHED"
                },
                "supplierApi": null,
                "transactionFee": 0.22
              },
              "supplierApi": null,
              "reseller": null,
              "backoffice": null,
              "currency": {
                "code": "SGD",
                "description": "Singapore Dollar",
                "markup": 1.5,
                "roundingUp": 0.01,
                "creditCardFee": 3
              },
              "isProxyUser": false,
              "isUsing2FA": false
            },
            "barcode": {
              "id": 6605864,
              "code": "PRF2X11RY02LN7",
              "start": "2023-06-01T16:00:00Z",
              "end": "2023-11-30T15:59:59Z",
              "bin": {
                "id": 1764,
                "left": 437,
                "attraction": {
                  "id": 110
                },
                "name": "Cable Car Sky Pass (Direct Entry) -  Adult",
                "sku": "01CAB0100ZA",
                "skipBarcodes": false,
                "format": "QR_CODE",
                "termsAndConditions": "Valid for Adult.\n    Ticket is valid for 6 months.\n    Non-refundable, cancellation and exchange are allowed once e-tickets are issued.\n    Change for the ticket at the ticketing counter",
                "barcodesLimitNotification": 400,
                "emails": [
                  "ticketorder@globaltix.com",
                  "ops-team@globaltix.com"
                ],
                "validityPeriodType": {
                  "enumType": "gt.enumeration.PrintTicketValidityPeriodType",
                  "name": "HIDE"
                },
                "validityPeriodText": null,
                "validFor": "Single Admission",
                "additionalInfos": [
                  {
                    "class": "com.globaltix.api.v1.BarcodeBinAdditionalInfo",
                    "id": 50651,
                    "label": null,
                    "remark": null
                  }
                ],
                "barcodeOutputType": {
                  "enumType": "gt.enumeration.BarcodeOutputType",
                  "name": "TEMPLATE"
                },
                "templateFilename": "TF20220422-MFLG-03.gsp",
                "status": {
                  "enumType": "gt.enumeration.Status",
                  "name": "PUBLISHED"
                },
                "barcodeBinType": "NOT_APPLICABLE",
                "offerCount": null,
                "offerNo": null,
                "pluCode": null,
                "offerIdentifier": null,
                "basePrice": null,
                "packagePlu": null,
                "purpose": null
              },
              "used": true,
              "bookingNo": null,
              "barcodeAdditionalInformation": []
            }
          }
        ],
        "promoCode": null,
        "dateRevoked": null,
        "country": null,
        "city": null,
        "ticketFormat": "PDFVOUCHER",
        "visitDate": null,
        "reservation": null,
        "channelName": null,
        "revokeRemarks": null,
        "childrenTix": [],
        "seatInfos": {},
        "additionalDetails": [
          {
            "class": "com.globaltix.api.v1.TicketAdditionalDetails",
            "id": 78788211,
            "infoType": {
              "enumType": "gt.enumeration.TicketInfoType",
              "name": "OTHERS"
            },
            "name": "advance_booking_hours",
            "ticket": {
              "class": "com.globaltix.api.v1.Ticket",
              "id": 24234816
            },
            "value": "null"
          },
          {
            "class": "com.globaltix.api.v1.TicketAdditionalDetails",
            "id": 78788212,
            "infoType": {
              "enumType": "gt.enumeration.TicketInfoType",
              "name": "OTHERS"
            },
            "name": "advance_booking_minutes",
            "ticket": {
              "class": "com.globaltix.api.v1.Ticket",
              "id": 24234816
            },
            "value": "null"
          }
        ]
      },
      {
        "id": 24234817,
        "code": "GTW0UGHA",
        "redeemed": false,
        "termsAndConditions": "<ul>\n<li>Child Age: 4 years to 12 years old.</li>\n<li>Free admission for children below 4 years old. We reserve the right to request for presentation of documents for verification of age.&nbsp;</li>\n<li>Both the Mount Faber Line and Sentosa Line have to be used on the same day of redemption.</li>\n<li>Cable Car Sky Pass refers to one round trip on Mount Faber Line and Sentosa Line and is valid for same-day use only.</li>\n</ul>\n<div>\n<p><b>Following the latest government announcement on the lifting of COVID-19 Safe Management Measures, please take note of the following guidelines that will be implemented at our premises from April 26, 2022:</b><br></p><ul><li>No limit of group size. Sharing of cabin is allowed</li><li>Maximum capacity 8 pax per cabin</li><li>This activity required to wear mask</li><li>No need required Vaccination-Differentiated Safe Management Measures (VDS)</li><li>No need required TraceTogether &amp; SafeEntry check-in</li><li>No need safe distancing required</li></ul><p></p>\n<p><b>In line with the latest announcement by the Singapore Multi-Ministry Taskforce, please note that the following persons will be allowed onboard the Singapore Cable Car from 13 October 2021:</b><br></p><ul><li>Fully vaccinated individuals</li><li>Children aged 12 years and below</li><li>Unvaccinated individuals that have obtained a valid negative Covid-19 pre-event test result (taken at least 24 hours before boarding)</li><li>&nbsp;Individuals who have recovered from Covid-19 within the last 270 days</li><li>Please be informed that Singapore Cable Car will be resuming operations from 8 October 2021.&nbsp;</li><li>Singapore Cable Car (Mount Faber Line and Sentosa Line) operating hours 8.45 am to 9.30 pm daily with last boarding at 9pm</li><li>Cable Car Sky Network Stations: - Mount Faber Line: Mount Faber Station - Harbourfront Station - Sentosa Station - Sentosa Line: Siloso Point Station - Imbiah Lookout Station - Merlion Station.</li></ul><p></p>\n</div>",
        "name": "Cable Car Sky Pass - Round Trip (Direct Entry)",
        "reseller": 1127,
        "description": null,
        "isOpenDated": true,
        "variation": {
          "enumType": "gt.enumeration.Variation",
          "name": "ADULT"
        },
        "attractionTitle": "Singapore Cable Car",
        "location": "109 Mount Faber Rd, Mount Faber Peak, Singapore 099203",
        "postalCode": "099203",
        "attractionImagePath": "3a4185e5-81fb-47b2-81d2-4a8463f571ec",
        "attraction": {
          "id": 110
        },
        "sellingPrice": null,
        "paidAmount": 17.1,
        "checkoutPrice": 17.1,
        "payToMerchant": 17,
        "posItemId": null,
        "product": {
          "customVariationName": null,
          "id": 133879,
          "hasSeries": false,
          "publishStart": "2022-04-10T16:00:00Z",
          "publishEnd": null,
          "sku": "01CAB0100ZA",
          "merchantProductCode": null,
          "multiEntryType": null,
          "multiEntryValue": null,
          "isPrintEntryTicket": false,
          "requireReceiptCode": false,
          "printTemplateId": null,
          "originalPrice": 35,
          "isRequestVisitDate": false,
          "cloudApi": false
        },
        "qrcode": "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\nAABJRU5ErkJggg==",
        "eventTime": null,
        "type": {
          "enumType": "gt.enumeration.IssuedTicketType",
          "name": "TICKETTYPE"
        },
        "choicesLeft": null,
        "choicesTotal": null,
        "isChoicePass": null,
        "validityPeriod": null,
        "distributedByGlobaltix": true,
        "isTimePass": null,
        "definedDuration": 180,
        "redeemStart": "2023-06-05T17:36:15",
        "redeemEnd": "2023-12-02T23:59:59",
        "level": 1,
        "quantity_total": 1,
        "quantity_available": 0,
        "status": {
          "enumType": "gt.enumeration.IssuedTicketStatus",
          "name": "REDEEMED"
        },
        "displayStatus": {
          "enumType": "gt.enumeration.IssuedTicketStatus",
          "name": "REDEEMED"
        },
        "parent": null,
        "transaction": {
          "id": 5301001,
          "referenceNumber": "UI86W18HGT",
          "time": "2023-06-05T09:36:15Z",
          "paymentMethod": "CREDIT"
        },
        "fromReseller": {
          "id": null,
          "name": null
        },
        "r1": {
          "id": null,
          "name": null
        },
        "merchantName": "Mount Faber Leisure Group",
        "merchant": {
          "id": 30,
          "name": "Mount Faber Leisure Group"
        },
        "questions": null,
        "answers": null,
        "resellerName": "go Budget air",
        "subAgentName": null,
        "customerName": "Ms Lena Sara",
        "customerEmail": "inbound@saratnt.sg",
        "customerMobileNumber": null,
        "dateIssued": "2023-06-05T09:36:15Z",
        "lastUpdated": "2023-06-05T09:36:15Z",
        "dateRedeemed": "2023-06-05T09:36:15Z",
        "useBin": null,
        "redemptions": [
          {
            "id": 12130234,
            "time": "2023-06-05T09:36:15Z",
            "code": "GTW0UGHA",
            "quantity": 1,
            "ticket": {
              "_ref": "../../../..",
              "class": "com.globaltix.api.v1.Ticket"
            },
            "remark": null,
            "operator": {
              "id": 140,
              "firstname": "Faber Peak",
              "lastname": "MFLG",
              "username": "faberpeak@mountfaber.com.sg",
              "merchant": {
                "class": "com.globaltix.api.v1.Merchant",
                "id": 30,
                "GTA": false,
                "accountManager": null,
                "code": "CAB",
                "companyName": "Mount Faber Leisure Group",
                "contactPerson": "Susan Kuan",
                "country": {
                  "class": "com.globaltix.api.v1.Country",
                  "id": 1
                },
                "createBy": {
                  "class": "com.globaltix.api.v1.User",
                  "id": 140
                },
                "createdBy": null,
                "customTemplateName": null,
                "dailyRedemptionCount": 0,
                "dateCreated": "2016-04-22T09:25:38Z",
                "discountReference": [],
                "emailSettings": null,
                "empApiKey": null,
                "externalMerchant": [],
                "grabSettlementId": null,
                "gridTabs": [],
                "headquarter": {
                  "class": "com.globaltix.api.v1.Country",
                  "id": 1
                },
                "internalEmail": "EMpnK2m+tasks@s.freedcamp.com",
                "internalInfo": "Under GAADIT (01 Apr19-31 Mar20):\nRevenue Tier (CC, WOT, Merlion Products):\nTier 1: $450,000 - $649,999: 2.5% payout of total revenue\nTier 2: $650,000 - $799,999: 3% payout of total revenue\n** Payout at the end of 31 Mar20\n\nSky Dining Revenue Tier (01 Apr19-31Mar20):\nTier 1: $40,000 - $44,999: $1,000 nett payout\nTier 2: $45,000 - $59,999: 3% payout of total revenue\n** All payout at the end of 31 Mar20\n\nStandard Seat (07:40pm Show) & Standard Seat (08:40pm Show) - To buy from WOT portal\nPremium Seat - To buy from Sentosa B2B portal\n\nLogin: gt-enquiry@globaltix.com\nPW: 12345",
                "inventories": [],
                "inventoryCategories": [],
                "isCreatedByReseller": null,
                "isPasswordReprint": true,
                "lastUpdated": "2021-11-06T03:54:13Z",
                "lastUpdatedBy": "16735",
                "mainMerchant": true,
                "mobileNumber": "63779688",
                "orders": [],
                "ownReseller": {
                  "class": "com.globaltix.api.v1.Reseller",
                  "id": 1295
                },
                "paymentConfigs": [],
                "posSettings": [
                  {
                    "class": "com.globaltix.api.v1.PosSetting",
                    "id": 1464
                  },
                  {
                    "class": "com.globaltix.api.v1.PosSetting",
                    "id": 1462
                  },
                  {
                    "class": "com.globaltix.api.v1.PosSetting",
                    "id": 1478
                  },
                  {
                    "class": "com.globaltix.api.v1.PosSetting",
                    "id": 1469
                  },
                  {
                    "class": "com.globaltix.api.v1.PosSetting",
                    "id": 1463
                  },
                  {
                    "class": "com.globaltix.api.v1.PosSetting",
                    "id": 1467
                  },
                  {
                    "class": "com.globaltix.api.v1.PosSetting",
                    "id": 1468
                  },
                  {
                    "class": "com.globaltix.api.v1.PosSetting",
                    "id": 1455
                  },
                  {
                    "class": "com.globaltix.api.v1.PosSetting",
                    "id": 1453
                  },
                  {
                    "class": "com.globaltix.api.v1.PosSetting",
                    "id": 1473
                  },
                  {
                    "class": "com.globaltix.api.v1.PosSetting",
                    "id": 1471
                  },
                  {
                    "class": "com.globaltix.api.v1.PosSetting",
                    "id": 1458
                  },
                  {
                    "class": "com.globaltix.api.v1.PosSetting",
                    "id": 1454
                  },
                  {
                    "class": "com.globaltix.api.v1.PosSetting",
                    "id": 1456
                  },
                  {
                    "class": "com.globaltix.api.v1.PosSetting",
                    "id": 1477
                  },
                  {
                    "class": "com.globaltix.api.v1.PosSetting",
                    "id": 1457
                  },
                  {
                    "class": "com.globaltix.api.v1.PosSetting",
                    "id": 1465
                  },
                  {
                    "class": "com.globaltix.api.v1.PosSetting",
                    "id": 1479
                  },
                  {
                    "class": "com.globaltix.api.v1.PosSetting",
                    "id": 1472
                  },
                  {
                    "class": "com.globaltix.api.v1.PosSetting",
                    "id": 1470
                  },
                  {
                    "class": "com.globaltix.api.v1.PosSetting",
                    "id": 1476
                  },
                  {
                    "class": "com.globaltix.api.v1.PosSetting",
                    "id": 1466
                  },
                  {
                    "class": "com.globaltix.api.v1.PosSetting",
                    "id": 1480
                  },
                  {
                    "class": "com.globaltix.api.v1.PosSetting",
                    "id": 1459
                  },
                  {
                    "class": "com.globaltix.api.v1.PosSetting",
                    "id": 1461
                  },
                  {
                    "class": "com.globaltix.api.v1.PosSetting",
                    "id": 1452
                  },
                  {
                    "class": "com.globaltix.api.v1.PosSetting",
                    "id": 1474
                  },
                  {
                    "class": "com.globaltix.api.v1.PosSetting",
                    "id": 1451
                  },
                  {
                    "class": "com.globaltix.api.v1.PosSetting",
                    "id": 1460
                  },
                  {
                    "class": "com.globaltix.api.v1.PosSetting",
                    "id": 1475
                  }
                ],
                "printTemplates": [],
                "size": {
                  "enumType": "gt.enumeration.Size",
                  "name": "Large"
                },
                "status": {
                  "enumType": "gt.enumeration.Status",
                  "name": "PUBLISHED"
                },
                "supplierApi": null,
                "transactionFee": 0.22
              },
              "supplierApi": null,
              "reseller": null,
              "backoffice": null,
              "currency": {
                "code": "SGD",
                "description": "Singapore Dollar",
                "markup": 1.5,
                "roundingUp": 0.01,
                "creditCardFee": 3
              },
              "isProxyUser": false,
              "isUsing2FA": false
            },
            "barcode": {
              "id": 6605865,
              "code": "PRF2X11RY02I9E",
              "start": "2023-06-01T16:00:00Z",
              "end": "2023-11-30T15:59:59Z",
              "bin": {
                "id": 1764,
                "left": 437,
                "attraction": {
                  "id": 110
                },
                "name": "Cable Car Sky Pass (Direct Entry) -  Adult",
                "sku": "01CAB0100ZA",
                "skipBarcodes": false,
                "format": "QR_CODE",
                "termsAndConditions": "Valid for Adult.\n    Ticket is valid for 6 months.\n    Non-refundable, cancellation and exchange are allowed once e-tickets are issued.\n    Change for the ticket at the ticketing counter",
                "barcodesLimitNotification": 400,
                "emails": [
                  "ticketorder@globaltix.com",
                  "ops-team@globaltix.com"
                ],
                "validityPeriodType": {
                  "enumType": "gt.enumeration.PrintTicketValidityPeriodType",
                  "name": "HIDE"
                },
                "validityPeriodText": null,
                "validFor": "Single Admission",
                "additionalInfos": [
                  {
                    "class": "com.globaltix.api.v1.BarcodeBinAdditionalInfo",
                    "id": 50651,
                    "label": null,
                    "remark": null
                  }
                ],
                "barcodeOutputType": {
                  "enumType": "gt.enumeration.BarcodeOutputType",
                  "name": "TEMPLATE"
                },
                "templateFilename": "TF20220422-MFLG-03.gsp",
                "status": {
                  "enumType": "gt.enumeration.Status",
                  "name": "PUBLISHED"
                },
                "barcodeBinType": "NOT_APPLICABLE",
                "offerCount": null,
                "offerNo": null,
                "pluCode": null,
                "offerIdentifier": null,
                "basePrice": null,
                "packagePlu": null,
                "purpose": null
              },
              "used": true,
              "bookingNo": null,
              "barcodeAdditionalInformation": []
            }
          }
        ],
        "promoCode": null,
        "dateRevoked": null,
        "country": null,
        "city": null,
        "ticketFormat": "PDFVOUCHER",
        "visitDate": null,
        "reservation": null,
        "channelName": null,
        "revokeRemarks": null,
        "childrenTix": [],
        "seatInfos": {},
        "additionalDetails": [
          {
            "class": "com.globaltix.api.v1.TicketAdditionalDetails",
            "id": 78788213,
            "infoType": {
              "enumType": "gt.enumeration.TicketInfoType",
              "name": "OTHERS"
            },
            "name": "advance_booking_minutes",
            "ticket": {
              "class": "com.globaltix.api.v1.Ticket",
              "id": 24234817
            },
            "value": "null"
          },
          {
            "class": "com.globaltix.api.v1.TicketAdditionalDetails",
            "id": 78788214,
            "infoType": {
              "enumType": "gt.enumeration.TicketInfoType",
              "name": "OTHERS"
            },
            "name": "advance_booking_hours",
            "ticket": {
              "class": "com.globaltix.api.v1.Ticket",
              "id": 24234817
            },
            "value": "null"
          }
        ]
      },
      {
        "id": 24234818,
        "code": "GTNCBXUM",
        "redeemed": false,
        "termsAndConditions": "<ul>\n<li>Child Age: 4 years to 12 years old.</li>\n<li>Free admission for children below 4 years old. We reserve the right to request for presentation of documents for verification of age.&nbsp;</li>\n<li>Both the Mount Faber Line and Sentosa Line have to be used on the same day of redemption.</li>\n<li>Cable Car Sky Pass refers to one round trip on Mount Faber Line and Sentosa Line and is valid for same-day use only.</li>\n</ul>\n<div>\n<p><b>Following the latest government announcement on the lifting of COVID-19 Safe Management Measures, please take note of the following guidelines that will be implemented at our premises from April 26, 2022:</b><br></p><ul><li>No limit of group size. Sharing of cabin is allowed</li><li>Maximum capacity 8 pax per cabin</li><li>This activity required to wear mask</li><li>No need required Vaccination-Differentiated Safe Management Measures (VDS)</li><li>No need required TraceTogether &amp; SafeEntry check-in</li><li>No need safe distancing required</li></ul><p></p>\n<p><b>In line with the latest announcement by the Singapore Multi-Ministry Taskforce, please note that the following persons will be allowed onboard the Singapore Cable Car from 13 October 2021:</b><br></p><ul><li>Fully vaccinated individuals</li><li>Children aged 12 years and below</li><li>Unvaccinated individuals that have obtained a valid negative Covid-19 pre-event test result (taken at least 24 hours before boarding)</li><li>&nbsp;Individuals who have recovered from Covid-19 within the last 270 days</li><li>Please be informed that Singapore Cable Car will be resuming operations from 8 October 2021.&nbsp;</li><li>Singapore Cable Car (Mount Faber Line and Sentosa Line) operating hours 8.45 am to 9.30 pm daily with last boarding at 9pm</li><li>Cable Car Sky Network Stations: - Mount Faber Line: Mount Faber Station - Harbourfront Station - Sentosa Station - Sentosa Line: Siloso Point Station - Imbiah Lookout Station - Merlion Station.</li></ul><p></p>\n</div>",
        "name": "Cable Car Sky Pass - Round Trip (Direct Entry)",
        "reseller": 1127,
        "description": null,
        "isOpenDated": true,
        "variation": {
          "enumType": "gt.enumeration.Variation",
          "name": "ADULT"
        },
        "attractionTitle": "Singapore Cable Car",
        "location": "109 Mount Faber Rd, Mount Faber Peak, Singapore 099203",
        "postalCode": "099203",
        "attractionImagePath": "3a4185e5-81fb-47b2-81d2-4a8463f571ec",
        "attraction": {
          "id": 110
        },
        "sellingPrice": null,
        "paidAmount": 17.1,
        "checkoutPrice": 17.1,
        "payToMerchant": 17,
        "posItemId": null,
        "product": {
          "customVariationName": null,
          "id": 133879,
          "hasSeries": false,
          "publishStart": "2022-04-10T16:00:00Z",
          "publishEnd": null,
          "sku": "01CAB0100ZA",
          "merchantProductCode": null,
          "multiEntryType": null,
          "multiEntryValue": null,
          "isPrintEntryTicket": false,
          "requireReceiptCode": false,
          "printTemplateId": null,
          "originalPrice": 35,
          "isRequestVisitDate": false,
          "cloudApi": false
        },
        "qrcode": "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\nYII=",
        "eventTime": null,
        "type": {
          "enumType": "gt.enumeration.IssuedTicketType",
          "name": "TICKETTYPE"
        },
        "choicesLeft": null,
        "choicesTotal": null,
        "isChoicePass": null,
        "validityPeriod": null,
        "distributedByGlobaltix": true,
        "isTimePass": null,
        "definedDuration": 180,
        "redeemStart": "2023-06-05T17:36:15",
        "redeemEnd": "2023-12-02T23:59:59",
        "level": 1,
        "quantity_total": 1,
        "quantity_available": 0,
        "status": {
          "enumType": "gt.enumeration.IssuedTicketStatus",
          "name": "REDEEMED"
        },
        "displayStatus": {
          "enumType": "gt.enumeration.IssuedTicketStatus",
          "name": "REDEEMED"
        },
        "parent": null,
        "transaction": {
          "id": 5301001,
          "referenceNumber": "UI86W18HGT",
          "time": "2023-06-05T09:36:15Z",
          "paymentMethod": "CREDIT"
        },
        "fromReseller": {
          "id": null,
          "name": null
        },
        "r1": {
          "id": null,
          "name": null
        },
        "merchantName": "Mount Faber Leisure Group",
        "merchant": {
          "id": 30,
          "name": "Mount Faber Leisure Group"
        },
        "questions": null,
        "answers": null,
        "resellerName": "go Budget air",
        "subAgentName": null,
        "customerName": "Ms Lena Sara",
        "customerEmail": "inbound@saratnt.sg",
        "customerMobileNumber": null,
        "dateIssued": "2023-06-05T09:36:15Z",
        "lastUpdated": "2023-06-05T09:36:15Z",
        "dateRedeemed": "2023-06-05T09:36:15Z",
        "useBin": null,
        "redemptions": [
          {
            "id": 12130235,
            "time": "2023-06-05T09:36:15Z",
            "code": "GTNCBXUM",
            "quantity": 1,
            "ticket": {
              "_ref": "../../../..",
              "class": "com.globaltix.api.v1.Ticket"
            },
            "remark": null,
            "operator": {
              "id": 140,
              "firstname": "Faber Peak",
              "lastname": "MFLG",
              "username": "faberpeak@mountfaber.com.sg",
              "merchant": {
                "class": "com.globaltix.api.v1.Merchant",
                "id": 30,
                "GTA": false,
                "accountManager": null,
                "code": "CAB",
                "companyName": "Mount Faber Leisure Group",
                "contactPerson": "Susan Kuan",
                "country": {
                  "class": "com.globaltix.api.v1.Country",
                  "id": 1
                },
                "createBy": {
                  "class": "com.globaltix.api.v1.User",
                  "id": 140
                },
                "createdBy": null,
                "customTemplateName": null,
                "dailyRedemptionCount": 0,
                "dateCreated": "2016-04-22T09:25:38Z",
                "discountReference": [],
                "emailSettings": null,
                "empApiKey": null,
                "externalMerchant": [],
                "grabSettlementId": null,
                "gridTabs": [],
                "headquarter": {
                  "class": "com.globaltix.api.v1.Country",
                  "id": 1
                },
                "internalEmail": "EMpnK2m+tasks@s.freedcamp.com",
                "internalInfo": "Under GAADIT (01 Apr19-31 Mar20):\nRevenue Tier (CC, WOT, Merlion Products):\nTier 1: $450,000 - $649,999: 2.5% payout of total revenue\nTier 2: $650,000 - $799,999: 3% payout of total revenue\n** Payout at the end of 31 Mar20\n\nSky Dining Revenue Tier (01 Apr19-31Mar20):\nTier 1: $40,000 - $44,999: $1,000 nett payout\nTier 2: $45,000 - $59,999: 3% payout of total revenue\n** All payout at the end of 31 Mar20\n\nStandard Seat (07:40pm Show) & Standard Seat (08:40pm Show) - To buy from WOT portal\nPremium Seat - To buy from Sentosa B2B portal\n\nLogin: gt-enquiry@globaltix.com\nPW: 12345",
                "inventories": [],
                "inventoryCategories": [],
                "isCreatedByReseller": null,
                "isPasswordReprint": true,
                "lastUpdated": "2021-11-06T03:54:13Z",
                "lastUpdatedBy": "16735",
                "mainMerchant": true,
                "mobileNumber": "63779688",
                "orders": [],
                "ownReseller": {
                  "class": "com.globaltix.api.v1.Reseller",
                  "id": 1295
                },
                "paymentConfigs": [],
                "posSettings": [
                  {
                    "class": "com.globaltix.api.v1.PosSetting",
                    "id": 1464
                  },
                  {
                    "class": "com.globaltix.api.v1.PosSetting",
                    "id": 1462
                  },
                  {
                    "class": "com.globaltix.api.v1.PosSetting",
                    "id": 1478
                  },
                  {
                    "class": "com.globaltix.api.v1.PosSetting",
                    "id": 1469
                  },
                  {
                    "class": "com.globaltix.api.v1.PosSetting",
                    "id": 1463
                  },
                  {
                    "class": "com.globaltix.api.v1.PosSetting",
                    "id": 1467
                  },
                  {
                    "class": "com.globaltix.api.v1.PosSetting",
                    "id": 1468
                  },
                  {
                    "class": "com.globaltix.api.v1.PosSetting",
                    "id": 1455
                  },
                  {
                    "class": "com.globaltix.api.v1.PosSetting",
                    "id": 1453
                  },
                  {
                    "class": "com.globaltix.api.v1.PosSetting",
                    "id": 1473
                  },
                  {
                    "class": "com.globaltix.api.v1.PosSetting",
                    "id": 1471
                  },
                  {
                    "class": "com.globaltix.api.v1.PosSetting",
                    "id": 1458
                  },
                  {
                    "class": "com.globaltix.api.v1.PosSetting",
                    "id": 1454
                  },
                  {
                    "class": "com.globaltix.api.v1.PosSetting",
                    "id": 1456
                  },
                  {
                    "class": "com.globaltix.api.v1.PosSetting",
                    "id": 1477
                  },
                  {
                    "class": "com.globaltix.api.v1.PosSetting",
                    "id": 1457
                  },
                  {
                    "class": "com.globaltix.api.v1.PosSetting",
                    "id": 1465
                  },
                  {
                    "class": "com.globaltix.api.v1.PosSetting",
                    "id": 1479
                  },
                  {
                    "class": "com.globaltix.api.v1.PosSetting",
                    "id": 1472
                  },
                  {
                    "class": "com.globaltix.api.v1.PosSetting",
                    "id": 1470
                  },
                  {
                    "class": "com.globaltix.api.v1.PosSetting",
                    "id": 1476
                  },
                  {
                    "class": "com.globaltix.api.v1.PosSetting",
                    "id": 1466
                  },
                  {
                    "class": "com.globaltix.api.v1.PosSetting",
                    "id": 1480
                  },
                  {
                    "class": "com.globaltix.api.v1.PosSetting",
                    "id": 1459
                  },
                  {
                    "class": "com.globaltix.api.v1.PosSetting",
                    "id": 1461
                  },
                  {
                    "class": "com.globaltix.api.v1.PosSetting",
                    "id": 1452
                  },
                  {
                    "class": "com.globaltix.api.v1.PosSetting",
                    "id": 1474
                  },
                  {
                    "class": "com.globaltix.api.v1.PosSetting",
                    "id": 1451
                  },
                  {
                    "class": "com.globaltix.api.v1.PosSetting",
                    "id": 1460
                  },
                  {
                    "class": "com.globaltix.api.v1.PosSetting",
                    "id": 1475
                  }
                ],
                "printTemplates": [],
                "size": {
                  "enumType": "gt.enumeration.Size",
                  "name": "Large"
                },
                "status": {
                  "enumType": "gt.enumeration.Status",
                  "name": "PUBLISHED"
                },
                "supplierApi": null,
                "transactionFee": 0.22
              },
              "supplierApi": null,
              "reseller": null,
              "backoffice": null,
              "currency": {
                "code": "SGD",
                "description": "Singapore Dollar",
                "markup": 1.5,
                "roundingUp": 0.01,
                "creditCardFee": 3
              },
              "isProxyUser": false,
              "isUsing2FA": false
            },
            "barcode": {
              "id": 6605866,
              "code": "PRF2X11RY02I3Q",
              "start": "2023-06-01T16:00:00Z",
              "end": "2023-11-30T15:59:59Z",
              "bin": {
                "id": 1764,
                "left": 437,
                "attraction": {
                  "id": 110
                },
                "name": "Cable Car Sky Pass (Direct Entry) -  Adult",
                "sku": "01CAB0100ZA",
                "skipBarcodes": false,
                "format": "QR_CODE",
                "termsAndConditions": "Valid for Adult.\n    Ticket is valid for 6 months.\n    Non-refundable, cancellation and exchange are allowed once e-tickets are issued.\n    Change for the ticket at the ticketing counter",
                "barcodesLimitNotification": 400,
                "emails": [
                  "ticketorder@globaltix.com",
                  "ops-team@globaltix.com"
                ],
                "validityPeriodType": {
                  "enumType": "gt.enumeration.PrintTicketValidityPeriodType",
                  "name": "HIDE"
                },
                "validityPeriodText": null,
                "validFor": "Single Admission",
                "additionalInfos": [
                  {
                    "class": "com.globaltix.api.v1.BarcodeBinAdditionalInfo",
                    "id": 50651,
                    "label": null,
                    "remark": null
                  }
                ],
                "barcodeOutputType": {
                  "enumType": "gt.enumeration.BarcodeOutputType",
                  "name": "TEMPLATE"
                },
                "templateFilename": "TF20220422-MFLG-03.gsp",
                "status": {
                  "enumType": "gt.enumeration.Status",
                  "name": "PUBLISHED"
                },
                "barcodeBinType": "NOT_APPLICABLE",
                "offerCount": null,
                "offerNo": null,
                "pluCode": null,
                "offerIdentifier": null,
                "basePrice": null,
                "packagePlu": null,
                "purpose": null
              },
              "used": true,
              "bookingNo": null,
              "barcodeAdditionalInformation": []
            }
          }
        ],
        "promoCode": null,
        "dateRevoked": null,
        "country": null,
        "city": null,
        "ticketFormat": "PDFVOUCHER",
        "visitDate": null,
        "reservation": null,
        "channelName": null,
        "revokeRemarks": null,
        "childrenTix": [],
        "seatInfos": {},
        "additionalDetails": [
          {
            "class": "com.globaltix.api.v1.TicketAdditionalDetails",
            "id": 78788215,
            "infoType": {
              "enumType": "gt.enumeration.TicketInfoType",
              "name": "OTHERS"
            },
            "name": "advance_booking_hours",
            "ticket": {
              "class": "com.globaltix.api.v1.Ticket",
              "id": 24234818
            },
            "value": "null"
          },
          {
            "class": "com.globaltix.api.v1.TicketAdditionalDetails",
            "id": 78788216,
            "infoType": {
              "enumType": "gt.enumeration.TicketInfoType",
              "name": "OTHERS"
            },
            "name": "advance_booking_minutes",
            "ticket": {
              "class": "com.globaltix.api.v1.Ticket",
              "id": 24234818
            },
            "value": "null"
          }
        ]
      },
      {
        "id": 24234819,
        "code": "GTXUVQJB",
        "redeemed": false,
        "termsAndConditions": "<ul>\n<li>Child Age: 4 years to 12 years old.</li>\n<li>Free admission for children below 4 years old. We reserve the right to request for presentation of documents for verification of age.&nbsp;</li>\n<li>Both the Mount Faber Line and Sentosa Line have to be used on the same day of redemption.</li>\n<li>Cable Car Sky Pass refers to one round trip on Mount Faber Line and Sentosa Line and is valid for same-day use only.</li>\n</ul>\n<div>\n<p><b>Following the latest government announcement on the lifting of COVID-19 Safe Management Measures, please take note of the following guidelines that will be implemented at our premises from April 26, 2022:</b><br></p><ul><li>No limit of group size. Sharing of cabin is allowed</li><li>Maximum capacity 8 pax per cabin</li><li>This activity required to wear mask</li><li>No need required Vaccination-Differentiated Safe Management Measures (VDS)</li><li>No need required TraceTogether &amp; SafeEntry check-in</li><li>No need safe distancing required</li></ul><p></p>\n<p><b>In line with the latest announcement by the Singapore Multi-Ministry Taskforce, please note that the following persons will be allowed onboard the Singapore Cable Car from 13 October 2021:</b><br></p><ul><li>Fully vaccinated individuals</li><li>Children aged 12 years and below</li><li>Unvaccinated individuals that have obtained a valid negative Covid-19 pre-event test result (taken at least 24 hours before boarding)</li><li>&nbsp;Individuals who have recovered from Covid-19 within the last 270 days</li><li>Please be informed that Singapore Cable Car will be resuming operations from 8 October 2021.&nbsp;</li><li>Singapore Cable Car (Mount Faber Line and Sentosa Line) operating hours 8.45 am to 9.30 pm daily with last boarding at 9pm</li><li>Cable Car Sky Network Stations: - Mount Faber Line: Mount Faber Station - Harbourfront Station - Sentosa Station - Sentosa Line: Siloso Point Station - Imbiah Lookout Station - Merlion Station.</li></ul><p></p>\n</div>",
        "name": "Cable Car Sky Pass - Round Trip (Direct Entry)",
        "reseller": 1127,
        "description": null,
        "isOpenDated": true,
        "variation": {
          "enumType": "gt.enumeration.Variation",
          "name": "ADULT"
        },
        "attractionTitle": "Singapore Cable Car",
        "location": "109 Mount Faber Rd, Mount Faber Peak, Singapore 099203",
        "postalCode": "099203",
        "attractionImagePath": "3a4185e5-81fb-47b2-81d2-4a8463f571ec",
        "attraction": {
          "id": 110
        },
        "sellingPrice": null,
        "paidAmount": 17.1,
        "checkoutPrice": 17.1,
        "payToMerchant": 17,
        "posItemId": null,
        "product": {
          "customVariationName": null,
          "id": 133879,
          "hasSeries": false,
          "publishStart": "2022-04-10T16:00:00Z",
          "publishEnd": null,
          "sku": "01CAB0100ZA",
          "merchantProductCode": null,
          "multiEntryType": null,
          "multiEntryValue": null,
          "isPrintEntryTicket": false,
          "requireReceiptCode": false,
          "printTemplateId": null,
          "originalPrice": 35,
          "isRequestVisitDate": false,
          "cloudApi": false
        },
        "qrcode": "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\nxgAAAABJRU5ErkJggg==",
        "eventTime": null,
        "type": {
          "enumType": "gt.enumeration.IssuedTicketType",
          "name": "TICKETTYPE"
        },
        "choicesLeft": null,
        "choicesTotal": null,
        "isChoicePass": null,
        "validityPeriod": null,
        "distributedByGlobaltix": true,
        "isTimePass": null,
        "definedDuration": 180,
        "redeemStart": "2023-06-05T17:36:15",
        "redeemEnd": "2023-12-02T23:59:59",
        "level": 1,
        "quantity_total": 1,
        "quantity_available": 0,
        "status": {
          "enumType": "gt.enumeration.IssuedTicketStatus",
          "name": "REDEEMED"
        },
        "displayStatus": {
          "enumType": "gt.enumeration.IssuedTicketStatus",
          "name": "REDEEMED"
        },
        "parent": null,
        "transaction": {
          "id": 5301001,
          "referenceNumber": "UI86W18HGT",
          "time": "2023-06-05T09:36:15Z",
          "paymentMethod": "CREDIT"
        },
        "fromReseller": {
          "id": null,
          "name": null
        },
        "r1": {
          "id": null,
          "name": null
        },
        "merchantName": "Mount Faber Leisure Group",
        "merchant": {
          "id": 30,
          "name": "Mount Faber Leisure Group"
        },
        "questions": null,
        "answers": null,
        "resellerName": "go Budget air",
        "subAgentName": null,
        "customerName": "Ms Lena Sara",
        "customerEmail": "inbound@saratnt.sg",
        "customerMobileNumber": null,
        "dateIssued": "2023-06-05T09:36:15Z",
        "lastUpdated": "2023-06-05T09:36:15Z",
        "dateRedeemed": "2023-06-05T09:36:15Z",
        "useBin": null,
        "redemptions": [
          {
            "id": 12130236,
            "time": "2023-06-05T09:36:15Z",
            "code": "GTXUVQJB",
            "quantity": 1,
            "ticket": {
              "_ref": "../../../..",
              "class": "com.globaltix.api.v1.Ticket"
            },
            "remark": null,
            "operator": {
              "id": 140,
              "firstname": "Faber Peak",
              "lastname": "MFLG",
              "username": "faberpeak@mountfaber.com.sg",
              "merchant": {
                "class": "com.globaltix.api.v1.Merchant",
                "id": 30,
                "GTA": false,
                "accountManager": null,
                "code": "CAB",
                "companyName": "Mount Faber Leisure Group",
                "contactPerson": "Susan Kuan",
                "country": {
                  "class": "com.globaltix.api.v1.Country",
                  "id": 1
                },
                "createBy": {
                  "class": "com.globaltix.api.v1.User",
                  "id": 140
                },
                "createdBy": null,
                "customTemplateName": null,
                "dailyRedemptionCount": 0,
                "dateCreated": "2016-04-22T09:25:38Z",
                "discountReference": [],
                "emailSettings": null,
                "empApiKey": null,
                "externalMerchant": [],
                "grabSettlementId": null,
                "gridTabs": [],
                "headquarter": {
                  "class": "com.globaltix.api.v1.Country",
                  "id": 1
                },
                "internalEmail": "EMpnK2m+tasks@s.freedcamp.com",
                "internalInfo": "Under GAADIT (01 Apr19-31 Mar20):\nRevenue Tier (CC, WOT, Merlion Products):\nTier 1: $450,000 - $649,999: 2.5% payout of total revenue\nTier 2: $650,000 - $799,999: 3% payout of total revenue\n** Payout at the end of 31 Mar20\n\nSky Dining Revenue Tier (01 Apr19-31Mar20):\nTier 1: $40,000 - $44,999: $1,000 nett payout\nTier 2: $45,000 - $59,999: 3% payout of total revenue\n** All payout at the end of 31 Mar20\n\nStandard Seat (07:40pm Show) & Standard Seat (08:40pm Show) - To buy from WOT portal\nPremium Seat - To buy from Sentosa B2B portal\n\nLogin: gt-enquiry@globaltix.com\nPW: 12345",
                "inventories": [],
                "inventoryCategories": [],
                "isCreatedByReseller": null,
                "isPasswordReprint": true,
                "lastUpdated": "2021-11-06T03:54:13Z",
                "lastUpdatedBy": "16735",
                "mainMerchant": true,
                "mobileNumber": "63779688",
                "orders": [],
                "ownReseller": {
                  "class": "com.globaltix.api.v1.Reseller",
                  "id": 1295
                },
                "paymentConfigs": [],
                "posSettings": [
                  {
                    "class": "com.globaltix.api.v1.PosSetting",
                    "id": 1464
                  },
                  {
                    "class": "com.globaltix.api.v1.PosSetting",
                    "id": 1462
                  },
                  {
                    "class": "com.globaltix.api.v1.PosSetting",
                    "id": 1478
                  },
                  {
                    "class": "com.globaltix.api.v1.PosSetting",
                    "id": 1469
                  },
                  {
                    "class": "com.globaltix.api.v1.PosSetting",
                    "id": 1463
                  },
                  {
                    "class": "com.globaltix.api.v1.PosSetting",
                    "id": 1467
                  },
                  {
                    "class": "com.globaltix.api.v1.PosSetting",
                    "id": 1468
                  },
                  {
                    "class": "com.globaltix.api.v1.PosSetting",
                    "id": 1455
                  },
                  {
                    "class": "com.globaltix.api.v1.PosSetting",
                    "id": 1453
                  },
                  {
                    "class": "com.globaltix.api.v1.PosSetting",
                    "id": 1473
                  },
                  {
                    "class": "com.globaltix.api.v1.PosSetting",
                    "id": 1471
                  },
                  {
                    "class": "com.globaltix.api.v1.PosSetting",
                    "id": 1458
                  },
                  {
                    "class": "com.globaltix.api.v1.PosSetting",
                    "id": 1454
                  },
                  {
                    "class": "com.globaltix.api.v1.PosSetting",
                    "id": 1456
                  },
                  {
                    "class": "com.globaltix.api.v1.PosSetting",
                    "id": 1477
                  },
                  {
                    "class": "com.globaltix.api.v1.PosSetting",
                    "id": 1457
                  },
                  {
                    "class": "com.globaltix.api.v1.PosSetting",
                    "id": 1465
                  },
                  {
                    "class": "com.globaltix.api.v1.PosSetting",
                    "id": 1479
                  },
                  {
                    "class": "com.globaltix.api.v1.PosSetting",
                    "id": 1472
                  },
                  {
                    "class": "com.globaltix.api.v1.PosSetting",
                    "id": 1470
                  },
                  {
                    "class": "com.globaltix.api.v1.PosSetting",
                    "id": 1476
                  },
                  {
                    "class": "com.globaltix.api.v1.PosSetting",
                    "id": 1466
                  },
                  {
                    "class": "com.globaltix.api.v1.PosSetting",
                    "id": 1480
                  },
                  {
                    "class": "com.globaltix.api.v1.PosSetting",
                    "id": 1459
                  },
                  {
                    "class": "com.globaltix.api.v1.PosSetting",
                    "id": 1461
                  },
                  {
                    "class": "com.globaltix.api.v1.PosSetting",
                    "id": 1452
                  },
                  {
                    "class": "com.globaltix.api.v1.PosSetting",
                    "id": 1474
                  },
                  {
                    "class": "com.globaltix.api.v1.PosSetting",
                    "id": 1451
                  },
                  {
                    "class": "com.globaltix.api.v1.PosSetting",
                    "id": 1460
                  },
                  {
                    "class": "com.globaltix.api.v1.PosSetting",
                    "id": 1475
                  }
                ],
                "printTemplates": [],
                "size": {
                  "enumType": "gt.enumeration.Size",
                  "name": "Large"
                },
                "status": {
                  "enumType": "gt.enumeration.Status",
                  "name": "PUBLISHED"
                },
                "supplierApi": null,
                "transactionFee": 0.22
              },
              "supplierApi": null,
              "reseller": null,
              "backoffice": null,
              "currency": {
                "code": "SGD",
                "description": "Singapore Dollar",
                "markup": 1.5,
                "roundingUp": 0.01,
                "creditCardFee": 3
              },
              "isProxyUser": false,
              "isUsing2FA": false
            },
            "barcode": {
              "id": 6605867,
              "code": "PRF2X11RY02GY5",
              "start": "2023-06-01T16:00:00Z",
              "end": "2023-11-30T15:59:59Z",
              "bin": {
                "id": 1764,
                "left": 437,
                "attraction": {
                  "id": 110
                },
                "name": "Cable Car Sky Pass (Direct Entry) -  Adult",
                "sku": "01CAB0100ZA",
                "skipBarcodes": false,
                "format": "QR_CODE",
                "termsAndConditions": "Valid for Adult.\n    Ticket is valid for 6 months.\n    Non-refundable, cancellation and exchange are allowed once e-tickets are issued.\n    Change for the ticket at the ticketing counter",
                "barcodesLimitNotification": 400,
                "emails": [
                  "ticketorder@globaltix.com",
                  "ops-team@globaltix.com"
                ],
                "validityPeriodType": {
                  "enumType": "gt.enumeration.PrintTicketValidityPeriodType",
                  "name": "HIDE"
                },
                "validityPeriodText": null,
                "validFor": "Single Admission",
                "additionalInfos": [
                  {
                    "class": "com.globaltix.api.v1.BarcodeBinAdditionalInfo",
                    "id": 50651,
                    "label": null,
                    "remark": null
                  }
                ],
                "barcodeOutputType": {
                  "enumType": "gt.enumeration.BarcodeOutputType",
                  "name": "TEMPLATE"
                },
                "templateFilename": "TF20220422-MFLG-03.gsp",
                "status": {
                  "enumType": "gt.enumeration.Status",
                  "name": "PUBLISHED"
                },
                "barcodeBinType": "NOT_APPLICABLE",
                "offerCount": null,
                "offerNo": null,
                "pluCode": null,
                "offerIdentifier": null,
                "basePrice": null,
                "packagePlu": null,
                "purpose": null
              },
              "used": true,
              "bookingNo": null,
              "barcodeAdditionalInformation": []
            }
          }
        ],
        "promoCode": null,
        "dateRevoked": null,
        "country": null,
        "city": null,
        "ticketFormat": "PDFVOUCHER",
        "visitDate": null,
        "reservation": null,
        "channelName": null,
        "revokeRemarks": null,
        "childrenTix": [],
        "seatInfos": {},
        "additionalDetails": [
          {
            "class": "com.globaltix.api.v1.TicketAdditionalDetails",
            "id": 78788217,
            "infoType": {
              "enumType": "gt.enumeration.TicketInfoType",
              "name": "OTHERS"
            },
            "name": "advance_booking_hours",
            "ticket": {
              "class": "com.globaltix.api.v1.Ticket",
              "id": 24234819
            },
            "value": "null"
          },
          {
            "class": "com.globaltix.api.v1.TicketAdditionalDetails",
            "id": 78788218,
            "infoType": {
              "enumType": "gt.enumeration.TicketInfoType",
              "name": "OTHERS"
            },
            "name": "advance_booking_minutes",
            "ticket": {
              "class": "com.globaltix.api.v1.Ticket",
              "id": 24234819
            },
            "value": "null"
          }
        ]
      }
    ],
    "isContainVoucher": true,
    "otherInfo": null,
    "eTicketUrl": "https://eticket.globaltix.com/live/download/ticket?fn=VUk4NlcxOEhHVF8xNjg1OTU3Nzc1MDAw.pdf",
    "isGrabPayPurchase": false,
    "additionalDetails": [],
    "type": {
      "enumType": "gt.enumeration.TransactionType",
      "name": "SALES"
    },
    "paymentCollection": {
      "enumType": "gt.enumeration.PaymentCollection",
      "name": "COLLECTED"
    },
    "isTicketsReady": true,
    "viewTicketUrl": "https://viewmybookings.globaltix.com/verify/NklGc1luVlhIdmlWaEdtODlLYmkybkhJYmtpVVNMRXRqcFBkeDhTWFRPbDM2MlBBb25sVE9qSGNJZnl3M1dyb21ZYnhBbk5reFlVQ3IzbE0rNHJ1d3c9PQ"
  },
  "error": null,
  "size": null,
  "success": true
}';
		return $xml;
	} 
	
		
}
?>
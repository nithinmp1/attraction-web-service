<?php
/**
	@File Name 		:	GetBookingDetails.php
	@Author 		:	Elavarasan	P
	@Date	 		:	13-07-2017
	@Description	:	GetBookingDetails service
*/
class GetBookingDetails extends Execute
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
		
		
		//$this->_Ainput['prohibitedCarriers'] = array();
	}
	
    public function _doGetBookingDetails()
	{
	
		 $sellObj   						= controllerGet::getObject('GetSecurityToken',$this);
		$sellObj->_Ainput['action'] 	= 'GetSecurityToken';
		$_AgetTokenRes 				= $sellObj->_doGetSecurityToken();
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
			$_ApaymentTransaction = json_decode($_AsearchResult,true);
		}

		$_Areturn = $this->_paymentTransaction($_ApaymentTransaction, $this->_Ainput);
		return $_Areturn;
	}
	
	function _paymentTransaction($_Aresponse, $_AinputData)
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
				$_AticketsArr = array();
				foreach($_Aresponse['data']['tickets'] as $_AticektKey => $_AticketVal)
				{
					
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
			return array("status"=>false, "msg"=>"Ticket Booking Details Error", "data"=>'');
		}
		
		return array("status"=>true, "msg"=>"Ticket Booking  Details Response", "data"=>$_AresponseArr);
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
		$xml = '{"data":{"id":159167,"time":"2023-05-18T08:29:16Z","currency":"SGD","creditCardCurrency":null,"creditCardAmount":null,"amount":2.1,"reference_number":"CQAFRYRJGT","alternateEmail":null,"email":"elavarasan@dss.com.sg","customerName":"Mr Elavarasan Ram","groupBooking":false,"groupName":null,"groupNoOfMember":0,"isSingleCodeForGroup":false,"mobileNumber":null,"mobilePrefix":null,"passportNumber":null,"paymentStatus":{"enumType":"gt.enumeration.PaymentStatus","name":"PAID"},"paymentMethod":{"enumType":"gt.enumeration.PaymentMethod","name":"CREDIT"},"paymentProvider":null,"paymentTransactionId":null,"remarks":null,"reseller":{"class":"com.globaltix.api.v1.Reseller","id":49,"accountManager":null,"attachmentLogoUrl":null,"code":"RED","commissionBasedAgent":null,"country":{"class":"com.globaltix.api.v1.Country","id":1},"createBy":{"class":"com.globaltix.api.v1.User","id":124},"createdBy":null,"credit":{"class":"com.globaltix.api.v1.Credit","id":49},"creditCardFee":3.0,"creditCardPaymentOnly":false,"customEmailAPI":null,"customEmailFilename":"uat_reseller_demo_7_v2-b.01.gsp","customEmailType":{"enumType":"gt.enumeration.CustomEmailType","name":"EMAIL_TEMPLATE"},"dateCreated":"2016-04-25T14:37:11Z","emailConfig":{"class":"com.globaltix.api.v1.EmailConfig","id":13},"emailLogoUrl":"https://s3-ap-southeast-1.amazonaws.com/gt-email-attachment/assets/email/images/confirmation/partner/voyagin-1.png","externalReseller":[{"class":"com.globaltix.api.v1.ExternalReseller","id":1},{"class":"com.globaltix.api.v1.ExternalReseller","id":6}],"hasBeenNotifiedLowCreditLimit":false,"headquarters":{"class":"com.globaltix.api.v1.Country","id":1},"internalEmail":"devteam@globaltix.com","isAttachmentLogo":null,"isEmailLogo":false,"isMerchantBarcodeOnly":true,"isSubAgentOnly":false,"lastUpdated":"2022-12-22T08:12:47Z","lastUpdatedBy":"116","lowCreditLimit":1500.0,"mainReseller":true,"mobileNumber":"546546","monthlyFee":null,"name":"Reseller Demo","noAttachmentPurchase":false,"noCustomerEmail":false,"notifyLowCredit":true,"notifyLowCreditEmail":"emmanuel@globaltix.com","onlineStore":{"class":"com.globaltix.api.v1.Reseller","id":2162},"ownMerchant":{"class":"com.globaltix.api.v1.Merchant","id":126},"paymentProcessingFee":null,"pos":{"class":"com.globaltix.api.v1.Reseller","id":2570},"presetGroups":[{"class":"com.globaltix.api.v1.PresetGroup","id":4}],"primaryPresetGroup":{"class":"com.globaltix.api.v1.PresetGroup","id":4},"salesCommission":null,"sendCustomEmail":false,"size":{"enumType":"gt.enumeration.Size","name":"Small"},"status":{"enumType":"gt.enumeration.Status","name":"PUBLISHED"},"subAgentGroups":[{"class":"com.globaltix.api.v1.SubAgentGroup","id":195},{"class":"com.globaltix.api.v1.SubAgentGroup","id":196},{"class":"com.globaltix.api.v1.SubAgentGroup","id":193},{"class":"com.globaltix.api.v1.SubAgentGroup","id":194}],"transactionExpire":2880,"transactionFee":0.5,"transactionFeeCap":null,"transactionFeeType":{"enumType":"gt.enumeration.TransactionFeeType","name":"FIXED"},"useCallback":null,"useCase":{"enumType":"gt.enumeration.AccountUseCase","name":"DEFAULT"},"webhook":[{"class":"com.globaltix.api.v1.Webhook","id":36},{"class":"com.globaltix.api.v1.Webhook","id":37}]},"tickets":[{"id":314375,"code":"GTNZFNAX","redeemed":false,"termsAndConditions":"<p>Lorem Ipsum<\u002fp>","name":"SINGLE - KAYAKING","reseller":49,"description":"<p>SINGLE - KAYAKING - $25/per hour<\u002fp>","isOpenDated":false,"variation":{"enumType":"gt.enumeration.Variation","name":"ADULT"},"attractionTitle":"KAYAKING","location":null,"postalCode":null,"attractionImagePath":"22fbcdb5-77b1-4e6d-9e43-256435a23b4b","attraction":{"id":260},"sellingPrice":null,"paidAmount":2.1,"checkoutPrice":2.1,"payToMerchant":2.0,"posItemId":null,"product":{"customVariationName":null,"id":685,"hasSeries":false,"publishStart":"2017-05-18T16:00:00Z","publishEnd":null,"sku":"01RED010300A","merchantProductCode":null,"multiEntryType":null,"multiEntryValue":null,"isPrintEntryTicket":null,"requireReceiptCode":null,"printTemplateId":null,"originalPrice":25.0,"isRequestVisitDate":null,"cloudApi":null,"linkId":648},"qrcode":"iVBORw0KGgoAAAANSUhEUgAAAJYAAACWCAIAAACzY+a1AAAGB0lEQVR42u3c2U8bRxzAcf49pEiJ\nkpdKfakqVaoqtS9Vo0Rpk0hpriYlhCuQiGKb24BPDpvTNpCEELANTbANMRDAQEjAxjan7fZH3KI+\n9KUke7j5/gTWsjuzOzufmd0dz4qiP4gCj6KjX/3Fv5dVrX0qcXTlaglCCCGEEEIIIYQQQgh1Sqje\nsEbTSlSinCrXEoQQQgghhBBCCCGEEBYSobYjM9VagLZNDUIIIYQQQgghhBBCCCHUvmpUawEQQggh\nhBBCCCGEEEIIYcETfqAWhBBCCCGEEEIIIYQQQqgqoQ7fYNMhIS8hQgghhBBCCCGEEEIIofah7cSQ\nEqM95WoJQgghhBBCCCGEEEIItScs6CiUgZ2CNQAhhBBCCCGEEEIIIYSFTqjEHJASRfrAUalqB9Jg\nXAghhBBCCCGEEEIIIYRKEKo2C6Nafelw/uujNF8IIYQQQgghhBBCCFUjVD8y2Zw/vLG8Fv+fEyrR\njTQBy+WymczB/kE6vbO5mVjeTqU6fdGG7vDL2ViR1v9puIAJR4aHzS2tfb29uVwuGAjkVy4tLbU0\nN7eb21KpVDgcbqivHx0ZlfXZbLbL2SkL29vb0VdRWZhacATnbctvp1a3ZkLL/Zns4Xo8spGYk017\n+5mh8dednpkm53h148Cdartl6MtW92cG+9nqllP3jcUdrvrfbFOukch2MgnhCU94oL9/7OlTWRCn\nSDhsMhrzPA8qK0UrnU6XlZY6HY7YykpVRYUYez2e69d+XltdXVlelrySOLIyNPyien79qVjOxnxP\nQgb35M2DzK5sSu0cGBwvqlufldQNXq9w/Hinpdn1eZPrbJ3ttBCWGYstLmONeWw5tp4vOYQnOeG6\n2tpMJmOzWOVndGQkT/h8fDzg9+cTNJhMlvb2qorKC+fPJ5PJSxcuOuz20pKSY8K1rdD4bPPKu2kh\nzOYylic/RFY8+bzZbC66tNHUGSg1eG5UOn+629rQ9UWz65zhb0Krq6ay0SstBsKTn/CzsbHurq79\n/X2fx+vq6TEaDLKcSiYFSbpgLBarrqqSXriwsCCf1o4Ot8sVj8cf1TyUXuvucUnifxJOL3YFolbp\nhbv7ieMiBWZi943em1Wdl381G51fHRHaT9e0niozFTfZb//ysMfaNz09uw7hyU94NhJpM5vzd0H/\n5KR0slAolIjH7VZbr7v38PBQ7osOm02wI5GIXEsl2ebmZjQalQSdTufOXvztdjS9t/Uuubj45rk8\nsMTTsa3U0vH+PePzZSbfrQfdV0ra6mzfNLvPGe1nhLDcVFxvuXKt3Hrf5B14EobwhCf8enFxbm7O\n7/fPvHwpVD6vNxgMbmxsDA4MhEOh36enQzMhed6Zj0Ynnk/IlVPul7JmKhiUvJJYXCXXsNf3eHR0\n2OeTZIFAIBgISpq/npX8K7WWQHnDyO2anqv32ms7vmsRQseZh+ZT5fXFjbZLV++Zm+2jsdU3eifU\n7fhBroT9fX2CJAaeoaGmhka3y72zsyP9UtbMzc7J3dHS0SGu0k3tNpv8KVQOm116p3zK1dVpd5gM\nBnkmmpyYqDea2lrNsp+hwcH8/p2+aK01WNE4eveR+0aFzWC9bBv62tL3bbvr+/bui4/HOyKvXsvh\npHPr8+uCAiDMjxN2d3eFRKpSHm2ymezRiPt9yBrZuv8+ZOFo6/tPWZ/PmP8zH/nlvb29451IJLbT\nsbW3bzbebW5uJRIJGaJIXkkjOzw4OJCUSn8x9EkQ6nxyGEIIIYQQQggh1AehtlqqzdcUSnYIIYQQ\nQgghhBBCCCH85AhVCx2+AKdt84UQQgghhBBCCCGEEEK9EBbpL3RYiapNYP3nw0EIIYQQQgghhBBC\nCKE+CQtltFco2ZWdbIIQQgghhBBCCCGEEMJCIVSiHKo1IG2Hqso1dAghhBBCCCGEEEIIIYRQy5RK\nTGApUXUQQgghhBBCCCGEEEIIoarVrdpsEeNCCCGEEEIIIYQQQggh/ITeYNNhW/kohYcQQgghhBBC\nCCGEEEKdEmob2k7iqDZY/CidB0IIIYQQQgghhBBCCLUnJAo6ICz4+BN1yPq7baTsYQAAAABJRU5E\nrkJggg==","eventTime":null,"type":{"enumType":"gt.enumeration.IssuedTicketType","name":"TICKETTYPE"},"choicesLeft":null,"choicesTotal":null,"isChoicePass":null,"validityPeriod":null,"distributedByGlobaltix":true,"isTimePass":null,"definedDuration":200,"redeemStart":"2023-05-18T16:29:16","redeemEnd":"2023-12-04T23:59:59","level":1,"quantity_total":1,"quantity_available":1,"status":{"enumType":"gt.enumeration.IssuedTicketStatus","name":"VALID"},"displayStatus":{"enumType":"gt.enumeration.IssuedTicketStatus","name":"VALID"},"parent":null,"transaction":{"id":159167,"referenceNumber":"CQAFRYRJGT","time":"2023-05-18T08:29:16Z","paymentMethod":"CREDIT"},"fromReseller":{"id":null,"name":null},"r1":{"id":null,"name":null},"merchantName":"Reseller Demo Products","merchant":{"id":126,"name":"Reseller Demo Products"},"questions":null,"answers":null,"resellerName":"Reseller Demo","subAgentName":null,"customerName":"Mr Elavarasan Ram","customerEmail":"elavarasan@dss.com.sg","customerMobileNumber":null,"dateIssued":"2023-05-18T08:29:16Z","lastUpdated":"2023-05-18T08:29:16Z","dateRedeemed":null,"useBin":null,"redemptions":[],"promoCode":null,"dateRevoked":null,"country":null,"city":null,"ticketFormat":"QRCODE","visitDate":null,"reservation":null,"channelName":null,"revokeRemarks":null,"childrenTix":[],"seatInfos":{},"additionalDetails":[{"class":"com.globaltix.api.v1.TicketAdditionalDetails","id":553242,"infoType":{"enumType":"gt.enumeration.TicketInfoType","name":"OTHERS"},"name":"advance_booking_hours","ticket":{"class":"com.globaltix.api.v1.Ticket","id":314375},"value":"null"},{"class":"com.globaltix.api.v1.TicketAdditionalDetails","id":553243,"infoType":{"enumType":"gt.enumeration.TicketInfoType","name":"OTHERS"},"name":"advance_booking_minutes","ticket":{"class":"com.globaltix.api.v1.Ticket","id":314375},"value":"null"}]}],"isContainVoucher":false,"otherInfo":null,"eTicketUrl":"https://new-eticket.globaltix.com/uat/download/ticket?fn=Q1FBRlJZUkpHVF8xNjg0Mzk4NTU2MDAw.pdf","isGrabPayPurchase":false,"additionalDetails":[],"type":{"enumType":"gt.enumeration.TransactionType","name":"SALES"},"paymentCollection":{"enumType":"gt.enumeration.PaymentCollection","name":"COLLECTED"},"isTicketsReady":true,"viewTicketUrl":"https://uat-viewmybookings.globaltix.com/verify/dC93NmRxUnBCTnJTcm52UWJYQ1I0bEZ1UUdNZG9NMlBpMklpQ0UzK28yTHVDQzRMYVdtZENlZitYMGpockIwdU81SzVZVzNaei9pNExGNDRnRnZnRkE9PQ"},"error":null,"size":null,"success":true}';
		
	return $xml;
	
	}
	
		
}
?>
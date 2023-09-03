<?php
/**
	@File Name 		:	CancelTickets.php
	@Author 		:	Elavarasan Palani
	@Description	:	CancelTickets service
*/
class CancelTickets extends Execute
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
	
    public function _doCancelTickets()
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
		echo "<pre>";

			
		if($_AsearchResult!='')
		{
			$_AcancelTickets = json_decode($_AsearchResult,true);
		}

		$_Areturn = $this->_cancelTickets($_AcancelTickets, $this->_Ainput);
		return $_Areturn;
	}
	
	function _cancelTickets($_Aresponse, $_AinputData)
	{

		$_AresponseArr = array();
		if($_Aresponse['success']==1){
			

			$_AresponseArr['pnr'] = $_Aresponse['data']['code'];
			
			$_AresponseArr['referenceNumber'] 	= $_Aresponse['data']['transaction']['referenceNumber'];
			$_AresponseArr['referenceId'] 	= $_Aresponse['data']['transaction']['Id'];
			$_AresponseArr['attractionId'] 	= $_Aresponse['data']['attraction']['id'];
			$_AresponseArr['attractionName'] 	= $_Aresponse['data']['attractionTitle'];
			$_AresponseArr['ticketType'] 	= $_Aresponse['data']['type']['name'];
			$_AresponseArr['ticketId'] 		= $_Aresponse['data']['id'];
			$_AresponseArr['paxType'] 		= $_Aresponse['data']['variation']['name'];
			$_AresponseArr['paxTotal'] 		= $_Aresponse['data']['quantity_total'];
			$_AresponseArr['availablePax'] 	= $_Aresponse['data']['quantity_available'];
			$_AresponseArr['merchantName'] 	= $_Aresponse['data']['merchantName'];
			$_AresponseArr['resellerId'] 	= $_Aresponse['data']['reseller'];
			$_AresponseArr['resellerName'] 	= $_Aresponse['data']['resellerName'];
			$_AresponseArr['customerName'] 	= $_Aresponse['data']['customerName'];
			$_AresponseArr['customerEmail'] = $_Aresponse['data']['customerEmail'];
			$_AresponseArr['ticketName'] 	= $_Aresponse['data']['name'];
			$_AresponseArr['paidAmount'] = $_Aresponse['data']['paidAmount'];
			$_AresponseArr['checkoutPrice'] = $_Aresponse['data']['checkoutPrice'];
			$_AresponseArr['dateIssued'] = $_Aresponse['data']['dateIssued'];
			$_AresponseArr['dateRevoked'] = $_Aresponse['data']['dateRevoked'];
			
			
			$_AresponseArr['status'] = $_Aresponse['data']['status']['name'];
			$_AresponseArr['redeemEnd'] = $_Aresponse['data']['redeemEnd'];
			
			
			$_AresponseArr['cancelDetails'] = $_Aresponse['data'];
			
			
			
			return array("status"=>true, "msg"=>"Cancel Ticket", "data"=>$_AresponseArr);
		}else if($_Aresponse['error']['code']){
			
			return array("status"=>false, "msg"=>$_Aresponse['error']['code']);
		}
		else {
			
			return array("status"=>false, "msg"=>"Cancel Ticket Error");
		}
		
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
		$xml = '{"data":{"parent":null,"country":null,"postalCode":null,"questions":null,"answers":null,"type":{"enumType":"gt.enumeration.IssuedTicketType","name":"TICKETTYPE"},"variation":{"enumType":"gt.enumeration.Variation","name":"ADULT"},"merchantName":"Reseller Demo Products","validityPeriod":null,"distributedByGlobaltix":true,"lastUpdated":"2023-05-18T09:00:01Z","payToMerchant":2.0,"customerEmail":"elavarasan@dss.com.sg","ticketFormat":"QRCODE","reservation":null,"visitDate":null,"id":314375,"isOpenDated":false,"posItemId":null,"level":1,"resellerName":"Reseller Demo","dateRedeemed":null,"redeemStart":"2023-05-18T16:29:16","merchant":{"name":"Reseller Demo Products","id":126},"useBin":null,"isTimePass":null,"subAgentName":null,"customerName":"Mr Elavarasan Ram","choicesLeft":null,"fromReseller":{"name":null,"id":null},"redemptions":[],"childrenTix":[],"name":"SINGLE - KAYAKING","paidAmount":2.1,"status":{"enumType":"gt.enumeration.IssuedTicketStatus","name":"REVOKED"},"code":"GTNZFNAX","redeemed":false,"redeemEnd":"2023-12-04T23:59:59","city":null,"qrcode":"iVBORw0KGgoAAAANSUhEUgAAAJYAAACWCAIAAACzY+a1AAAGB0lEQVR42u3c2U8bRxzAcf49pEiJ\nkpdKfakqVaoqtS9Vo0Rpk0hpriYlhCuQiGKb24BPDpvTNpCEELANTbANMRDAQEjAxjan7fZH3KI+\n9KUke7j5/gTWsjuzOzufmd0dz4qiP4gCj6KjX/3Fv5dVrX0qcXTlaglCCCGEEEIIIYQQQgh1Sqje\nsEbTSlSinCrXEoQQQgghhBBCCCGEEBYSobYjM9VagLZNDUIIIYQQQgghhBBCCCHUvmpUawEQQggh\nhBBCCCGEEEIIYcETfqAWhBBCCCGEEEIIIYQQQqgqoQ7fYNMhIS8hQgghhBBCCCGEEEIIofah7cSQ\nEqM95WoJQgghhBBCCCGEEEIItScs6CiUgZ2CNQAhhBBCCCGEEEIIIYSFTqjEHJASRfrAUalqB9Jg\nXAghhBBCCCGEEEIIIYRKEKo2C6Nafelw/uujNF8IIYQQQgghhBBCCFUjVD8y2Zw/vLG8Fv+fEyrR\njTQBy+WymczB/kE6vbO5mVjeTqU6fdGG7vDL2ViR1v9puIAJR4aHzS2tfb29uVwuGAjkVy4tLbU0\nN7eb21KpVDgcbqivHx0ZlfXZbLbL2SkL29vb0VdRWZhacATnbctvp1a3ZkLL/Zns4Xo8spGYk017\n+5mh8dednpkm53h148Cdartl6MtW92cG+9nqllP3jcUdrvrfbFOukch2MgnhCU94oL9/7OlTWRCn\nSDhsMhrzPA8qK0UrnU6XlZY6HY7YykpVRYUYez2e69d+XltdXVlelrySOLIyNPyien79qVjOxnxP\nQgb35M2DzK5sSu0cGBwvqlufldQNXq9w/Hinpdn1eZPrbJ3ttBCWGYstLmONeWw5tp4vOYQnOeG6\n2tpMJmOzWOVndGQkT/h8fDzg9+cTNJhMlvb2qorKC+fPJ5PJSxcuOuz20pKSY8K1rdD4bPPKu2kh\nzOYylic/RFY8+bzZbC66tNHUGSg1eG5UOn+629rQ9UWz65zhb0Krq6ay0SstBsKTn/CzsbHurq79\n/X2fx+vq6TEaDLKcSiYFSbpgLBarrqqSXriwsCCf1o4Ot8sVj8cf1TyUXuvucUnifxJOL3YFolbp\nhbv7ieMiBWZi943em1Wdl381G51fHRHaT9e0niozFTfZb//ysMfaNz09uw7hyU94NhJpM5vzd0H/\n5KR0slAolIjH7VZbr7v38PBQ7osOm02wI5GIXEsl2ebmZjQalQSdTufOXvztdjS9t/Uuubj45rk8\nsMTTsa3U0vH+PePzZSbfrQfdV0ra6mzfNLvPGe1nhLDcVFxvuXKt3Hrf5B14EobwhCf8enFxbm7O\n7/fPvHwpVD6vNxgMbmxsDA4MhEOh36enQzMhed6Zj0Ynnk/IlVPul7JmKhiUvJJYXCXXsNf3eHR0\n2OeTZIFAIBgISpq/npX8K7WWQHnDyO2anqv32ms7vmsRQseZh+ZT5fXFjbZLV++Zm+2jsdU3eifU\n7fhBroT9fX2CJAaeoaGmhka3y72zsyP9UtbMzc7J3dHS0SGu0k3tNpv8KVQOm116p3zK1dVpd5gM\nBnkmmpyYqDea2lrNsp+hwcH8/p2+aK01WNE4eveR+0aFzWC9bBv62tL3bbvr+/bui4/HOyKvXsvh\npHPr8+uCAiDMjxN2d3eFRKpSHm2ymezRiPt9yBrZuv8+ZOFo6/tPWZ/PmP8zH/nlvb29451IJLbT\nsbW3bzbebW5uJRIJGaJIXkkjOzw4OJCUSn8x9EkQ6nxyGEIIIYQQQggh1AehtlqqzdcUSnYIIYQQ\nQgghhBBCCCH85AhVCx2+AKdt84UQQgghhBBCCCGEEEK9EBbpL3RYiapNYP3nw0EIIYQQQgghhBBC\nCKE+CQtltFco2ZWdbIIQQgghhBBCCCGEEMJCIVSiHKo1IG2Hqso1dAghhBBCCCGEEEIIIYRQy5RK\nTGApUXUQQgghhBBCCCGEEEIIoarVrdpsEeNCCCGEEEIIIYQQQggh/ITeYNNhW/kohYcQQgghhBBC\nCCGEEEKdEmob2k7iqDZY/CidB0IIIYQQQgghhBBCCLUnJAo6ICz4+BN1yPq7baTsYQAAAABJRU5E\nrkJggg==","isChoicePass":null,"description":"<p>SINGLE - KAYAKING - $25/per hour<\u002fp>","displayStatus":{"enumType":"gt.enumeration.IssuedTicketStatus","name":"REVOKED"},"termsAndConditions":"<p>Lorem Ipsum<\u002fp>","attractionTitle":"KAYAKING","sellingPrice":null,"quantity_total":1,"eventTime":null,"customerMobileNumber":null,"promoCode":null,"dateRevoked":"2023-05-18T09:00:01Z","checkoutPrice":2.1,"dateIssued":"2023-05-18T08:29:16Z","product":{"publishEnd":null,"hasSeries":false,"printTemplateId":null,"requireReceiptCode":null,"originalPrice":25.0,"merchantProductCode":null,"publishStart":"2017-05-18T16:00:00Z","multiEntryType":null,"isRequestVisitDate":null,"linkId":648,"isPrintEntryTicket":null,"customVariationName":null,"multiEntryValue":null,"id":685,"cloudApi":null,"sku":"01RED010300A"},"definedDuration":200,"revokeRemarks":null,"reseller":49,"additionalDetails":[{"infoType":{"enumType":"gt.enumeration.TicketInfoType","name":"CANCELLATION"},"ticket":{"id":314375,"class":"com.globaltix.api.v1.Ticket"},"name":"TIMESTAMP","id":null,"class":"com.globaltix.api.v1.TicketAdditionalDetails","value":"2023-05-18T17:00:01"},{"infoType":{"enumType":"gt.enumeration.TicketInfoType","name":"CANCELLATION"},"ticket":{"id":314375,"class":"com.globaltix.api.v1.Ticket"},"name":"USERID","id":null,"class":"com.globaltix.api.v1.TicketAdditionalDetails","value":"124"},{"infoType":{"enumType":"gt.enumeration.TicketInfoType","name":"OTHERS"},"ticket":{"id":314375,"class":"com.globaltix.api.v1.Ticket"},"name":"advance_booking_hours","id":553242,"class":"com.globaltix.api.v1.TicketAdditionalDetails","value":"null"},{"infoType":{"enumType":"gt.enumeration.TicketInfoType","name":"OTHERS"},"ticket":{"id":314375,"class":"com.globaltix.api.v1.Ticket"},"name":"advance_booking_minutes","id":553243,"class":"com.globaltix.api.v1.TicketAdditionalDetails","value":"null"},{"infoType":{"enumType":"gt.enumeration.TicketInfoType","name":"CANCELLATION"},"ticket":{"id":314375,"class":"com.globaltix.api.v1.Ticket"},"name":"PAYABLE","id":null,"class":"com.globaltix.api.v1.TicketAdditionalDetails","value":"false"}],"attractionImagePath":"22fbcdb5-77b1-4e6d-9e43-256435a23b4b","choicesTotal":null,"attraction":{"id":260},"location":null,"channelName":null,"seatInfos":{},"transaction":{"referenceNumber":"CQAFRYRJGT","paymentMethod":"CREDIT","id":159167,"time":"2023-05-18T08:29:16Z"},"quantity_available":1,"r1":{"name":null,"id":null}},"error":null,"size":null,"success":true}';
		
	return $xml;
	
	}
	
		
}
?>
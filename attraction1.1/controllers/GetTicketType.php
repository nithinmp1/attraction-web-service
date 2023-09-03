<?php
/**
	@File Name 		:	GetTicketType.php
	@Author 		:	Elavarasan	P
	@Description	:	GetTicketType service
*/
class GetTicketType extends Execute
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
	
    public function _doGetTicketType()
	{
		
		$_Bstatus  = true;
		$_Smessage = '';
		$_Adata	   = array();
		
		$this->_modifyData();
		$this->_setData();
		//$_AsearchResult = $this->fun1();
		$_AsearchResult = $this->_executeService();
		
		if($_AsearchResult!='')
		{
			$_AgetTicketType = json_decode($_AsearchResult,true);
		}

		$_Areturn = $this->_getTicketType($_AgetTicketType, $this->_Ainput);
		return $_Areturn;
	}
	
	function _getTicketType($_Aresponse, $_AinputData)
	{
		//print_r($_Aresponse);
		$_AresponseArr = array();
		if($_Aresponse['success']==1){
			
			$_AresponseArr['attractionID'] 		= $this->_Ainput['attractionId'];
			
			if(!isset($_Aresponse['data'][0]))
			{
				$_Aresponse['data'] = array($_Aresponse['data']);
			}
			
			foreach($_Aresponse['data'] as $_AattractionKey => $_AattractionVal){
				
				
				$_AresponseArr['ticketTypes'][$_AattractionKey] 	= $_AattractionVal;
				

			}
			
		}else{
			
			return array("status"=>false, "msg"=>"Get Ticket Type Error", "data"=>'');
		}
		
		return array("status"=>true, "msg"=>"GetTicketType", "data"=>$_AresponseArr);
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
		$xml = '{
  "data":[
    {
      "id":182,
      "hasSeries":false,
      "name":"Singapore Zoo Sample Ticket - With Barcode",
      "currency":"SGD",
      "favorited":true,
      "price":13.22,
      "variation":{
        "enumType":"gt.enumeration.Variation",
        "name":"ADULT"
      },
      "issuanceLimit":null,
      "originalPrice":11.0,
      "settlementPrice":13.0,
      "merchantCurrency":"SGD",
      "sourceName":"Wildlife Reserves Singapore Group",
      "sourceTitle":"Merchant",
      "ableToDistributeToGlobaltix":true,
      "from":null,
      "did":146594
    },
    {
      "id":519,
      "hasSeries":false,
      "name":"General Admission",
      "currency":"SGD",
      "favorited":true,
      "price":35.0,
      "variation":{
        "enumType":"gt.enumeration.Variation",
        "name":"ADULT"
      },
      "issuanceLimit":null,
      "originalPrice":34.0,
      "settlementPrice":35.0,
      "merchantCurrency":"SGD",
      "sourceName":"Wildlife Reserves Singapore Group",
      "sourceTitle":"Merchant",
      "ableToDistributeToGlobaltix":false,
      "from":null,
      "did":149909
    },
    {
      "id":520,
      "hasSeries":false,
      "name":"General Admission",
      "currency":"SGD",
      "favorited":true,
      "price":27.0,
      "variation":{
        "enumType":"gt.enumeration.Variation",
        "name":"CHILD"
      },
      "issuanceLimit":null,
      "originalPrice":26.0,
      "settlementPrice":27.0,
      "merchantCurrency":"SGD",
      "sourceName":"Wildlife Reserves Singapore Group",
      "sourceTitle":"Merchant",
      "ableToDistributeToGlobaltix":false,
      "from":null,
      "did":149910
    },
    {
      "id":75,
      "hasSeries":false,
      "name":"Print",
      "currency":"SGD",
      "favorited":false,
      "price":50.22,
      "variation":{
        "enumType":"gt.enumeration.Variation",
        "name":"ADULT"
      },
      "issuanceLimit":null,
      "originalPrice":50.0,
      "settlementPrice":50.0,
      "merchantCurrency":"SGD",
      "sourceName":"Wildlife Reserves Singapore Group",
      "sourceTitle":"Merchant",
      "ableToDistributeToGlobaltix":true,
      "from":null,
      "did":192053
    },
    {
      "id":81,
      "hasSeries":false,
      "name":"tt",
      "currency":"SGD",
      "favorited":false,
      "price":5.0,
      "variation":{
        "enumType":"gt.enumeration.Variation",
        "name":"ADULT"
      },
      "issuanceLimit":null,
      "originalPrice":50.0,
      "settlementPrice":5.0,
      "merchantCurrency":"SGD",
      "sourceName":"Wildlife Reserves Singapore Group",
      "sourceTitle":"Merchant",
      "ableToDistributeToGlobaltix":false,
      "from":null,
      "did":153200
    },
    {
      "id":82,
      "hasSeries":false,
      "name":"tt",
      "currency":"SGD",
      "favorited":false,
      "price":3.0,
      "variation":{
        "enumType":"gt.enumeration.Variation",
        "name":"CHILD"
      },
      "issuanceLimit":null,
      "originalPrice":60.0,
      "settlementPrice":3.0,
      "merchantCurrency":"SGD",
      "sourceName":"Wildlife Reserves Singapore Group",
      "sourceTitle":"Merchant",
      "ableToDistributeToGlobaltix":false,
      "from":null,
      "did":153201
    },
    {
      "id":181,
      "hasSeries":false,
      "name":"Singapore Zoo Sample Ticket - With QR Code",
      "currency":"SGD",
      "favorited":false,
      "price":15.0,
      "variation":{
        "enumType":"gt.enumeration.Variation",
        "name":"ADULT"
      },
      "issuanceLimit":null,
      "originalPrice":10.0,
      "settlementPrice":15.0,
      "merchantCurrency":"SGD",
      "sourceName":"Wildlife Reserves Singapore Group",
      "sourceTitle":"Merchant",
      "ableToDistributeToGlobaltix":false,
      "from":null,
      "did":154445
    },
    {
      "id":183,
      "hasSeries":false,
      "name":"Singapore Zoo Sample Ticket - Without bin",
      "currency":"SGD",
      "favorited":false,
      "price":11.22,
      "variation":{
        "enumType":"gt.enumeration.Variation",
        "name":"ADULT"
      },
      "issuanceLimit":null,
      "originalPrice":10.0,
      "settlementPrice":11.0,
      "merchantCurrency":"SGD",
      "sourceName":"Wildlife Reserves Singapore Group",
      "sourceTitle":"Merchant",
      "ableToDistributeToGlobaltix":true,
      "from":null,
      "did":201949
    },
    {
      "id":227,
      "hasSeries":true,
      "name":"Singapore Zoo - Capacity Open Dated",
      "currency":"SGD",
      "favorited":false,
      "price":10.0,
      "variation":{
        "enumType":"gt.enumeration.Variation",
        "name":"ADULT"
      },
      "issuanceLimit":null,
      "originalPrice":10.0,
      "settlementPrice":10.0,
      "merchantCurrency":"SGD",
      "sourceName":"Wildlife Reserves Singapore Group",
      "sourceTitle":"Merchant",
      "ableToDistributeToGlobaltix":false,
      "from":null,
      "did":100141
    },
    {
      "id":229,
      "hasSeries":true,
      "name":"Singapore Zoo - Capacity Non Open Dated",
      "currency":"SGD",
      "favorited":false,
      "price":10.22,
      "variation":{
        "enumType":"gt.enumeration.Variation",
        "name":"ADULT"
      },
      "issuanceLimit":null,
      "originalPrice":10.0,
      "settlementPrice":10.0,
      "merchantCurrency":"SGD",
      "sourceName":"Wildlife Reserves Singapore Group",
      "sourceTitle":"Merchant",
      "ableToDistributeToGlobaltix":true,
      "from":null,
      "did":100143
    }
  ],
  "error":null,
  "size":null,
  "success":true
}';
		
	return $xml;
	
	}
	
		
}
?>
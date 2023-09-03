<?php
/**
	@File Name 		:	GetAttractionList.php
	@Author 		:	Elavarasan	P
	@Description	:	GetAttractionList service
*/
class GetAttractionList extends Execute
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
		$this->_ApaxTypes  = array('ADULT','CHILD');
		
	}
	
    public function _doGetAttractionList()
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
		$_AresponseArr = array();
		if($_Aresponse['success']==1 && $_Aresponse['size']>0){
			
			$_Smarkup_fee 		= $this->userInfo['markup_fee'];				//2;
			$_Smarkup_type 		= $this->userInfo['markup_type'];				//'percentage';
			$_Smarkup_source 	= $this->userInfo['markup_source'];				// This is for future use
			$_Smarkup_added 	= 'tax';										//base_fare, tax, 
			
			$_SreqCurrencyRate 	= $this->_getCurrencyRate($this->_Ainput['currencyCode']);
			$_Sconvertion_rate	= $_SreqCurrencyRate['value'];
			if($_Sconvertion_rate=='')
				$_Sconvertion_rate=1;
			foreach($_Aresponse['data'] as $_AattractionKey => $_AattractionVal){
				
				if(empty($_AattractionVal['ticketTypes'])){
					continue;
				}
				
				$_AresponseArr[$_AattractionKey]['attractionID'] 		= $_AattractionVal['id'];
				$_AresponseArr[$_AattractionKey]['title'] 				= $_AattractionVal['title'];
				$_AresponseArr[$_AattractionKey]['description'] 		= $_AattractionVal['description'];
				$_AresponseArr[$_AattractionKey]['hoursOfOperation'] 	= $_AattractionVal['hoursOfOperation'];
				$_AresponseArr[$_AattractionKey]['categoryId'] 			= $_AattractionVal['category']['id'];
				$_AresponseArr[$_AattractionKey]['imagePath'] 			= $this->_SrequestUrl.'image?name='.$_AattractionVal['imagePath'];
				
				$_AresponseArr[$_AattractionKey]['dateCreated'] 		= $_AattractionVal['dateCreated'];
				$_AresponseArr[$_AattractionKey]['lastUpdated'] 		= $_AattractionVal['lastUpdated'];
				
				if(!isset($_AattractionVal['country'][0])){
					$_AattractionVal['country'] = array($_AattractionVal['country']);
				}
				
				$_AresponseArr[$_AattractionKey]['country'] 		= $_AattractionVal['country'];
				
				if(!isset($_AattractionVal['city'][0])){
					$_AattractionVal['city'] = array($_AattractionVal['city']);
				}
				$_AresponseArr[$_AattractionKey]['city'] 		= $_AattractionVal['city'];
				
				if(!isset($_AattractionVal['merchant'][0])){
					$_AattractionVal['merchant'] = array($_AattractionVal['merchant']);
				}
				$_AresponseArr[$_AattractionKey]['merchant'] 		= $_AattractionVal['merchant'];
				
				if(!isset($_AattractionVal['ticketTypesAndPackages'][0])){
					$_AattractionVal['ticketTypesAndPackages'] = array($_AattractionVal['ticketTypesAndPackages']);
				}
				
				//$_AresponseArr[$_AattractionKey]['ticketTypesAndPackages'] 		= $_AattractionVal['ticketTypesAndPackages'];
				
				if(!isset($_AattractionVal['ticketTypes'][0])){
					$_AattractionVal['ticketTypes'] = array($_AattractionVal['ticketTypes']);
				}
				
				if(!isset($_AattractionVal['ticketTypes'][0]))
				{
					$_AattractionVal['ticketTypes'] =array($_AattractionVal['ticketTypes']);
				}
				$_AticketNameArr = array();
				$_AmergeArray=array();

				foreach($_AattractionVal['ticketTypes'] as $_AticketKey => $_AticketVal)
				{
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

				$_AresponseArr[$_AattractionKey]['ticketTypes'] 		= $_AmergeArray;
				
				
			}
			
		return array("status"=>true, "msg"=>"GetAttractionList", "data"=>$_AresponseArr);
		}
		else{
			return array("status"=>false, "msg"=>"No GetAttractionList  ", "data"=>'');
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
		$xml = '';
		
	return $xml;
	
	}
	
		
}
?>
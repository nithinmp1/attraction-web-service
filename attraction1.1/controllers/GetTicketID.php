<?php
/**
	@File Name 		:	GetTicketID.php
	@Author 		:	Elavarasan	P
	@Description	:	GetTicketID service
*/
class GetTicketID extends Execute
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
	
    public function _doGetTicketID()
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
		//print_r($_AgetTokenRes);die;
		$this->_modifyData();
		$this->_setData();
		//$_AsearchResult = $this->fun1();
		$_AsearchResult = $this->_executeService();
		echo "<pre>";

			
		if($_AsearchResult!='')
		{
			$_AgetTicketID = json_decode($_AsearchResult,true);
		}

		$_Areturn = $this->_getTicketID($_AgetTicketID, $this->_Ainput);
		return $_Areturn;
	}
	
	function _getTicketID($_Aresponse, $_AinputData)
	{
		if($_Aresponse['success']==1){
			
			
			return array("status"=>true, "msg"=>"GetTicketID", "data"=>$_Aresponse);
		}else if($_Aresponse['error']['code']){
			
			return array("status"=>false, "msg"=>$_Aresponse['error']['code']);
		}
		else {
			
			return array("status"=>false, "msg"=>"Get Ticket ID error");
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
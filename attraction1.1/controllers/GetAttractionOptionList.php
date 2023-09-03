<?php
/**
	@File Name 		:	GetAttractionList.php
	@Author 		:	Elavarasan	P
	@Description	:	GetAttractionList service
*/
class GetAttractionOptionList extends Execute
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
	
    public function _doGetAttractionOptionList()
	{


		$this->_modifyData();
		$this->_setData();
		//$_AsearchResult = $this->fun1();
		
		$_AsearchResult = $this->_executeService();
		
			
		if($_AsearchResult!='')
		{
			$_AgetAttractionList = json_decode($_AsearchResult,true);
		}

		$_Areturn = $this->_getAttractionOptionList($_AgetAttractionList, $this->_Ainput);
		
		
		return $_Areturn;
	}
	
	
	
	
	
	
	function _getAttractionOptionList($_Aresponse, $_AinputData)
	{
		
		$_ApiIdIs		= $this->_Oconf['site']['apiId'];
		$_AccountIdIs = $this->_Oconf['account']['users'][$this->_Ainput['userName']]['account_id'];
		
		$_AresponseArr = array();
		if($_Aresponse['success']==1 && $_Aresponse['size']>0){
			
			
			return array("status"=>true, "msg"=>"GetAttractionOptionList", "data"=>$_Aresponse);
		}
		else{
			return array("status"=>false, "msg"=>"No GetAttractionOptionList  ", "data"=>'');
		}
	}
	
	
	function fun1()
	{
		$xml = '';
		
	return $xml;
	
	}
	
		
}
?>
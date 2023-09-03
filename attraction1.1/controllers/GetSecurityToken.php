<?php
/**
	@File Name 		:	GetSecurityToken.php
	@Author 		:	Elavarasan	P
	@Description	:	GetSecurityToken service
*/
class GetSecurityToken extends Execute
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
		
		$this->_Ainput['postData']='{"username": "'.$this->_Asettings['apiCredentials']['userName'].'", "password": "'.$this->_Asettings['apiCredentials']['password'].'" }';
		
	}
	
    public function _doGetSecurityToken()
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
			$_AgetSecurityToken = json_decode($_AsearchResult,true);
		}

		$_Areturn = $this->_getSecurityToken($_AgetSecurityToken, $this->_Ainput);
		return $_Areturn;
	}
	
	function _getSecurityToken($_Aresponse, $_AinputData)
	{
		//print_r($_Aresponse);
		$_AresponseArr = array();
		if($_Aresponse['success']==1){
			
			$_AresponseArr = $_Aresponse['data'];
			
		}else{
			$_AresponseArr =  array("status" => false, "msg"  => "Security Token Error", "data"	=>	'');
		}
		
		//print_r($_AresponseArr);die;
		
		
		
		return array("status"=>true, "msg"=>"Get Security Token", "data"=>$_AresponseArr);
	}

	function fun1()
	{
		$xml = '{"success":true,"data":{"roles":["RESELLER_ADMIN","RESELLER_FINANCE","RESELLER_OPERATIONS"],"token_type":"Bearer","access_token":"eyJhbGciOiJIUzI1NiJ9.eyJwcmluY2lwYWwiOm51bGwsInN1YiI6InJlc2VsbGVyQGdsb2JhbHRpeC5jb20iLCJleHAiOjE0OTk3NDY3NjEsImlhdCI6MTQ5OTY2MDM2MSwicm9sZXMiOlsiUkVTRUxMRVJfQURNSU4iLCJSRVNFTExFUl9GSU5BTkNFIiwiUkVTRUxMRVJfT1BFUkFUSU9OUyJdfQ.kcTGjS9uky0RuzSEUNJHdxE3Xn4u5px-kCUvf3-fxgw","user":{"id":124,"firstname":null,"lastname":null,"username":"reseller@globaltix.com","merchant":null,"reseller":{"class":"com.globaltix.api.v1.Reseller","id":49,"code":"RED","commissionBasedAgent":null,"country":{"class":"com.globaltix.api.v1.Country","id":1},"createBy":{"class":"com.globaltix.api.v1.User","id":124},"createdBy":null,"credit":{"class":"com.globaltix.api.v1.Credit","id":49},"creditCardPaymentOnly":false,"customEmailAPI":null,"customEmailFilename":"uat_reseller_demo1.gsp","customEmailType":{"enumType":"gt.enumeration.CustomEmailType","name":"EMAIL_TEMPLATE"},"dateCreated":"2016-04-25T14:37:11Z","emailConfig":{"class":"com.globaltix.api.v1.EmailConfig","id":13},"hasBeenNotifiedLowCreditLimit":false,"internalEmail":"emmanuel@globaltix.com","isMerchantBarcodeOnly":true,"isSubAgentOnly":false,"lastUpdated":"2017-07-05T10:30:17Z","lastUpdatedBy":"116","lowCreditLimit":1500.0,"mobileNumber":"546546","name":"Reseller Demo","notifyLowCredit":true,"notifyLowCreditEmail":"emmanuel@globaltix.com","onlineStore":{"class":"com.globaltix.api.v1.Reseller","id":2162},"ownMerchant":{"class":"com.globaltix.api.v1.Merchant","id":126},"presetGroups":[{"class":"com.globaltix.api.v1.PresetGroup","id":9}],"primaryPresetGroup":{"class":"com.globaltix.api.v1.PresetGroup","id":9},"sendCustomEmail":false,"size":{"enumType":"gt.enumeration.Size","name":"Small"},"status":{"enumType":"gt.enumeration.Status","name":"PUBLISHED"},"subAgentGroups":[{"class":"com.globaltix.api.v1.SubAgentGroup","id":196},{"class":"com.globaltix.api.v1.SubAgentGroup","id":194},{"class":"com.globaltix.api.v1.SubAgentGroup","id":195},{"class":"com.globaltix.api.v1.SubAgentGroup","id":193}],"transactionFee":0.22},"backoffice":null,"currency":{"code":"SGD","description":"Singapore Dollar","markup":0.00,"roundingUp":0.01,"creditCardFee":3.00},"isProxyUser":false},"expires_in":86400,"refresh_token":"eyJhbGciOiJIUzI1NiJ9.eyJwcmluY2lwYWwiOm51bGwsInN1YiI6InJlc2VsbGVyQGdsb2JhbHRpeC5jb20iLCJpYXQiOjE0OTk2NjAzNjEsInJvbGVzIjpbIlJFU0VMTEVSX0FETUlOIiwiUkVTRUxMRVJfRklOQU5DRSIsIlJFU0VMTEVSX09QRVJBVElPTlMiXX0.ALq-wPu0Iv5005eggnCKs4zh8Z78sVO1_fbFq3uXwdY"},"error":null}';
		
	return $xml;
	
	}
	
		
}
?>
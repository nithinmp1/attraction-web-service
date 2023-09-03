<?php
/**
	@File Name 		:	GetVouchers.php
	@Author 		:	Elavarasan	P
	@Date			:   11-07-2017
	@Description	:	GetVouchers service
*/
class GetVouchers extends Execute
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
		$this->_SrequestUrl = $this->_Oconf['userSettings']['apiUrl']['getVouchersURL'];
		
	}
	
    public function _doGetVouchers()
	{
		
		$_Bstatus  = true;
		$_Smessage = '';
		$_Adata	   = array();
		
		$this->_modifyData();
		$this->_setData();
		//$_AsearchResult = $this->fun1();
		$_AsearchResult = $this->_executeService();
		
		if(count($_AsearchResult)>0){
			
			return array("status"=>true, "msg"=>"GetVouchers", "data"=>$_AsearchResult);
		
		}else{
			
			return array("status"=>false, "msg"=>"Get Ticket Details Error", "data"=>'');
			
		}
		return $_Areturn;
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
		$xml = '{"data":{"originalPrice":34.0,"redeemEnd":null,"applyCapacity":false,"questions":[],"description":"For general admission ticket","settlementRate":35.0,"merchantProductCode":null,"variation":{"enumType":"gt.enumeration.Variation","name":"ADULT"},"payableAmount":35.0,"termsAndConditions":"Terms and Conditions for Singapore Zoo","publishStart":"2016-12-07T00:00:00","lastUpdated":"2017-07-04T09:46:30Z","isMerchantBarcodeOnly":false,"dateCreated":"2016-12-07T03:58:39Z","barcodeBin":{"additionalInfos":[{"remark":null,"id":184,"label":null,"class":"com.globaltix.api.v1.BarcodeBinAdditionalInfo"}],"barcodeOutputType":{"enumType":"gt.enumeration.BarcodeOutputType","name":"EMAIL"},"validFor":"Valid on the day of redemption only","format":"EAN_128","barcodesLimitNotification":2,"termsAndConditions":"If purchasing tickets from a 3rd party seller, you are strongly advised to verify that the seller is an authorised ticket agent.\n\nPlease be informed that each ticket is a revocable licence and we reserve the right to only honour tickets sold through our ticketing counter, our official website, SISTIC and authorised travel agents only.\n\nAll other tickets obtained through fraudulent or unauthorized resale transaction will not be honoured at our entrance for admission.","emails":["sajithasela@gmail.com"],"attraction":{"id":1},"left":5,"validityPeriodText":null,"name":"Singapore Zoo Adult Admission (Barcode)","validityPeriodType":{"enumType":"gt.enumeration.PrintTicketValidityPeriodType","name":"HIDE"},"id":31,"templateFilename":null,"sku":"Z0001","skipBarcodes":false},"currency":"SGD","id":519,"owner":null,"lastUpdatedBy":"124","isOpenDated":false,"publishEnd":null,"definedDuration":200,"redeemStart":null,"showTypeName":null,"payableToMerchant":0,"linkId":524,"attraction":{"id":1,"title":"Singapore Zoo (UAT)"},"gtPackageOnlyPrice":33.0,"createdBy":"44","series":[],"name":"General Admission","changeStatus":null,"SKU":"01WLR0100DA","did":149909,"status":{"enumType":"gt.enumeration.Status","name":"PUBLISHED"}},"error":null,"size":null,"success":true}';
		
	return $xml;
	
	}
	
		
}
?>
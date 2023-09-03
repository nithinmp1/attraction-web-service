<?php
/**
	@File Name 		:	Common.php
	@Author 		:	Ramanathan M <ramanathan@dss.com.sg>
	@Created Date	:	2015-12-21 10:55 AM
	@Description	:	All commonly using function will be here and it should be accessable through out the application
**/
class Common
{
	public static function getSecureHash($_AuserInfo,$_Ainput)
	{		
		$_ShashSeparator	= $_AuserInfo['hashSettings']['hashSeparator'];
		$_ShasFormat		= $_AuserInfo['hashSettings']['hashFormat'];
		$_SencryptionType	= $_AuserInfo['hashSettings']['encryptionType'];

		$_SinpStr		= '';
		$_Sappened		= '';
		$_AhasExplode	= explode($_ShashSeparator,$_ShasFormat);
		
		foreach($_AhasExplode as $_Ikey=>$_Sval){
			
			$_SinpVal = $_Sval.':';
			
			if($_Sval == 'salt'){
				$_SinpVal .= $_AuserInfo['salt'];
			}
			else if($_Sval == 'sectorInfo'){
				if(isset($_Ainput[$_Sval])){
					foreach($_Ainput[$_Sval] as $_IsecKey=>$_SsecVal){
						$_SinpVal .= $_SsecVal['origin'].$_SsecVal['destination'].$_SsecVal['departureDate'];
					}
				}
			}
			else{
				if(isset($_Ainput[$_Sval])){
					$_SinpVal .= $_Ainput[$_Sval];
				}
			}
			
			$_SinpStr	.= $_Sappened.$_SinpVal;
			$_Sappened   = $_ShashSeparator;
		}
		
		$_SencString = '';
				
		switch ($_SencryptionType){			
			case  'MD5':		
				$_SencString = md5($_SinpStr);	
				break;
			default:
				$_SencString = '';
		}
		
		return $_SencString;
	}
	
	public function xmlstrToArray($xmlstr)
	{
		$doc = new DOMDocument();
		$doc->loadXML($xmlstr);
		return self::domNodeToArray($doc->documentElement);
	}
	
	function domNodeToArray($node) 
	{
		$output = array();
		switch ($node->nodeType) {
			case XML_CDATA_SECTION_NODE:
			case XML_TEXT_NODE:
				$output = trim($node->textContent);
				break;
			case XML_ELEMENT_NODE:
				for ($i=0, $m=$node->childNodes->length; $i<$m; $i++) { 
					$child = $node->childNodes->item($i);
					$v = self::domNodeToArray($child);
					if(isset($child->tagName)) {
						$t = $child->tagName;
						$t1 = explode(":",$t);
						if(isset($t1[1])){
							$t = $t1[1];
						}
						if(!isset($output[$t])) {
							$output[$t] = array();
						}
						$output[$t][] = $v;
					}
					elseif($v) {
						$output = (string) $v;
					}
				}
				if($node->attributes->length && !is_array($output)) {
                    $output = array('content'=>$output);
                }
				if(is_array($output)) {
					if($node->attributes->length) {
						$a = array();
						foreach($node->attributes as $attrName => $attrNode) {
							$a[$attrName] = (string) $attrNode->value;
						}
						$output['attributes'] = $a;
					}
					foreach ($output as $t => $v) {
						if(is_array($v) && count($v)==1 && $t!='attributes') {
							$output[$t] = $v[0];
						}
					}
				}
			break;
		}
		return $output;
	}
	
	function getMarkup($_MarkupArray, $_AccountId, $_API, $_Country, $_Attraction){
		$_Markup_fee 		= 0;
		$_Markup_type 		= '';	
		$_Markup_source 	= '';
		$_Child_Markup_fee	= 0;
		for($i=1;$i<=2;$i++){
			if($i==2){
				// All accounts markup
				$_AccountId = 0;
			}
			
			if( isset($_MarkupArray[$_AccountId]) ){
				//if(isset($_MarkupArray[$_AccountId])){
					$_AttractionValues = 	array( "markup_amount" => 0, "markup_fee_type" => 0, "markup_type" => 0 );
					if(isset($_MarkupArray[$_AccountId][$_API][$_Country][$_Attraction])){
						$_AttractionValues = $_MarkupArray[$_AccountId][$_API][$_Country][$_Attraction];
					}else if(isset($_MarkupArray[$_AccountId][$_API][$_Country][0])){
						$_AttractionValues = $_MarkupArray[$_AccountId][$_API][$_Country][0];
					}else if(isset($_MarkupArray[$_AccountId][$_API][0][$_Attraction])){
						$_AttractionValues = $_MarkupArray[$_AccountId][$_API][0][$_Attraction];
					}else if(isset($_MarkupArray[$_AccountId][$_API][0][0])){
						$_AttractionValues = $_MarkupArray[$_AccountId][$_API][0][0];
					}else if(isset($_MarkupArray[$_AccountId][0][$_Country][$_Attraction])){
						$_AttractionValues = $_MarkupArray[$_AccountId][0][$_Country][$_Attraction];
					}else if(isset($_MarkupArray[$_AccountId][0][$_Country][0])){
						$_AttractionValues = $_MarkupArray[$_AccountId][0][$_Country][0];                                        
					}else if(isset($_MarkupArray[$_AccountId][0][0][$_Attraction])){
						$_AttractionValues = $_MarkupArray[$_AccountId][0][0][$_Attraction];                                    
					}else if(isset($_MarkupArray[$_AccountId][0][0][0])){
						$_AttractionValues = $_MarkupArray[$_AccountId][0][0][0];
					}
					
					if($_AttractionValues['markup_amount'] !=0){
						$_Markup_fee 		= $_AttractionValues['markup_amount'];
						$_Child_Markup_fee 	= $_AttractionValues['child_markup_amount'];
						$_Markup_type 		= $_AttractionValues['markup_fee_type'];	
						$_Markup_source 	= $_AttractionValues['markup_type'];
						break;
					}
				//}
			}
		}
		
		//echo "<pre>";
		//print_r(array( "markup_amount" => $_Markup_fee, "markup_fee_type" => $_Markup_type, "markup_type" => $_Markup_source ));
		return array( "markup_amount" => $_Markup_fee,"child_markup_amount" => $_Child_Markup_fee, "markup_fee_type" => $_Markup_type, "markup_type" => $_Markup_source );
		
	}
	
	
	
	
	/* Check balance is available or not for API(Airline) and user */
	function checkBalance( $_IbookingAmount, $_SbookingCurrency, $thisObj ){
		
		$_IapiId			= $this->_Oconf['site']['apiId'];
		$_IapiShortId 		= $this->_Oconf['site']['apiShortId'];
		$_flagReturn 		= false;
		
		//$_IisapiBalance = self::getApiAvailableAmount($_IapiId);
		
		//if($_IisapiBalance>=$_IbookingAmount){
			
			$sqlAccount 		= "SELECT
											(credit_limit + available_balance) as userBalance,
											currency,
											balance_type,
											credit_limit
								   FROM
											account_details
								   WHERE
											account_id = '".$this->userInfo['account_id']."'";
						
			$_Aresult = $thisObj->_Odb->getAll($sqlAccount);
			
			if(isset($_Aresult) && !empty($_Aresult)){
				
				$_CreditLimit  = ( isset($_Aresult[0]['credit_limit']) && !empty($_Aresult[0]['credit_limit']) ) ? $_Aresult[0]['credit_limit'] : 0;
				$_IuserBalance = 0;
				
				if($_Aresult[0]['balance_type'] == "A"){
					if(isset($_Aresult[0]['userBalance']) && $_Aresult[0]['userBalance'] > 0 ){
						$_IuserBalance = $_Aresult[0]['userBalance'];
					}
				}else if($_Aresult[0]['balance_type'] == "S"){
					$sqlGetAccountApiBalance = 	"
													SELECT
														available_balance
													FROM
														account_api_balance
													WHERE
														account_id	= '".$this->userInfo['account_id']."'
														AND 
														api_id = '".$_IapiId."'
														AND
														api_short_id = '".$_IapiShortId."'
												";
					$_RsApiUserBalance = $thisObj->_Odb->getAll($sqlGetAccountApiBalance);
					
					if(isset($_RsApiUserBalance) && !empty($_RsApiUserBalance)){
						if(isset($_RsApiUserBalance[0]['available_balance']) && $_RsApiUserBalance[0]['available_balance'] > 0 ){
							$_IuserBalance = $_RsApiUserBalance[0]['available_balance']+$_CreditLimit;
						}
					}
				}
				$_AuserExchangeRate		= $this->_getCurrencyRate($_Aresult[0]['currency']);
				$_IuserBaseAmount		= ($_IuserBalance/$_AuserExchangeRate['value']);
				$_IuserBaseAmount		= round($_IuserBaseAmount,3);
				
				$_AbookingExchangeRate  = $this->_getCurrencyRate($_SbookingCurrency);
				$_IbookingBaseAmount	= ($_IbookingAmount/$_AbookingExchangeRate['value']);
				$_IbookingBaseAmount	= round($_IbookingBaseAmount,3);
				if($_IuserBaseAmount > $_IbookingBaseAmount){
					$_flagReturn = true;
				}
			}
		/* }else{
			//echo "Booking amount is greaterthan API balance amount";
			logWrite("\nBooking amount is greaterthan API balance amount\n","LogXML",'Y','a+');
			/* Booking amount is greaterthan API balance amount */
		/* } */
		return $_flagReturn;
	}
	
	
	/* Update balance for API based */
	function updateBalance( $_IdebitAmount, $_IapiDebitAmount, $_IbookingDetailsId, $_SmodeOfPayment, $_StransactionRefNo, $_SaccountCurrency, $_SaccountExchangeRate, $thisObj ){
		$_IapiId				= $this->_Oconf['site']['apiId'];
		$_CurrentTimestamp 		= date("Y-m-d H:i:s");
		
		$_IaccountId 			= $this->userInfo['account_id'];
		$_IapiShortId 			= $this->_Oconf['site']['apiShortId'];
		
		$sqlCreditDebit = "INSERT INTO account_credit_debit
							(account_id, booking_id, api_id, trancation_amount, transaction_type, mode_of_payment, mode,	transaction_ref_no, transaction_currency, exchange_rate, last_update_date, credit_debit_date, created_date)
							VALUES  
							( '".$_IaccountId."', '".$_IbookingDetailsId."', '".$_IapiShortId."', '".$_IdebitAmount."',  'debit', 'attractionBooking', '".$_SmodeOfPayment."', '".$_StransactionRefNo."', '".$_SaccountCurrency."',  '".$_SaccountExchangeRate."',  '".$_CurrentTimestamp."',  '".$_CurrentTimestamp."', '".$_CurrentTimestamp."' )";
						
		$_IcreditDebitId = $thisObj->_Odb->executeQuery($sqlCreditDebit);
		
		$sqlUpdateAvblBalanace = "UPDATE account_details SET available_balance = available_balance-".$_IdebitAmount.", last_updated_date='".$_CurrentTimestamp."' WHERE account_id = '".$_IaccountId."'";		
		
		$thisObj->_Odb->executeQuery($sqlUpdateAvblBalanace);	
		
		
		$_IapiAvailableAmt	= ( self::getApiAvailableAmount($_IapiId, $_IapiShortId, $thisObj) - $_IapiDebitAmount );
		
		$_Sqery 		= "UPDATE api_balance SET available_amount = available_amount - '".$_IapiDebitAmount."' WHERE api_id='".$_IapiId."' AND api_short_id = '".$_IapiShortId."'";
		$thisObj->_Odb->executeQuery($_Sqery);
		
		$_Sqeruy		= "INSERT INTO api_deposit (api_id,transaction_type,amount,available_amount,pnr_no,updated_by,update_date,alert_status) VALUES ('".$_IapiShortId."','D','".$_IdebitAmount."','".$_IapiAvailableAmt."','".$_StransactionRefNo."', 1	, '".$_CurrentTimestamp."' ,'C')";
		
		
		$thisObj->_Odb->executeQuery($_Sqeruy);
				
		$sqlAccount 		= "SELECT balance_type FROM account_details WHERE account_id = '".$GLOBALS['CONF']['userSettings']['accountId']."'";
		$_Aresult = $thisObj->_Odb->getAll($sqlAccount);
		if(isset($_Aresult) && !empty($_Aresult)){
			if($_Aresult[0]['balance_type'] == "S"){
				$_SuserDetails	= "UPDATE account_api_balance SET available_balance = available_balance-".$_IdebitAmount." WHERE account_id = '".$_IaccountId."' AND api_id='".$_IapiId."' AND api_short_id = '".$_IapiShortId."'";
				$thisObj->_Odb->executeQuery($_SuserDetails);
			}
		}
	}
	
	/* Get API(Airline) balance */
	function getApiAvailableAmount($_IapiId, $_IapiShortId, $thisObj){
		
		
		
		$_IapiAvailableAmt		=	0;
		$sqlGetApiAvailableAmt	=	" SELECT available_amount FROM api_balance WHERE api_id='".$_IapiId."' AND api_short_id='".$_IapiShortId."'";
		$_RsApiAvailableAmt = $thisObj->_Odb->getAll($sqlGetApiAvailableAmt);
		if(isset($_RsApiAvailableAmt) && !empty($_RsApiAvailableAmt)){
			if(isset($_RsApiAvailableAmt[0]['available_amount']) && $_RsApiAvailableAmt[0]['available_amount'] > 0 ){
				$_IapiAvailableAmt		=	$_RsApiAvailableAmt[0]['available_amount'];
			}
		}
		return $_IapiAvailableAmt;
	}
	
	
	
	
	
	
	
}
?>
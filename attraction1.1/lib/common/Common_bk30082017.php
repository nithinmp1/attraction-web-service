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
						$_Markup_type 		= $_AttractionValues['markup_fee_type'];	
						$_Markup_source 	= $_AttractionValues['markup_type'];
						break;
					}
				//}
			}
		}
		
		//echo "<pre>";
		//print_r(array( "markup_amount" => $_Markup_fee, "markup_fee_type" => $_Markup_type, "markup_type" => $_Markup_source ));
		return array( "markup_amount" => $_Markup_fee, "markup_fee_type" => $_Markup_type, "markup_type" => $_Markup_source );
		
	}
}
?>
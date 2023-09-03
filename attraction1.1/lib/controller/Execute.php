<?php
/**
	@File Name 		:	Execute.php
	@Author 		:	Ramanathan M <ramanathan@dss.com.sg>
	@Created Date	:	2015-12-21 10:55 AM
	@Description	:	Execute the webservive
*/
class Execute 
{
	var $_SwebserviceMethod;
	var $_Asettings;
	var $_SreqXml;
	var $_SheaderXml;
	var $_SrequestUrl;
	var $_IreferenceId;
	
	function __construct()
	{
		$this->_SwebserviceMethod = $GLOBALS['CONF']['site']['webserviceMethod'];
		$this->_Asettings		  = array();
		$this->_SreqXml			  = '';
		$this->_SheaderXml		  = '';
		$this->_SrequestUrl		  = '';
		$this->_IreferenceId	  = 0;
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
	
    public function _setData()
	{
		$this->_assignValues();		
	}

	public function _assignValues()
	{
		if(isset($this->_Ainput['serviceProviderCode']) && $this->_Ainput['serviceProviderCode']=='ACH'){
			$this->_Asettings['apiCredentials']['travelMediaTargetBranch']	= $this->_Asettings['apiCredentials']['goBudgetAirTargetBranch'];
			$this->_Asettings['apiCredentials']['travelMediaPCC']			= $this->_Asettings['apiCredentials']['goBudgetAirPCC'];
		}
		else{
			$this->_Ainput['serviceProviderCode'] = '1G';
		}
		
		if(isset($this->_Ainput['serviceProviderCode']) && !empty($this->_Ainput['serviceProviderCode'])){
			$this->_IreferenceId = $this->_Ainput['serviceProviderCode']."-".$this->_IreferenceId;
		}
		
		$this->_SheaderXml='';
		$functionName = $this->_Asettings['actionInfo']['bodyTpl'];
		
		$functionName = str_replace(".php","",$functionName);
		$functionName = str_replace(".tpl","",$functionName);
		fileInclude("views/{$functionName}.php");
		$this->_SreqXml	= $functionName($this);
	}
	
	public function _executeService()
	{
		if($this->_SwebserviceMethod  == 'SOAP'){
			 return $this->_doSoapAction();
		}
		
		if($this->_SwebserviceMethod  == 'CURL'){
			 return $this->_doCurlAction();
		}
	}
	
	public function _doCurlAction()
	{
		$header			= trim($this->_SheaderXml);
		$requestXml 	= trim($this->_SreqXml);


		
		$httpHeader2 = array(
    		'X-Authorization: 67d706fda09dcad1f882de5691a0fb0b86af1e8f',
   			'Content-Type: application/json',
   			'Accept: application/json'
		);
	
		
		$url = $this->_SrequestUrl.$requestXml; 
		$ch2  = curl_init();
		curl_setopt($ch2, CURLOPT_URL, $url);
		curl_setopt($ch2, CURLOPT_HTTPHEADER, $httpHeader2);
		curl_setopt($ch2, CURLOPT_TIMEOUT, 180);
		curl_setopt($ch2, CURLOPT_HEADER, 0);
		curl_setopt($ch2, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch2, CURLOPT_CUSTOMREQUEST, 'GET');


		curl_setopt($ch2, CURLOPT_SSL_VERIFYPEER, false); 
		curl_setopt($ch2, CURLOPT_SSL_VERIFYHOST, false);
		//curl_setopt ($ch2, CURLOPT_ENCODING, "gzip,deflate"); 
		
		if(!empty($this->_IreferenceId)){
			logWrite("\n Request \n ----------- \n".$url.print_r($this->_Ainput['postData'],true)."\n","LogXML-".$this->_IreferenceId,'N','a+');
			logWrite("\n Headers \n ----------- \n".print_r($httpHeader2,true)."\n","LogXML-".$this->_IreferenceId,'N','a+');
		}
		else{
			logWrite("\n Request \n ----------- \n".$url.print_r($this->_Ainput['postData'],true),"LogXML",'Y','a+');
			
			logWrite("\n Headers \n ----------- \n".print_r($httpHeader2,true),"LogXML",'Y','a+');
		}
		$response = '';
		
		//if($this->_Ainput['action']!='PaymentTransaction'){
			
			//if($this->_Ainput['action']=='GetSecurityToken')
			{
				$response = curl_exec($ch2);         
			}
		//} 
		
		//echo "<pre>";print_r($response);die;
		
		//$replaceArr = array('u002f');  
		//$response = str_replace($replaceArr,"",$response);
			
		curl_close($ch2); 
		
		
		//if($this->_Ainput['action']=='GetAttractionList' || $this->_Ainput['action']=='GetAttractionFirstList'){
			//$response_display = "success";   //We have restricted to filewrite attractions response.
			$response_display = $response;   //We have restricted to filewrite attractions response.
			
			if(!empty($this->_IreferenceId)){
				
					logWrite("Response\n-------------\n".$response_display,"LogXML-".$this->_IreferenceId,'N','a+'); 
					$replaceArr = array(",,","'","#",'  ""');     
					$response_display = str_replace($replaceArr,"",$response_display);
					
					$response_display = str_replace("null",'""',$response_display); 
					//$response_display = str_replace("<\,",'</',$response_display);      
					$response_display = str_replace("<\u002f",'</',$response_display);          
					$response_display = str_replace(' ""','',$response_display);         
					
				logWrite("".$response_display,"LogXML-Res__2".$this->_IreferenceId,'N','a+');
			}
			else{
				logWrite("\n Response \n ----------- \n".$response_display,"LogXML-Res",'Y','a+'); 
			}
		/* }else{
			$response_display = $response;   
			
			logWrite("\n Response \n ----------- \n".$response_display,"LogXML-Res",'Y','a+'); 
		} */
		
		
		
		
		return $response_display;     
	}
}
?>
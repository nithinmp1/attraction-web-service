<?php
/**
	@File Name 		:	controllerGet.php
	@Author 		:	Ramanathan M <rammrkv@gmail.com>
	@Created Date	:	2015-08-21 10:10 PM
	@Description	:	Cobtroller get process file will create instance for the required class
*/
class controllerGet
{
	public static function getObject($reqAction='',$thisObj,$instanceVal='NEW')
    {	
        if(!empty($reqAction)){
		
			if(isset($GLOBALS['CONF']['api']['actions'][$reqAction]['className'])){
				
				$className      = $GLOBALS['CONF']['api']['actions'][$reqAction]['className'];
				$actionName     = $GLOBALS['CONF']['api']['actions'][$reqAction]['className'];
				$templateName   = $GLOBALS['CONF']['api']['actions'][$reqAction]['bodyTpl'];
					
				fileInclude("controllers/{$className}.php");
				
				if(!empty($instanceVal) && $instanceVal == 'NEW'){
					$instance = new $className;
				}
				else{
					$instance = call_user_func($className.'::singleton');
				}
				
				$instance->_Osmarty 			= $thisObj->_Osmarty;
				$instance->_Odb 				= $thisObj->_Odb;
				$instance->_Oconf 				= $thisObj->_Oconf;
				
				$instance->_Ainput	 			= $thisObj->_Ainput;
				$instance->_Asettings 			= $thisObj->_Asettings;
				$instance->_Asettings['action'] = $className;
				
				$instance->_Asettings['actionInfo']['className'] = $className;
				$instance->_Asettings['actionInfo']['headerTpl'] = 'headerXml.tpl';
				$instance->_Asettings['actionInfo']['bodyTpl'] = $className.'Xml.tpl';
				
				$instance->_SclassName 			= $className;
				$instance->_SactionName 		= $className;
		
				$instance->_IreferenceId 		= $thisObj->_IreferenceId;
				$instance->_StemplateName 		= $templateName;				

				return $instance;
			}
        }
        return false;
    }
}
?>
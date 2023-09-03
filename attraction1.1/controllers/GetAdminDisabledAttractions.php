<?php
/**
	@File Name 		:	GetAdminDisabledAttractions.php.php
	@Author 		:	Satish kilari
	@Description	:	GetAdminDisabledAttractions.php service- Get Disabled Attracations .
*/

class GetAdminDisabledAttractions extends Execute
{
	public $_MasterInput = array();
	function __construct(){
		parent::__construct();
	}
	
	public static function &singleton(){
        static $instance;
        // If the instance is not there, create one
        if (!isset($instance)) {
            $class = __CLASS__;
            $instance = new $class();
        }
        return $instance;
    }
	
	/* public function _modifyData(){
		
		$this->_Ainput['apiCurrencyCode']	= $this->_Oconf['site']['apiCurrencyCode'];
		$this->_Ainput['baseCurrencyCode']	= $this->_Oconf['site']['baseCurrencyCode'];
	
	} */
	
    public function _doGetAdminDisabledAttractions(){
		
		//$this->_modifyData();
		//$this->_setData();

		$_AsearchResult = $this->_GetAllBranch();
		return $_AsearchResult;
	}
	
	function _GetAllBranch(){
		
		
		$_AgetBranchResult = $this->GetAllBranch();
		$_AreturnArr = array();
		if(!empty($_AgetBranchResult)){
			
			$_AreturnArr = array("status"=>true, "msg"=>"Deactivated Attractions List", "data"=>$_AgetBranchResult);
		}
		else{
			$_AreturnArr = array("status"=>false, "msg"=>"Deactivated Attractions Not Available", "data"=>"");
		}
		
		return $_AreturnArr;
		
	}
	
	/**		Get Supplier Data	**/
	function GetAllBranch(){
		//echo "satish";exit;
		/* if($_POST['api'] == '9' || $_POST['api'] == '18' || $_POST['api'] == '25')
		{ */
			$query   = "SELECT m.api_id,a.attraction_name as name,matm.attraction_id,ap.api_name
			FROM attraction_api_management_details as m
			LEFT JOIN api_attraction_mapping_details as matm ON m.details_id = matm.details_id
			LEFT JOIN attraction_list as a ON a.attraction_id = matm.attraction_id 
			LEFT JOIN api as ap on ap.api_id = m.api_id
			WHERE m.status='A'";
			

/* WHERE m.api_id='".$_POST['api']."' AND a.api_id='".$_POST['api']."' AND m.details_id ='".$_POST['markupId']."'group by  matm.attraction_id ORDER BY m.details_id DESC"; */
		/*} else if($_POST['api'] == '24')
		{
	
			$query = "SELECT 
							SQL_CALC_FOUND_ROWS 
							a.attraction_name as name
							FROM attraction_api_management_details as m
							LEFT JOIN api_attraction_mapping_details as matm ON m.details_id = matm.details_id
							LEFT JOIN attractions_views_list as a ON a.attraction_id = matm.attraction_id WHERE m.api_id='".$_POST['api']."' AND a.api_id='".$_POST['api']."' AND m.details_id ='".$_POST['markupId']."'group by  matm.attraction_id ORDER BY m.details_id DESC";
	
		}  *///order by mbn.`branch_name` asc
			$data = $this->_Odb->getAll($query);
			return $data;
		//}
	}
	
		
}
?>
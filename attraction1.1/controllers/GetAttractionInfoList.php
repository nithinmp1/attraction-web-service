<?php
/**
	@File Name 		:	GetAttractionList.php
	@Author 		:	Elavarasan	P
	@Description	:	GetAttractionList service
*/
class GetAttractionInfoList extends Execute
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
	
    public function _doGetAttractionInfoList()
	{


		$this->_modifyData();
		$this->_setData();
		$_AsearchResult = $this->fun1();
		
		//$_AsearchResult = $this->_executeService();
		
			
		if($_AsearchResult!='')
		{
			$_AgetAttractionList = json_decode($_AsearchResult,true);
		}

		$_Areturn = $this->_getAttractionInfoList($_AgetAttractionList, $this->_Ainput);
		
		
		return $_Areturn;
	}
	
	
	
	
	
	
	function _getAttractionInfoList($_Aresponse, $_AinputData)
	{
		
		$_ApiIdIs		= $this->_Oconf['site']['apiId'];
		$_AccountIdIs = $this->_Oconf['account']['users'][$this->_Ainput['userName']]['account_id'];
		
		$_AresponseArr = array();
		if($_Aresponse['success']==1 && $_Aresponse['size']>0){
			
			
			return array("status"=>true, "msg"=>"GetAttractionInfoList", "data"=>$_Aresponse);
		}
		else{
			return array("status"=>false, "msg"=>"No GetAttractionInfoList  ", "data"=>'');
		}
	}
	
	
	function fun1()
	{
		$xml = '{"data":{"country":"Singapore","originalPrice":61.0,"keywords":null,"blockedDate":[{"date":"2023-06-09T16:00:00Z","title":"holiday"},{"date":"2023-07-05T16:00:00Z","title":"cleaning"},{"date":"2023-07-10T16:00:00Z","title":"nov 11 maintenance"},{"date":"2023-07-29T16:00:00Z","title":"maintenance smaple"}],"fromPrice":61.0,"city":"Singapore","postalCode":"098269","latitude":1.25486,"description":"Experience Southeast Asia’s first and only Universal Studios theme park based on your favourite blockbuster films and television series. Get an adrenaline rush on cutting-edge rides like Battlestar Galactica: HUMAN vs. CYLON™, TRANSFORMERS The Ride: The Ultimate 3D Battle, while the little ones laugh along to Sesame Street Spaghetti Space Chase. And get ready to strike a pose with the stars of DreamWorks Animation’s Kung Fu Panda and your favourite Minions from Illumination’s Despicable Me.","media":[],"countryId":1,"whatToExpect":"6 Themed Zones\n\n- Hollywood: Stroll down the Walk of Fame on Hollywood Boulevard and onto the sets of your favourite blockbuster movies.\n\n- New York: Walk the sidewalks of the Big Apple and experience the energy of NYC, just as youve seen it in the movies.\n\n- Sci-Fi City: Explore this action-packed futuristic metropolis, home to adrenaline rides including TRANSFORMERS The Ride: The Ultimate 3D battle and Battlestar Galactica: HUMAN vs. CYLON.\n\n- Ancient Egypt: Step back into 1920s Egypt and explore ancient obelisks, the riddles of the Sphinx and curse-ridden rides.\n\n- The Lost World: Walk with dinosaurs in Jurassic Park and watch death-defying stunts at WaterWorlds sensational water show.\n\n- Far Far Away: Step into the fairytale kingdom of Far Far Away with castles, green ogres, a talking donkey and magic potions.","timezoneOffset":480,"currency":"SGD","id":57,"isGTRecommend":true,"longitude":103.82347,"image":"733235dd-2654-4d3c-9740-051bb3df6098","isOpenDated":true,"isOwnContracted":false,"merchant":{"name":"Resorts World Sentosa","id":68},"isFavorited":false,"isBestSeller":false,"fromReseller":null,"highlights":["1st sample","2nd sample","3rd sample","4th sample","5th sample"],"operatingHours":{"fixedDays":[{"day":"SUNDAY","startHour":"11:00","endHour":"18:00"},{"day":"MONDAY","startHour":"11:00","endHour":"18:00"},{"day":"TUESDAY","startHour":"11:00","endHour":"18:00"},{"day":"WEDNESDAY","startHour":"11:00","endHour":"18:00"},{"day":"THURSDAY","startHour":"11:00","endHour":"18:00"},{"day":"FRIDAY","startHour":"11:00","endHour":"18:00"},{"day":"SATURDAY","startHour":"11:00","endHour":"18:00"}],"isToursActivities":null,"custom":"Operating hours may be subject to changes without prior notice."},"name":"Universal Studios Singapore","isInstantConfirmation":true,"location":"8 Sentosa Gateway, Singapore 098269","category":"Attraction","thingsToNote":["Operation Hours: Please kindly visit Universal Studios Singapore official website for any updates of operation hours.","Operation Hours: Rides and shows operating hours may be subject to changes without prior notice.","Operation Hours: Selected rides, street entertainment, meet-and-greet, events, show performances and experiences will not be available until further notice.","Restrictions: Please kindly visit Universal Studios Singapore official website for the age and height restrictions of the rides and attractions.","Dresscode: For the best experience, you are advised to wear comfortable clothes and shoes.","Dresscode: You may wish to bring along a spare set of clothes as you may get wet at select attractions.","Accessibility: View the Riders Guide for Rider Safety and Guest with Disabilities."]},"error":null,"size":1,"success":true}';
		
	return $xml;
	
	}
	
		
}
?>
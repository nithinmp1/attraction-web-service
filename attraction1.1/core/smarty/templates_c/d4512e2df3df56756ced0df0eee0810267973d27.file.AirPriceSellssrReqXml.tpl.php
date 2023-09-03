<?php /* Smarty version Smarty-3.1.21, created on 2017-03-30 16:54:56
         compiled from "F:\xampp\htdocs\bridges\airline\travelportNew\views\AirPriceSellssrReqXml.tpl" */ ?>
<?php /*%%SmartyHeaderCode:31975869fabf80bb08-80326599%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'd4512e2df3df56756ced0df0eee0810267973d27' => 
    array (
      0 => 'F:\\xampp\\htdocs\\bridges\\airline\\travelportNew\\views\\AirPriceSellssrReqXml.tpl',
      1 => 1490869245,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '31975869fabf80bb08-80326599',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.21',
  'unifunc' => 'content_5869fabfaf1e17_32036640',
  'variables' => 
  array (
    '_Ainput' => 0,
    '_Asettings' => 0,
    'hostTokenXml' => 0,
    'airPricingCommandXml' => 0,
    'loop' => 0,
    'idx' => 0,
    '_Oconf' => 0,
    'idxVal' => 0,
    'itemVal' => 0,
    'keyVal' => 0,
    'PaxType' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5869fabfaf1e17_32036640')) {function content_5869fabfaf1e17_32036640($_smarty_tpl) {?><AirPriceReq xmlns="http://www.travelport.com/schema/air_v35_0" TraceId="<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['traceId'];?>
" AuthorizedBy="<?php echo $_smarty_tpl->tpl_vars['_Asettings']->value['apiCredentials']['AuthorizedBy'];?>
" TargetBranch="<?php echo $_smarty_tpl->tpl_vars['_Asettings']->value['apiCredentials']['travelMediaTargetBranch'];?>
">
   <BillingPointOfSaleInfo xmlns="http://www.travelport.com/schema/common_v35_0" OriginApplication="<?php echo $_smarty_tpl->tpl_vars['_Asettings']->value['apiCredentials']['application'];?>
" />
   <AirItinerary>
	  <?php $_smarty_tpl->tpl_vars["providerCode"] = new Smarty_variable('', null, 0);?>
      <?php if (isset($_smarty_tpl->tpl_vars['_Ainput']->value['providerCode'])&&$_smarty_tpl->tpl_vars['_Ainput']->value['providerCode']!='') {?>
      <?php $_smarty_tpl->tpl_vars["providerCode"] = new Smarty_variable($_smarty_tpl->tpl_vars['_Ainput']->value['providerCode']['ProviderCode'], null, 0);?>
      <?php }?>
      <?php $_smarty_tpl->tpl_vars["hostTokenXml"] = new Smarty_variable('', null, 0);?>
      <?php $_smarty_tpl->tpl_vars["airPricingCommandXml"] = new Smarty_variable('', null, 0);?>
      <?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['segInfo'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['segInfo']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['segInfo']['name'] = 'segInfo';
$_smarty_tpl->tpl_vars['smarty']->value['section']['segInfo']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['_Ainput']->value['airSegment']) ? count($_loop) : max(0, (int) $_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['segInfo']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['segInfo']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['segInfo']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['segInfo']['step'] = 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['segInfo']['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['segInfo']['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']['segInfo']['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['segInfo']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['segInfo']['total'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['segInfo']['loop'];
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['segInfo']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['segInfo']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['segInfo']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['segInfo']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['segInfo']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['segInfo']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['segInfo']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['segInfo']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['segInfo']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['segInfo']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['segInfo']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['segInfo']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['segInfo']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['segInfo']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['segInfo']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['segInfo']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['segInfo']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['segInfo']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['segInfo']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['segInfo']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['segInfo']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['segInfo']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['segInfo']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['segInfo']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['segInfo']['total']);
?>
	  
	  <AirSegment Key="<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['airSegment'][$_smarty_tpl->getVariable('smarty')->value['section']['segInfo']['index']]['attributes']['Key'];?>
" Group="<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['airSegment'][$_smarty_tpl->getVariable('smarty')->value['section']['segInfo']['index']]['attributes']['Group'];?>
" Carrier="<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['airSegment'][$_smarty_tpl->getVariable('smarty')->value['section']['segInfo']['index']]['attributes']['Carrier'];?>
" FlightNumber="<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['airSegment'][$_smarty_tpl->getVariable('smarty')->value['section']['segInfo']['index']]['attributes']['FlightNumber'];?>
" Origin="<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['airSegment'][$_smarty_tpl->getVariable('smarty')->value['section']['segInfo']['index']]['attributes']['Origin'];?>
" Destination="<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['airSegment'][$_smarty_tpl->getVariable('smarty')->value['section']['segInfo']['index']]['attributes']['Destination'];?>
" DepartureTime="<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['airSegment'][$_smarty_tpl->getVariable('smarty')->value['section']['segInfo']['index']]['attributes']['DepartureTime'];?>
" ArrivalTime="<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['airSegment'][$_smarty_tpl->getVariable('smarty')->value['section']['segInfo']['index']]['attributes']['ArrivalTime'];?>
" FlightTime="<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['airSegment'][$_smarty_tpl->getVariable('smarty')->value['section']['segInfo']['index']]['attributes']['FlightTime'];?>
" ProviderCode="<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['airSegment'][$_smarty_tpl->getVariable('smarty')->value['section']['segInfo']['index']]['attributes']['ProviderCode'];?>
" ClassOfService="<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['airSegment'][$_smarty_tpl->getVariable('smarty')->value['section']['segInfo']['index']]['attributes']['ClassOfService'];?>
" <?php if (isset($_smarty_tpl->tpl_vars['_Ainput']->value['airSegment'][$_smarty_tpl->getVariable('smarty',null,true,false)->value['section']['segInfo']['index']]['attributes']['Status'])&&$_smarty_tpl->tpl_vars['_Ainput']->value['airSegment'][$_smarty_tpl->getVariable('smarty')->value['section']['segInfo']['index']]['attributes']['Status']!='') {?> Status="<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['airSegment'][$_smarty_tpl->getVariable('smarty')->value['section']['segInfo']['index']]['attributes']['Status'];?>
" <?php }?> <?php if (isset($_smarty_tpl->tpl_vars['_Ainput']->value['airSegment'][$_smarty_tpl->getVariable('smarty',null,true,false)->value['section']['segInfo']['index']]['attributes']['HostTokenRef'])&&$_smarty_tpl->tpl_vars['_Ainput']->value['airSegment'][$_smarty_tpl->getVariable('smarty')->value['section']['segInfo']['index']]['attributes']['HostTokenRef']!='') {?> HostTokenRef="<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['airSegment'][$_smarty_tpl->getVariable('smarty')->value['section']['segInfo']['index']]['attributes']['HostTokenRef'];?>
" <?php }
if (isset($_smarty_tpl->tpl_vars['_Ainput']->value['airSegment'][$_smarty_tpl->getVariable('smarty',null,true,false)->value['section']['segInfo']['index']]['attributes']['SupplierCode'])&&$_smarty_tpl->tpl_vars['_Ainput']->value['airSegment'][$_smarty_tpl->getVariable('smarty')->value['section']['segInfo']['index']]['attributes']['SupplierCode']!='') {?> SupplierCode="<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['airSegment'][$_smarty_tpl->getVariable('smarty')->value['section']['segInfo']['index']]['attributes']['SupplierCode'];?>
" <?php }?> <?php if (isset($_smarty_tpl->tpl_vars['_Ainput']->value['airSegment'][$_smarty_tpl->getVariable('smarty',null,true,false)->value['section']['segInfo']['index']]['attributes']['Equipment'])&&$_smarty_tpl->tpl_vars['_Ainput']->value['airSegment'][$_smarty_tpl->getVariable('smarty')->value['section']['segInfo']['index']]['attributes']['Equipment']!='') {?> Equipment="<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['airSegment'][$_smarty_tpl->getVariable('smarty')->value['section']['segInfo']['index']]['attributes']['Equipment'];?>
" <?php }?> OptionalServicesIndicator="<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['airSegment'][$_smarty_tpl->getVariable('smarty')->value['section']['segInfo']['index']]['attributes']['OptionalServicesIndicator'];?>
" <?php if (isset($_smarty_tpl->tpl_vars['_Ainput']->value['airSegment'][$_smarty_tpl->getVariable('smarty',null,true,false)->value['section']['segInfo']['index']]['attributes']['APISRequirementsRef'])&&$_smarty_tpl->tpl_vars['_Ainput']->value['airSegment'][$_smarty_tpl->getVariable('smarty')->value['section']['segInfo']['index']]['attributes']['APISRequirementsRef']!='') {?> APISRequirementsRef="<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['airSegment'][$_smarty_tpl->getVariable('smarty')->value['section']['segInfo']['index']]['attributes']['APISRequirementsRef'];?>
" <?php }?>>
      </AirSegment>

      <?php if (isset($_smarty_tpl->tpl_vars['_Ainput']->value['airSegment'][$_smarty_tpl->getVariable('smarty',null,true,false)->value['section']['segInfo']['index']]['hostToken']['key'])&&$_smarty_tpl->tpl_vars['_Ainput']->value['airSegment'][$_smarty_tpl->getVariable('smarty')->value['section']['segInfo']['index']]['hostToken']['key']!='') {?>
      <?php $_smarty_tpl->tpl_vars["hostTokenXml"] = new Smarty_variable(("<HostToken xmlns='http://www.travelport.com/schema/common_v35_0' Key='".((string)$_smarty_tpl->tpl_vars['_Ainput']->value['airSegment'][$_smarty_tpl->getVariable('smarty')->value['section']['segInfo']['index']]['hostToken']['key'])."'>".((string)$_smarty_tpl->tpl_vars['_Ainput']->value['airSegment'][$_smarty_tpl->getVariable('smarty')->value['section']['segInfo']['index']]['hostToken']['value'])."</HostToken>").($_smarty_tpl->tpl_vars['hostTokenXml']->value), null, 0);?>
      <?php }?>
      <?php $_smarty_tpl->tpl_vars["airPricingCommandXml"] = new Smarty_variable(("<AirSegmentPricingModifiers AirSegmentRef='".((string)$_smarty_tpl->tpl_vars['_Ainput']->value['airSegment'][$_smarty_tpl->getVariable('smarty')->value['section']['segInfo']['index']]['attributes']['Key'])."' FareBasisCode='".((string)$_smarty_tpl->tpl_vars['_Ainput']->value['BookingInfo'][0]['FareBasisCode'][$_smarty_tpl->getVariable('smarty')->value['section']['segInfo']['index']])."'></AirSegmentPricingModifiers>").($_smarty_tpl->tpl_vars['airPricingCommandXml']->value), null, 0);?>
      <?php endfor; endif; ?>
	  
      <?php echo $_smarty_tpl->tpl_vars['hostTokenXml']->value;?>

   </AirItinerary>

   <?php $_smarty_tpl->tpl_vars['loop'] = new Smarty_Variable;$_smarty_tpl->tpl_vars['loop']->step = 1;$_smarty_tpl->tpl_vars['loop']->total = (int) ceil(($_smarty_tpl->tpl_vars['loop']->step > 0 ? $_smarty_tpl->tpl_vars['_Ainput']->value['ADT']+1 - (1) : 1-($_smarty_tpl->tpl_vars['_Ainput']->value['ADT'])+1)/abs($_smarty_tpl->tpl_vars['loop']->step));
if ($_smarty_tpl->tpl_vars['loop']->total > 0) {
for ($_smarty_tpl->tpl_vars['loop']->value = 1, $_smarty_tpl->tpl_vars['loop']->iteration = 1;$_smarty_tpl->tpl_vars['loop']->iteration <= $_smarty_tpl->tpl_vars['loop']->total;$_smarty_tpl->tpl_vars['loop']->value += $_smarty_tpl->tpl_vars['loop']->step, $_smarty_tpl->tpl_vars['loop']->iteration++) {
$_smarty_tpl->tpl_vars['loop']->first = $_smarty_tpl->tpl_vars['loop']->iteration == 1;$_smarty_tpl->tpl_vars['loop']->last = $_smarty_tpl->tpl_vars['loop']->iteration == $_smarty_tpl->tpl_vars['loop']->total;?>
   <?php $_smarty_tpl->tpl_vars['idx'] = new Smarty_variable($_smarty_tpl->tpl_vars['loop']->value-1, null, 0);?>
   <?php $_smarty_tpl->tpl_vars['idxVal'] = new Smarty_variable(("ADT_").($_smarty_tpl->tpl_vars['idx']->value), null, 0);?>

   <SearchPassenger xmlns="http://www.travelport.com/schema/common_v35_0" Code="<?php echo $_smarty_tpl->tpl_vars['_Oconf']->value['site']['paxTypes']['ADT'];?>
" BookingTravelerRef="<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['PassengerType'][$_smarty_tpl->tpl_vars['idxVal']->value];?>
" Key="<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['PassengerType'][$_smarty_tpl->tpl_vars['idxVal']->value];?>
" Age="<?php echo $_smarty_tpl->tpl_vars['_Oconf']->value['site']['paxAge']['ADT'];?>
" />
   <?php }} ?>
   <?php if ($_smarty_tpl->tpl_vars['_Ainput']->value['CHD']>0) {?>
   <?php $_smarty_tpl->tpl_vars['loop'] = new Smarty_Variable;$_smarty_tpl->tpl_vars['loop']->step = 1;$_smarty_tpl->tpl_vars['loop']->total = (int) ceil(($_smarty_tpl->tpl_vars['loop']->step > 0 ? $_smarty_tpl->tpl_vars['_Ainput']->value['CHD']+1 - (1) : 1-($_smarty_tpl->tpl_vars['_Ainput']->value['CHD'])+1)/abs($_smarty_tpl->tpl_vars['loop']->step));
if ($_smarty_tpl->tpl_vars['loop']->total > 0) {
for ($_smarty_tpl->tpl_vars['loop']->value = 1, $_smarty_tpl->tpl_vars['loop']->iteration = 1;$_smarty_tpl->tpl_vars['loop']->iteration <= $_smarty_tpl->tpl_vars['loop']->total;$_smarty_tpl->tpl_vars['loop']->value += $_smarty_tpl->tpl_vars['loop']->step, $_smarty_tpl->tpl_vars['loop']->iteration++) {
$_smarty_tpl->tpl_vars['loop']->first = $_smarty_tpl->tpl_vars['loop']->iteration == 1;$_smarty_tpl->tpl_vars['loop']->last = $_smarty_tpl->tpl_vars['loop']->iteration == $_smarty_tpl->tpl_vars['loop']->total;?>
      <?php $_smarty_tpl->tpl_vars['idx'] = new Smarty_variable($_smarty_tpl->tpl_vars['loop']->value-1, null, 0);?>
	  <?php $_smarty_tpl->tpl_vars['idxVal'] = new Smarty_variable(("CHD_").($_smarty_tpl->tpl_vars['idx']->value), null, 0);?>
   
   <SearchPassenger xmlns="http://www.travelport.com/schema/common_v35_0" Code="<?php echo $_smarty_tpl->tpl_vars['_Oconf']->value['site']['paxTypes']['CHD'];?>
" BookingTravelerRef="<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['PassengerType'][$_smarty_tpl->tpl_vars['idxVal']->value];?>
" Key="<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['PassengerType'][$_smarty_tpl->tpl_vars['idxVal']->value];?>
" Age="<?php echo $_smarty_tpl->tpl_vars['_Oconf']->value['site']['paxAge']['CHD'];?>
" />
   <?php }} ?>
   <?php }?>
   <?php if ($_smarty_tpl->tpl_vars['_Ainput']->value['INF']>0) {?>
   <?php $_smarty_tpl->tpl_vars['loop'] = new Smarty_Variable;$_smarty_tpl->tpl_vars['loop']->step = 1;$_smarty_tpl->tpl_vars['loop']->total = (int) ceil(($_smarty_tpl->tpl_vars['loop']->step > 0 ? $_smarty_tpl->tpl_vars['_Ainput']->value['INF']+1 - (1) : 1-($_smarty_tpl->tpl_vars['_Ainput']->value['INF'])+1)/abs($_smarty_tpl->tpl_vars['loop']->step));
if ($_smarty_tpl->tpl_vars['loop']->total > 0) {
for ($_smarty_tpl->tpl_vars['loop']->value = 1, $_smarty_tpl->tpl_vars['loop']->iteration = 1;$_smarty_tpl->tpl_vars['loop']->iteration <= $_smarty_tpl->tpl_vars['loop']->total;$_smarty_tpl->tpl_vars['loop']->value += $_smarty_tpl->tpl_vars['loop']->step, $_smarty_tpl->tpl_vars['loop']->iteration++) {
$_smarty_tpl->tpl_vars['loop']->first = $_smarty_tpl->tpl_vars['loop']->iteration == 1;$_smarty_tpl->tpl_vars['loop']->last = $_smarty_tpl->tpl_vars['loop']->iteration == $_smarty_tpl->tpl_vars['loop']->total;?>
	<?php $_smarty_tpl->tpl_vars['idx'] = new Smarty_variable($_smarty_tpl->tpl_vars['loop']->value-1, null, 0);?>
	<?php $_smarty_tpl->tpl_vars['idxVal'] = new Smarty_variable(("INF_").($_smarty_tpl->tpl_vars['idx']->value), null, 0);?>
   
   <SearchPassenger xmlns="http://www.travelport.com/schema/common_v35_0" Code="<?php echo $_smarty_tpl->tpl_vars['_Oconf']->value['site']['paxTypes']['INF'];?>
" BookingTravelerRef="<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['PassengerType'][$_smarty_tpl->tpl_vars['idxVal']->value];?>
" Key="<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['PassengerType'][$_smarty_tpl->tpl_vars['idxVal']->value];?>
" Age="<?php echo $_smarty_tpl->tpl_vars['_Oconf']->value['site']['paxAge']['INF'];?>
" />
   <?php }} ?>
   <?php }?>
   
   <AirPricingCommand>
      <?php echo $_smarty_tpl->tpl_vars['airPricingCommandXml']->value;?>

   </AirPricingCommand>
    <OptionalServices>

	<?php if (isset($_smarty_tpl->tpl_vars['_Ainput']->value['OptionalService'])&&$_smarty_tpl->tpl_vars['_Ainput']->value['OptionalService']!='') {?>
	<?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['OptSerBaggage'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['OptSerBaggage']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['OptSerBaggage']['name'] = 'OptSerBaggage';
$_smarty_tpl->tpl_vars['smarty']->value['section']['OptSerBaggage']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['_Ainput']->value['OptionalService']) ? count($_loop) : max(0, (int) $_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['OptSerBaggage']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['OptSerBaggage']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['OptSerBaggage']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['OptSerBaggage']['step'] = 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['OptSerBaggage']['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['OptSerBaggage']['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']['OptSerBaggage']['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['OptSerBaggage']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['OptSerBaggage']['total'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['OptSerBaggage']['loop'];
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['OptSerBaggage']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['OptSerBaggage']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['OptSerBaggage']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['OptSerBaggage']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['OptSerBaggage']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['OptSerBaggage']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['OptSerBaggage']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['OptSerBaggage']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['OptSerBaggage']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['OptSerBaggage']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['OptSerBaggage']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['OptSerBaggage']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['OptSerBaggage']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['OptSerBaggage']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['OptSerBaggage']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['OptSerBaggage']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['OptSerBaggage']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['OptSerBaggage']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['OptSerBaggage']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['OptSerBaggage']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['OptSerBaggage']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['OptSerBaggage']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['OptSerBaggage']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['OptSerBaggage']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['OptSerBaggage']['total']);
?>
		<?php  $_smarty_tpl->tpl_vars['itemVal'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['itemVal']->_loop = false;
 $_smarty_tpl->tpl_vars['keyVal'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['_Ainput']->value['PassengerType']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['itemVal']->key => $_smarty_tpl->tpl_vars['itemVal']->value) {
$_smarty_tpl->tpl_vars['itemVal']->_loop = true;
 $_smarty_tpl->tpl_vars['keyVal']->value = $_smarty_tpl->tpl_vars['itemVal']->key;
?>
			<?php if ($_smarty_tpl->tpl_vars['_Ainput']->value['OptionalService'][$_smarty_tpl->getVariable('smarty')->value['section']['OptSerBaggage']['index']]['ServiceData']['attributes']['BookingTravelerRef']==$_smarty_tpl->tpl_vars['itemVal']->value) {?>
				<?php $_smarty_tpl->tpl_vars['PaxType'] = new Smarty_variable(explode("_",$_smarty_tpl->tpl_vars['keyVal']->value), null, 0);?>
			<?php }?>	
		<?php } ?>
		<OptionalService  Type="<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['OptionalService'][$_smarty_tpl->getVariable('smarty')->value['section']['OptSerBaggage']['index']]['attributes']['Type'];?>
"  TotalPrice="<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['OptionalService'][$_smarty_tpl->getVariable('smarty')->value['section']['OptSerBaggage']['index']]['attributes']['TotalPrice'];?>
"  SupplierCode="<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['OptionalService'][$_smarty_tpl->getVariable('smarty')->value['section']['OptSerBaggage']['index']]['attributes']['SupplierCode'];?>
"  CreateDate="<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['OptionalService'][$_smarty_tpl->getVariable('smarty')->value['section']['OptSerBaggage']['index']]['attributes']['CreateDate'];?>
"  ServiceStatus="<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['OptionalService'][$_smarty_tpl->getVariable('smarty')->value['section']['OptSerBaggage']['index']]['attributes']['ServiceStatus'];?>
"  Key="<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['OptionalService'][$_smarty_tpl->getVariable('smarty')->value['section']['OptSerBaggage']['index']]['attributes']['Key'];?>
"  AssessIndicator="<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['OptionalService'][$_smarty_tpl->getVariable('smarty')->value['section']['OptSerBaggage']['index']]['attributes']['AssessIndicator'];?>
"  IsPricingApproximate="<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['OptionalService'][$_smarty_tpl->getVariable('smarty')->value['section']['OptSerBaggage']['index']]['attributes']['IsPricingApproximate'];?>
"  Source="<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['OptionalService'][$_smarty_tpl->getVariable('smarty')->value['section']['OptSerBaggage']['index']]['attributes']['Source'];?>
"  DisplayText="<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['OptionalService'][$_smarty_tpl->getVariable('smarty')->value['section']['OptSerBaggage']['index']]['attributes']['DisplayText'];?>
"  ProviderCode="<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['OptionalService'][$_smarty_tpl->getVariable('smarty')->value['section']['OptSerBaggage']['index']]['attributes']['ProviderCode'];?>
"  Quantity="<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['OptionalService'][$_smarty_tpl->getVariable('smarty')->value['section']['OptSerBaggage']['index']]['attributes']['Quantity'];?>
"  ProviderDefinedType="<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['OptionalService'][$_smarty_tpl->getVariable('smarty')->value['section']['OptSerBaggage']['index']]['attributes']['ProviderDefinedType'];?>
"  BasePrice="<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['OptionalService'][$_smarty_tpl->getVariable('smarty')->value['section']['OptSerBaggage']['index']]['attributes']['BasePrice'];?>
"  ApproximateTotalPrice="<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['OptionalService'][$_smarty_tpl->getVariable('smarty')->value['section']['OptSerBaggage']['index']]['attributes']['ApproximateTotalPrice'];?>
"  ApproximateBasePrice="<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['OptionalService'][$_smarty_tpl->getVariable('smarty')->value['section']['OptSerBaggage']['index']]['attributes']['ApproximateBasePrice'];?>
" >
		<ServiceData xmlns="http://www.travelport.com/schema/common_v35_0" AirSegmentRef="<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['OptionalService'][$_smarty_tpl->getVariable('smarty')->value['section']['OptSerBaggage']['index']]['ServiceData']['attributes']['AirSegmentRef'];?>
" BookingTravelerRef="<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['OptionalService'][$_smarty_tpl->getVariable('smarty')->value['section']['OptSerBaggage']['index']]['ServiceData']['attributes']['BookingTravelerRef'];?>
" TravelerType="<?php echo $_smarty_tpl->tpl_vars['PaxType']->value[0];?>
"></ServiceData>
		<ServiceInfo xmlns="http://www.travelport.com/schema/common_v35_0">
			<Description><?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['OptionalService'][$_smarty_tpl->getVariable('smarty')->value['section']['OptSerBaggage']['index']]['ServiceInfo']['Description'];?>
</Description>
		</ServiceInfo>
	</OptionalService>
	<?php endfor; endif; ?>
	<?php }?>
	<?php if (isset($_smarty_tpl->tpl_vars['_Ainput']->value['OptionalServiceSeatBooking'])&&$_smarty_tpl->tpl_vars['_Ainput']->value['OptionalServiceSeatBooking']!='') {?>
	<?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['OptSerSeatBooking'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['OptSerSeatBooking']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['OptSerSeatBooking']['name'] = 'OptSerSeatBooking';
$_smarty_tpl->tpl_vars['smarty']->value['section']['OptSerSeatBooking']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['_Ainput']->value['OptionalServiceSeatBooking']) ? count($_loop) : max(0, (int) $_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['OptSerSeatBooking']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['OptSerSeatBooking']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['OptSerSeatBooking']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['OptSerSeatBooking']['step'] = 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['OptSerSeatBooking']['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['OptSerSeatBooking']['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']['OptSerSeatBooking']['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['OptSerSeatBooking']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['OptSerSeatBooking']['total'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['OptSerSeatBooking']['loop'];
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['OptSerSeatBooking']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['OptSerSeatBooking']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['OptSerSeatBooking']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['OptSerSeatBooking']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['OptSerSeatBooking']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['OptSerSeatBooking']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['OptSerSeatBooking']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['OptSerSeatBooking']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['OptSerSeatBooking']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['OptSerSeatBooking']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['OptSerSeatBooking']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['OptSerSeatBooking']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['OptSerSeatBooking']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['OptSerSeatBooking']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['OptSerSeatBooking']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['OptSerSeatBooking']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['OptSerSeatBooking']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['OptSerSeatBooking']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['OptSerSeatBooking']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['OptSerSeatBooking']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['OptSerSeatBooking']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['OptSerSeatBooking']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['OptSerSeatBooking']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['OptSerSeatBooking']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['OptSerSeatBooking']['total']);
?>
		<?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['optserviceSeat'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['optserviceSeat']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['optserviceSeat']['name'] = 'optserviceSeat';
$_smarty_tpl->tpl_vars['smarty']->value['section']['optserviceSeat']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['_Ainput']->value['OptionalServiceSeat']) ? count($_loop) : max(0, (int) $_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['optserviceSeat']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['optserviceSeat']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['optserviceSeat']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['optserviceSeat']['step'] = 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['optserviceSeat']['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['optserviceSeat']['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']['optserviceSeat']['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['optserviceSeat']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['optserviceSeat']['total'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['optserviceSeat']['loop'];
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['optserviceSeat']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['optserviceSeat']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['optserviceSeat']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['optserviceSeat']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['optserviceSeat']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['optserviceSeat']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['optserviceSeat']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['optserviceSeat']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['optserviceSeat']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['optserviceSeat']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['optserviceSeat']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['optserviceSeat']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['optserviceSeat']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['optserviceSeat']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['optserviceSeat']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['optserviceSeat']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['optserviceSeat']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['optserviceSeat']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['optserviceSeat']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['optserviceSeat']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['optserviceSeat']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['optserviceSeat']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['optserviceSeat']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['optserviceSeat']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['optserviceSeat']['total']);
?>
		<?php if ($_smarty_tpl->tpl_vars['_Ainput']->value['OptionalServiceSeatBooking'][$_smarty_tpl->getVariable('smarty')->value['section']['OptSerSeatBooking']['index']]['OptionalServiceRef']==$_smarty_tpl->tpl_vars['_Ainput']->value['OptionalServiceSeat'][$_smarty_tpl->getVariable('smarty')->value['section']['optserviceSeat']['index']]['attributes']['Key']) {?>
		
       <OptionalService Type="<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['OptionalServiceSeat'][$_smarty_tpl->getVariable('smarty')->value['section']['optserviceSeat']['index']]['attributes']['Type'];?>
" TotalPrice="<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['OptionalServiceSeat'][$_smarty_tpl->getVariable('smarty')->value['section']['optserviceSeat']['index']]['attributes']['TotalPrice'];?>
" SupplierCode="<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['OptionalServiceSeat'][$_smarty_tpl->getVariable('smarty')->value['section']['optserviceSeat']['index']]['attributes']['SupplierCode'];?>
" PurchaseWindow="<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['OptionalServiceSeat'][$_smarty_tpl->getVariable('smarty')->value['section']['optserviceSeat']['index']]['attributes']['PurchaseWindow'];?>
" CreateDate="<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['OptionalServiceSeat'][$_smarty_tpl->getVariable('smarty')->value['section']['optserviceSeat']['index']]['attributes']['CreateDate'];?>
" Key="<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['OptionalServiceSeat'][$_smarty_tpl->getVariable('smarty')->value['section']['optserviceSeat']['index']]['attributes']['Key'];?>
" Source="<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['OptionalServiceSeat'][$_smarty_tpl->getVariable('smarty')->value['section']['optserviceSeat']['index']]['attributes']['Source'];?>
" Quantity="<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['OptionalServiceSeat'][$_smarty_tpl->getVariable('smarty')->value['section']['optserviceSeat']['index']]['attributes']['Quantity'];?>
" ProviderDefinedType="<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['OptionalServiceSeat'][$_smarty_tpl->getVariable('smarty')->value['section']['optserviceSeat']['index']]['attributes']['ProviderDefinedType'];?>
" BasePrice="<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['OptionalServiceSeat'][$_smarty_tpl->getVariable('smarty')->value['section']['optserviceSeat']['index']]['attributes']['BasePrice'];?>
" ApproximateTotalPrice="<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['OptionalServiceSeat'][$_smarty_tpl->getVariable('smarty')->value['section']['optserviceSeat']['index']]['attributes']['ApproximateTotalPrice'];?>
">
		   <ServiceData xmlns="http://www.travelport.com/schema/common_v35_0" Data="<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['OptionalServiceSeatBooking'][$_smarty_tpl->getVariable('smarty')->value['section']['OptSerSeatBooking']['index']]['SeatCode'];?>
" AirSegmentRef="<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['OptionalServiceSeat'][$_smarty_tpl->getVariable('smarty')->value['section']['optserviceSeat']['index']]['ServiceData']['attributes']['AirSegmentRef'];?>
" BookingTravelerRef="<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['OptionalServiceSeatBooking'][$_smarty_tpl->getVariable('smarty')->value['section']['OptSerSeatBooking']['index']]['BookingTravelerRef'];?>
" />
		   <ServiceInfo xmlns="http://www.travelport.com/schema/common_v35_0">
			  <Description><?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['OptionalServiceSeat'][$_smarty_tpl->getVariable('smarty')->value['section']['optserviceSeat']['index']]['ServiceInfo']['Description'];?>
</Description>
		   </ServiceInfo>
        </OptionalService>
 
	<?php }?>
	<?php endfor; endif; ?> 
   <?php endfor; endif; ?>
   <?php }?>
  </OptionalServices>
   

</AirPriceReq>





<?php }} ?>

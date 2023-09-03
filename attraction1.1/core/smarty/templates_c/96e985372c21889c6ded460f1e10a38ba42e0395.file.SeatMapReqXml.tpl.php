<?php /* Smarty version Smarty-3.1.21, created on 2017-01-02 12:28:33
         compiled from "F:\xampp\htdocs\bridges\airline\travelportNew\views\SeatMapReqXml.tpl" */ ?>
<?php /*%%SmartyHeaderCode:287115869fa1903eaf9-73302730%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '96e985372c21889c6ded460f1e10a38ba42e0395' => 
    array (
      0 => 'F:\\xampp\\htdocs\\bridges\\airline\\travelportNew\\views\\SeatMapReqXml.tpl',
      1 => 1478244401,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '287115869fa1903eaf9-73302730',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    '_Ainput' => 0,
    '_Asettings' => 0,
    'hostTokenXml' => 0,
    '_Oconf' => 0,
    'loop' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21',
  'unifunc' => 'content_5869fa193c1205_65797889',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5869fa193c1205_65797889')) {function content_5869fa193c1205_65797889($_smarty_tpl) {?><SeatMapReq xmlns="http://www.travelport.com/schema/air_v35_0" TraceId="<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['traceId'];?>
" AuthorizedBy="<?php echo $_smarty_tpl->tpl_vars['_Asettings']->value['apiCredentials']['AuthorizedBy'];?>
" TargetBranch="<?php echo $_smarty_tpl->tpl_vars['_Asettings']->value['apiCredentials']['travelMediaTargetBranch'];?>
" ReturnSeatPricing="true">
	<BillingPointOfSaleInfo xmlns="http://www.travelport.com/schema/common_v35_0" OriginApplication="<?php echo $_smarty_tpl->tpl_vars['_Asettings']->value['apiCredentials']['application'];?>
"/>
<?php $_smarty_tpl->tpl_vars["hostTokenXml"] = new Smarty_variable('', null, 0);?>
<?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['segInfo'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['segInfo']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['segInfo']['name'] = 'segInfo';
$_smarty_tpl->tpl_vars['smarty']->value['section']['segInfo']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['_Ainput']->value['trm_AirSegment']) ? count($_loop) : max(0, (int) $_loop); unset($_loop);
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

	<AirSegment Key="<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['trm_AirSegment'][$_smarty_tpl->getVariable('smarty')->value['section']['segInfo']['index']]['attributes']['Key'];?>
" Group="<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['trm_AirSegment'][$_smarty_tpl->getVariable('smarty')->value['section']['segInfo']['index']]['attributes']['Group'];?>
" Carrier="<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['trm_AirSegment'][$_smarty_tpl->getVariable('smarty')->value['section']['segInfo']['index']]['attributes']['Carrier'];?>
" FlightNumber="<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['trm_AirSegment'][$_smarty_tpl->getVariable('smarty')->value['section']['segInfo']['index']]['attributes']['FlightNumber'];?>
" ProviderCode="<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['trm_AirSegment'][$_smarty_tpl->getVariable('smarty')->value['section']['segInfo']['index']]['attributes']['ProviderCode'];?>
" Origin="<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['trm_AirSegment'][$_smarty_tpl->getVariable('smarty')->value['section']['segInfo']['index']]['attributes']['Origin'];?>
" Destination="<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['trm_AirSegment'][$_smarty_tpl->getVariable('smarty')->value['section']['segInfo']['index']]['attributes']['Destination'];?>
" DepartureTime="<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['trm_AirSegment'][$_smarty_tpl->getVariable('smarty')->value['section']['segInfo']['index']]['attributes']['DepartureTime'];?>
" ArrivalTime="<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['trm_AirSegment'][$_smarty_tpl->getVariable('smarty')->value['section']['segInfo']['index']]['attributes']['ArrivalTime'];?>
" FlightTime="<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['trm_AirSegment'][$_smarty_tpl->getVariable('smarty')->value['section']['segInfo']['index']]['attributes']['FlightTime'];?>
" ClassOfService="<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['trm_AirSegment'][$_smarty_tpl->getVariable('smarty')->value['section']['segInfo']['index']]['attributes']['ClassOfService'];?>
" Equipment="<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['trm_AirSegment'][$_smarty_tpl->getVariable('smarty')->value['section']['segInfo']['index']]['attributes']['Equipment'];?>
" Status="<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['trm_AirSegment'][$_smarty_tpl->getVariable('smarty')->value['section']['segInfo']['index']]['attributes']['Status'];?>
" ChangeOfPlane="false" <?php if (isset($_smarty_tpl->tpl_vars['_Ainput']->value['trm_AirSegment'][$_smarty_tpl->getVariable('smarty',null,true,false)->value['section']['segInfo']['index']]['attributes']['HostTokenRef'])) {?> HostTokenRef="<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['trm_AirSegment'][$_smarty_tpl->getVariable('smarty')->value['section']['segInfo']['index']]['attributes']['HostTokenRef'];?>
"<?php }?> <?php if (isset($_smarty_tpl->tpl_vars['_Ainput']->value['trm_AirSegment'][$_smarty_tpl->getVariable('smarty',null,true,false)->value['section']['segInfo']['index']]['attributes']['SupplierCode'])) {?>SupplierCode="<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['trm_AirSegment'][$_smarty_tpl->getVariable('smarty')->value['section']['segInfo']['index']]['attributes']['SupplierCode'];?>
"<?php }?> OptionalServicesIndicator="true" APISRequirementsRef="<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['trm_AirSegment'][$_smarty_tpl->getVariable('smarty')->value['section']['segInfo']['index']]['attributes']['APISRequirementsRef'];?>
"></AirSegment>
	
<?php if (isset($_smarty_tpl->tpl_vars['_Ainput']->value['trm_AirSegment'][$_smarty_tpl->getVariable('smarty',null,true,false)->value['section']['segInfo']['index']]['hostToken']['key'])&&$_smarty_tpl->tpl_vars['_Ainput']->value['trm_AirSegment'][$_smarty_tpl->getVariable('smarty')->value['section']['segInfo']['index']]['hostToken']['key']!='') {?>
<?php $_smarty_tpl->tpl_vars["hostTokenXml"] = new Smarty_variable(("
<HostToken xmlns='http://www.travelport.com/schema/common_v35_0' Key='".((string)$_smarty_tpl->tpl_vars['_Ainput']->value['trm_AirSegment'][$_smarty_tpl->getVariable('smarty')->value['section']['segInfo']['index']]['hostToken']['key'])."'>".((string)$_smarty_tpl->tpl_vars['_Ainput']->value['trm_AirSegment'][$_smarty_tpl->getVariable('smarty')->value['section']['segInfo']['index']]['hostToken']['value'])."</HostToken>").($_smarty_tpl->tpl_vars['hostTokenXml']->value), null, 0);?>

<?php }?>
<?php endfor; endif; ?>

	<?php echo $_smarty_tpl->tpl_vars['hostTokenXml']->value;?>

	
<?php $_smarty_tpl->tpl_vars['loop'] = new Smarty_Variable;$_smarty_tpl->tpl_vars['loop']->step = 1;$_smarty_tpl->tpl_vars['loop']->total = (int) ceil(($_smarty_tpl->tpl_vars['loop']->step > 0 ? $_smarty_tpl->tpl_vars['_Ainput']->value['ADT']+1 - (1) : 1-($_smarty_tpl->tpl_vars['_Ainput']->value['ADT'])+1)/abs($_smarty_tpl->tpl_vars['loop']->step));
if ($_smarty_tpl->tpl_vars['loop']->total > 0) {
for ($_smarty_tpl->tpl_vars['loop']->value = 1, $_smarty_tpl->tpl_vars['loop']->iteration = 1;$_smarty_tpl->tpl_vars['loop']->iteration <= $_smarty_tpl->tpl_vars['loop']->total;$_smarty_tpl->tpl_vars['loop']->value += $_smarty_tpl->tpl_vars['loop']->step, $_smarty_tpl->tpl_vars['loop']->iteration++) {
$_smarty_tpl->tpl_vars['loop']->first = $_smarty_tpl->tpl_vars['loop']->iteration == 1;$_smarty_tpl->tpl_vars['loop']->last = $_smarty_tpl->tpl_vars['loop']->iteration == $_smarty_tpl->tpl_vars['loop']->total;?>

	<SearchTraveler Code="<?php echo $_smarty_tpl->tpl_vars['_Oconf']->value['site']['paxTypes']['ADT'];?>
" BookingTravelerRef="ucoVPGwKTS+Fc8E7Wnp5uQ==" Age="<?php echo $_smarty_tpl->tpl_vars['_Oconf']->value['site']['paxAge']['ADT'];?>
">
		<Name xmlns="http://www.travelport.com/schema/common_v35_0" Prefix="Mr" First="First_ADT_<?php echo $_smarty_tpl->tpl_vars['loop']->value;?>
" Last="Last_ADT_<?php echo $_smarty_tpl->tpl_vars['loop']->value;?>
"/>
	</SearchTraveler>
<?php }} ?>

<?php if ($_smarty_tpl->tpl_vars['_Ainput']->value['CHD']>0) {?>
<?php $_smarty_tpl->tpl_vars['loop'] = new Smarty_Variable;$_smarty_tpl->tpl_vars['loop']->step = 1;$_smarty_tpl->tpl_vars['loop']->total = (int) ceil(($_smarty_tpl->tpl_vars['loop']->step > 0 ? $_smarty_tpl->tpl_vars['_Ainput']->value['CHD']+1 - (1) : 1-($_smarty_tpl->tpl_vars['_Ainput']->value['CHD'])+1)/abs($_smarty_tpl->tpl_vars['loop']->step));
if ($_smarty_tpl->tpl_vars['loop']->total > 0) {
for ($_smarty_tpl->tpl_vars['loop']->value = 1, $_smarty_tpl->tpl_vars['loop']->iteration = 1;$_smarty_tpl->tpl_vars['loop']->iteration <= $_smarty_tpl->tpl_vars['loop']->total;$_smarty_tpl->tpl_vars['loop']->value += $_smarty_tpl->tpl_vars['loop']->step, $_smarty_tpl->tpl_vars['loop']->iteration++) {
$_smarty_tpl->tpl_vars['loop']->first = $_smarty_tpl->tpl_vars['loop']->iteration == 1;$_smarty_tpl->tpl_vars['loop']->last = $_smarty_tpl->tpl_vars['loop']->iteration == $_smarty_tpl->tpl_vars['loop']->total;?>

	<SearchTraveler Code="<?php echo $_smarty_tpl->tpl_vars['_Oconf']->value['site']['paxTypes']['CHD'];?>
" BookingTravelerRef="ucoVPGwKTS+Fc8E7Wnp5uQ==" Age="<?php echo $_smarty_tpl->tpl_vars['_Oconf']->value['site']['paxAge']['CHD'];?>
">
		<Name xmlns="http://www.travelport.com/schema/common_v35_0" Prefix="Mr" First="First_CHD_<?php echo $_smarty_tpl->tpl_vars['loop']->value;?>
" Last="Last_CHD_<?php echo $_smarty_tpl->tpl_vars['loop']->value;?>
"/>
	</SearchTraveler>
<?php }} ?>
<?php }?>

<?php if ($_smarty_tpl->tpl_vars['_Ainput']->value['INF']>0) {?>
<?php $_smarty_tpl->tpl_vars['loop'] = new Smarty_Variable;$_smarty_tpl->tpl_vars['loop']->step = 1;$_smarty_tpl->tpl_vars['loop']->total = (int) ceil(($_smarty_tpl->tpl_vars['loop']->step > 0 ? $_smarty_tpl->tpl_vars['_Ainput']->value['INF']+1 - (1) : 1-($_smarty_tpl->tpl_vars['_Ainput']->value['INF'])+1)/abs($_smarty_tpl->tpl_vars['loop']->step));
if ($_smarty_tpl->tpl_vars['loop']->total > 0) {
for ($_smarty_tpl->tpl_vars['loop']->value = 1, $_smarty_tpl->tpl_vars['loop']->iteration = 1;$_smarty_tpl->tpl_vars['loop']->iteration <= $_smarty_tpl->tpl_vars['loop']->total;$_smarty_tpl->tpl_vars['loop']->value += $_smarty_tpl->tpl_vars['loop']->step, $_smarty_tpl->tpl_vars['loop']->iteration++) {
$_smarty_tpl->tpl_vars['loop']->first = $_smarty_tpl->tpl_vars['loop']->iteration == 1;$_smarty_tpl->tpl_vars['loop']->last = $_smarty_tpl->tpl_vars['loop']->iteration == $_smarty_tpl->tpl_vars['loop']->total;?>

	<SearchTraveler Code="<?php echo $_smarty_tpl->tpl_vars['_Oconf']->value['site']['paxTypes']['INF'];?>
" BookingTravelerRef="ucoVPGwKTS+Fc8E7Wnp5uQ==" Age="<?php echo $_smarty_tpl->tpl_vars['_Oconf']->value['site']['paxAge']['INF'];?>
">
		<Name xmlns="http://www.travelport.com/schema/common_v35_0" Prefix="Mr" First="First_INF_<?php echo $_smarty_tpl->tpl_vars['loop']->value;?>
" Last="Last_INF_<?php echo $_smarty_tpl->tpl_vars['loop']->value;?>
"/>
	</SearchTraveler>
<?php }} ?>
<?php }?>

</SeatMapReq><?php }} ?>

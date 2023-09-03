<?php /* Smarty version Smarty-3.1.21, created on 2016-12-17 14:29:57
         compiled from "F:\xampp\htdocs\bridges\airline\travelportNew\views\AirRePriceReqXml.tpl" */ ?>
<?php /*%%SmartyHeaderCode:89255852a14f9fe9b1-61447875%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '785416407f4199fdcce48adbb0a7d5118e10925b' => 
    array (
      0 => 'F:\\xampp\\htdocs\\bridges\\airline\\travelportNew\\views\\AirRePriceReqXml.tpl',
      1 => 1481965184,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '89255852a14f9fe9b1-61447875',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.21',
  'unifunc' => 'content_5852a14fce4cb5_58111424',
  'variables' => 
  array (
    '_Ainput' => 0,
    '_Asettings' => 0,
    'providerCode' => 0,
    '_Oconf' => 0,
    'loop' => 0,
    'airPricingCommandXml' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5852a14fce4cb5_58111424')) {function content_5852a14fce4cb5_58111424($_smarty_tpl) {?><AirPriceReq xmlns="http://www.travelport.com/schema/air_v35_0" TraceId="<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['traceId'];?>
" AuthorizedBy="<?php echo $_smarty_tpl->tpl_vars['_Asettings']->value['apiCredentials']['AuthorizedBy'];?>
" TargetBranch="<?php echo $_smarty_tpl->tpl_vars['_Asettings']->value['apiCredentials']['travelMediaTargetBranch'];?>
">
   <BillingPointOfSaleInfo xmlns="http://www.travelport.com/schema/common_v35_0" OriginApplication="<?php echo $_smarty_tpl->tpl_vars['_Asettings']->value['apiCredentials']['application'];?>
" />
   <AirItinerary>
      <?php $_smarty_tpl->tpl_vars["providerCode"] = new Smarty_variable("1G", null, 0);?>
      <?php $_smarty_tpl->tpl_vars["hostTokenXml"] = new Smarty_variable('', null, 0);?>
      <?php $_smarty_tpl->tpl_vars["airPricingCommandXml"] = new Smarty_variable('', null, 0);?>
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
" Origin="<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['trm_AirSegment'][$_smarty_tpl->getVariable('smarty')->value['section']['segInfo']['index']]['attributes']['Origin'];?>
" Destination="<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['trm_AirSegment'][$_smarty_tpl->getVariable('smarty')->value['section']['segInfo']['index']]['attributes']['Destination'];?>
" DepartureTime="<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['trm_AirSegment'][$_smarty_tpl->getVariable('smarty')->value['section']['segInfo']['index']]['attributes']['DepartureTime'];?>
" ArrivalTime="<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['trm_AirSegment'][$_smarty_tpl->getVariable('smarty')->value['section']['segInfo']['index']]['attributes']['ArrivalTime'];?>
"<?php if (isset($_smarty_tpl->tpl_vars['_Ainput']->value['trm_AirSegment'][$_smarty_tpl->getVariable('smarty',null,true,false)->value['section']['segInfo']['index']]['attributes']['FlightTime'])) {?>  FlightTime="<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['trm_AirSegment'][$_smarty_tpl->getVariable('smarty')->value['section']['segInfo']['index']]['attributes']['FlightTime'];?>
" <?php }?> ProviderCode="<?php echo $_smarty_tpl->tpl_vars['providerCode']->value;?>
" <?php if (isset($_smarty_tpl->tpl_vars['_Ainput']->value['trm_AirSegment'][$_smarty_tpl->getVariable('smarty',null,true,false)->value['section']['segInfo']['index']]['attributes']['BookingCode'])) {?> ClassOfService="<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['trm_AirSegment'][$_smarty_tpl->getVariable('smarty')->value['section']['segInfo']['index']]['attributes']['BookingCode'];?>
" <?php }?> Status="<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['trm_AirSegment'][$_smarty_tpl->getVariable('smarty')->value['section']['segInfo']['index']]['attributes']['Status'];?>
" <?php if (isset($_smarty_tpl->tpl_vars['_Ainput']->value['trm_AirSegment'][$_smarty_tpl->getVariable('smarty',null,true,false)->value['section']['segInfo']['index']]['attributes']['HostTokenRef'])) {?> HostTokenRef="<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['trm_AirSegment'][$_smarty_tpl->getVariable('smarty')->value['section']['segInfo']['index']]['attributes']['HostTokenRef'];?>
" <?php }?> <?php if (isset($_smarty_tpl->tpl_vars['_Ainput']->value['trm_AirSegment'][$_smarty_tpl->getVariable('smarty',null,true,false)->value['section']['segInfo']['index']]['attributes']['SupplierCode'])) {?> SupplierCode="<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['trm_AirSegment'][$_smarty_tpl->getVariable('smarty')->value['section']['segInfo']['index']]['attributes']['SupplierCode'];?>
" <?php }?> Equipment="<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['trm_AirSegment'][$_smarty_tpl->getVariable('smarty')->value['section']['segInfo']['index']]['attributes']['Equipment'];?>
">
      <?php if (isset($_smarty_tpl->tpl_vars['_Ainput']->value['trm_AirSegment'][$_smarty_tpl->getVariable('smarty',null,true,false)->value['section']['segInfo']['index']]['FlightDetails'])) {?>
      <FlightDetails Key="<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['trm_AirSegment'][$_smarty_tpl->getVariable('smarty')->value['section']['segInfo']['index']]['FlightDetails']['attributes']['Key'];?>
" FlightTime="<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['trm_AirSegment'][$_smarty_tpl->getVariable('smarty')->value['section']['segInfo']['index']]['FlightDetails']['attributes']['FlightTime'];?>
" TravelTime="<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['trm_AirSegment'][$_smarty_tpl->getVariable('smarty')->value['section']['segInfo']['index']]['FlightDetails']['attributes']['TravelTime'];?>
" Origin="<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['trm_AirSegment'][$_smarty_tpl->getVariable('smarty')->value['section']['segInfo']['index']]['FlightDetails']['attributes']['Origin'];?>
" Destination="<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['trm_AirSegment'][$_smarty_tpl->getVariable('smarty')->value['section']['segInfo']['index']]['FlightDetails']['attributes']['Destination'];?>
" 
         DepartureTime="<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['trm_AirSegment'][$_smarty_tpl->getVariable('smarty')->value['section']['segInfo']['index']]['FlightDetails']['attributes']['DepartureTime'];?>
" ArrivalTime="<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['trm_AirSegment'][$_smarty_tpl->getVariable('smarty')->value['section']['segInfo']['index']]['FlightDetails']['attributes']['ArrivalTime'];?>
" Equipment="<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['trm_AirSegment'][$_smarty_tpl->getVariable('smarty')->value['section']['segInfo']['index']]['FlightDetails']['attributes']['Equipment'];?>
" <?php if (isset($_smarty_tpl->tpl_vars['_Ainput']->value['trm_AirSegment'][$_smarty_tpl->getVariable('smarty',null,true,false)->value['section']['segInfo']['index']]['FlightDetails']['attributes']['OriginTerminal'])) {?> OriginTerminal="<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['trm_AirSegment'][$_smarty_tpl->getVariable('smarty')->value['section']['segInfo']['index']]['FlightDetails']['attributes']['OriginTerminal'];?>
" <?php }
if (isset($_smarty_tpl->tpl_vars['_Ainput']->value['trm_AirSegment'][$_smarty_tpl->getVariable('smarty',null,true,false)->value['section']['segInfo']['index']]['FlightDetails']['attributes']['DestinationTerminal'])) {?> DestinationTerminal="<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['trm_AirSegment'][$_smarty_tpl->getVariable('smarty')->value['section']['segInfo']['index']]['FlightDetails']['attributes']['DestinationTerminal'];?>
" <?php }?> />
      <?php }?>
      <?php if (isset($_smarty_tpl->tpl_vars['_Ainput']->value['trm_AirSegment'][$_smarty_tpl->getVariable('smarty',null,true,false)->value['section']['segInfo']['index']]['SegmentIndex'])) {?>
      <Connection SegmentIndex="<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['trm_AirSegment'][$_smarty_tpl->getVariable('smarty')->value['section']['segInfo']['index']]['SegmentIndex'];?>
" />
      <?php }?>		 
      </AirSegment>
      <?php endfor; endif; ?>
   </AirItinerary>
   <AirPricingModifiers InventoryRequestType="DirectAccess">
      <BrandModifiers ModifierType="BasicDetailOnly" />
   </AirPricingModifiers>
   <?php $_smarty_tpl->tpl_vars['loop'] = new Smarty_Variable;$_smarty_tpl->tpl_vars['loop']->step = 1;$_smarty_tpl->tpl_vars['loop']->total = (int) ceil(($_smarty_tpl->tpl_vars['loop']->step > 0 ? $_smarty_tpl->tpl_vars['_Ainput']->value['ADT']+1 - (1) : 1-($_smarty_tpl->tpl_vars['_Ainput']->value['ADT'])+1)/abs($_smarty_tpl->tpl_vars['loop']->step));
if ($_smarty_tpl->tpl_vars['loop']->total > 0) {
for ($_smarty_tpl->tpl_vars['loop']->value = 1, $_smarty_tpl->tpl_vars['loop']->iteration = 1;$_smarty_tpl->tpl_vars['loop']->iteration <= $_smarty_tpl->tpl_vars['loop']->total;$_smarty_tpl->tpl_vars['loop']->value += $_smarty_tpl->tpl_vars['loop']->step, $_smarty_tpl->tpl_vars['loop']->iteration++) {
$_smarty_tpl->tpl_vars['loop']->first = $_smarty_tpl->tpl_vars['loop']->iteration == 1;$_smarty_tpl->tpl_vars['loop']->last = $_smarty_tpl->tpl_vars['loop']->iteration == $_smarty_tpl->tpl_vars['loop']->total;?>
   <SearchPassenger xmlns="http://www.travelport.com/schema/common_v35_0" Code="<?php echo $_smarty_tpl->tpl_vars['_Oconf']->value['site']['paxTypes']['ADT'];?>
" BookingTravelerRef="ADT<?php echo $_smarty_tpl->tpl_vars['loop']->value;?>
" Key="ADT<?php echo $_smarty_tpl->tpl_vars['loop']->value;?>
" />
   <?php }} ?>
   <?php if ($_smarty_tpl->tpl_vars['_Ainput']->value['CHD']>0) {?>
   <?php $_smarty_tpl->tpl_vars['loop'] = new Smarty_Variable;$_smarty_tpl->tpl_vars['loop']->step = 1;$_smarty_tpl->tpl_vars['loop']->total = (int) ceil(($_smarty_tpl->tpl_vars['loop']->step > 0 ? $_smarty_tpl->tpl_vars['_Ainput']->value['CHD']+1 - (1) : 1-($_smarty_tpl->tpl_vars['_Ainput']->value['CHD'])+1)/abs($_smarty_tpl->tpl_vars['loop']->step));
if ($_smarty_tpl->tpl_vars['loop']->total > 0) {
for ($_smarty_tpl->tpl_vars['loop']->value = 1, $_smarty_tpl->tpl_vars['loop']->iteration = 1;$_smarty_tpl->tpl_vars['loop']->iteration <= $_smarty_tpl->tpl_vars['loop']->total;$_smarty_tpl->tpl_vars['loop']->value += $_smarty_tpl->tpl_vars['loop']->step, $_smarty_tpl->tpl_vars['loop']->iteration++) {
$_smarty_tpl->tpl_vars['loop']->first = $_smarty_tpl->tpl_vars['loop']->iteration == 1;$_smarty_tpl->tpl_vars['loop']->last = $_smarty_tpl->tpl_vars['loop']->iteration == $_smarty_tpl->tpl_vars['loop']->total;?>
   <SearchPassenger xmlns="http://www.travelport.com/schema/common_v35_0" Code="<?php echo $_smarty_tpl->tpl_vars['_Oconf']->value['site']['paxTypes']['CHD'];?>
" BookingTravelerRef="CHD<?php echo $_smarty_tpl->tpl_vars['loop']->value;?>
" Key="CHD<?php echo $_smarty_tpl->tpl_vars['loop']->value;?>
"  />
   <?php }} ?>
   <?php }?>
   <?php if ($_smarty_tpl->tpl_vars['_Ainput']->value['INF']>0) {?>
   <?php $_smarty_tpl->tpl_vars['loop'] = new Smarty_Variable;$_smarty_tpl->tpl_vars['loop']->step = 1;$_smarty_tpl->tpl_vars['loop']->total = (int) ceil(($_smarty_tpl->tpl_vars['loop']->step > 0 ? $_smarty_tpl->tpl_vars['_Ainput']->value['INF']+1 - (1) : 1-($_smarty_tpl->tpl_vars['_Ainput']->value['INF'])+1)/abs($_smarty_tpl->tpl_vars['loop']->step));
if ($_smarty_tpl->tpl_vars['loop']->total > 0) {
for ($_smarty_tpl->tpl_vars['loop']->value = 1, $_smarty_tpl->tpl_vars['loop']->iteration = 1;$_smarty_tpl->tpl_vars['loop']->iteration <= $_smarty_tpl->tpl_vars['loop']->total;$_smarty_tpl->tpl_vars['loop']->value += $_smarty_tpl->tpl_vars['loop']->step, $_smarty_tpl->tpl_vars['loop']->iteration++) {
$_smarty_tpl->tpl_vars['loop']->first = $_smarty_tpl->tpl_vars['loop']->iteration == 1;$_smarty_tpl->tpl_vars['loop']->last = $_smarty_tpl->tpl_vars['loop']->iteration == $_smarty_tpl->tpl_vars['loop']->total;?>
   <SearchPassenger xmlns="http://www.travelport.com/schema/common_v35_0" Code="<?php echo $_smarty_tpl->tpl_vars['_Oconf']->value['site']['paxTypes']['INF'];?>
" BookingTravelerRef="INF<?php echo $_smarty_tpl->tpl_vars['loop']->value;?>
" Key="INF<?php echo $_smarty_tpl->tpl_vars['loop']->value;?>
"  />
   <?php }} ?>
   <?php }?><AirPricingCommand>
      <?php echo $_smarty_tpl->tpl_vars['airPricingCommandXml']->value;?>

   </AirPricingCommand>
</AirPriceReq>



<?php }} ?>

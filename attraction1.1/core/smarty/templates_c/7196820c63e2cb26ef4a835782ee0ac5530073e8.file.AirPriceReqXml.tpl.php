<?php /* Smarty version Smarty-3.1.21, created on 2017-06-27 10:09:56
         compiled from "F:\xampp\htdocs\bridges\airline\travelportNew\views\AirPriceReqXml.tpl" */ ?>
<?php /*%%SmartyHeaderCode:29436581c6203798393-05944980%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '7196820c63e2cb26ef4a835782ee0ac5530073e8' => 
    array (
      0 => 'F:\\xampp\\htdocs\\bridges\\airline\\travelportNew\\views\\AirPriceReqXml.tpl',
      1 => 1498484953,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '29436581c6203798393-05944980',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.21',
  'unifunc' => 'content_581c6203a30499_49234815',
  'variables' => 
  array (
    '_Ainput' => 0,
    '_Asettings' => 0,
    'providerCode' => 0,
    'hostTokenXml' => 0,
    'airPricingCommandXml' => 0,
    '_Oconf' => 0,
    'loop' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_581c6203a30499_49234815')) {function content_581c6203a30499_49234815($_smarty_tpl) {?><AirPriceReq xmlns="http://www.travelport.com/schema/air_v40_0" TraceId="<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['traceId'];?>
" AuthorizedBy="<?php echo $_smarty_tpl->tpl_vars['_Asettings']->value['apiCredentials']['AuthorizedBy'];?>
" TargetBranch="<?php echo $_smarty_tpl->tpl_vars['_Asettings']->value['apiCredentials']['travelMediaTargetBranch'];?>
">
   <BillingPointOfSaleInfo xmlns="http://www.travelport.com/schema/common_v40_0" OriginApplication="<?php echo $_smarty_tpl->tpl_vars['_Asettings']->value['apiCredentials']['application'];?>
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
?><AirSegment Key="<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['trm_AirSegment'][$_smarty_tpl->getVariable('smarty')->value['section']['segInfo']['index']]['Key'];?>
" Group="<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['trm_AirSegment'][$_smarty_tpl->getVariable('smarty')->value['section']['segInfo']['index']]['Group'];?>
" Carrier="<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['trm_AirSegment'][$_smarty_tpl->getVariable('smarty')->value['section']['segInfo']['index']]['Carrier'];?>
" FlightNumber="<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['trm_AirSegment'][$_smarty_tpl->getVariable('smarty')->value['section']['segInfo']['index']]['FlightNumber'];?>
" Origin="<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['trm_AirSegment'][$_smarty_tpl->getVariable('smarty')->value['section']['segInfo']['index']]['Origin'];?>
" Destination="<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['trm_AirSegment'][$_smarty_tpl->getVariable('smarty')->value['section']['segInfo']['index']]['Destination'];?>
" DepartureTime="<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['trm_AirSegment'][$_smarty_tpl->getVariable('smarty')->value['section']['segInfo']['index']]['DepartureTime'];?>
" ArrivalTime="<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['trm_AirSegment'][$_smarty_tpl->getVariable('smarty')->value['section']['segInfo']['index']]['ArrivalTime'];?>
" FlightTime="<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['trm_AirSegment'][$_smarty_tpl->getVariable('smarty')->value['section']['segInfo']['index']]['FlightTime'];?>
" ProviderCode="<?php echo $_smarty_tpl->tpl_vars['providerCode']->value;?>
" ClassOfService="<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['trm_AirSegment'][$_smarty_tpl->getVariable('smarty')->value['section']['segInfo']['index']]['BookingCode'];?>
" <?php if (isset($_smarty_tpl->tpl_vars['_Ainput']->value['trm_AirSegment'][$_smarty_tpl->getVariable('smarty',null,true,false)->value['section']['segInfo']['index']]['Status'])&&$_smarty_tpl->tpl_vars['_Ainput']->value['trm_AirSegment'][$_smarty_tpl->getVariable('smarty')->value['section']['segInfo']['index']]['Status']!='') {?> Status="<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['trm_AirSegment'][$_smarty_tpl->getVariable('smarty')->value['section']['segInfo']['index']]['Status'];?>
" <?php }?> <?php if (isset($_smarty_tpl->tpl_vars['_Ainput']->value['trm_AirSegment'][$_smarty_tpl->getVariable('smarty',null,true,false)->value['section']['segInfo']['index']]['HostTokenRef'])&&$_smarty_tpl->tpl_vars['_Ainput']->value['trm_AirSegment'][$_smarty_tpl->getVariable('smarty')->value['section']['segInfo']['index']]['HostTokenRef']!='') {?> HostTokenRef="<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['trm_AirSegment'][$_smarty_tpl->getVariable('smarty')->value['section']['segInfo']['index']]['HostTokenRef'];?>
" <?php }?> <?php if (isset($_smarty_tpl->tpl_vars['_Ainput']->value['trm_AirSegment'][$_smarty_tpl->getVariable('smarty',null,true,false)->value['section']['segInfo']['index']]['SupplierCode'])) {?> SupplierCode="<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['trm_AirSegment'][$_smarty_tpl->getVariable('smarty')->value['section']['segInfo']['index']]['SupplierCode'];?>
" <?php }?> <?php if (isset($_smarty_tpl->tpl_vars['_Ainput']->value['trm_AirSegment'][$_smarty_tpl->getVariable('smarty',null,true,false)->value['section']['segInfo']['index']]['Equipment'])&&$_smarty_tpl->tpl_vars['_Ainput']->value['trm_AirSegment'][$_smarty_tpl->getVariable('smarty')->value['section']['segInfo']['index']]['Equipment']!='') {?> Equipment="<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['trm_AirSegment'][$_smarty_tpl->getVariable('smarty')->value['section']['segInfo']['index']]['Equipment'];?>
" <?php }?>>
         <?php if (isset($_smarty_tpl->tpl_vars['_Ainput']->value['trm_AirSegment'][$_smarty_tpl->getVariable('smarty',null,true,false)->value['section']['segInfo']['index']]['attributes'])&&$_smarty_tpl->tpl_vars['_Ainput']->value['trm_AirSegment'][$_smarty_tpl->getVariable('smarty')->value['section']['segInfo']['index']]['attributes']!='') {?>
         <CodeshareInfo OperatingCarrier="<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['trm_AirSegment'][$_smarty_tpl->getVariable('smarty')->value['section']['segInfo']['index']]['attributes']['OPERATINGCARRIER'];?>
" OperatingFlightNumber="<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['trm_AirSegment'][$_smarty_tpl->getVariable('smarty')->value['section']['segInfo']['index']]['attributes']['OPERATINGFLIGHTNUMBER'];?>
" />
         <?php }?>
		  <?php if (isset($_smarty_tpl->tpl_vars['_Ainput']->value['trm_AirSegment'][$_smarty_tpl->getVariable('smarty',null,true,false)->value['section']['segInfo']['index']]['tmpSegmentIdx'])) {?>
         <Connection SegmentIndex="<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['trm_AirSegment'][$_smarty_tpl->getVariable('smarty')->value['section']['segInfo']['index']]['tmpSegmentIdx'];?>
" />
         <?php }?>		 
      </AirSegment>
      <?php if (isset($_smarty_tpl->tpl_vars['_Ainput']->value['trm_AirSegment'][$_smarty_tpl->getVariable('smarty',null,true,false)->value['section']['segInfo']['index']]['hostToken']['key'])&&$_smarty_tpl->tpl_vars['_Ainput']->value['trm_AirSegment'][$_smarty_tpl->getVariable('smarty')->value['section']['segInfo']['index']]['hostToken']['key']!='') {?>
      <?php $_smarty_tpl->tpl_vars["hostTokenXml"] = new Smarty_variable(("<HostToken xmlns='http://www.travelport.com/schema/common_v40_0' Key='".((string)$_smarty_tpl->tpl_vars['_Ainput']->value['trm_AirSegment'][$_smarty_tpl->getVariable('smarty')->value['section']['segInfo']['index']]['hostToken']['key'])."'>".((string)$_smarty_tpl->tpl_vars['_Ainput']->value['trm_AirSegment'][$_smarty_tpl->getVariable('smarty')->value['section']['segInfo']['index']]['hostToken']['value'])."</HostToken>").($_smarty_tpl->tpl_vars['hostTokenXml']->value), null, 0);?>
      <?php }?>
      <?php $_smarty_tpl->tpl_vars["airPricingCommandXml"] = new Smarty_variable(("<AirSegmentPricingModifiers AirSegmentRef='".((string)$_smarty_tpl->tpl_vars['_Ainput']->value['trm_AirSegment'][$_smarty_tpl->getVariable('smarty')->value['section']['segInfo']['index']]['Key'])."' FareBasisCode='".((string)$_smarty_tpl->tpl_vars['_Ainput']->value['trm_AirSegment'][$_smarty_tpl->getVariable('smarty')->value['section']['segInfo']['index']]['FareBasis'])."'>
      <PermittedBookingCodes><BookingCode Code='".((string)$_smarty_tpl->tpl_vars['_Ainput']->value['trm_AirSegment'][$_smarty_tpl->getVariable('smarty')->value['section']['segInfo']['index']]['BookingCode'])."' /></PermittedBookingCodes>
      </AirSegmentPricingModifiers>").($_smarty_tpl->tpl_vars['airPricingCommandXml']->value), null, 0);?>
      <?php endfor; endif; ?>
      <?php echo $_smarty_tpl->tpl_vars['hostTokenXml']->value;?>

   </AirItinerary>
  
    <AirPricingModifiers InventoryRequestType="DirectAccess" >
    </AirPricingModifiers>
   <?php $_smarty_tpl->tpl_vars['loop'] = new Smarty_Variable;$_smarty_tpl->tpl_vars['loop']->step = 1;$_smarty_tpl->tpl_vars['loop']->total = (int) ceil(($_smarty_tpl->tpl_vars['loop']->step > 0 ? $_smarty_tpl->tpl_vars['_Ainput']->value['ADT']+1 - (1) : 1-($_smarty_tpl->tpl_vars['_Ainput']->value['ADT'])+1)/abs($_smarty_tpl->tpl_vars['loop']->step));
if ($_smarty_tpl->tpl_vars['loop']->total > 0) {
for ($_smarty_tpl->tpl_vars['loop']->value = 1, $_smarty_tpl->tpl_vars['loop']->iteration = 1;$_smarty_tpl->tpl_vars['loop']->iteration <= $_smarty_tpl->tpl_vars['loop']->total;$_smarty_tpl->tpl_vars['loop']->value += $_smarty_tpl->tpl_vars['loop']->step, $_smarty_tpl->tpl_vars['loop']->iteration++) {
$_smarty_tpl->tpl_vars['loop']->first = $_smarty_tpl->tpl_vars['loop']->iteration == 1;$_smarty_tpl->tpl_vars['loop']->last = $_smarty_tpl->tpl_vars['loop']->iteration == $_smarty_tpl->tpl_vars['loop']->total;?>
   <SearchPassenger xmlns="http://www.travelport.com/schema/common_v40_0" Code="<?php echo $_smarty_tpl->tpl_vars['_Oconf']->value['site']['paxTypes']['ADT'];?>
" BookingTravelerRef="ADT<?php echo $_smarty_tpl->tpl_vars['loop']->value;?>
" Key="ADT<?php echo $_smarty_tpl->tpl_vars['loop']->value;?>
" />
   <?php }} ?>
   <?php if ($_smarty_tpl->tpl_vars['_Ainput']->value['CHD']>0) {?>
   <?php $_smarty_tpl->tpl_vars['loop'] = new Smarty_Variable;$_smarty_tpl->tpl_vars['loop']->step = 1;$_smarty_tpl->tpl_vars['loop']->total = (int) ceil(($_smarty_tpl->tpl_vars['loop']->step > 0 ? $_smarty_tpl->tpl_vars['_Ainput']->value['CHD']+1 - (1) : 1-($_smarty_tpl->tpl_vars['_Ainput']->value['CHD'])+1)/abs($_smarty_tpl->tpl_vars['loop']->step));
if ($_smarty_tpl->tpl_vars['loop']->total > 0) {
for ($_smarty_tpl->tpl_vars['loop']->value = 1, $_smarty_tpl->tpl_vars['loop']->iteration = 1;$_smarty_tpl->tpl_vars['loop']->iteration <= $_smarty_tpl->tpl_vars['loop']->total;$_smarty_tpl->tpl_vars['loop']->value += $_smarty_tpl->tpl_vars['loop']->step, $_smarty_tpl->tpl_vars['loop']->iteration++) {
$_smarty_tpl->tpl_vars['loop']->first = $_smarty_tpl->tpl_vars['loop']->iteration == 1;$_smarty_tpl->tpl_vars['loop']->last = $_smarty_tpl->tpl_vars['loop']->iteration == $_smarty_tpl->tpl_vars['loop']->total;?>
   <SearchPassenger xmlns="http://www.travelport.com/schema/common_v40_0" Code="<?php echo $_smarty_tpl->tpl_vars['_Oconf']->value['site']['paxTypes']['CHD'];?>
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
   <SearchPassenger xmlns="http://www.travelport.com/schema/common_v40_0" Code="<?php echo $_smarty_tpl->tpl_vars['_Oconf']->value['site']['paxTypes']['INF'];?>
" BookingTravelerRef="INF<?php echo $_smarty_tpl->tpl_vars['loop']->value;?>
" Key="INF<?php echo $_smarty_tpl->tpl_vars['loop']->value;?>
"  />
   <?php }} ?>
   <?php }?>
   <AirPricingCommand>
      <?php echo $_smarty_tpl->tpl_vars['airPricingCommandXml']->value;?>

   </AirPricingCommand>

</AirPriceReq>

<?php }} ?>

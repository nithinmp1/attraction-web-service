<?php /* Smarty version Smarty-3.1.21, created on 2017-06-28 19:14:04
         compiled from "F:\xampp\htdocs\bridges\airline\travelportNew1.1\views\LowFareSearchReqXml.tpl" */ ?>
<?php /*%%SmartyHeaderCode:680059366e88061d74-27022762%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'a5e3aabe62c32ed63a75702ee4ca9a013d82c9d4' => 
    array (
      0 => 'F:\\xampp\\htdocs\\bridges\\airline\\travelportNew1.1\\views\\LowFareSearchReqXml.tpl',
      1 => 1497851233,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '680059366e88061d74-27022762',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.21',
  'unifunc' => 'content_59366e8819e443_99703034',
  'variables' => 
  array (
    '_Ainput' => 0,
    '_Asettings' => 0,
    '_Oconf' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_59366e8819e443_99703034')) {function content_59366e8819e443_99703034($_smarty_tpl) {?><LowFareSearchReq xmlns="http://www.travelport.com/schema/air_v40_0" TraceId="<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['traceId'];?>
" TargetBranch="<?php echo $_smarty_tpl->tpl_vars['_Asettings']->value['apiCredentials']['travelMediaTargetBranch'];?>
" ReturnUpsellFare="false" >

	<BillingPointOfSaleInfo xmlns="http://www.travelport.com/schema/common_v40_0" OriginApplication="<?php echo $_smarty_tpl->tpl_vars['_Asettings']->value['apiCredentials']['application'];?>
" />
<?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['secInfo'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['secInfo']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['secInfo']['name'] = 'secInfo';
$_smarty_tpl->tpl_vars['smarty']->value['section']['secInfo']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['_Ainput']->value['sectorInfo']) ? count($_loop) : max(0, (int) $_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['secInfo']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['secInfo']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['secInfo']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['secInfo']['step'] = 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['secInfo']['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['secInfo']['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']['secInfo']['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['secInfo']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['secInfo']['total'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['secInfo']['loop'];
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['secInfo']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['secInfo']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['secInfo']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['secInfo']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['secInfo']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['secInfo']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['secInfo']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['secInfo']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['secInfo']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['secInfo']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['secInfo']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['secInfo']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['secInfo']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['secInfo']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['secInfo']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['secInfo']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['secInfo']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['secInfo']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['secInfo']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['secInfo']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['secInfo']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['secInfo']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['secInfo']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['secInfo']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['secInfo']['total']);
?>
	<SearchAirLeg>
		<SearchOrigin>
			<CityOrAirport xmlns="http://www.travelport.com/schema/common_v40_0" Code="<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['sectorInfo'][$_smarty_tpl->getVariable('smarty')->value['section']['secInfo']['index']]['origin'];?>
"  />
		</SearchOrigin>
		<SearchDestination>
			<CityOrAirport xmlns="http://www.travelport.com/schema/common_v40_0" Code="<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['sectorInfo'][$_smarty_tpl->getVariable('smarty')->value['section']['secInfo']['index']]['destination'];?>
"  />
		</SearchDestination>
		<SearchDepTime PreferredTime="<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['sectorInfo'][$_smarty_tpl->getVariable('smarty')->value['section']['secInfo']['index']]['departureDate'];?>
" />
		<AirLegModifiers>
<?php if (isset($_smarty_tpl->tpl_vars['_Ainput']->value['cabinClass'])&&$_smarty_tpl->tpl_vars['_Ainput']->value['cabinClass']!='') {?>
			<PreferredCabins>
				<CabinClass xmlns="http://www.travelport.com/schema/common_v40_0" Type="<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['cabinClass'];?>
" />
			</PreferredCabins>
<?php }?>
		</AirLegModifiers>
	</SearchAirLeg>
<?php endfor; endif; ?>
	<AirSearchModifiers>
<?php if (isset($_smarty_tpl->tpl_vars['_Ainput']->value['preferredProviders'])) {?>
		<PreferredProviders>
<?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['providerInfo'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['providerInfo']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['providerInfo']['name'] = 'providerInfo';
$_smarty_tpl->tpl_vars['smarty']->value['section']['providerInfo']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['_Ainput']->value['preferredProviders']) ? count($_loop) : max(0, (int) $_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['providerInfo']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['providerInfo']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['providerInfo']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['providerInfo']['step'] = 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['providerInfo']['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['providerInfo']['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']['providerInfo']['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['providerInfo']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['providerInfo']['total'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['providerInfo']['loop'];
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['providerInfo']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['providerInfo']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['providerInfo']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['providerInfo']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['providerInfo']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['providerInfo']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['providerInfo']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['providerInfo']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['providerInfo']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['providerInfo']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['providerInfo']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['providerInfo']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['providerInfo']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['providerInfo']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['providerInfo']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['providerInfo']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['providerInfo']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['providerInfo']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['providerInfo']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['providerInfo']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['providerInfo']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['providerInfo']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['providerInfo']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['providerInfo']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['providerInfo']['total']);
?>
			<Provider xmlns="http://www.travelport.com/schema/common_v40_0" Code="<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['preferredProviders'][$_smarty_tpl->getVariable('smarty')->value['section']['providerInfo']['index']];?>
" />
<?php endfor; endif; ?>
		</PreferredProviders>
<?php }?>
<?php if (isset($_smarty_tpl->tpl_vars['_Ainput']->value['permittedCarriers'])&&!empty($_smarty_tpl->tpl_vars['_Ainput']->value['permittedCarriers'])) {?>
		<PermittedCarriers>
<?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['permittedInfo'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['permittedInfo']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['permittedInfo']['name'] = 'permittedInfo';
$_smarty_tpl->tpl_vars['smarty']->value['section']['permittedInfo']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['_Ainput']->value['permittedCarriers']) ? count($_loop) : max(0, (int) $_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['permittedInfo']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['permittedInfo']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['permittedInfo']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['permittedInfo']['step'] = 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['permittedInfo']['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['permittedInfo']['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']['permittedInfo']['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['permittedInfo']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['permittedInfo']['total'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['permittedInfo']['loop'];
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['permittedInfo']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['permittedInfo']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['permittedInfo']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['permittedInfo']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['permittedInfo']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['permittedInfo']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['permittedInfo']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['permittedInfo']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['permittedInfo']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['permittedInfo']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['permittedInfo']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['permittedInfo']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['permittedInfo']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['permittedInfo']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['permittedInfo']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['permittedInfo']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['permittedInfo']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['permittedInfo']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['permittedInfo']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['permittedInfo']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['permittedInfo']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['permittedInfo']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['permittedInfo']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['permittedInfo']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['permittedInfo']['total']);
?>
			<Carrier xmlns="http://www.travelport.com/schema/common_v40_0" Code="<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['permittedCarriers'][$_smarty_tpl->getVariable('smarty')->value['section']['permittedInfo']['index']];?>
" />
<?php endfor; endif; ?>
		</PermittedCarriers>
<?php } elseif (isset($_smarty_tpl->tpl_vars['_Ainput']->value['prohibitedCarriers'])&&!empty($_smarty_tpl->tpl_vars['_Ainput']->value['prohibitedCarriers'])) {?>
		<ProhibitedCarriers>
<?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['prohibitedInfo'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['prohibitedInfo']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['prohibitedInfo']['name'] = 'prohibitedInfo';
$_smarty_tpl->tpl_vars['smarty']->value['section']['prohibitedInfo']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['_Ainput']->value['prohibitedCarriers']) ? count($_loop) : max(0, (int) $_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['prohibitedInfo']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['prohibitedInfo']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['prohibitedInfo']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['prohibitedInfo']['step'] = 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['prohibitedInfo']['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['prohibitedInfo']['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']['prohibitedInfo']['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['prohibitedInfo']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['prohibitedInfo']['total'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['prohibitedInfo']['loop'];
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['prohibitedInfo']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['prohibitedInfo']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['prohibitedInfo']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['prohibitedInfo']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['prohibitedInfo']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['prohibitedInfo']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['prohibitedInfo']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['prohibitedInfo']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['prohibitedInfo']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['prohibitedInfo']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['prohibitedInfo']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['prohibitedInfo']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['prohibitedInfo']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['prohibitedInfo']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['prohibitedInfo']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['prohibitedInfo']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['prohibitedInfo']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['prohibitedInfo']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['prohibitedInfo']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['prohibitedInfo']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['prohibitedInfo']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['prohibitedInfo']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['prohibitedInfo']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['prohibitedInfo']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['prohibitedInfo']['total']);
?>
			<Carrier xmlns="http://www.travelport.com/schema/common_v40_0" Code="<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['prohibitedCarriers'][$_smarty_tpl->getVariable('smarty')->value['section']['prohibitedInfo']['index']];?>
" />
<?php endfor; endif; ?>
		</ProhibitedCarriers>
<?php }?>
	
		<FlightType RequireSingleCarrier="false" TripleInterlineCon="true" DoubleInterlineCon="true" SingleInterlineCon="true" TripleOnlineCon="true" DoubleOnlineCon="true" SingleOnlineCon="true" StopDirects="true" NonStopDirects="true"/>
		
	</AirSearchModifiers>
<?php $_smarty_tpl->tpl_vars['adtLoop'] = new Smarty_Variable;$_smarty_tpl->tpl_vars['adtLoop']->step = 1;$_smarty_tpl->tpl_vars['adtLoop']->total = (int) ceil(($_smarty_tpl->tpl_vars['adtLoop']->step > 0 ? $_smarty_tpl->tpl_vars['_Ainput']->value['ADT']+1 - (1) : 1-($_smarty_tpl->tpl_vars['_Ainput']->value['ADT'])+1)/abs($_smarty_tpl->tpl_vars['adtLoop']->step));
if ($_smarty_tpl->tpl_vars['adtLoop']->total > 0) {
for ($_smarty_tpl->tpl_vars['adtLoop']->value = 1, $_smarty_tpl->tpl_vars['adtLoop']->iteration = 1;$_smarty_tpl->tpl_vars['adtLoop']->iteration <= $_smarty_tpl->tpl_vars['adtLoop']->total;$_smarty_tpl->tpl_vars['adtLoop']->value += $_smarty_tpl->tpl_vars['adtLoop']->step, $_smarty_tpl->tpl_vars['adtLoop']->iteration++) {
$_smarty_tpl->tpl_vars['adtLoop']->first = $_smarty_tpl->tpl_vars['adtLoop']->iteration == 1;$_smarty_tpl->tpl_vars['adtLoop']->last = $_smarty_tpl->tpl_vars['adtLoop']->iteration == $_smarty_tpl->tpl_vars['adtLoop']->total;?>
	<SearchPassenger xmlns="http://www.travelport.com/schema/common_v40_0" Code="<?php echo $_smarty_tpl->tpl_vars['_Oconf']->value['site']['paxTypes']['ADT'];?>
"  />
<?php }} ?>

<?php if ($_smarty_tpl->tpl_vars['_Ainput']->value['CHD']>0) {?>
<?php $_smarty_tpl->tpl_vars['adtLoop'] = new Smarty_Variable;$_smarty_tpl->tpl_vars['adtLoop']->step = 1;$_smarty_tpl->tpl_vars['adtLoop']->total = (int) ceil(($_smarty_tpl->tpl_vars['adtLoop']->step > 0 ? $_smarty_tpl->tpl_vars['_Ainput']->value['CHD']+1 - (1) : 1-($_smarty_tpl->tpl_vars['_Ainput']->value['CHD'])+1)/abs($_smarty_tpl->tpl_vars['adtLoop']->step));
if ($_smarty_tpl->tpl_vars['adtLoop']->total > 0) {
for ($_smarty_tpl->tpl_vars['adtLoop']->value = 1, $_smarty_tpl->tpl_vars['adtLoop']->iteration = 1;$_smarty_tpl->tpl_vars['adtLoop']->iteration <= $_smarty_tpl->tpl_vars['adtLoop']->total;$_smarty_tpl->tpl_vars['adtLoop']->value += $_smarty_tpl->tpl_vars['adtLoop']->step, $_smarty_tpl->tpl_vars['adtLoop']->iteration++) {
$_smarty_tpl->tpl_vars['adtLoop']->first = $_smarty_tpl->tpl_vars['adtLoop']->iteration == 1;$_smarty_tpl->tpl_vars['adtLoop']->last = $_smarty_tpl->tpl_vars['adtLoop']->iteration == $_smarty_tpl->tpl_vars['adtLoop']->total;?>
	<SearchPassenger xmlns="http://www.travelport.com/schema/common_v40_0" Code="<?php echo $_smarty_tpl->tpl_vars['_Oconf']->value['site']['paxTypes']['CHD'];?>
" Age="<?php echo $_smarty_tpl->tpl_vars['_Oconf']->value['site']['paxAge']['CHD'];?>
" DOB="<?php echo $_smarty_tpl->tpl_vars['_Oconf']->value['site']['paxDob']['CHD'];?>
" />
<?php }} ?>
<?php }?>

<?php if ($_smarty_tpl->tpl_vars['_Ainput']->value['INF']>0) {?>
<?php $_smarty_tpl->tpl_vars['adtLoop'] = new Smarty_Variable;$_smarty_tpl->tpl_vars['adtLoop']->step = 1;$_smarty_tpl->tpl_vars['adtLoop']->total = (int) ceil(($_smarty_tpl->tpl_vars['adtLoop']->step > 0 ? $_smarty_tpl->tpl_vars['_Ainput']->value['INF']+1 - (1) : 1-($_smarty_tpl->tpl_vars['_Ainput']->value['INF'])+1)/abs($_smarty_tpl->tpl_vars['adtLoop']->step));
if ($_smarty_tpl->tpl_vars['adtLoop']->total > 0) {
for ($_smarty_tpl->tpl_vars['adtLoop']->value = 1, $_smarty_tpl->tpl_vars['adtLoop']->iteration = 1;$_smarty_tpl->tpl_vars['adtLoop']->iteration <= $_smarty_tpl->tpl_vars['adtLoop']->total;$_smarty_tpl->tpl_vars['adtLoop']->value += $_smarty_tpl->tpl_vars['adtLoop']->step, $_smarty_tpl->tpl_vars['adtLoop']->iteration++) {
$_smarty_tpl->tpl_vars['adtLoop']->first = $_smarty_tpl->tpl_vars['adtLoop']->iteration == 1;$_smarty_tpl->tpl_vars['adtLoop']->last = $_smarty_tpl->tpl_vars['adtLoop']->iteration == $_smarty_tpl->tpl_vars['adtLoop']->total;?>
	<SearchPassenger xmlns="http://www.travelport.com/schema/common_v40_0" Code="<?php echo $_smarty_tpl->tpl_vars['_Oconf']->value['site']['paxTypes']['INF'];?>
" Age="<?php echo $_smarty_tpl->tpl_vars['_Oconf']->value['site']['paxAge']['INF'];?>
" DOB="<?php echo $_smarty_tpl->tpl_vars['_Oconf']->value['site']['paxDob']['INF'];?>
" />
<?php }} ?>
<?php }?>
	<AirPricingModifiers FaresIndicator="AllFares" CurrencyType="<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['currencyCode'];?>
">
		<AccountCodes>
			<AccountCode xmlns="http://www.travelport.com/schema/common_v40_0" Code="-" />
		</AccountCodes>
		<PromoCodes>               
			<PromoCode Code="6ESININD" ProviderCode="ACH" SupplierCode="6E"/>
		</PromoCodes>

	</AirPricingModifiers>
</LowFareSearchReq><?php }} ?>

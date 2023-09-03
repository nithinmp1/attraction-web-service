<?php /* Smarty version Smarty-3.1.21, created on 2016-12-21 16:14:52
         compiled from "F:\xampp\htdocs\bridges\airline\travelportNew\views\UniversalRecordAddPriceXml.tpl" */ ?>
<?php /*%%SmartyHeaderCode:31487585396bd8f8b24-72418615%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'b42e4b6a3e78e6e3c682f85af4619334b282d54e' => 
    array (
      0 => 'F:\\xampp\\htdocs\\bridges\\airline\\travelportNew\\views\\UniversalRecordAddPriceXml.tpl',
      1 => 1482317089,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '31487585396bd8f8b24-72418615',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.21',
  'unifunc' => 'content_585396bd94ea40_41401289',
  'variables' => 
  array (
    '_Ainput' => 0,
    '_Asettings' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_585396bd94ea40_41401289')) {function content_585396bd94ea40_41401289($_smarty_tpl) {?><univ:UniversalRecordModifyReq TraceId="<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['traceId'];?>
" AuthorizedBy="<?php echo $_smarty_tpl->tpl_vars['_Asettings']->value['apiCredentials']['AuthorizedBy'];?>
" TargetBranch="<?php echo $_smarty_tpl->tpl_vars['_Asettings']->value['apiCredentials']['goBudgetAirTargetBranch'];?>
" ReturnRecord="true" Version="<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['Version'];?>
" xmlns:univ="http://www.travelport.com/schema/universal_v35_0" xmlns:common_v35_0="http://www.travelport.com/schema/common_v35_0" xmlns:air="http://www.travelport.com/schema/air_v35_0">
  <common_v35_0:BillingPointOfSaleInfo OriginApplication="<?php echo $_smarty_tpl->tpl_vars['_Asettings']->value['apiCredentials']['application'];?>
" />
  
  <univ:RecordIdentifier UniversalLocatorCode="<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['UniversalLocatorCode'];?>
" ProviderCode="<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['ProviderCode'];?>
" ProviderLocatorCode="<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['ProviderLocatorCode'];?>
" />
  
  <univ:UniversalModifyCmd Key="<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['ProviderReservationRefKey'];?>
">
    <univ:AirAdd ReservationLocatorCode="<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['AirReservationLocatorCode'];?>
" BookingTravelerRef="<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['PaxArray'][0]['Key'];?>
">

	<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['addAirPriceResponse'];?>

    </univ:AirAdd>
	
  </univ:UniversalModifyCmd>
</univ:UniversalRecordModifyReq><?php }} ?>

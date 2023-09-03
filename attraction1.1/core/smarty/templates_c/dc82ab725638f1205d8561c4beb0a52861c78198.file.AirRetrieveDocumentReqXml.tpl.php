<?php /* Smarty version Smarty-3.1.21, created on 2016-11-10 12:08:37
         compiled from "F:\xampp\htdocs\bridges\airline\travelportNew\views\AirRetrieveDocumentReqXml.tpl" */ ?>
<?php /*%%SmartyHeaderCode:78265822edeed398d6-17463732%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'dc82ab725638f1205d8561c4beb0a52861c78198' => 
    array (
      0 => 'F:\\xampp\\htdocs\\bridges\\airline\\travelportNew\\views\\AirRetrieveDocumentReqXml.tpl',
      1 => 1478758609,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '78265822edeed398d6-17463732',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.21',
  'unifunc' => 'content_5822edeeec41b2_43483744',
  'variables' => 
  array (
    '_Ainput' => 0,
    '_Asettings' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5822edeeec41b2_43483744')) {function content_5822edeeec41b2_43483744($_smarty_tpl) {?><ns2:AirRetrieveDocumentReq xmlns="http://www.travelport.com/schema/common_v35_0" xmlns:ns2="http://www.travelport.com/schema/air_v35_0" xmlns:ns7="http://www.travelport.com/schema/universal_v35_0" ProviderLocatorCode="<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['ProviderLocatorCode'];?>
" ProviderCode="<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['ProviderCode'];?>
" UniversalRecordLocatorCode="<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['UniversalLocatorCode'];?>
" ReturnPricing="true" TargetBranch="<?php echo $_smarty_tpl->tpl_vars['_Asettings']->value['apiCredentials']['travelMediaTargetBranch'];?>
" AuthorizedBy="<?php echo $_smarty_tpl->tpl_vars['_Asettings']->value['apiCredentials']['AuthorizedBy'];?>
">

  <BillingPointOfSaleInfo OriginApplication="<?php echo $_smarty_tpl->tpl_vars['_Asettings']->value['apiCredentials']['application'];?>
" />

  <ns2:AirReservationLocatorCode><?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['AirReservationLocatorCode'];?>
</ns2:AirReservationLocatorCode>

</ns2:AirRetrieveDocumentReq> <?php }} ?>

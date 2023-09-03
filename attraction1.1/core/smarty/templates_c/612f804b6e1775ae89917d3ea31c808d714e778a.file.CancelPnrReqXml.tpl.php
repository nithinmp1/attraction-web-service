<?php /* Smarty version Smarty-3.1.21, created on 2017-06-27 12:05:52
         compiled from "F:\xampp\htdocs\bridges\airline\travelportNew\views\CancelPnrReqXml.tpl" */ ?>
<?php /*%%SmartyHeaderCode:164305820182217b220-71399124%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '612f804b6e1775ae89917d3ea31c808d714e778a' => 
    array (
      0 => 'F:\\xampp\\htdocs\\bridges\\airline\\travelportNew\\views\\CancelPnrReqXml.tpl',
      1 => 1496739990,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '164305820182217b220-71399124',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.21',
  'unifunc' => 'content_58201822217624_79712072',
  'variables' => 
  array (
    '_Ainput' => 0,
    '_Asettings' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_58201822217624_79712072')) {function content_58201822217624_79712072($_smarty_tpl) {?><UniversalRecordCancelReq xmlns="http://www.travelport.com/schema/universal_v40_0" TraceId="<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['traceId'];?>
" AuthorizedBy="<?php echo $_smarty_tpl->tpl_vars['_Asettings']->value['apiCredentials']['AuthorizedBy'];?>
" TargetBranch="<?php echo $_smarty_tpl->tpl_vars['_Asettings']->value['apiCredentials']['goBudgetAirTargetBranch'];?>
" UniversalRecordLocatorCode="<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['pnr'];?>
" Version="0">
	<BillingPointOfSaleInfo xmlns="http://www.travelport.com/schema/common_v40_0" OriginApplication="<?php echo $_smarty_tpl->tpl_vars['_Asettings']->value['apiCredentials']['application'];?>
" />
</UniversalRecordCancelReq><?php }} ?>

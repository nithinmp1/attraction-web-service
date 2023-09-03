<?php /* Smarty version Smarty-3.1.21, created on 2017-06-30 15:58:38
         compiled from "F:\xampp\htdocs\bridges\airline\travelport1.1\views\RetrievePnrReqXml.tpl" */ ?>
<?php /*%%SmartyHeaderCode:5952595627d6acd690-45102505%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'd6878f0867f109871b140719024d7aeffa4a67c5' => 
    array (
      0 => 'F:\\xampp\\htdocs\\bridges\\airline\\travelport1.1\\views\\RetrievePnrReqXml.tpl',
      1 => 1496739967,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '5952595627d6acd690-45102505',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    '_Ainput' => 0,
    '_Asettings' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21',
  'unifunc' => 'content_595627d6b1b8a5_23397609',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_595627d6b1b8a5_23397609')) {function content_595627d6b1b8a5_23397609($_smarty_tpl) {?><UniversalRecordRetrieveReq  xmlns="http://www.travelport.com/schema/universal_v40_0" TraceId="<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['traceId'];?>
" AuthorizedBy="<?php echo $_smarty_tpl->tpl_vars['_Asettings']->value['apiCredentials']['AuthorizedBy'];?>
" TargetBranch="<?php echo $_smarty_tpl->tpl_vars['_Asettings']->value['apiCredentials']['goBudgetAirTargetBranch'];?>
">
	<BillingPointOfSaleInfo xmlns="http://www.travelport.com/schema/common_v40_0" OriginApplication="<?php echo $_smarty_tpl->tpl_vars['_Asettings']->value['apiCredentials']['application'];?>
" />
	<UniversalRecordLocatorCode><?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['pnr'];?>
</UniversalRecordLocatorCode>
</UniversalRecordRetrieveReq>

<?php }} ?>

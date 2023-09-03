<?php /* Smarty version Smarty-3.1.21, created on 2017-06-29 16:38:10
         compiled from "F:\xampp\htdocs\bridges\airline\travelportNew1.1\views\RetrievePnrReqXml.tpl" */ ?>
<?php /*%%SmartyHeaderCode:305025954df9a37a2a7-24420968%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '5246fd8b6c4841bbe3565acdc7d94770b781cb05' => 
    array (
      0 => 'F:\\xampp\\htdocs\\bridges\\airline\\travelportNew1.1\\views\\RetrievePnrReqXml.tpl',
      1 => 1496739967,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '305025954df9a37a2a7-24420968',
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
  'unifunc' => 'content_5954df9a3d7eb6_15264215',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5954df9a3d7eb6_15264215')) {function content_5954df9a3d7eb6_15264215($_smarty_tpl) {?><UniversalRecordRetrieveReq  xmlns="http://www.travelport.com/schema/universal_v40_0" TraceId="<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['traceId'];?>
" AuthorizedBy="<?php echo $_smarty_tpl->tpl_vars['_Asettings']->value['apiCredentials']['AuthorizedBy'];?>
" TargetBranch="<?php echo $_smarty_tpl->tpl_vars['_Asettings']->value['apiCredentials']['goBudgetAirTargetBranch'];?>
">
	<BillingPointOfSaleInfo xmlns="http://www.travelport.com/schema/common_v40_0" OriginApplication="<?php echo $_smarty_tpl->tpl_vars['_Asettings']->value['apiCredentials']['application'];?>
" />
	<UniversalRecordLocatorCode><?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['pnr'];?>
</UniversalRecordLocatorCode>
</UniversalRecordRetrieveReq>

<?php }} ?>

<?php /* Smarty version Smarty-3.1.21, created on 2017-06-14 09:03:30
         compiled from "F:\xampp\htdocs\bridges\airline\travelportNew\views\RetrievePnrReqXml.tpl" */ ?>
<?php /*%%SmartyHeaderCode:2093258201364d149a4-81803956%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '66a686f2e15687a6f86ebc6a52686b6328668fff' => 
    array (
      0 => 'F:\\xampp\\htdocs\\bridges\\airline\\travelportNew\\views\\RetrievePnrReqXml.tpl',
      1 => 1496739967,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2093258201364d149a4-81803956',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.21',
  'unifunc' => 'content_58201364d62ba4_37564600',
  'variables' => 
  array (
    '_Ainput' => 0,
    '_Asettings' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_58201364d62ba4_37564600')) {function content_58201364d62ba4_37564600($_smarty_tpl) {?><UniversalRecordRetrieveReq  xmlns="http://www.travelport.com/schema/universal_v40_0" TraceId="<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['traceId'];?>
" AuthorizedBy="<?php echo $_smarty_tpl->tpl_vars['_Asettings']->value['apiCredentials']['AuthorizedBy'];?>
" TargetBranch="<?php echo $_smarty_tpl->tpl_vars['_Asettings']->value['apiCredentials']['goBudgetAirTargetBranch'];?>
">
	<BillingPointOfSaleInfo xmlns="http://www.travelport.com/schema/common_v40_0" OriginApplication="<?php echo $_smarty_tpl->tpl_vars['_Asettings']->value['apiCredentials']['application'];?>
" />
	<UniversalRecordLocatorCode><?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['pnr'];?>
</UniversalRecordLocatorCode>
</UniversalRecordRetrieveReq>

<?php }} ?>

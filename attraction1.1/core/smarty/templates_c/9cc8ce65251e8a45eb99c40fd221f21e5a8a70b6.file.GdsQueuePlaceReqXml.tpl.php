<?php /* Smarty version Smarty-3.1.21, created on 2017-06-20 12:19:33
         compiled from "F:\xampp\htdocs\bridges\airline\travelportNew\views\GdsQueuePlaceReqXml.tpl" */ ?>
<?php /*%%SmartyHeaderCode:23569581c130f95ad18-85440843%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '9cc8ce65251e8a45eb99c40fd221f21e5a8a70b6' => 
    array (
      0 => 'F:\\xampp\\htdocs\\bridges\\airline\\travelportNew\\views\\GdsQueuePlaceReqXml.tpl',
      1 => 1496742990,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '23569581c130f95ad18-85440843',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.21',
  'unifunc' => 'content_581c130fb049f1_35429821',
  'variables' => 
  array (
    '_Ainput' => 0,
    '_Asettings' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_581c130fb049f1_35429821')) {function content_581c130fb049f1_35429821($_smarty_tpl) {?><gds:GdsQueuePlaceReq xmlns:gds="http://www.travelport.com/schema/gdsQueue_v40_0" xmlns:com="http://www.travelport.com/schema/common_v40_0" TraceId="<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['traceId'];?>
" AuthorizedBy="<?php echo $_smarty_tpl->tpl_vars['_Asettings']->value['apiCredentials']['AuthorizedBy'];?>
" TargetBranch="<?php echo $_smarty_tpl->tpl_vars['_Asettings']->value['apiCredentials']['goBudgetAirTargetBranch'];?>
" PseudoCityCode="<?php echo $_smarty_tpl->tpl_vars['_Asettings']->value['apiCredentials']['queuePCC'];?>
" ProviderCode="<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['ProviderCode'];?>
" ProviderLocatorCode="<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['ProviderLocatorCode'];?>
">
   <com:BillingPointOfSaleInfo OriginApplication="<?php echo $_smarty_tpl->tpl_vars['_Asettings']->value['apiCredentials']['application'];?>
" />
   <com:QueueSelector Queue="0" />
</gds:GdsQueuePlaceReq><?php }} ?>

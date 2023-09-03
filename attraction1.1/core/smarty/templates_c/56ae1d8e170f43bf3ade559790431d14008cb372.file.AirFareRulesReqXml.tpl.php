<?php /* Smarty version Smarty-3.1.21, created on 2016-11-14 13:28:28
         compiled from "F:\xampp\htdocs\bridges\airline\travelportNew\views\AirFareRulesReqXml.tpl" */ ?>
<?php /*%%SmartyHeaderCode:977658296ea4129ee8-56824890%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '56ae1d8e170f43bf3ade559790431d14008cb372' => 
    array (
      0 => 'F:\\xampp\\htdocs\\bridges\\airline\\travelportNew\\views\\AirFareRulesReqXml.tpl',
      1 => 1478244401,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '977658296ea4129ee8-56824890',
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
  'unifunc' => 'content_58296ea4373de9_36938000',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_58296ea4373de9_36938000')) {function content_58296ea4373de9_36938000($_smarty_tpl) {?><AirFareRulesReq xmlns="http://www.travelport.com/schema/air_v35_0" TraceId="<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['traceId'];?>
" TargetBranch="<?php echo $_smarty_tpl->tpl_vars['_Asettings']->value['apiCredentials']['goBudgetAirTargetBranch'];?>
">
	<BillingPointOfSaleInfo xmlns="http://www.travelport.com/schema/common_v35_0" OriginApplication="<?php echo $_smarty_tpl->tpl_vars['_Asettings']->value['apiCredentials']['application'];?>
" ></BillingPointOfSaleInfo>

<?php if (isset($_smarty_tpl->tpl_vars['_Ainput']->value['AirPricingInfo'])) {?>
<?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['airPrice'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['airPrice']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['airPrice']['name'] = 'airPrice';
$_smarty_tpl->tpl_vars['smarty']->value['section']['airPrice']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['_Ainput']->value['AirPricingInfo']) ? count($_loop) : max(0, (int) $_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['airPrice']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['airPrice']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['airPrice']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['airPrice']['step'] = 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['airPrice']['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['airPrice']['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']['airPrice']['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['airPrice']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['airPrice']['total'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['airPrice']['loop'];
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['airPrice']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['airPrice']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['airPrice']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['airPrice']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['airPrice']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['airPrice']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['airPrice']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['airPrice']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['airPrice']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['airPrice']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['airPrice']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['airPrice']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['airPrice']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['airPrice']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['airPrice']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['airPrice']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['airPrice']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['airPrice']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['airPrice']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['airPrice']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['airPrice']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['airPrice']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['airPrice']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['airPrice']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['airPrice']['total']);
?>

	
	<?php if (isset($_smarty_tpl->tpl_vars['_Ainput']->value['AirPricingInfo'][$_smarty_tpl->getVariable('smarty',null,true,false)->value['section']['airPrice']['index']]['FareInfo'])) {?>
	<?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['fareRule'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['fareRule']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['fareRule']['name'] = 'fareRule';
$_smarty_tpl->tpl_vars['smarty']->value['section']['fareRule']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['_Ainput']->value['AirPricingInfo'][$_smarty_tpl->getVariable('smarty')->value['section']['airPrice']['index']]['FareInfo']) ? count($_loop) : max(0, (int) $_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['fareRule']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['fareRule']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['fareRule']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['fareRule']['step'] = 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['fareRule']['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['fareRule']['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']['fareRule']['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['fareRule']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['fareRule']['total'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['fareRule']['loop'];
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['fareRule']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['fareRule']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['fareRule']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['fareRule']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['fareRule']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['fareRule']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['fareRule']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['fareRule']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['fareRule']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['fareRule']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['fareRule']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['fareRule']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['fareRule']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['fareRule']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['fareRule']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['fareRule']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['fareRule']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['fareRule']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['fareRule']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['fareRule']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['fareRule']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['fareRule']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['fareRule']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['fareRule']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['fareRule']['total']);
?>

		<FareRuleKey FareInfoRef="<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['AirPricingInfo'][$_smarty_tpl->getVariable('smarty')->value['section']['airPrice']['index']]['FareInfo'][$_smarty_tpl->getVariable('smarty')->value['section']['fareRule']['index']]['FareRuleKey']['attributes']['FareInfoRef'];?>
" ProviderCode="<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['AirPricingInfo'][$_smarty_tpl->getVariable('smarty')->value['section']['airPrice']['index']]['FareInfo'][$_smarty_tpl->getVariable('smarty')->value['section']['fareRule']['index']]['FareRuleKey']['attributes']['ProviderCode'];?>
"><?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['AirPricingInfo'][$_smarty_tpl->getVariable('smarty')->value['section']['airPrice']['index']]['FareInfo'][$_smarty_tpl->getVariable('smarty')->value['section']['fareRule']['index']]['FareRuleKey']['content'];?>
</FareRuleKey>
	<?php endfor; endif; ?>	
	<?php }?>

<?php endfor; endif; ?>
<?php }?>
</AirFareRulesReq><?php }} ?>

<?php /* Smarty version Smarty-3.1.21, created on 2017-05-16 08:32:03
         compiled from "F:\xampp\htdocs\bridges\airline\travelportNew\views\UniversalRecordModifyReqXml.tpl" */ ?>
<?php /*%%SmartyHeaderCode:212455852679f839098-16895458%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '33c08ad49c58f0430bfa66f6b830f98e995f2376' => 
    array (
      0 => 'F:\\xampp\\htdocs\\bridges\\airline\\travelportNew\\views\\UniversalRecordModifyReqXml.tpl',
      1 => 1494484464,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '212455852679f839098-16895458',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.21',
  'unifunc' => 'content_5852679f913cc8_49837202',
  'variables' => 
  array (
    '_Ainput' => 0,
    '_Asettings' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5852679f913cc8_49837202')) {function content_5852679f913cc8_49837202($_smarty_tpl) {?><univ:UniversalRecordModifyReq TraceId="<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['traceId'];?>
" AuthorizedBy="<?php echo $_smarty_tpl->tpl_vars['_Asettings']->value['apiCredentials']['AuthorizedBy'];?>
" TargetBranch="<?php echo $_smarty_tpl->tpl_vars['_Asettings']->value['apiCredentials']['goBudgetAirTargetBranch'];?>
" ReturnRecord="true" Version="<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['Version'];?>
" xmlns:univ="http://www.travelport.com/schema/universal_v35_0" xmlns:common="http://www.travelport.com/schema/common_v35_0" xmlns:air="http://www.travelport.com/schema/air_v35_0">
  <common:BillingPointOfSaleInfo OriginApplication="<?php echo $_smarty_tpl->tpl_vars['_Asettings']->value['apiCredentials']['application'];?>
" />
  <univ:RecordIdentifier UniversalLocatorCode="<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['UniversalLocatorCode'];?>
" ProviderCode="<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['ProviderCode'];?>
" ProviderLocatorCode="<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['ProviderLocatorCode'];?>
" />
  <?php if (isset($_smarty_tpl->tpl_vars['_Ainput']->value['AirPricingInfoKey'])) {?>
  
  <?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['AirPriceSol'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['AirPriceSol']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['AirPriceSol']['name'] = 'AirPriceSol';
$_smarty_tpl->tpl_vars['smarty']->value['section']['AirPriceSol']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['_Ainput']->value['AirPricingInfoKey']) ? count($_loop) : max(0, (int) $_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['AirPriceSol']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['AirPriceSol']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['AirPriceSol']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['AirPriceSol']['step'] = 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['AirPriceSol']['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['AirPriceSol']['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']['AirPriceSol']['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['AirPriceSol']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['AirPriceSol']['total'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['AirPriceSol']['loop'];
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['AirPriceSol']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['AirPriceSol']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['AirPriceSol']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['AirPriceSol']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['AirPriceSol']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['AirPriceSol']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['AirPriceSol']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['AirPriceSol']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['AirPriceSol']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['AirPriceSol']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['AirPriceSol']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['AirPriceSol']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['AirPriceSol']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['AirPriceSol']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['AirPriceSol']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['AirPriceSol']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['AirPriceSol']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['AirPriceSol']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['AirPriceSol']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['AirPriceSol']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['AirPriceSol']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['AirPriceSol']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['AirPriceSol']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['AirPriceSol']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['AirPriceSol']['total']);
?>
  <univ:UniversalModifyCmd Key="<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['AirPricingInfoKey'][$_smarty_tpl->getVariable('smarty')->value['section']['AirPriceSol']['index']];?>
">
    <univ:AirDelete ReservationLocatorCode="<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['AirReservationLocatorCode'];?>
" Element="AirPricingInfo" Key="<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['AirPricingInfoKey'][$_smarty_tpl->getVariable('smarty')->value['section']['AirPriceSol']['index']];?>
" />
  </univ:UniversalModifyCmd>
  <?php endfor; endif; ?>
  <?php }?>
  <?php if (isset($_smarty_tpl->tpl_vars['_Ainput']->value['FormOfPaymentKey'])&&$_smarty_tpl->tpl_vars['_Ainput']->value['FormOfPaymentKey']!='') {?>
  <univ:UniversalModifyCmd Key="Cmd2">
	<univ:UniversalDelete Element="FormOfPayment" Key="<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['FormOfPaymentKey'];?>
">
	</univ:UniversalDelete>
  </univ:UniversalModifyCmd>
  <?php }?>
</univ:UniversalRecordModifyReq>
<?php }} ?>

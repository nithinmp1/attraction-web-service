<?php /* Smarty version Smarty-3.1.21, created on 2017-04-25 19:51:51
         compiled from "F:\xampp\htdocs\bridges\airline\travelportNew\views\getTicketStatusXml.tpl" */ ?>
<?php /*%%SmartyHeaderCode:3100258ff5a9be9d940-89144821%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'e1cac108b474c232c9339adda24fcec5d0eba376' => 
    array (
      0 => 'F:\\xampp\\htdocs\\bridges\\airline\\travelportNew\\views\\getTicketStatusXml.tpl',
      1 => 1493130104,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '3100258ff5a9be9d940-89144821',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.21',
  'unifunc' => 'content_58ff5a9c02e486_03419427',
  'variables' => 
  array (
    '_Ainput' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_58ff5a9c02e486_03419427')) {function content_58ff5a9c02e486_03419427($_smarty_tpl) {?><soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:data="http://data.webservice.ticket.air.hk3t.com">
   <soapenv:Header/>
   <soapenv:Body>
      <data:getTicketStatus>
         <GetTicketStatusRQ>
            <Lang>ENG</Lang>
            <Authenticate>
			<CompanyId><?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['CompanyId'];?>
</CompanyId>
		   <LoginId><?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['LoginId'];?>
</LoginId>
		   <Password><?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['Password'];?>
</Password>
            </Authenticate>
            <Pnr><?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['Pnr'];?>
</Pnr>
         </GetTicketStatusRQ>
      </data:getTicketStatus>
   </soapenv:Body>
</soapenv:Envelope><?php }} ?>

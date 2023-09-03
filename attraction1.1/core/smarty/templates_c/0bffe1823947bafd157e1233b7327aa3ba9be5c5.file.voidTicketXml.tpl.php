<?php /* Smarty version Smarty-3.1.21, created on 2017-04-25 10:37:48
         compiled from "F:\xampp\htdocs\bridges\airline\travelportNew\views\voidTicketXml.tpl" */ ?>
<?php /*%%SmartyHeaderCode:365958fed66a7f1293-25932802%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '0bffe1823947bafd157e1233b7327aa3ba9be5c5' => 
    array (
      0 => 'F:\\xampp\\htdocs\\bridges\\airline\\travelportNew\\views\\voidTicketXml.tpl',
      1 => 1493096844,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '365958fed66a7f1293-25932802',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.21',
  'unifunc' => 'content_58fed66a91df68_79141843',
  'variables' => 
  array (
    '_Ainput' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_58fed66a91df68_79141843')) {function content_58fed66a91df68_79141843($_smarty_tpl) {?><soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:data="http://data.webservice.ticket.air.hk3t.com">
   <soapenv:Header/>
   <soapenv:Body>
      <data:voidTicket>
         <VoidTicketRQ>
            <Lang>ENG</Lang>
            <Authenticate> 
               <CompanyId><?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['CompanyId'];?>
</CompanyId>
               <LoginId><?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['LoginId'];?>
</LoginId>
               <Password><?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['Password'];?>
</Password>
            </Authenticate>
            <Host><?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['ProviderCode'];?>
</Host>
            <TicketNumber><?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['TicketNumber'];?>
</TicketNumber>
            <AsynchronousModel>false</AsynchronousModel>
            <ReturnURL></ReturnURL>
         </VoidTicketRQ>

		 </data:voidTicket>
   </soapenv:Body>
</soapenv:Envelope><?php }} ?>

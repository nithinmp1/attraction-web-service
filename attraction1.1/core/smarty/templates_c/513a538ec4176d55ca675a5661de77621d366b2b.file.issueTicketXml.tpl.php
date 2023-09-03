<?php /* Smarty version Smarty-3.1.21, created on 2017-04-12 15:44:25
         compiled from "F:\xampp\htdocs\bridges\airline\travelportNew\views\issueTicketXml.tpl" */ ?>
<?php /*%%SmartyHeaderCode:2719458e39093eb4ce1-61998764%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '513a538ec4176d55ca675a5661de77621d366b2b' => 
    array (
      0 => 'F:\\xampp\\htdocs\\bridges\\airline\\travelportNew\\views\\issueTicketXml.tpl',
      1 => 1491991959,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2719458e39093eb4ce1-61998764',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.21',
  'unifunc' => 'content_58e3909421e306_65160511',
  'variables' => 
  array (
    '_Ainput' => 0,
    'segId' => 0,
    'paxId' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_58e3909421e306_65160511')) {function content_58e3909421e306_65160511($_smarty_tpl) {?><soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:data="http://data.webservice.ticket.air.hk3t.com">
   <soapenv:Header/>
   <soapenv:Body>
      <data:issueTicket>

	  <IssueTicketRQ >
		<Lang>ENG</Lang>
		 <Authenticate>
			<CompanyId><?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['CompanyId'];?>
</CompanyId>
		   <LoginId><?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['LoginId'];?>
</LoginId>
		   <Password><?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['Password'];?>
</Password>
		</Authenticate>
		<Criteria>
		   <TagMap/>
		   <Pnr><?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['Pnr'];?>
</Pnr>
		   <PCC><?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['Pcc'];?>
</PCC>
		   <Host><?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['ProviderCode'];?>
</Host>
		   <TicketType>UAPI</TicketType>
		   <Currency><?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['Currency'];?>
</Currency>
		  <TicketCityPairList>
		  	<?php $_smarty_tpl->tpl_vars['segId'] = new Smarty_variable(1, null, 0);?>
			<?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['segInfo'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['segInfo']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['segInfo']['name'] = 'segInfo';
$_smarty_tpl->tpl_vars['smarty']->value['section']['segInfo']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['_Ainput']->value['segmentDetails']) ? count($_loop) : max(0, (int) $_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['segInfo']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['segInfo']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['segInfo']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['segInfo']['step'] = 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['segInfo']['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['segInfo']['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']['segInfo']['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['segInfo']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['segInfo']['total'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['segInfo']['loop'];
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['segInfo']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['segInfo']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['segInfo']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['segInfo']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['segInfo']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['segInfo']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['segInfo']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['segInfo']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['segInfo']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['segInfo']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['segInfo']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['segInfo']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['segInfo']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['segInfo']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['segInfo']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['segInfo']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['segInfo']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['segInfo']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['segInfo']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['segInfo']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['segInfo']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['segInfo']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['segInfo']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['segInfo']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['segInfo']['total']);
?>
			  <TicketCityPair>
				 <Id><?php echo $_smarty_tpl->tpl_vars['segId']->value;?>
</Id>
				 <StartPoint><?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['segmentDetails'][$_smarty_tpl->getVariable('smarty')->value['section']['segInfo']['index']]['origin'];?>
</StartPoint>
				 <EndPoint><?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['segmentDetails'][$_smarty_tpl->getVariable('smarty')->value['section']['segInfo']['index']]['destination'];?>
</EndPoint>
				 <StartDate date="<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['segmentDetails'][$_smarty_tpl->getVariable('smarty')->value['section']['segInfo']['index']]['departure_date'];?>
" time="<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['segmentDetails'][$_smarty_tpl->getVariable('smarty')->value['section']['segInfo']['index']]['departure_time'];?>
"/>
				 <EndDate date="<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['segmentDetails'][$_smarty_tpl->getVariable('smarty')->value['section']['segInfo']['index']]['arrival_date'];?>
" time="<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['segmentDetails'][$_smarty_tpl->getVariable('smarty')->value['section']['segInfo']['index']]['arrival_time'];?>
"/>
				 <AirlineCode><?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['segmentDetails'][$_smarty_tpl->getVariable('smarty')->value['section']['segInfo']['index']]['airline_code'];?>
</AirlineCode>
				 <ClassCode><?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['segmentDetails'][$_smarty_tpl->getVariable('smarty')->value['section']['segInfo']['index']]['class_code'];?>
</ClassCode>
			  </TicketCityPair>
			  	<?php $_smarty_tpl->tpl_vars['segId'] = new Smarty_variable($_smarty_tpl->tpl_vars['segId']->value+1, null, 0);?>
			<?php endfor; endif; ?>  
		   </TicketCityPairList>
		   <TicketPaxTypeList>
		   	<?php $_smarty_tpl->tpl_vars['paxId'] = new Smarty_variable(1, null, 0);?>
		   <?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['paxInfo'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['paxInfo']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['paxInfo']['name'] = 'paxInfo';
$_smarty_tpl->tpl_vars['smarty']->value['section']['paxInfo']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['_Ainput']->value['paxDetails']) ? count($_loop) : max(0, (int) $_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['paxInfo']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['paxInfo']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['paxInfo']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['paxInfo']['step'] = 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['paxInfo']['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['paxInfo']['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']['paxInfo']['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['paxInfo']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['paxInfo']['total'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['paxInfo']['loop'];
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['paxInfo']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['paxInfo']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['paxInfo']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['paxInfo']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['paxInfo']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['paxInfo']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['paxInfo']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['paxInfo']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['paxInfo']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['paxInfo']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['paxInfo']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['paxInfo']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['paxInfo']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['paxInfo']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['paxInfo']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['paxInfo']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['paxInfo']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['paxInfo']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['paxInfo']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['paxInfo']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['paxInfo']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['paxInfo']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['paxInfo']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['paxInfo']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['paxInfo']['total']);
?>
		   <TicketPaxType>
				 <PassengerId></PassengerId>
				 <FareBasis><?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['paxDetails'][$_smarty_tpl->getVariable('smarty')->value['section']['paxInfo']['index']]['fare_basis'];?>
</FareBasis>
				 <Type><?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['paxDetails'][$_smarty_tpl->getVariable('smarty')->value['section']['paxInfo']['index']]['pax_type'];?>
</Type>
				 <PriceRecordKey><?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['paxDetails'][$_smarty_tpl->getVariable('smarty')->value['section']['paxInfo']['index']]['price_record_key'];?>
</PriceRecordKey>
				 <FarePerPax><?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['paxDetails'][$_smarty_tpl->getVariable('smarty')->value['section']['paxInfo']['index']]['fare_per_pax'];?>
</FarePerPax>
			  </TicketPaxType>
			  	<?php $_smarty_tpl->tpl_vars['paxId'] = new Smarty_variable($_smarty_tpl->tpl_vars['paxId']->value+1, null, 0);?>
			<?php endfor; endif; ?>
		   </TicketPaxTypeList>
		   <Fop>
			  <Category>INVAGT</Category>
			  <FreeFormat></FreeFormat>
		   </Fop>
		</Criteria>
		<AsynchronousModel>false</AsynchronousModel>
		<ReturnURL></ReturnURL>
	 </IssueTicketRQ>
 
 </data:issueTicket>
   </soapenv:Body>
</soapenv:Envelope><?php }} ?>

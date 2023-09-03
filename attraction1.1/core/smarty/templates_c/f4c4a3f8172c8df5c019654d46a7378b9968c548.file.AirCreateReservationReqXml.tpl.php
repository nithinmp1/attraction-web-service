<?php /* Smarty version Smarty-3.1.21, created on 2017-07-04 11:15:38
         compiled from "F:\xampp\htdocs\bridges\airline\travelport1.1\views\AirCreateReservationReqXml.tpl" */ ?>
<?php /*%%SmartyHeaderCode:323625955f5743e4eb7-07948080%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'f4c4a3f8172c8df5c019654d46a7378b9968c548' => 
    array (
      0 => 'F:\\xampp\\htdocs\\bridges\\airline\\travelport1.1\\views\\AirCreateReservationReqXml.tpl',
      1 => 1499147058,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '323625955f5743e4eb7-07948080',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.21',
  'unifunc' => 'content_5955f5749ff6b5_68798953',
  'variables' => 
  array (
    '_Ainput' => 0,
    '_Asettings' => 0,
    'dob' => 0,
    '_Oconf' => 0,
    'tmpAdtCnt' => 0,
    'tmpChdCnt' => 0,
    'tmpInfCnt' => 0,
    'paxAge' => 0,
    'paxDob' => 0,
    'gender' => 0,
    'expDate' => 0,
    'dobDate' => 0,
    'dobDateformat' => 0,
    'expDateformat' => 0,
    'val' => 0,
    'tmpairPricingInfoGroup' => 0,
    'TaxInfoArr' => 0,
    'PassengerTypeArr' => 0,
    'paxLoopIdx' => 0,
    'FeeInfoArr' => 0,
    'itemVal' => 0,
    'keyVal' => 0,
    'PaxType' => 0,
    'tmpSsrDes' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5955f5749ff6b5_68798953')) {function content_5955f5749ff6b5_68798953($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_date_format')) include 'F:\\xampp\\htdocs\\bridges\\airline\\travelport1.1\\core\\smarty\\libs\\plugins\\modifier.date_format.php';
?><AirCreateReservationReq xmlns="http://www.travelport.com/schema/universal_v35_0" TraceId="<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['traceId'];?>
" AuthorizedBy="<?php echo $_smarty_tpl->tpl_vars['_Asettings']->value['apiCredentials']['AuthorizedBy'];?>
" TargetBranch="<?php echo $_smarty_tpl->tpl_vars['_Asettings']->value['apiCredentials']['goBudgetAirTargetBranch'];?>
" ProviderCode="<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['providerCode']['ProviderCode'];?>
" RetainReservation="None">
	<BillingPointOfSaleInfo xmlns="http://www.travelport.com/schema/common_v35_0" OriginApplication="<?php echo $_smarty_tpl->tpl_vars['_Asettings']->value['apiCredentials']['application'];?>
" ></BillingPointOfSaleInfo>
	
	<?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['pax'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['pax']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['pax']['name'] = 'pax';
$_smarty_tpl->tpl_vars['smarty']->value['section']['pax']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['_Ainput']->value['paxDetails']) ? count($_loop) : max(0, (int) $_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['pax']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['pax']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['pax']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['pax']['step'] = 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['pax']['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['pax']['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']['pax']['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['pax']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['pax']['total'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['pax']['loop'];
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['pax']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['pax']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['pax']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['pax']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['pax']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['pax']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['pax']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['pax']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['pax']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['pax']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['pax']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['pax']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['pax']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['pax']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['pax']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['pax']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['pax']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['pax']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['pax']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['pax']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['pax']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['pax']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['pax']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['pax']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['pax']['total']);
?>
	<?php $_smarty_tpl->tpl_vars['val'] = new Smarty_variable(0, null, 0);?>
	
	<?php $_smarty_tpl->tpl_vars['tmpAdtCnt'] = new Smarty_variable(0, null, 0);?>
	<?php $_smarty_tpl->tpl_vars['tmpChdCnt'] = new Smarty_variable(0, null, 0);?>
	<?php $_smarty_tpl->tpl_vars['tmpInfCnt'] = new Smarty_variable(0, null, 0);?>
	
	<?php if ($_smarty_tpl->tpl_vars['_Ainput']->value['paxDetails'][$_smarty_tpl->getVariable('smarty')->value['section']['pax']['index']]['paxType']=='ADT') {?>
	
		<?php $_smarty_tpl->tpl_vars["paxAge"] = new Smarty_variable($_smarty_tpl->tpl_vars['_Ainput']->value['paxDetails'][$_smarty_tpl->getVariable('smarty')->value['section']['pax']['index']]['age'], null, 0);?>
		
		<?php if (isset($_smarty_tpl->tpl_vars['_Ainput']->value['paxDetails'][$_smarty_tpl->getVariable('smarty',null,true,false)->value['section']['pax']['index']]['dob'])) {?>
			<?php $_smarty_tpl->tpl_vars['dob'] = new Smarty_variable(explode("T",$_smarty_tpl->tpl_vars['_Ainput']->value['paxDetails'][$_smarty_tpl->getVariable('smarty')->value['section']['pax']['index']]['dob']), null, 0);?>
			<?php $_smarty_tpl->tpl_vars["paxDob"] = new Smarty_variable($_smarty_tpl->tpl_vars['dob']->value[0], null, 0);?>
		<?php } else { ?>
			<?php $_smarty_tpl->tpl_vars["paxDob"] = new Smarty_variable($_smarty_tpl->tpl_vars['_Oconf']->value['site']['paxDob']['ADT'], null, 0);?>
		<?php }?>
		
		<?php $_smarty_tpl->tpl_vars['tmpAdtCnt'] = new Smarty_variable($_smarty_tpl->tpl_vars['tmpAdtCnt']->value+1, null, 0);?>
	<?php }?>
	<?php if ($_smarty_tpl->tpl_vars['_Ainput']->value['paxDetails'][$_smarty_tpl->getVariable('smarty')->value['section']['pax']['index']]['paxType']=='CHD') {?>
		<?php $_smarty_tpl->tpl_vars["paxAge"] = new Smarty_variable($_smarty_tpl->tpl_vars['_Ainput']->value['paxDetails'][$_smarty_tpl->getVariable('smarty')->value['section']['pax']['index']]['age'], null, 0);?>
		
		<?php if (isset($_smarty_tpl->tpl_vars['_Ainput']->value['paxDetails'][$_smarty_tpl->getVariable('smarty',null,true,false)->value['section']['pax']['index']]['dob'])) {?>
			<?php $_smarty_tpl->tpl_vars['dob'] = new Smarty_variable(explode("T",$_smarty_tpl->tpl_vars['_Ainput']->value['paxDetails'][$_smarty_tpl->getVariable('smarty')->value['section']['pax']['index']]['dob']), null, 0);?>
			<?php $_smarty_tpl->tpl_vars["paxDob"] = new Smarty_variable($_smarty_tpl->tpl_vars['dob']->value[0], null, 0);?>
		<?php } else { ?>
			<?php $_smarty_tpl->tpl_vars["paxDob"] = new Smarty_variable($_smarty_tpl->tpl_vars['_Oconf']->value['site']['paxDob']['CHD'], null, 0);?>
		<?php }?>

		<?php $_smarty_tpl->tpl_vars['tmpChdCnt'] = new Smarty_variable($_smarty_tpl->tpl_vars['tmpChdCnt']->value+1, null, 0);?>
		
	<?php }?>
	<?php if ($_smarty_tpl->tpl_vars['_Ainput']->value['paxDetails'][$_smarty_tpl->getVariable('smarty')->value['section']['pax']['index']]['paxType']=='INF'||$_smarty_tpl->tpl_vars['_Ainput']->value['paxDetails'][$_smarty_tpl->getVariable('smarty')->value['section']['pax']['index']]['paxType']=='CNN') {?>
		<?php $_smarty_tpl->tpl_vars["paxAge"] = new Smarty_variable($_smarty_tpl->tpl_vars['_Ainput']->value['paxDetails'][$_smarty_tpl->getVariable('smarty')->value['section']['pax']['index']]['age'], null, 0);?>
		
		<?php if (isset($_smarty_tpl->tpl_vars['_Ainput']->value['paxDetails'][$_smarty_tpl->getVariable('smarty',null,true,false)->value['section']['pax']['index']]['dob'])) {?>
			<?php $_smarty_tpl->tpl_vars['dob'] = new Smarty_variable(explode("T",$_smarty_tpl->tpl_vars['_Ainput']->value['paxDetails'][$_smarty_tpl->getVariable('smarty')->value['section']['pax']['index']]['dob']), null, 0);?>
			<?php $_smarty_tpl->tpl_vars["paxDob"] = new Smarty_variable($_smarty_tpl->tpl_vars['dob']->value[0], null, 0);?>
		<?php } else { ?>
			<?php $_smarty_tpl->tpl_vars["paxDob"] = new Smarty_variable($_smarty_tpl->tpl_vars['_Oconf']->value['site']['paxDob']['INF'], null, 0);?>
		<?php }?>
		
		<?php $_smarty_tpl->tpl_vars['tmpInfCnt'] = new Smarty_variable($_smarty_tpl->tpl_vars['tmpInfCnt']->value+1, null, 0);?>
	<?php }?>
	
	
	<?php if ($_smarty_tpl->tpl_vars['_Ainput']->value['paxDetails'][$_smarty_tpl->getVariable('smarty')->value['section']['pax']['index']]['passportDetails']['gender']=='Male') {?>
		<?php $_smarty_tpl->tpl_vars["gender"] = new Smarty_variable("M", null, 0);?>
	<?php }?>
	<?php if ($_smarty_tpl->tpl_vars['_Ainput']->value['paxDetails'][$_smarty_tpl->getVariable('smarty')->value['section']['pax']['index']]['passportDetails']['gender']=='Female') {?>
		<?php $_smarty_tpl->tpl_vars["gender"] = new Smarty_variable("F", null, 0);?>
	<?php }?>
	<?php $_smarty_tpl->tpl_vars["CarrierValue"] = new Smarty_variable('', null, 0);?>
	
	<BookingTraveler xmlns="http://www.travelport.com/schema/common_v35_0" <?php if ($_smarty_tpl->tpl_vars['_Ainput']->value['PassengerType'][((string)$_smarty_tpl->tpl_vars['_Ainput']->value['paxDetails'][$_smarty_tpl->getVariable('smarty')->value['section']['pax']['index']]['paxTypeKeyIdx'])]!='') {?> Key='<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['PassengerType'][((string)$_smarty_tpl->tpl_vars['_Ainput']->value['paxDetails'][$_smarty_tpl->getVariable('smarty')->value['section']['pax']['index']]['paxTypeKeyIdx'])];?>
' <?php } else { ?> Key="<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['paxDetails'][$_smarty_tpl->getVariable('smarty')->value['section']['pax']['index']]['paxTypeKey'];?>
" <?php }?> TravelerType="<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['paxDetails'][$_smarty_tpl->getVariable('smarty')->value['section']['pax']['index']]['paxType'];?>
" <?php if ($_smarty_tpl->tpl_vars['_Ainput']->value['paxDetails'][$_smarty_tpl->getVariable('smarty')->value['section']['pax']['index']]['paxType']!='ADT') {?> Age="<?php echo $_smarty_tpl->tpl_vars['paxAge']->value;?>
" DOB="<?php echo $_smarty_tpl->tpl_vars['paxDob']->value;?>
" <?php }?> Gender="<?php echo $_smarty_tpl->tpl_vars['gender']->value;?>
" Nationality="<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['paxDetails'][$_smarty_tpl->getVariable('smarty')->value['section']['pax']['index']]['passportDetails']['NationalityISO'];?>
">
		<BookingTravelerName Prefix="<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['paxDetails'][$_smarty_tpl->getVariable('smarty')->value['section']['pax']['index']]['passportDetails']['title'];?>
" First="<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['paxDetails'][$_smarty_tpl->getVariable('smarty')->value['section']['pax']['index']]['passportDetails']['firstName'];?>
" Last="<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['paxDetails'][$_smarty_tpl->getVariable('smarty')->value['section']['pax']['index']]['passportDetails']['lastName'];?>
" ></BookingTravelerName>
		
		<PhoneNumber Type="<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['phoneNumberType'];?>
" Number="<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['deliveryInfoPhone'];?>
" AreaCode="<?php echo $_smarty_tpl->tpl_vars['_Asettings']->value['apiCredentials']['AreaCode'];?>
"  Location="<?php echo $_smarty_tpl->tpl_vars['_Asettings']->value['apiCredentials']['LocationCode'];?>
" ></PhoneNumber>
		
		<Email EmailID="<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['deliveryInfoMail'];?>
" Type="<?php echo $_smarty_tpl->tpl_vars['_Asettings']->value['apiCredentials']['AgencyType'];?>
" ></Email>
		<?php if (isset($_smarty_tpl->tpl_vars['_Ainput']->value['paxDetails'][$_smarty_tpl->getVariable('smarty',null,true,false)->value['section']['pax']['index']]['passportDetails'])) {?>
			<?php $_smarty_tpl->tpl_vars['expDate'] = new Smarty_variable(explode("T",$_smarty_tpl->tpl_vars['_Ainput']->value['paxDetails'][$_smarty_tpl->getVariable('smarty')->value['section']['pax']['index']]['passportDetails']['expiryDate']), null, 0);?>
			<?php $_smarty_tpl->tpl_vars['expDateformat'] = new Smarty_variable(smarty_modifier_date_format($_smarty_tpl->tpl_vars['expDate']->value[0],"%d%b%y"), null, 0);?>


			<?php $_smarty_tpl->tpl_vars['dobDate'] = new Smarty_variable(explode("T",$_smarty_tpl->tpl_vars['_Ainput']->value['paxDetails'][$_smarty_tpl->getVariable('smarty')->value['section']['pax']['index']]['passportDetails']['dob']), null, 0);?>
			<?php $_smarty_tpl->tpl_vars['dobDateformat'] = new Smarty_variable(smarty_modifier_date_format($_smarty_tpl->tpl_vars['dobDate']->value[0],"%d%b%y"), null, 0);?>
			
			<?php if (isset($_smarty_tpl->tpl_vars['_Ainput']->value['carrierCode'])) {?>
			<?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['CarrierCode'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['CarrierCode']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['CarrierCode']['name'] = 'CarrierCode';
$_smarty_tpl->tpl_vars['smarty']->value['section']['CarrierCode']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['_Ainput']->value['carrierCode']) ? count($_loop) : max(0, (int) $_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['CarrierCode']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['CarrierCode']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['CarrierCode']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['CarrierCode']['step'] = 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['CarrierCode']['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['CarrierCode']['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']['CarrierCode']['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['CarrierCode']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['CarrierCode']['total'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['CarrierCode']['loop'];
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['CarrierCode']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['CarrierCode']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['CarrierCode']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['CarrierCode']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['CarrierCode']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['CarrierCode']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['CarrierCode']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['CarrierCode']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['CarrierCode']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['CarrierCode']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['CarrierCode']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['CarrierCode']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['CarrierCode']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['CarrierCode']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['CarrierCode']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['CarrierCode']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['CarrierCode']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['CarrierCode']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['CarrierCode']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['CarrierCode']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['CarrierCode']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['CarrierCode']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['CarrierCode']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['CarrierCode']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['CarrierCode']['total']);
?>
			<SSR Type="DOCS" FreeText="P/<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['paxDetails'][$_smarty_tpl->getVariable('smarty')->value['section']['pax']['index']]['passportDetails']['issuedCountry'];?>
/<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['paxDetails'][$_smarty_tpl->getVariable('smarty')->value['section']['pax']['index']]['passportDetails']['passportNumber'];?>
/<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['paxDetails'][$_smarty_tpl->getVariable('smarty')->value['section']['pax']['index']]['passportDetails']['NationalityISO'];?>
/<?php echo $_smarty_tpl->tpl_vars['dobDateformat']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['gender']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['expDateformat']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['paxDetails'][$_smarty_tpl->getVariable('smarty')->value['section']['pax']['index']]['passportDetails']['lastName'];?>
/<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['paxDetails'][$_smarty_tpl->getVariable('smarty')->value['section']['pax']['index']]['passportDetails']['firstName'];?>
" Carrier="<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['carrierCode'][$_smarty_tpl->getVariable('smarty')->value['section']['CarrierCode']['index']];?>
" ></SSR>
			<?php if ($_smarty_tpl->tpl_vars['_Ainput']->value['providerCode']['ProviderCode']=='1G') {?>
			<SSR Type="CTCE" Status="HK" FreeText="<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['deliveryInfoMail'];?>
" Carrier="<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['carrierCode'][$_smarty_tpl->getVariable('smarty')->value['section']['CarrierCode']['index']];?>
"/>
            <SSR Type="CTCM" Status="HK" FreeText="<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['deliveryInfoPhone'];?>
" Carrier="<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['carrierCode'][$_smarty_tpl->getVariable('smarty')->value['section']['CarrierCode']['index']];?>
"/>
            <?php }?>                                                         
			<?php endfor; endif; ?>
			
			<?php }?>
			
		<?php }?>
		<Address>
			<AddressName><?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['deliveryInfoAddr1'];?>
</AddressName>
			<Street><?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['deliveryInfoStreet'];?>
</Street>
			<City><?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['deliveryInfoCity'];?>
</City>
			<State><?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['deliveryInfoState'];?>
</State>
			<PostalCode><?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['deliveryInfoPostalCode'];?>
</PostalCode>
			<Country><?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['deliveryInfoCountryCode'];?>
</Country>
		</Address>
	</BookingTraveler>
		
	<?php $_smarty_tpl->tpl_vars['val'] = new Smarty_variable($_smarty_tpl->tpl_vars['val']->value+1, null, 0);?>
	<?php endfor; endif; ?>
	<?php if ($_smarty_tpl->tpl_vars['_Ainput']->value['providerCode']['ProviderCode']=='1G_') {?>
	<QueuePlace>
		<PseudoCityCode>XXX</PseudoCityCode>
		<QueueSelector Queue="41"/>
	</QueuePlace>
	<?php }?>

	<AgencyContactInfo xmlns="http://www.travelport.com/schema/common_v35_0">
		<PhoneNumber Type="<?php echo $_smarty_tpl->tpl_vars['_Asettings']->value['apiCredentials']['AgencyType'];?>
" Location="<?php echo $_smarty_tpl->tpl_vars['_Asettings']->value['apiCredentials']['AgencyLocation'];?>
" Number="<?php echo $_smarty_tpl->tpl_vars['_Asettings']->value['apiCredentials']['AgencyNumber'];?>
" Text="<?php echo $_smarty_tpl->tpl_vars['_Asettings']->value['apiCredentials']['AgencyText'];?>
" />
	</AgencyContactInfo>
	
	<?php if ($_smarty_tpl->tpl_vars['_Ainput']->value['providerCode']['ProviderCode']=='1G') {?>
	<FormOfPayment Type="MiscFormOfPayment" xmlns="http://www.travelport.com/schema/common_v35_0">
		<MiscFormOfPayment Category="Invoice" Text="AGT" ></MiscFormOfPayment>
	</FormOfPayment>
	<?php } elseif (isset($_smarty_tpl->tpl_vars['_Ainput']->value['formOfPayment'])&&$_smarty_tpl->tpl_vars['_Ainput']->value['formOfPayment']!='') {?>
	<FormOfPayment xmlns="http://www.travelport.com/schema/common_v35_0" Type="Credit" Key="1">
		<CreditCard Type="<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['formOfPayment']['CreditCardType'];?>
" Number="<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['formOfPayment']['CreditCardNumber'];?>
" ExpDate="<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['formOfPayment']['CreditCardExpDate'];?>
" Name="<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['formOfPayment']['CreditCardName'];?>
" CVV="<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['formOfPayment']['CreditCardName'];?>
" Key="<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['formOfPayment']['CreditCardName'];?>
">
			<BillingAddress Key="<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['formOfPayment']['CreditCardName'];?>
">
				<AddressName><?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['formOfPayment']['BillingAddressName'];?>
</AddressName>
				<Street><?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['formOfPayment']['BillingAddressStreet'];?>
</Street>
				<City><?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['formOfPayment']['BillingCity'];?>
</City>
				<State><?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['formOfPayment']['BillingState'];?>
</State>
				<PostalCode><?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['formOfPayment']['BillingPostalCode'];?>
</PostalCode>
				<Country><?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['formOfPayment']['BillingCountry'];?>
</Country>
			</BillingAddress>
		</CreditCard>
	</FormOfPayment>
	<?php } else { ?>
		<?php if (isset($_smarty_tpl->tpl_vars['_Ainput']->value['supplierAgencyPayment'])&&!empty($_smarty_tpl->tpl_vars['_Ainput']->value['supplierAgencyPayment'])) {?>
			<FormOfPayment xmlns="http://www.travelport.com/schema/common_v35_0" Type="AgencyPayment">
				<AgencyPayment AgencyBillingIdentifier="<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['supplierAgencyPayment']['agencyId'];?>
" <?php if (isset($_smarty_tpl->tpl_vars['_Ainput']->value['supplierAgencyPayment']['agencyPwd'])) {?> AgencyBillingPassword="<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['supplierAgencyPayment']['agencyPwd'];?>
" <?php }?> />
			</FormOfPayment>
		<?php } else { ?>
			<FormOfPayment xmlns="http://www.travelport.com/schema/common_v35_0" Type="Credit" Key="1">
				<CreditCard Type="VI" Number="4895390000000013" ExpDate="2018-01" Name="John Smith" CVV="595" Key="1">
					<BillingAddress Key="02f2dbfc-1704-425e-8d29-ce588b5bad45">
						<AddressName>DemoSiteAddress</AddressName>
						<Street>Via Augusta 59 5</Street>
						<City>Madrid</City>
						<State>IA</State>
						<PostalCode>50156</PostalCode>
						<Country>US</Country>
					</BillingAddress>
				</CreditCard>
			</FormOfPayment>
		<?php }?>
	<?php }?>
	
	<?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['AirPriceSol'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['AirPriceSol']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['AirPriceSol']['name'] = 'AirPriceSol';
$_smarty_tpl->tpl_vars['smarty']->value['section']['AirPriceSol']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['_Ainput']->value['AirPricingSolution']) ? count($_loop) : max(0, (int) $_loop); unset($_loop);
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
	<?php if ('AirPriceSol'==0) {?>
	
	<AirPricingSolution xmlns="http://www.travelport.com/schema/air_v35_0"  Key="<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['AirPricingSolution'][$_smarty_tpl->getVariable('smarty')->value['section']['AirPriceSol']['index']]['attributes']['Key'];?>
"  TotalPrice="<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['AirPricingSolution'][$_smarty_tpl->getVariable('smarty')->value['section']['AirPriceSol']['index']]['attributes']['TotalPrice'];?>
"  BasePrice="<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['AirPricingSolution'][$_smarty_tpl->getVariable('smarty')->value['section']['AirPriceSol']['index']]['attributes']['BasePrice'];?>
"  ApproximateTotalPrice="<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['AirPricingSolution'][$_smarty_tpl->getVariable('smarty')->value['section']['AirPriceSol']['index']]['attributes']['ApproximateTotalPrice'];?>
"  ApproximateBasePrice="<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['AirPricingSolution'][$_smarty_tpl->getVariable('smarty')->value['section']['AirPriceSol']['index']]['attributes']['ApproximateBasePrice'];?>
"  Taxes="<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['AirPricingSolution'][$_smarty_tpl->getVariable('smarty')->value['section']['AirPriceSol']['index']]['attributes']['Taxes'];?>
"  Fees="<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['AirPricingSolution'][$_smarty_tpl->getVariable('smarty')->value['section']['AirPriceSol']['index']]['attributes']['Fees'];?>
"  Services="<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['AirPricingSolution'][$_smarty_tpl->getVariable('smarty')->value['section']['AirPriceSol']['index']]['attributes']['Services'];?>
"  ApproximateTaxes="<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['AirPricingSolution'][$_smarty_tpl->getVariable('smarty')->value['section']['AirPriceSol']['index']]['attributes']['ApproximateTaxes'];?>
"  ApproximateFees="<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['AirPricingSolution'][$_smarty_tpl->getVariable('smarty')->value['section']['AirPriceSol']['index']]['attributes']['ApproximateFees'];?>
">
	<?php if (isset($_smarty_tpl->tpl_vars['_Ainput']->value['AirSegment'])) {?>
		<?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['AirSeg'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['AirSeg']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['AirSeg']['name'] = 'AirSeg';
$_smarty_tpl->tpl_vars['smarty']->value['section']['AirSeg']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['_Ainput']->value['AirSegment']) ? count($_loop) : max(0, (int) $_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['AirSeg']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['AirSeg']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['AirSeg']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['AirSeg']['step'] = 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['AirSeg']['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['AirSeg']['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']['AirSeg']['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['AirSeg']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['AirSeg']['total'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['AirSeg']['loop'];
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['AirSeg']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['AirSeg']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['AirSeg']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['AirSeg']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['AirSeg']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['AirSeg']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['AirSeg']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['AirSeg']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['AirSeg']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['AirSeg']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['AirSeg']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['AirSeg']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['AirSeg']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['AirSeg']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['AirSeg']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['AirSeg']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['AirSeg']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['AirSeg']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['AirSeg']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['AirSeg']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['AirSeg']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['AirSeg']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['AirSeg']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['AirSeg']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['AirSeg']['total']);
?>
	
		<AirSegment  Key="<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['AirSegment'][$_smarty_tpl->getVariable('smarty')->value['section']['AirSeg']['index']]['attributes']['Key'];?>
" Group="<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['AirSegment'][$_smarty_tpl->getVariable('smarty')->value['section']['AirSeg']['index']]['attributes']['Group'];?>
" Carrier="<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['AirSegment'][$_smarty_tpl->getVariable('smarty')->value['section']['AirSeg']['index']]['attributes']['Carrier'];?>
" FlightNumber="<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['AirSegment'][$_smarty_tpl->getVariable('smarty')->value['section']['AirSeg']['index']]['attributes']['FlightNumber'];?>
" ProviderCode="<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['AirSegment'][$_smarty_tpl->getVariable('smarty')->value['section']['AirSeg']['index']]['attributes']['ProviderCode'];?>
" Origin="<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['AirSegment'][$_smarty_tpl->getVariable('smarty')->value['section']['AirSeg']['index']]['attributes']['Origin'];?>
" Destination="<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['AirSegment'][$_smarty_tpl->getVariable('smarty')->value['section']['AirSeg']['index']]['attributes']['Destination'];?>
" DepartureTime="<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['AirSegment'][$_smarty_tpl->getVariable('smarty')->value['section']['AirSeg']['index']]['attributes']['DepartureTime'];?>
" ArrivalTime="<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['AirSegment'][$_smarty_tpl->getVariable('smarty')->value['section']['AirSeg']['index']]['attributes']['ArrivalTime'];?>
" FlightTime="<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['AirSegment'][$_smarty_tpl->getVariable('smarty')->value['section']['AirSeg']['index']]['attributes']['FlightTime'];?>
" TravelTime="<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['AirSegment'][$_smarty_tpl->getVariable('smarty')->value['section']['AirSeg']['index']]['attributes']['TravelTime'];?>
" ClassOfService="<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['AirSegment'][$_smarty_tpl->getVariable('smarty')->value['section']['AirSeg']['index']]['attributes']['ClassOfService'];?>
" <?php if (isset($_smarty_tpl->tpl_vars['_Ainput']->value['AirSegment'][$_smarty_tpl->getVariable('smarty',null,true,false)->value['section']['AirSeg']['index']]['attributes']['Equipment'])&&$_smarty_tpl->tpl_vars['_Ainput']->value['AirSegment'][$_smarty_tpl->getVariable('smarty')->value['section']['AirSeg']['index']]['attributes']['Equipment']!='') {?> Equipment="<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['AirSegment'][$_smarty_tpl->getVariable('smarty')->value['section']['AirSeg']['index']]['attributes']['Equipment'];?>
" <?php }?> Status="<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['AirSegment'][$_smarty_tpl->getVariable('smarty')->value['section']['AirSeg']['index']]['attributes']['Status'];?>
" ChangeOfPlane="<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['AirSegment'][$_smarty_tpl->getVariable('smarty')->value['section']['AirSeg']['index']]['attributes']['ChangeOfPlane'];?>
" <?php if (isset($_smarty_tpl->tpl_vars['_Ainput']->value['AirSegment'][$_smarty_tpl->getVariable('smarty',null,true,false)->value['section']['AirSeg']['index']]['attributes']['HostTokenRef'])) {?> HostTokenRef="<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['AirSegment'][$_smarty_tpl->getVariable('smarty')->value['section']['AirSeg']['index']]['attributes']['HostTokenRef'];?>
" <?php }?> <?php if (isset($_smarty_tpl->tpl_vars['_Ainput']->value['AirSegment'][$_smarty_tpl->getVariable('smarty',null,true,false)->value['section']['AirSeg']['index']]['attributes']['SupplierCode'])) {?> SupplierCode="<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['AirSegment'][$_smarty_tpl->getVariable('smarty')->value['section']['AirSeg']['index']]['attributes']['SupplierCode'];?>
" <?php }?> OptionalServicesIndicator="<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['AirSegment'][$_smarty_tpl->getVariable('smarty')->value['section']['AirSeg']['index']]['attributes']['OptionalServicesIndicator'];?>
" APISRequirementsRef="<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['AirSegment'][$_smarty_tpl->getVariable('smarty')->value['section']['AirSeg']['index']]['attributes']['APISRequirementsRef'];?>
">
			<?php if (isset($_smarty_tpl->tpl_vars['_Ainput']->value['AirSegment'][$_smarty_tpl->getVariable('smarty',null,true,false)->value['section']['AirSeg']['index']]['CodeshareInfo'])) {?>
			<CodeshareInfo OperatingCarrier="<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['AirSegment'][$_smarty_tpl->getVariable('smarty')->value['section']['AirSeg']['index']]['CodeshareInfo']['attributes']['OPERATINGCARRIER'];?>
" OperatingFlightNumber="<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['AirSegment'][$_smarty_tpl->getVariable('smarty')->value['section']['AirSeg']['index']]['CodeshareInfo']['attributes']['OPERATINGFLIGHTNUMBER'];?>
" ></CodeshareInfo>
			<?php }?>
			<?php if (isset($_smarty_tpl->tpl_vars['_Ainput']->value['AirSegment'][$_smarty_tpl->getVariable('smarty',null,true,false)->value['section']['AirSeg']['index']]['FlightDetails'])) {?>
			<FlightDetails Key="<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['AirSegment'][$_smarty_tpl->getVariable('smarty')->value['section']['AirSeg']['index']]['FlightDetails']['attributes']['Key'];?>
" FlightTime="<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['AirSegment'][$_smarty_tpl->getVariable('smarty')->value['section']['AirSeg']['index']]['FlightDetails']['attributes']['FlightTime'];?>
" TravelTime="<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['AirSegment'][$_smarty_tpl->getVariable('smarty')->value['section']['AirSeg']['index']]['FlightDetails']['attributes']['TravelTime'];?>
" Origin="<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['AirSegment'][$_smarty_tpl->getVariable('smarty')->value['section']['AirSeg']['index']]['FlightDetails']['attributes']['Origin'];?>
" Destination="<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['AirSegment'][$_smarty_tpl->getVariable('smarty')->value['section']['AirSeg']['index']]['FlightDetails']['attributes']['Destination'];?>
" 
DepartureTime="<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['AirSegment'][$_smarty_tpl->getVariable('smarty')->value['section']['AirSeg']['index']]['FlightDetails']['attributes']['DepartureTime'];?>
"/>
			<?php }?>
		  <?php if (isset($_smarty_tpl->tpl_vars['_Ainput']->value['AirSegment'][$_smarty_tpl->getVariable('smarty',null,true,false)->value['section']['AirSeg']['index']]['tmpSegmentIdx'])) {?>
         <Connection SegmentIndex="<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['AirSegment'][$_smarty_tpl->getVariable('smarty')->value['section']['AirSeg']['index']]['tmpSegmentIdx'];?>
" />
         <?php }?>	
		</AirSegment>
		<?php endfor; endif; ?>
	<?php }?>
		
		<?php $_smarty_tpl->tpl_vars['tmpairPricingInfoGroup'] = new Smarty_variable(1, null, 0);?>
		<?php if (isset($_smarty_tpl->tpl_vars['_Ainput']->value['AirPricingSolution'][$_smarty_tpl->getVariable('smarty',null,true,false)->value['section']['AirPriceSol']['index']]['AirPricingInfo'])) {?>
		<?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['AirPriceInfo'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['AirPriceInfo']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['AirPriceInfo']['name'] = 'AirPriceInfo';
$_smarty_tpl->tpl_vars['smarty']->value['section']['AirPriceInfo']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['_Ainput']->value['AirPricingSolution'][$_smarty_tpl->getVariable('smarty')->value['section']['AirPriceSol']['index']]['AirPricingInfo']) ? count($_loop) : max(0, (int) $_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['AirPriceInfo']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['AirPriceInfo']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['AirPriceInfo']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['AirPriceInfo']['step'] = 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['AirPriceInfo']['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['AirPriceInfo']['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']['AirPriceInfo']['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['AirPriceInfo']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['AirPriceInfo']['total'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['AirPriceInfo']['loop'];
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['AirPriceInfo']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['AirPriceInfo']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['AirPriceInfo']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['AirPriceInfo']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['AirPriceInfo']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['AirPriceInfo']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['AirPriceInfo']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['AirPriceInfo']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['AirPriceInfo']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['AirPriceInfo']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['AirPriceInfo']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['AirPriceInfo']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['AirPriceInfo']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['AirPriceInfo']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['AirPriceInfo']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['AirPriceInfo']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['AirPriceInfo']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['AirPriceInfo']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['AirPriceInfo']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['AirPriceInfo']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['AirPriceInfo']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['AirPriceInfo']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['AirPriceInfo']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['AirPriceInfo']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['AirPriceInfo']['total']);
?>
		
		<AirPricingInfo Key="<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['AirPricingSolution'][$_smarty_tpl->getVariable('smarty')->value['section']['AirPriceSol']['index']]['AirPricingInfo'][$_smarty_tpl->getVariable('smarty')->value['section']['AirPriceInfo']['index']]['attributes']['Key'];?>
" TotalPrice="<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['AirPricingSolution'][$_smarty_tpl->getVariable('smarty')->value['section']['AirPriceSol']['index']]['AirPricingInfo'][$_smarty_tpl->getVariable('smarty')->value['section']['AirPriceInfo']['index']]['attributes']['TotalPrice'];?>
"  BasePrice="<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['AirPricingSolution'][$_smarty_tpl->getVariable('smarty')->value['section']['AirPriceSol']['index']]['AirPricingInfo'][$_smarty_tpl->getVariable('smarty')->value['section']['AirPriceInfo']['index']]['attributes']['BasePrice'];?>
"  ApproximateTotalPrice="<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['AirPricingSolution'][$_smarty_tpl->getVariable('smarty')->value['section']['AirPriceSol']['index']]['AirPricingInfo'][$_smarty_tpl->getVariable('smarty')->value['section']['AirPriceInfo']['index']]['attributes']['ApproximateTotalPrice'];?>
"  ApproximateBasePrice="<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['AirPricingSolution'][$_smarty_tpl->getVariable('smarty')->value['section']['AirPriceSol']['index']]['AirPricingInfo'][$_smarty_tpl->getVariable('smarty')->value['section']['AirPriceInfo']['index']]['attributes']['ApproximateBasePrice'];?>
"  ApproximateTaxes="<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['AirPricingSolution'][$_smarty_tpl->getVariable('smarty')->value['section']['AirPriceSol']['index']]['AirPricingInfo'][$_smarty_tpl->getVariable('smarty')->value['section']['AirPriceInfo']['index']]['attributes']['ApproximateTaxes'];?>
"  ApproximateFees="<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['AirPricingSolution'][$_smarty_tpl->getVariable('smarty')->value['section']['AirPriceSol']['index']]['AirPricingInfo'][$_smarty_tpl->getVariable('smarty')->value['section']['AirPriceInfo']['index']]['attributes']['ApproximateFees'];?>
"  Taxes="<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['AirPricingSolution'][$_smarty_tpl->getVariable('smarty')->value['section']['AirPriceSol']['index']]['AirPricingInfo'][$_smarty_tpl->getVariable('smarty')->value['section']['AirPriceInfo']['index']]['attributes']['Taxes'];?>
"  PricingMethod="<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['AirPricingSolution'][$_smarty_tpl->getVariable('smarty')->value['section']['AirPriceSol']['index']]['AirPricingInfo'][$_smarty_tpl->getVariable('smarty')->value['section']['AirPriceInfo']['index']]['attributes']['PricingMethod'];?>
"  ProviderCode="<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['AirPricingSolution'][$_smarty_tpl->getVariable('smarty')->value['section']['AirPriceSol']['index']]['AirPricingInfo'][$_smarty_tpl->getVariable('smarty')->value['section']['AirPriceInfo']['index']]['attributes']['ProviderCode'];?>
" AirPricingInfoGroup="<?php echo $_smarty_tpl->tpl_vars['tmpairPricingInfoGroup']->value;?>
" Fees="<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['AirPricingSolution'][$_smarty_tpl->getVariable('smarty')->value['section']['AirPriceSol']['index']]['AirPricingInfo'][$_smarty_tpl->getVariable('smarty')->value['section']['AirPriceInfo']['index']]['attributes']['Fees'];?>
" >
			<?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['AirFareInfo'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['AirFareInfo']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['AirFareInfo']['name'] = 'AirFareInfo';
$_smarty_tpl->tpl_vars['smarty']->value['section']['AirFareInfo']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['_Ainput']->value['AirPricingSolution'][$_smarty_tpl->getVariable('smarty')->value['section']['AirPriceSol']['index']]['AirPricingInfo'][$_smarty_tpl->getVariable('smarty')->value['section']['AirPriceInfo']['index']]['FareInfo']) ? count($_loop) : max(0, (int) $_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['AirFareInfo']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['AirFareInfo']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['AirFareInfo']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['AirFareInfo']['step'] = 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['AirFareInfo']['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['AirFareInfo']['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']['AirFareInfo']['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['AirFareInfo']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['AirFareInfo']['total'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['AirFareInfo']['loop'];
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['AirFareInfo']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['AirFareInfo']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['AirFareInfo']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['AirFareInfo']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['AirFareInfo']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['AirFareInfo']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['AirFareInfo']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['AirFareInfo']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['AirFareInfo']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['AirFareInfo']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['AirFareInfo']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['AirFareInfo']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['AirFareInfo']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['AirFareInfo']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['AirFareInfo']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['AirFareInfo']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['AirFareInfo']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['AirFareInfo']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['AirFareInfo']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['AirFareInfo']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['AirFareInfo']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['AirFareInfo']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['AirFareInfo']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['AirFareInfo']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['AirFareInfo']['total']);
?>
			
			<FareInfo <?php if (isset($_smarty_tpl->tpl_vars['_Ainput']->value['AirPricingSolution'][$_smarty_tpl->getVariable('smarty',null,true,false)->value['section']['AirPriceSol']['index']]['AirPricingInfo'][$_smarty_tpl->getVariable('smarty',null,true,false)->value['section']['AirPriceInfo']['index']]['FareInfo'][$_smarty_tpl->getVariable('smarty',null,true,false)->value['section']['AirFareInfo']['index']]['attributes']['FareFamily'])) {?> FareFamily="<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['AirPricingSolution'][$_smarty_tpl->getVariable('smarty')->value['section']['AirPriceSol']['index']]['AirPricingInfo'][$_smarty_tpl->getVariable('smarty')->value['section']['AirPriceInfo']['index']]['FareInfo'][$_smarty_tpl->getVariable('smarty')->value['section']['AirFareInfo']['index']]['attributes']['FareFamily'];?>
" <?php }?> <?php if (isset($_smarty_tpl->tpl_vars['_Ainput']->value['AirPricingSolution'][$_smarty_tpl->getVariable('smarty',null,true,false)->value['section']['AirPriceSol']['index']]['AirPricingInfo'][$_smarty_tpl->getVariable('smarty',null,true,false)->value['section']['AirPriceInfo']['index']]['FareInfo'][$_smarty_tpl->getVariable('smarty',null,true,false)->value['section']['AirFareInfo']['index']]['attributes']['PromotionalFare'])) {?> PromotionalFare="<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['AirPricingSolution'][$_smarty_tpl->getVariable('smarty')->value['section']['AirPriceSol']['index']]['AirPricingInfo'][$_smarty_tpl->getVariable('smarty')->value['section']['AirPriceInfo']['index']]['FareInfo'][$_smarty_tpl->getVariable('smarty')->value['section']['AirFareInfo']['index']]['attributes']['PromotionalFare'];?>
" <?php }?> DepartureDate="<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['AirPricingSolution'][$_smarty_tpl->getVariable('smarty')->value['section']['AirPriceSol']['index']]['AirPricingInfo'][$_smarty_tpl->getVariable('smarty')->value['section']['AirPriceInfo']['index']]['FareInfo'][$_smarty_tpl->getVariable('smarty')->value['section']['AirFareInfo']['index']]['attributes']['DepartureDate'];?>
" Amount="<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['AirPricingSolution'][$_smarty_tpl->getVariable('smarty')->value['section']['AirPriceSol']['index']]['AirPricingInfo'][$_smarty_tpl->getVariable('smarty')->value['section']['AirPriceInfo']['index']]['FareInfo'][$_smarty_tpl->getVariable('smarty')->value['section']['AirFareInfo']['index']]['attributes']['Amount'];?>
" EffectiveDate="<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['AirPricingSolution'][$_smarty_tpl->getVariable('smarty')->value['section']['AirPriceSol']['index']]['AirPricingInfo'][$_smarty_tpl->getVariable('smarty')->value['section']['AirPriceInfo']['index']]['FareInfo'][$_smarty_tpl->getVariable('smarty')->value['section']['AirFareInfo']['index']]['attributes']['EffectiveDate'];?>
" Destination="<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['AirPricingSolution'][$_smarty_tpl->getVariable('smarty')->value['section']['AirPriceSol']['index']]['AirPricingInfo'][$_smarty_tpl->getVariable('smarty')->value['section']['AirPriceInfo']['index']]['FareInfo'][$_smarty_tpl->getVariable('smarty')->value['section']['AirFareInfo']['index']]['attributes']['Destination'];?>
" Origin="<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['AirPricingSolution'][$_smarty_tpl->getVariable('smarty')->value['section']['AirPriceSol']['index']]['AirPricingInfo'][$_smarty_tpl->getVariable('smarty')->value['section']['AirPriceInfo']['index']]['FareInfo'][$_smarty_tpl->getVariable('smarty')->value['section']['AirFareInfo']['index']]['attributes']['Origin'];?>
" PassengerTypeCode="<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['AirPricingSolution'][$_smarty_tpl->getVariable('smarty')->value['section']['AirPriceSol']['index']]['AirPricingInfo'][$_smarty_tpl->getVariable('smarty')->value['section']['AirPriceInfo']['index']]['FareInfo'][$_smarty_tpl->getVariable('smarty')->value['section']['AirFareInfo']['index']]['attributes']['PassengerTypeCode'];?>
" FareBasis="<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['AirPricingSolution'][$_smarty_tpl->getVariable('smarty')->value['section']['AirPriceSol']['index']]['AirPricingInfo'][$_smarty_tpl->getVariable('smarty')->value['section']['AirPriceInfo']['index']]['FareInfo'][$_smarty_tpl->getVariable('smarty')->value['section']['AirFareInfo']['index']]['attributes']['FareBasis'];?>
" Key="<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['AirPricingSolution'][$_smarty_tpl->getVariable('smarty')->value['section']['AirPriceSol']['index']]['AirPricingInfo'][$_smarty_tpl->getVariable('smarty')->value['section']['AirPriceInfo']['index']]['FareInfo'][$_smarty_tpl->getVariable('smarty')->value['section']['AirFareInfo']['index']]['attributes']['Key'];?>
">
				
				<FareRuleKey FareInfoRef="<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['AirPricingSolution'][$_smarty_tpl->getVariable('smarty')->value['section']['AirPriceSol']['index']]['AirPricingInfo'][$_smarty_tpl->getVariable('smarty')->value['section']['AirPriceInfo']['index']]['FareInfo'][$_smarty_tpl->getVariable('smarty')->value['section']['AirFareInfo']['index']]['FareRuleKey']['attributes']['FareInfoRef'];?>
" ProviderCode="<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['AirPricingSolution'][$_smarty_tpl->getVariable('smarty')->value['section']['AirPriceSol']['index']]['AirPricingInfo'][$_smarty_tpl->getVariable('smarty')->value['section']['AirPriceInfo']['index']]['FareInfo'][$_smarty_tpl->getVariable('smarty')->value['section']['AirFareInfo']['index']]['FareRuleKey']['attributes']['ProviderCode'];?>
"><?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['AirPricingSolution'][$_smarty_tpl->getVariable('smarty')->value['section']['AirPriceSol']['index']]['AirPricingInfo'][$_smarty_tpl->getVariable('smarty')->value['section']['AirPriceInfo']['index']]['FareInfo'][$_smarty_tpl->getVariable('smarty')->value['section']['AirFareInfo']['index']]['FareRuleKey']['content'];?>
</FareRuleKey>
			</FareInfo>
			<?php endfor; endif; ?>
			
			<?php if (isset($_smarty_tpl->tpl_vars['_Ainput']->value['AirPricingSolution'][$_smarty_tpl->getVariable('smarty',null,true,false)->value['section']['AirPriceSol']['index']]['AirPricingInfo'][$_smarty_tpl->getVariable('smarty',null,true,false)->value['section']['AirPriceInfo']['index']]['BookingInfo'])) {?>
			
			<?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['AirBookingInfo'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['AirBookingInfo']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['AirBookingInfo']['name'] = 'AirBookingInfo';
$_smarty_tpl->tpl_vars['smarty']->value['section']['AirBookingInfo']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['_Ainput']->value['AirPricingSolution'][$_smarty_tpl->getVariable('smarty')->value['section']['AirPriceSol']['index']]['AirPricingInfo'][$_smarty_tpl->getVariable('smarty')->value['section']['AirPriceInfo']['index']]['BookingInfo']) ? count($_loop) : max(0, (int) $_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['AirBookingInfo']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['AirBookingInfo']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['AirBookingInfo']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['AirBookingInfo']['step'] = 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['AirBookingInfo']['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['AirBookingInfo']['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']['AirBookingInfo']['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['AirBookingInfo']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['AirBookingInfo']['total'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['AirBookingInfo']['loop'];
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['AirBookingInfo']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['AirBookingInfo']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['AirBookingInfo']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['AirBookingInfo']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['AirBookingInfo']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['AirBookingInfo']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['AirBookingInfo']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['AirBookingInfo']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['AirBookingInfo']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['AirBookingInfo']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['AirBookingInfo']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['AirBookingInfo']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['AirBookingInfo']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['AirBookingInfo']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['AirBookingInfo']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['AirBookingInfo']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['AirBookingInfo']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['AirBookingInfo']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['AirBookingInfo']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['AirBookingInfo']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['AirBookingInfo']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['AirBookingInfo']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['AirBookingInfo']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['AirBookingInfo']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['AirBookingInfo']['total']);
?>
			
			<BookingInfo BookingCode="<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['AirPricingSolution'][$_smarty_tpl->getVariable('smarty')->value['section']['AirPriceSol']['index']]['AirPricingInfo'][$_smarty_tpl->getVariable('smarty')->value['section']['AirPriceInfo']['index']]['BookingInfo'][$_smarty_tpl->getVariable('smarty')->value['section']['AirBookingInfo']['index']]['attributes']['BookingCode'];?>
" CabinClass="<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['AirPricingSolution'][$_smarty_tpl->getVariable('smarty')->value['section']['AirPriceSol']['index']]['AirPricingInfo'][$_smarty_tpl->getVariable('smarty')->value['section']['AirPriceInfo']['index']]['BookingInfo'][$_smarty_tpl->getVariable('smarty')->value['section']['AirBookingInfo']['index']]['attributes']['CabinClass'];?>
" FareInfoRef="<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['AirPricingSolution'][$_smarty_tpl->getVariable('smarty')->value['section']['AirPriceSol']['index']]['AirPricingInfo'][$_smarty_tpl->getVariable('smarty')->value['section']['AirPriceInfo']['index']]['BookingInfo'][$_smarty_tpl->getVariable('smarty')->value['section']['AirBookingInfo']['index']]['attributes']['FareInfoRef'];?>
" SegmentRef="<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['AirPricingSolution'][$_smarty_tpl->getVariable('smarty')->value['section']['AirPriceSol']['index']]['AirPricingInfo'][$_smarty_tpl->getVariable('smarty')->value['section']['AirPriceInfo']['index']]['BookingInfo'][$_smarty_tpl->getVariable('smarty')->value['section']['AirBookingInfo']['index']]['attributes']['SegmentRef'];?>
" ></BookingInfo>
			<?php endfor; endif; ?>
			
			<?php }?>
			
			<?php if (isset($_smarty_tpl->tpl_vars['_Ainput']->value['AirPricingSolution'][$_smarty_tpl->getVariable('smarty',null,true,false)->value['section']['AirPriceSol']['index']]['AirPricingInfo'][$_smarty_tpl->getVariable('smarty',null,true,false)->value['section']['AirPriceInfo']['index']]['TaxInfo'])) {?>
			
			<?php $_smarty_tpl->tpl_vars["TaxInfoArr"] = new Smarty_variable($_smarty_tpl->tpl_vars['_Ainput']->value['AirPricingSolution'][$_smarty_tpl->getVariable('smarty')->value['section']['AirPriceSol']['index']]['AirPricingInfo'][$_smarty_tpl->getVariable('smarty')->value['section']['AirPriceInfo']['index']]['TaxInfo'], null, 0);?>
			<?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['AirTaxInfo'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['AirTaxInfo']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['AirTaxInfo']['name'] = 'AirTaxInfo';
$_smarty_tpl->tpl_vars['smarty']->value['section']['AirTaxInfo']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['TaxInfoArr']->value) ? count($_loop) : max(0, (int) $_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['AirTaxInfo']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['AirTaxInfo']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['AirTaxInfo']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['AirTaxInfo']['step'] = 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['AirTaxInfo']['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['AirTaxInfo']['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']['AirTaxInfo']['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['AirTaxInfo']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['AirTaxInfo']['total'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['AirTaxInfo']['loop'];
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['AirTaxInfo']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['AirTaxInfo']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['AirTaxInfo']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['AirTaxInfo']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['AirTaxInfo']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['AirTaxInfo']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['AirTaxInfo']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['AirTaxInfo']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['AirTaxInfo']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['AirTaxInfo']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['AirTaxInfo']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['AirTaxInfo']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['AirTaxInfo']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['AirTaxInfo']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['AirTaxInfo']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['AirTaxInfo']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['AirTaxInfo']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['AirTaxInfo']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['AirTaxInfo']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['AirTaxInfo']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['AirTaxInfo']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['AirTaxInfo']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['AirTaxInfo']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['AirTaxInfo']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['AirTaxInfo']['total']);
?>
			
			<TaxInfo Key="<?php echo $_smarty_tpl->tpl_vars['TaxInfoArr']->value[$_smarty_tpl->getVariable('smarty')->value['section']['AirTaxInfo']['index']]['attributes']['Key'];?>
" Category="<?php echo $_smarty_tpl->tpl_vars['TaxInfoArr']->value[$_smarty_tpl->getVariable('smarty')->value['section']['AirTaxInfo']['index']]['attributes']['Category'];?>
" Amount="<?php echo $_smarty_tpl->tpl_vars['TaxInfoArr']->value[$_smarty_tpl->getVariable('smarty')->value['section']['AirTaxInfo']['index']]['attributes']['Amount'];?>
" ></TaxInfo>
			<?php endfor; endif; ?>
			
			<?php }?>
			
			<?php if (isset($_smarty_tpl->tpl_vars['_Ainput']->value['AirPricingSolution'][$_smarty_tpl->getVariable('smarty',null,true,false)->value['section']['AirPriceSol']['index']]['AirPricingInfo'][$_smarty_tpl->getVariable('smarty',null,true,false)->value['section']['AirPriceInfo']['index']]['PassengerType'])) {?>
			
			<?php $_smarty_tpl->tpl_vars["PassengerTypeArr"] = new Smarty_variable($_smarty_tpl->tpl_vars['_Ainput']->value['AirPricingSolution'][$_smarty_tpl->getVariable('smarty')->value['section']['AirPriceSol']['index']]['AirPricingInfo'][$_smarty_tpl->getVariable('smarty')->value['section']['AirPriceInfo']['index']]['PassengerType'], null, 0);?>
			<?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['PassengerType'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['PassengerType']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['PassengerType']['name'] = 'PassengerType';
$_smarty_tpl->tpl_vars['smarty']->value['section']['PassengerType']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['PassengerTypeArr']->value) ? count($_loop) : max(0, (int) $_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['PassengerType']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['PassengerType']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['PassengerType']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['PassengerType']['step'] = 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['PassengerType']['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['PassengerType']['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']['PassengerType']['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['PassengerType']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['PassengerType']['total'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['PassengerType']['loop'];
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['PassengerType']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['PassengerType']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['PassengerType']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['PassengerType']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['PassengerType']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['PassengerType']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['PassengerType']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['PassengerType']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['PassengerType']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['PassengerType']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['PassengerType']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['PassengerType']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['PassengerType']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['PassengerType']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['PassengerType']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['PassengerType']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['PassengerType']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['PassengerType']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['PassengerType']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['PassengerType']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['PassengerType']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['PassengerType']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['PassengerType']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['PassengerType']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['PassengerType']['total']);
?>
			
			<?php $_smarty_tpl->tpl_vars['paxLoopIdx'] = new Smarty_variable($_smarty_tpl->getVariable('smarty')->value['section']['PassengerType']['index']+1, null, 0);?>
			<PassengerType Code="<?php echo $_smarty_tpl->tpl_vars['PassengerTypeArr']->value[$_smarty_tpl->getVariable('smarty')->value['section']['PassengerType']['index']]['attributes']['Code'];?>
" <?php if (isset($_smarty_tpl->tpl_vars['PassengerTypeArr']->value[$_smarty_tpl->getVariable('smarty',null,true,false)->value['section']['PassengerType']['index']]['attributes']['Age'])) {?> Age="<?php echo $_smarty_tpl->tpl_vars['PassengerTypeArr']->value[$_smarty_tpl->getVariable('smarty')->value['section']['PassengerType']['index']]['attributes']['Age'];?>
" <?php }
if (isset($_smarty_tpl->tpl_vars['PassengerTypeArr']->value[$_smarty_tpl->getVariable('smarty',null,true,false)->value['section']['PassengerType']['index']]['attributes']['BookingTravelerRef'])) {?> BookingTravelerRef="<?php echo $_smarty_tpl->tpl_vars['PassengerTypeArr']->value[$_smarty_tpl->getVariable('smarty')->value['section']['PassengerType']['index']]['attributes']['BookingTravelerRef'];?>
" <?php } else { ?> BookingTravelerRef="<?php echo $_smarty_tpl->tpl_vars['PassengerTypeArr']->value[$_smarty_tpl->getVariable('smarty')->value['section']['PassengerType']['index']]['attributes']['Code'];
echo $_smarty_tpl->tpl_vars['paxLoopIdx']->value;?>
" <?php }?> ></PassengerType>
			
			<?php endfor; endif; ?>
			
			<?php }?>
			
			<?php if (isset($_smarty_tpl->tpl_vars['_Ainput']->value['AirPricingSolution'][$_smarty_tpl->getVariable('smarty',null,true,false)->value['section']['AirPriceSol']['index']]['AirPricingInfo'][$_smarty_tpl->getVariable('smarty',null,true,false)->value['section']['AirPriceInfo']['index']]['FeeInfo'])) {?>
				<?php $_smarty_tpl->tpl_vars["FeeInfoArr"] = new Smarty_variable($_smarty_tpl->tpl_vars['_Ainput']->value['AirPricingSolution'][$_smarty_tpl->getVariable('smarty')->value['section']['AirPriceSol']['index']]['AirPricingInfo'][$_smarty_tpl->getVariable('smarty')->value['section']['AirPriceInfo']['index']]['FeeInfo'], null, 0);?>
				<?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['FeeInfo'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['FeeInfo']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['FeeInfo']['name'] = 'FeeInfo';
$_smarty_tpl->tpl_vars['smarty']->value['section']['FeeInfo']['loop'] = is_array($_loop='FeeInfoArr') ? count($_loop) : max(0, (int) $_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['FeeInfo']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['FeeInfo']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['FeeInfo']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['FeeInfo']['step'] = 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['FeeInfo']['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['FeeInfo']['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']['FeeInfo']['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['FeeInfo']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['FeeInfo']['total'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['FeeInfo']['loop'];
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['FeeInfo']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['FeeInfo']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['FeeInfo']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['FeeInfo']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['FeeInfo']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['FeeInfo']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['FeeInfo']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['FeeInfo']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['FeeInfo']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['FeeInfo']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['FeeInfo']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['FeeInfo']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['FeeInfo']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['FeeInfo']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['FeeInfo']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['FeeInfo']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['FeeInfo']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['FeeInfo']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['FeeInfo']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['FeeInfo']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['FeeInfo']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['FeeInfo']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['FeeInfo']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['FeeInfo']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['FeeInfo']['total']);
?>
				<FeeInfo  Key="<?php echo $_smarty_tpl->tpl_vars['FeeInfoArr']->value[$_smarty_tpl->getVariable('smarty')->value['section']['FeeInfo']['index']]['attributes']['Key'];?>
"  Amount="<?php echo $_smarty_tpl->tpl_vars['FeeInfoArr']->value[$_smarty_tpl->getVariable('smarty')->value['section']['FeeInfo']['index']]['attributes']['Amount'];?>
"  Code="<?php echo $_smarty_tpl->tpl_vars['FeeInfoArr']->value[$_smarty_tpl->getVariable('smarty')->value['section']['FeeInfo']['index']]['attributes']['Code'];?>
"  ProviderCode="<?php echo $_smarty_tpl->tpl_vars['FeeInfoArr']->value[$_smarty_tpl->getVariable('smarty')->value['section']['FeeInfo']['index']]['attributes']['ProviderCode'];?>
"  SupplierCode="<?php echo $_smarty_tpl->tpl_vars['FeeInfoArr']->value[$_smarty_tpl->getVariable('smarty')->value['section']['FeeInfo']['index']]['attributes']['SupplierCode'];?>
"  ></FeeInfo>
				<?php endfor; endif; ?>
			<?php }?>

		</AirPricingInfo>
		<?php $_smarty_tpl->tpl_vars['tmpairPricingInfoGroup'] = new Smarty_variable($_smarty_tpl->tpl_vars['tmpairPricingInfoGroup']->value+1, null, 0);?>
		<?php endfor; endif; ?>
		<?php }?>
		
		<?php if (isset($_smarty_tpl->tpl_vars['_Ainput']->value['AirPricingSolution'][$_smarty_tpl->getVariable('smarty',null,true,false)->value['section']['AirPriceSol']['index']]['FeeInfo'])) {?>
		<?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['AirFeeInfoArr'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['AirFeeInfoArr']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['AirFeeInfoArr']['name'] = 'AirFeeInfoArr';
$_smarty_tpl->tpl_vars['smarty']->value['section']['AirFeeInfoArr']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['_Ainput']->value['AirPricingSolution'][$_smarty_tpl->getVariable('smarty')->value['section']['AirPriceSol']['index']]['FeeInfo']) ? count($_loop) : max(0, (int) $_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['AirFeeInfoArr']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['AirFeeInfoArr']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['AirFeeInfoArr']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['AirFeeInfoArr']['step'] = 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['AirFeeInfoArr']['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['AirFeeInfoArr']['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']['AirFeeInfoArr']['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['AirFeeInfoArr']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['AirFeeInfoArr']['total'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['AirFeeInfoArr']['loop'];
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['AirFeeInfoArr']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['AirFeeInfoArr']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['AirFeeInfoArr']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['AirFeeInfoArr']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['AirFeeInfoArr']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['AirFeeInfoArr']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['AirFeeInfoArr']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['AirFeeInfoArr']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['AirFeeInfoArr']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['AirFeeInfoArr']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['AirFeeInfoArr']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['AirFeeInfoArr']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['AirFeeInfoArr']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['AirFeeInfoArr']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['AirFeeInfoArr']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['AirFeeInfoArr']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['AirFeeInfoArr']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['AirFeeInfoArr']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['AirFeeInfoArr']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['AirFeeInfoArr']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['AirFeeInfoArr']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['AirFeeInfoArr']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['AirFeeInfoArr']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['AirFeeInfoArr']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['AirFeeInfoArr']['total']);
?>
		
		<FeeInfo Key="<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['AirPricingSolution'][$_smarty_tpl->getVariable('smarty')->value['section']['AirPriceSol']['index']]['FeeInfo'][$_smarty_tpl->getVariable('smarty')->value['section']['AirFeeInfoArr']['index']]['attributes']['Key'];?>
" Amount="<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['AirPricingSolution'][$_smarty_tpl->getVariable('smarty')->value['section']['AirPriceSol']['index']]['FeeInfo'][$_smarty_tpl->getVariable('smarty')->value['section']['AirFeeInfoArr']['index']]['attributes']['Amount'];?>
"  Code="<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['AirPricingSolution'][$_smarty_tpl->getVariable('smarty')->value['section']['AirPriceSol']['index']]['FeeInfo'][$_smarty_tpl->getVariable('smarty')->value['section']['AirFeeInfoArr']['index']]['attributes']['Code'];?>
"  ProviderCode="<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['AirPricingSolution'][$_smarty_tpl->getVariable('smarty')->value['section']['AirPriceSol']['index']]['FeeInfo'][$_smarty_tpl->getVariable('smarty')->value['section']['AirFeeInfoArr']['index']]['attributes']['ProviderCode'];?>
"  SupplierCode="<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['AirPricingSolution'][$_smarty_tpl->getVariable('smarty')->value['section']['AirPriceSol']['index']]['FeeInfo'][$_smarty_tpl->getVariable('smarty')->value['section']['AirFeeInfoArr']['index']]['attributes']['SupplierCode'];?>
"  ></FeeInfo>
		
		<?php endfor; endif; ?>
		<?php }?>
		
		<?php if (isset($_smarty_tpl->tpl_vars['_Ainput']->value['AirPricingSolution'][$_smarty_tpl->getVariable('smarty',null,true,false)->value['section']['AirPriceSol']['index']]['TaxInfo'])) {?>
		<?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['AirTaxInfoArr'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['AirTaxInfoArr']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['AirTaxInfoArr']['name'] = 'AirTaxInfoArr';
$_smarty_tpl->tpl_vars['smarty']->value['section']['AirTaxInfoArr']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['_Ainput']->value['AirPricingSolution'][$_smarty_tpl->getVariable('smarty')->value['section']['AirPriceSol']['index']]['TaxInfo']) ? count($_loop) : max(0, (int) $_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['AirTaxInfoArr']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['AirTaxInfoArr']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['AirTaxInfoArr']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['AirTaxInfoArr']['step'] = 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['AirTaxInfoArr']['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['AirTaxInfoArr']['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']['AirTaxInfoArr']['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['AirTaxInfoArr']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['AirTaxInfoArr']['total'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['AirTaxInfoArr']['loop'];
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['AirTaxInfoArr']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['AirTaxInfoArr']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['AirTaxInfoArr']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['AirTaxInfoArr']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['AirTaxInfoArr']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['AirTaxInfoArr']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['AirTaxInfoArr']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['AirTaxInfoArr']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['AirTaxInfoArr']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['AirTaxInfoArr']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['AirTaxInfoArr']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['AirTaxInfoArr']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['AirTaxInfoArr']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['AirTaxInfoArr']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['AirTaxInfoArr']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['AirTaxInfoArr']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['AirTaxInfoArr']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['AirTaxInfoArr']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['AirTaxInfoArr']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['AirTaxInfoArr']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['AirTaxInfoArr']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['AirTaxInfoArr']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['AirTaxInfoArr']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['AirTaxInfoArr']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['AirTaxInfoArr']['total']);
?>
		
		<TaxInfo Category="<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['AirPricingSolution'][$_smarty_tpl->getVariable('smarty')->value['section']['AirPriceSol']['index']]['TaxInfo'][$_smarty_tpl->getVariable('smarty')->value['section']['AirTaxInfoArr']['index']]['attributes']['Category'];?>
"  Amount="<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['AirPricingSolution'][$_smarty_tpl->getVariable('smarty')->value['section']['AirPriceSol']['index']]['TaxInfo'][$_smarty_tpl->getVariable('smarty')->value['section']['AirTaxInfoArr']['index']]['attributes']['Amount'];?>
"  Key="<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['AirPricingSolution'][$_smarty_tpl->getVariable('smarty')->value['section']['AirPriceSol']['index']]['TaxInfo'][$_smarty_tpl->getVariable('smarty')->value['section']['AirTaxInfoArr']['index']]['attributes']['Key'];?>
"  ProviderCode="<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['AirPricingSolution'][$_smarty_tpl->getVariable('smarty')->value['section']['AirPriceSol']['index']]['TaxInfo'][$_smarty_tpl->getVariable('smarty')->value['section']['AirTaxInfoArr']['index']]['attributes']['ProviderCode'];?>
"  SupplierCode="<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['AirPricingSolution'][$_smarty_tpl->getVariable('smarty')->value['section']['AirPriceSol']['index']]['TaxInfo'][$_smarty_tpl->getVariable('smarty')->value['section']['AirTaxInfoArr']['index']]['attributes']['SupplierCode'];?>
"  ></TaxInfo>
		<?php endfor; endif; ?>
		<?php }?>
		<?php if (isset($_smarty_tpl->tpl_vars['_Ainput']->value['AirPricingSolution'][$_smarty_tpl->getVariable('smarty',null,true,false)->value['section']['AirPriceSol']['index']]['HostToken'])) {?>
		<?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['HostTokenArr'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['HostTokenArr']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['HostTokenArr']['name'] = 'HostTokenArr';
$_smarty_tpl->tpl_vars['smarty']->value['section']['HostTokenArr']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['_Ainput']->value['AirPricingSolution'][$_smarty_tpl->getVariable('smarty')->value['section']['AirPriceSol']['index']]['HostToken']) ? count($_loop) : max(0, (int) $_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['HostTokenArr']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['HostTokenArr']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['HostTokenArr']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['HostTokenArr']['step'] = 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['HostTokenArr']['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['HostTokenArr']['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']['HostTokenArr']['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['HostTokenArr']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['HostTokenArr']['total'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['HostTokenArr']['loop'];
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['HostTokenArr']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['HostTokenArr']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['HostTokenArr']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['HostTokenArr']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['HostTokenArr']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['HostTokenArr']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['HostTokenArr']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['HostTokenArr']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['HostTokenArr']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['HostTokenArr']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['HostTokenArr']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['HostTokenArr']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['HostTokenArr']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['HostTokenArr']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['HostTokenArr']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['HostTokenArr']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['HostTokenArr']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['HostTokenArr']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['HostTokenArr']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['HostTokenArr']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['HostTokenArr']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['HostTokenArr']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['HostTokenArr']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['HostTokenArr']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['HostTokenArr']['total']);
?>
		<HostToken xmlns="http://www.travelport.com/schema/common_v35_0" Key="<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['AirPricingSolution'][$_smarty_tpl->getVariable('smarty')->value['section']['AirPriceSol']['index']]['HostToken'][$_smarty_tpl->getVariable('smarty')->value['section']['HostTokenArr']['index']]['attributes']['Key'];?>
"><?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['AirPricingSolution'][$_smarty_tpl->getVariable('smarty')->value['section']['AirPriceSol']['index']]['HostToken'][$_smarty_tpl->getVariable('smarty')->value['section']['HostTokenArr']['index']]['content'];?>
</HostToken>
		<?php endfor; endif; ?>
		<?php }?>
		<?php if (isset($_smarty_tpl->tpl_vars['_Ainput']->value['OptionalServices'])&&$_smarty_tpl->tpl_vars['_Ainput']->value['OptionalServices']!='') {?>
		
		<OptionalServices>
	<?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['optService'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['optService']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['optService']['name'] = 'optService';
$_smarty_tpl->tpl_vars['smarty']->value['section']['optService']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['_Ainput']->value['OptionalServices']) ? count($_loop) : max(0, (int) $_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['optService']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['optService']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['optService']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['optService']['step'] = 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['optService']['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['optService']['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']['optService']['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['optService']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['optService']['total'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['optService']['loop'];
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['optService']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['optService']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['optService']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['optService']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['optService']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['optService']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['optService']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['optService']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['optService']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['optService']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['optService']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['optService']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['optService']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['optService']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['optService']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['optService']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['optService']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['optService']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['optService']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['optService']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['optService']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['optService']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['optService']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['optService']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['optService']['total']);
?>
		
		
		<?php if ($_smarty_tpl->tpl_vars['_Ainput']->value['OptionalServices'][$_smarty_tpl->getVariable('smarty')->value['section']['optService']['index']]['attributes']['ServiceStatus']=='Priced') {?>
		
		<OptionalService  Type="<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['OptionalServices'][$_smarty_tpl->getVariable('smarty')->value['section']['optService']['index']]['attributes']['Type'];?>
"  TotalPrice="<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['OptionalServices'][$_smarty_tpl->getVariable('smarty')->value['section']['optService']['index']]['attributes']['TotalPrice'];?>
"  SupplierCode="<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['OptionalServices'][$_smarty_tpl->getVariable('smarty')->value['section']['optService']['index']]['attributes']['SupplierCode'];?>
"  CreateDate="<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['OptionalServices'][$_smarty_tpl->getVariable('smarty')->value['section']['optService']['index']]['attributes']['CreateDate'];?>
"  ServiceStatus="<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['OptionalServices'][$_smarty_tpl->getVariable('smarty')->value['section']['optService']['index']]['attributes']['ServiceStatus'];?>
"  Key="<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['OptionalServices'][$_smarty_tpl->getVariable('smarty')->value['section']['optService']['index']]['attributes']['Key'];?>
"  AssessIndicator="<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['OptionalServices'][$_smarty_tpl->getVariable('smarty')->value['section']['optService']['index']]['attributes']['AssessIndicator'];?>
"  IsPricingApproximate="<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['OptionalServices'][$_smarty_tpl->getVariable('smarty')->value['section']['optService']['index']]['attributes']['IsPricingApproximate'];?>
"  Source="<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['OptionalServices'][$_smarty_tpl->getVariable('smarty')->value['section']['optService']['index']]['attributes']['Source'];?>
"  ProviderCode="<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['OptionalServices'][$_smarty_tpl->getVariable('smarty')->value['section']['optService']['index']]['attributes']['ProviderCode'];?>
"  Quantity="<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['OptionalServices'][$_smarty_tpl->getVariable('smarty')->value['section']['optService']['index']]['attributes']['Quantity'];?>
"  ProviderDefinedType="<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['OptionalServices'][$_smarty_tpl->getVariable('smarty')->value['section']['optService']['index']]['attributes']['ProviderDefinedType'];?>
"  BasePrice="<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['OptionalServices'][$_smarty_tpl->getVariable('smarty')->value['section']['optService']['index']]['attributes']['BasePrice'];?>
"  ApproximateTotalPrice="<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['OptionalServices'][$_smarty_tpl->getVariable('smarty')->value['section']['optService']['index']]['attributes']['ApproximateTotalPrice'];?>
"  ApproximateBasePrice="<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['OptionalServices'][$_smarty_tpl->getVariable('smarty')->value['section']['optService']['index']]['attributes']['ApproximateBasePrice'];?>
" >
		
			<?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['serviceDataLoop'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['serviceDataLoop']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['serviceDataLoop']['name'] = 'serviceDataLoop';
$_smarty_tpl->tpl_vars['smarty']->value['section']['serviceDataLoop']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['_Ainput']->value['OptionalServices'][$_smarty_tpl->getVariable('smarty')->value['section']['optService']['index']]['ServiceData']) ? count($_loop) : max(0, (int) $_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['serviceDataLoop']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['serviceDataLoop']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['serviceDataLoop']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['serviceDataLoop']['step'] = 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['serviceDataLoop']['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['serviceDataLoop']['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']['serviceDataLoop']['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['serviceDataLoop']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['serviceDataLoop']['total'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['serviceDataLoop']['loop'];
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['serviceDataLoop']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['serviceDataLoop']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['serviceDataLoop']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['serviceDataLoop']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['serviceDataLoop']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['serviceDataLoop']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['serviceDataLoop']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['serviceDataLoop']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['serviceDataLoop']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['serviceDataLoop']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['serviceDataLoop']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['serviceDataLoop']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['serviceDataLoop']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['serviceDataLoop']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['serviceDataLoop']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['serviceDataLoop']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['serviceDataLoop']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['serviceDataLoop']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['serviceDataLoop']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['serviceDataLoop']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['serviceDataLoop']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['serviceDataLoop']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['serviceDataLoop']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['serviceDataLoop']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['serviceDataLoop']['total']);
?>
			
				<?php  $_smarty_tpl->tpl_vars['itemVal'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['itemVal']->_loop = false;
 $_smarty_tpl->tpl_vars['keyVal'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['_Ainput']->value['PassengerType']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['itemVal']->key => $_smarty_tpl->tpl_vars['itemVal']->value) {
$_smarty_tpl->tpl_vars['itemVal']->_loop = true;
 $_smarty_tpl->tpl_vars['keyVal']->value = $_smarty_tpl->tpl_vars['itemVal']->key;
?>
					<?php if ($_smarty_tpl->tpl_vars['_Ainput']->value['OptionalServices'][$_smarty_tpl->getVariable('smarty')->value['section']['optService']['index']]['ServiceData'][$_smarty_tpl->getVariable('smarty')->value['section']['serviceDataLoop']['index']]['attributes']['BookingTravelerRef']==$_smarty_tpl->tpl_vars['itemVal']->value) {?>
						<?php $_smarty_tpl->tpl_vars['PaxType'] = new Smarty_variable(explode("_",$_smarty_tpl->tpl_vars['keyVal']->value), null, 0);?>
					<?php }?>	
				<?php } ?>
				<ServiceData <?php if (isset($_smarty_tpl->tpl_vars['_Ainput']->value['OptionalServices'][$_smarty_tpl->getVariable('smarty',null,true,false)->value['section']['optService']['index']]['ServiceData'][$_smarty_tpl->getVariable('smarty',null,true,false)->value['section']['serviceDataLoop']['index']]['attributes']['Data'])) {?> Data="<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['OptionalServices'][$_smarty_tpl->getVariable('smarty')->value['section']['optService']['index']]['ServiceData'][$_smarty_tpl->getVariable('smarty')->value['section']['serviceDataLoop']['index']]['attributes']['Data'];?>
" <?php }?> xmlns="http://www.travelport.com/schema/common_v35_0"  AirSegmentRef="<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['OptionalServices'][$_smarty_tpl->getVariable('smarty')->value['section']['optService']['index']]['ServiceData'][$_smarty_tpl->getVariable('smarty')->value['section']['serviceDataLoop']['index']]['attributes']['AirSegmentRef'];?>
" BookingTravelerRef="<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['OptionalServices'][$_smarty_tpl->getVariable('smarty')->value['section']['optService']['index']]['ServiceData'][$_smarty_tpl->getVariable('smarty')->value['section']['serviceDataLoop']['index']]['attributes']['BookingTravelerRef'];?>
" TravelerType="<?php echo $_smarty_tpl->tpl_vars['PaxType']->value[0];?>
">
				</ServiceData>
			<?php endfor; endif; ?>
			<ServiceInfo xmlns="http://www.travelport.com/schema/common_v35_0">
				<?php $_smarty_tpl->tpl_vars['tmpSsrDes'] = new Smarty_variable($_smarty_tpl->tpl_vars['_Ainput']->value['OptionalServices'][$_smarty_tpl->getVariable('smarty')->value['section']['optService']['index']]['ServiceInfo']['Description'], null, 0);?>
				<?php if (is_array($_smarty_tpl->tpl_vars['tmpSsrDes']->value)&&isset($_smarty_tpl->tpl_vars['tmpSsrDes']->value[0])) {?>
					<?php $_smarty_tpl->tpl_vars['tmpSsrDes'] = new Smarty_variable($_smarty_tpl->tpl_vars['tmpSsrDes']->value[0], null, 0);?>
				<?php }?>
				<Description><?php echo $_smarty_tpl->tpl_vars['tmpSsrDes']->value;?>
</Description>
			</ServiceInfo>
		</OptionalService>
		
		<?php }?>
		<?php endfor; endif; ?>
		</OptionalServices>
		<?php }?>
	</AirPricingSolution>
<?php }?>

<?php endfor; endif; ?>

<?php if ($_smarty_tpl->tpl_vars['_Ainput']->value['providerCode']['ProviderCode']=='1G') {?>
	<ActionStatus xmlns="http://www.travelport.com/schema/common_v35_0" Type="ACTIVE" TicketDate="<?php echo smarty_modifier_date_format('+2 days','%d%b%y');?>
" ProviderCode="<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['providerCode']['ProviderCode'];?>
" ></ActionStatus>
<?php } else { ?>
	<ActionStatus xmlns="http://www.travelport.com/schema/common_v35_0" Type="ACTIVE" TicketDate="T*" ProviderCode="<?php echo $_smarty_tpl->tpl_vars['_Ainput']->value['providerCode']['ProviderCode'];?>
" ></ActionStatus>
<?php }?>	
	</AirCreateReservationReq>
<?php }} ?>

<?php


//This is the access privilege file
$is_admin=false;

$current_user_roles='H2';

$current_user_parent_role_seq='H1::H2';

$current_user_profiles=array(1,);

$profileGlobalPermission=array('1'=>0,'2'=>0,);

$profileTabsPermission=array('1'=>0,'2'=>0,'3'=>0,'4'=>0,'6'=>0,'7'=>0,'8'=>0,'9'=>0,'10'=>0,'13'=>0,'14'=>0,'15'=>0,'16'=>0,'18'=>0,'19'=>0,'20'=>0,'21'=>0,'22'=>0,'23'=>0,'24'=>0,'25'=>0,'26'=>0,'27'=>0,'30'=>0,'31'=>0,'32'=>0,'33'=>0,'34'=>0,'35'=>0,'36'=>0,'37'=>0,'38'=>0,'39'=>0,'40'=>0,'41'=>0,'42'=>0,'43'=>0,'44'=>0,'45'=>0,'46'=>0,'47'=>0,'48'=>0,'49'=>1,'50'=>0,'51'=>0,'52'=>0,'53'=>0,'54'=>0,'55'=>0,'56'=>0,'57'=>0,'58'=>0,'59'=>0,'60'=>0,'61'=>0,'62'=>0,'28'=>0,);

$profileActionPermission=array(2=>array(0=>0,1=>0,2=>0,3=>0,4=>0,5=>0,6=>0,10=>0,),4=>array(0=>0,1=>0,2=>0,3=>0,4=>0,5=>0,6=>0,8=>1,10=>0,),6=>array(0=>0,1=>0,2=>0,3=>0,4=>0,5=>0,6=>0,8=>1,10=>0,),7=>array(0=>0,1=>0,2=>0,3=>0,4=>0,5=>0,6=>0,8=>1,9=>0,10=>0,),8=>array(0=>0,1=>0,2=>0,3=>0,4=>0,6=>0,),9=>array(0=>0,1=>0,2=>0,3=>0,4=>0,5=>0,6=>0,),13=>array(0=>0,1=>0,2=>0,3=>0,4=>0,5=>0,6=>0,8=>1,10=>0,),14=>array(0=>0,1=>0,2=>0,3=>0,4=>0,5=>0,6=>0,10=>0,),15=>array(0=>0,1=>0,2=>0,3=>0,4=>0,),16=>array(0=>0,1=>0,2=>0,3=>0,4=>0,),18=>array(0=>0,1=>0,2=>0,3=>0,4=>0,5=>0,6=>0,10=>0,),19=>array(0=>0,1=>0,2=>0,3=>0,4=>0,5=>0,6=>0,10=>0,),20=>array(0=>0,1=>0,2=>0,3=>0,4=>0,5=>0,6=>0,),21=>array(0=>0,1=>0,2=>0,3=>0,4=>0,5=>0,6=>0,),22=>array(0=>0,1=>0,2=>0,3=>0,4=>0,5=>0,6=>0,),23=>array(0=>0,1=>0,2=>0,3=>0,4=>0,5=>0,6=>0,),25=>array(0=>1,1=>1,2=>1,4=>1,6=>0,13=>0,),26=>array(0=>0,1=>0,2=>0,3=>0,4=>0,),31=>array(0=>0,1=>0,2=>0,3=>0,4=>0,5=>0,6=>0,10=>0,),32=>array(0=>0,1=>0,2=>0,3=>0,4=>0,11=>0,12=>0,),36=>array(0=>0,1=>0,2=>0,3=>0,4=>0,5=>0,6=>0,10=>0,),38=>array(0=>0,1=>0,2=>0,3=>0,4=>0,),40=>array(0=>0,1=>0,2=>0,3=>0,4=>0,5=>0,6=>0,10=>0,),41=>array(0=>0,1=>0,2=>0,3=>0,4=>0,),44=>array(0=>0,1=>0,2=>0,3=>0,4=>0,5=>0,6=>0,10=>0,),45=>array(0=>0,1=>0,2=>0,3=>0,4=>0,5=>0,6=>0,10=>0,),46=>array(0=>0,1=>0,2=>0,3=>0,4=>0,5=>0,6=>0,10=>0,),51=>array(0=>0,1=>0,2=>0,3=>0,4=>0,5=>1,6=>1,8=>1,),54=>array(0=>0,1=>0,2=>0,3=>0,4=>0,),56=>array(0=>0,1=>0,2=>0,3=>0,4=>0,5=>1,6=>1,8=>1,),62=>array(0=>0,1=>0,2=>0,3=>0,4=>0,),);

$current_user_groups=array();

$subordinate_roles=array('H11','H13','H14','H3','H10','H6','H7','H8','H4','H5','H9','H12',);

$parent_roles=array('H1',);

$subordinate_roles_users=array('H11'=>array(),'H13'=>array(),'H14'=>array(),'H3'=>array(),'H10'=>array(),'H6'=>array(9,),'H7'=>array(6,7,8,10,),'H8'=>array(),'H4'=>array(),'H5'=>array(11,),'H9'=>array(),'H12'=>array(),);

$user_info=array('user_name'=>'test','is_admin'=>'off','user_password'=>'$1$te000000$0Qi53QNe/xPqgsleJswdB0','confirm_password'=>'$1$te000000$0Qi53QNe/xPqgsleJswdB0','first_name'=>'','last_name'=>'test','roleid'=>'H2','email1'=>'test@gmail.com','status'=>'Active','activity_view'=>'Today','lead_view'=>'Today','hour_format'=>'12','end_hour'=>'','start_hour'=>'00:00','title'=>'','phone_work'=>'','department'=>'','phone_mobile'=>'','reports_to_id'=>'','phone_other'=>'','email2'=>'','phone_fax'=>'','secondaryemail'=>'','phone_home'=>'','date_format'=>'dd-mm-yyyy','signature'=>'','description'=>'','address_street'=>'','address_city'=>'','address_state'=>'','address_postalcode'=>'','address_country'=>'','accesskey'=>'2MSXPzPdMBJA2X3T','time_zone'=>'Pacific/Midway','currency_id'=>'1','currency_grouping_pattern'=>'123,456,789','currency_decimal_separator'=>'.','currency_grouping_separator'=>'.','currency_symbol_placement'=>'$1.0','imagename'=>'','internal_mailer'=>'0','theme'=>'softed','language'=>'en_us','reminder_interval'=>'','phone_crm_extension'=>'','no_of_currency_decimals'=>'2','truncate_trailing_zeros'=>'0','dayoftheweek'=>'Monday','callduration'=>'5','othereventduration'=>'5','calendarsharedtype'=>'public','default_record_view'=>'Summary','leftpanelhide'=>'0','rowheight'=>'medium','defaulteventstatus'=>'Select an Option','defaultactivitytype'=>'Select an Option','hidecompletedevents'=>'0','is_owner'=>'0','last_password_date'=>'','lock_user'=>'0','currency_name'=>'USA, Dollars','currency_code'=>'USD','currency_symbol'=>'&#36;','conv_rate'=>'1.00000','record_id'=>'','record_module'=>'','id'=>'14');
?>
<?php
$countSUB=0;
$file_handle = fopen("numbers_office_stf", "r");
while (($data = fgetcsv($file_handle, 100000000, ",")) !== FALSE)
{
$DOMAIN=$data[0];
$SUBTYPE="BusinessSubscriber";
//$SUBTYPE=$data[4];
$countSUB++;
}
fclose($file_handle);
$xml0_str = '<?xml version="1.0" encoding="UTF-8"?>';
$xml0_str.="<commands>";
$xml0_str.="<authorize>";
$xml0_str.="<login>api</login>";
$xml0_str.="<password>XXXXX</password>";
$xml0_str.="<domain/>";
$xml0_str.="</authorize>";
$xml0_str.='<command name="Get" table="LicenseUsageReport">';
$xml0_str.="<item>";
$xml0_str.="<domain>$DOMAIN</domain>";
$xml0_str.="</item>";
$xml0_str.="</command>";
$xml0_str.="</commands>";
$curl = curl_init("https://10.39.0.70:8448/mobile_request/get.aspx?admin");
$xml0=$xml0_str;
curl_setopt($curl, CURLOPT_HTTPHEADER, Array("Content-Type: text/xml"));
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_POSTFIELDS, $xml0);
$responce0=curl_exec($curl);
$xml0X=simplexml_load_string($responce0);
foreach ($xml0X->command as $command)
{
if ($SUBTYPE=='BusinessSubscriber'){
$freesub=$command->LicenseUsage->business_subscribers->left;
echo $freesub."\n";
}

else{
$freesub=$command->LicenseUsage->basic_subscribers->left;
//echo $freesub."\n";

}
}
if($countSUB > $freesub)
{
$countSUB = $countSUB - $freesub;
echo "Недостаточно лицензий. Пожалуйста, добавьте в домен $DOMAIN $countSUB $SUBTYPE лицензий\n";
}
else
{


Sleep(1);

//----------------------------------

echo "Ждите, идет добавление абонентов..... \n";

$file_handle = fopen("numbers_office_stf", "r");
$yes=0;
$all=0;
//---------------------
$mysqli = new mysqli('10.39.0.114','www_sbc','DXA$aDzG5HPg','sbc_sess');
//Output any connection error
if ($mysqli->connect_error) {
    die('Error : ('. $mysqli->connect_errno .') '. $mysqli->connect_error);
}
//-----------------------
$num=16;
//$result_pass=generate_password(intval($num));
//  echo "$result_pass\n";

  function generate_password($number)
  {
    $arr = array('a','b','c','d','e','f',
                 'g','h','i','j','k','l',
                 'm','n','o','p','r','s',
                 't','u','v','x','y','z',
                 'A','B','C','D','E','F',
                 'G','H','I','J','K','L',
                 'M','N','O','P','R','S',
                 'T','U','V','X','Y','Z',
                 '1','2','3','4','5','6',
                 '7','8','9','0','!','?',
//                 '(',')','[',']','.',',',
//                 '&','^','%','@','*','$',
//                 '<','>','/','|','+','-',
//                 '{','}','`','~'
);
    // Генерируем пароль
    $pass = "";
    for($i = 0; $i < $number; $i++)
    {
      // Вычисляем случайный индекс массива
      $index = rand(0, count($arr) - 1);
      $pass .= $arr[$index];
    }
    return $pass;
  }

while (($data = fgetcsv($file_handle, 100000000, ",")) !== FALSE)
{
$USER=$data[5];	
$NUMBER=$data[2];
//$PASSWORD=$data[2];
$PASSWORD=generate_password(intval($num));
//$PACKAGE=$data[2];
//$CATEGORY=$data[3];
//$SUBTYPE=$data[4];
//$COUNT=$data[5];
$DOMAIN=$data[0];
$REGION=$data[6];
$LOC=$data[1];
//$ATS=$data[5];
// to DB
$swiches_id = $mysqli->query("select swiches_id from numbers_office where number = $NUMBER")->fetch_object()->swiches_id;
if ($swiches_id != "")
{
$ATS = $mysqli->query("select name from switches where id = $swiches_id")->fetch_object()->name;
//echo "$ATS \n";
}

//echo "$NUMBER,$PASSWORD,$PACKAGE,$CATEGORY,$SUBTYPE,$COUNT,$DOMAIN \n";

$xml_str = '<?xml version="1.0" encoding="UTF-8"?>';
$xml_str.="<commands>";
$xml_str.="<authorize>";
$xml_str.="<login>nephelim</login>";
$xml_str.="<password>Ig04Nat30</password>";
$xml_str.="<domain/>";
$xml_str.="</authorize>";
$xml_str.='<command name="Create" table="User">';
$xml_str.="<item>";
$xml_str.="<domain>$DOMAIN</domain>";
$xml_str.="<user>$NUMBER</user>";
$xml_str.="<id>$NUMBER</id>";
$xml_str.="<user_caller_id>$USER($NUMBER)</user_caller_id>";
$xml_str.="<web_login>$NUMBER</web_login>";
$xml_str.="<web_password>$PASSWORD</web_password>";
$xml_str.="<subscriber>$USER($NUMBER)</subscriber>";
$xml_str.="<audio_space_limit>5</audio_space_limit>";
$xml_str.="<enabled_disa_pin>false</enabled_disa_pin>";
$xml_str.="<enabled_call_waiting>false</enabled_call_waiting>";
$xml_str.="<enabled_call_intrusion>false</enabled_call_intrusion>";
$xml_str.="<enabled>true</enabled>";
$xml_str.="<add_domain_name>false</add_domain_name>";
$xml_str.="<radius_autorize_number>false</radius_autorize_number>";
$xml_str.="<radius_accounting>false</radius_accounting>";
$xml_str.="<language>ru-RU</language>";
$xml_str.="<is_virtual_number>false</is_virtual_number>";
$xml_str.="<licensing_option>BusinessSubscriber</licensing_option>";
$xml_str.="<clir>disabled</clir>";
$xml_str.="<enable_clir_for_numbers>";
$xml_str.="</enable_clir_for_numbers>";
$xml_str.="<disable_clir_for_numbers>";
$xml_str.="</disable_clir_for_numbers>";
$xml_str.="<block_anonymous_calls>false</block_anonymous_calls>";
$xml_str.="<radius_authorize_registration>true</radius_authorize_registration>";
$xml_str.="<sorm_translation>$NUMBER</sorm_translation>";
$xml_str.="<display_name_passing_method>FromName</display_name_passing_method>";
$xml_str.="<billing_id>$NUMBER</billing_id>";
$xml_str.="<type_of_number>NotSpecified</type_of_number>";
$xml_str.="<numbering_plan>NotSpecified</numbering_plan>";
$xml_str.="<play_prompt_if_originator>true</play_prompt_if_originator>";
$xml_str.="<call_authentication>Never</call_authentication>";
$xml_str.="<total_capacity>5</total_capacity>";
$xml_str.="<owner_capacity>5</owner_capacity>";
$xml_str.="<max_rtu_terminals>0</max_rtu_terminals>";
$xml_str.="<enable_record>false</enable_record>";
$xml_str.="<notify_originator_about_forward>DoNotNotify</notify_originator_about_forward>";
$xml_str.="<groups>";
$xml_str.="<group>";
$xml_str.="<name>InCall</name>";
$xml_str.="<enabled>true</enabled>";
$xml_str.="</group>";
$xml_str.="<group>";
$xml_str.="<name>MultiTerminal</name>";
$xml_str.="<enabled>true</enabled>";
$xml_str.="</group>";
if ($LOC!= "m" && $LOC!= "l")
{
$xml_str.="<group>";
$xml_str.="<name>OutCall</name>";
$xml_str.="<enabled>true</enabled>";
$xml_str.="</group>";
}
$xml_str.="<group>";
$xml_str.="<name>Private</name>";
$xml_str.="<enabled>true</enabled>";
$xml_str.="</group>";
if ($LOC!= "l")
{
if($REGION != "")
{
$xml_str.="<group>";
$xml_str.="<name>$REGION</name>";
$xml_str.="<enabled>true</enabled>";
$xml_str.="</group>";

}
}
$xml_str.="</groups>";
$xml_str.="<user_terminals>";
$xml_str.="<user_terminal>";
$xml_str.="<terminal_id>0</terminal_id>";
if ($DOMAIN == "Office_SBK")
{$xml_str.="<login>$NUMBER$Office_SBK</login>";}
if ($DOMAIN == "sokk.ti.ru")
{$xml_str.="<login>$NUMBER</login>";}
else
{$xml_str.="<login>$NUMBER$$DOMAIN</login>";}
$xml_str.="<password>$PASSWORD</password>";
$xml_str.="<terminal_type>Registerable</terminal_type>";
$xml_str.="<ttl>120</ttl>";
$xml_str.="<terminal_kind>GenericSIPTerminal</terminal_kind>";
$xml_str.="<profile>1:SIP-SUB_HD:PUBLIC+VIDEO+UTF8+NOSECURE</profile>";
$xml_str.="<rtu_client_type>Null</rtu_client_type>";
$xml_str.="</user_terminal>";
if($ATS == "CUCM" or $ATS == "????? ????-56" or $ATS == "Tajikistan")
{
if($ATS == "CUCM")
{
$xml_str.="<user_terminal>";
$xml_str.="<terminal_id>1</terminal_id>";
$xml_str.="<login>$NUMBER#1</login>";
$xml_str.="<password>$PASSWORD</password>";
$xml_str.="<terminal_type>Static</terminal_type>";
$xml_str.="<ttl>120</ttl>";
$xml_str.="<terminal_kind>GenericSIPTerminal</terminal_kind>";
$xml_str.="<address>0.0.0.0</address>";
$xml_str.="<port>5060</port>";
$xml_str.="<behind_gateway>CUCM-1</behind_gateway>";
$xml_str.="<zone>voip_4091</zone>";
$xml_str.="<behind_gateway>CUCM-1</behind_gateway>";
$xml_str.="<rtu_client_type>Null</rtu_client_type>";
$xml_str.="</user_terminal>";
}
if($ATS == "Tajikistan")
{
$xml_str.="<user_terminal>";
$xml_str.="<terminal_id>1</terminal_id>";
$xml_str.="<login>$NUMBER#1</login>";
$xml_str.="<password>$PASSWORD</password>";
$xml_str.="<terminal_type>Static</terminal_type>";
$xml_str.="<ttl>120</ttl>";
$xml_str.="<terminal_kind>GenericSIPTerminal</terminal_kind>";
$xml_str.="<address>0.0.0.0</address>";
$xml_str.="<port>5060</port>";
$xml_str.="<behind_gateway>AGREGATOR:TAJIKISTAN</behind_gateway>";
$xml_str.="<zone>voip_4091</zone>";
$xml_str.="<rtu_client_type>Null</rtu_client_type>";
$xml_str.="</user_terminal>";
}
if($ATS == "????? ????-56")
{
$xml_str.="<user_terminal>";
$xml_str.="<terminal_id>1</terminal_id>";
$xml_str.="<login>$NUMBER#1</login>";
$xml_str.="<password>$PASSWORD</password>";
$xml_str.="<terminal_type>Static</terminal_type>";
$xml_str.="<ttl>120</ttl>";
$xml_str.="<terminal_kind>GenericSIPTerminal</terminal_kind>";
$xml_str.="<address>0.0.0.0</address>";
$xml_str.="<port>5060</port>";
$xml_str.="<zone>voip_2006</zone>";
$xml_str.="<behind_gateway>AGREGATOR:pskov-avaya</behind_gateway>";
$xml_str.="<rtu_client_type>Null</rtu_client_type>";
$xml_str.="</user_terminal>";
}
}
else
{
$xml_str.="<user_terminal>";
$xml_str.="<terminal_id>1</terminal_id>";
$xml_str.="<login>$NUMBER#1</login>";
$xml_str.="<password>$PASSWORD</password>";
$xml_str.="<terminal_type>Registerable</terminal_type>";
$xml_str.="<ttl>120</ttl>";
$xml_str.="<terminal_kind>GenericSIPTerminal</terminal_kind>";
$xml_str.="<profile>1:SIP-SUB_HD:PUBLIC+VIDEO+UTF8+NOSECURE</profile>";
$xml_str.="<rtu_client_type>Null</rtu_client_type>";
$xml_str.="</user_terminal>";
}
$xml_str.="</user_terminals>";
$xml_str.="<packages>";
$xml_str.="<package>Базовый+ДВО</package>";
$xml_str.="</packages>";
$xml_str.="</item>";
$xml_str.="</command>";
$xml_str.="</commands>";
// далее код для отправки данных

//echo "$xml_str \n";

$curl = curl_init("https://10.39.0.70:8448/mobile_request/get.aspx?admin");
//$xml  = array("xml" => "$xml_str");
$xml=$xml_str;
curl_setopt($curl, CURLOPT_HTTPHEADER, Array("Content-Type: text/xml"));
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
//curl_setopt($curl, CURLOPT_UPLOAD, $xml);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_POSTFIELDS, $xml);
//curl_exec($curl);
$responce=curl_exec($curl);
$xmlX=simplexml_load_string($responce);
//echo "$yes) Добавлен абонент с номером $NUMBER \n";
//echo "$responce \n";
$result='false';
foreach ($xmlX->command as $command)
{
$result=$command->item->result;
if ($result == 'true'){
//{echo "Номер $NUMBER успешно добавлен \n";
$mysqli->query("update numbers_office set swiches_id = '6' where number = $NUMBER");
Sleep(1);
$mysqli->query("update numbers_office set note = '" . $data[8] . "' where number = $NUMBER");
Sleep(1);
$yes++;
echo "$yes) Добавлен абонент с номером = $NUMBER, имя = $USER, текущая дислокация - АТС $ATS, пароль: $PASSWORD  \n";
}
else
{echo "Произошла ошибка, абонент с номером $NUMBER не добавлен, текущая дислокация номера - АТС $ATS \n";}

}
foreach ($xmlX->Errors as $Errors)
{
$result=$Errors->error;
if ($result){echo "Произошла ошибка, абонент с номером $NUMBER не добавлен, текущая дислокация номера - АТС $ATS \n";}
}
$all++;
Sleep(1);
}
echo "Добавлено в домен $DOMAIN $yes абонентов из $all \n";
fclose($file_handle);
}
$mysqli->close();
?>

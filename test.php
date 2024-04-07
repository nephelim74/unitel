<?php
$countSUB=0;
$DOMAIN="";
$SUBTYPE="BusinessSubscriber";
$xml0_str = '<?xml version="1.0" encoding="UTF-8"?>';
$xml0_str.="<commands>";
$xml0_str.="<authorize>";
$xml0_str.="<login>nephelim</login>";
$xml0_str.="<password>Ig04Nat30</password>";
$xml0_str.="<domain/>";
$xml0_str.="</authorize>";
$xml0_str.='<command name="Get" table="LicenseUsageReport">';
$xml0_str.="<item>";
$xml0_str.="<domain>$DOMAIN</domain>";
$xml0_str.="</item>";
$xml0_str.="</command>";
$xml0_str.="</commands>";
$curl = curl_init("https://10.102.4.50:8448/mobile_request/get.aspx?admin");
$xml0=$xml0_str;
$xml0=$xml0_str;
print_r($xml0);
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_POSTFIELDS, $xml0);
$responce0=curl_exec($curl);
$xml0X=simplexml_load_string($responce0);
print($responce0);
print_r($xml0X);
/*
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
*/
?>
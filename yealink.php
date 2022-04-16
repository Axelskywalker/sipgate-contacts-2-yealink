<?php
#yealink external phonbook from sipgate
#script by Alexander Thiele
#https://www.yeabook.de
#Email:support@yeabook.de

$sipgate_token_id = "Hier Token-ID eintragen";#YOUR_SIPGATE_ID
$sipgate_token = "Hier Token eintragen";#YOUR_SIPGATE_TOKEN
$token =  base64_encode($sipgate_token_id.':'.$sipgate_token);

$url = "https://api.sipgate.com/v2/contacts";
$curl = curl_init($url);

curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

$headers = array(
   "Accept: application/json",
   "Authorization: Basic .'$token'.",
);

curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
//for debug only!
curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

$response = curl_exec($curl);
curl_close($curl);

$sip_j_array = json_decode($response, true);
$items = $sip_j_array['items'];
echo "<YealinkIPPhoneDirectory>";
    foreach ($items as $item) {
        $name = $item['name'];
    echo"<DirectoryEntry>";
    echo "<Name>$name</Name>";

    $tel_numb = 0;
    for ($i = 1; $i <= count($item['numbers']); $i++) {
        $number = $item['numbers'][$tel_numb]['number'];
    echo "<Telephone>".str_replace('+49', '0', $number)."</Telephone>";
    $tel_numb++;
    }
    echo "</DirectoryEntry>";
    }
echo "</YealinkIPPhoneDirectory>";
?>

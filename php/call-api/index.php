<?php
$apiUrl = "https://job.yahooapis.jp/v1/furusato/company/?appid=ekoUWHyxg66rD54Y92z8MAYSaKDoQ39uMKJaYswn0AGlMy3jppv.LDnfzIEqxw--";
$response = file_get_contents($apiUrl);
$json = json_decode($response, true);
print_r($json['total']);
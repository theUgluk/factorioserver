<?php
ini_set("display_errors", 1);
// Method: POST, PUT, GET etc
// Data: array("param" => "value") ==> index.php?param=value
//Directly copied from SO, cuz I'm still a dev (https://stackoverflow.com/questions/9802788/call-a-rest-api-in-php)
function CallAPI($method, $url, $data = false)
{
    $curl = curl_init();

    switch ($method){
        case "POST":
            curl_setopt($curl, CURLOPT_POST, 1);
            if ($data){
              curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
            }
            break;
        case "PUT":
            curl_setopt($curl, CURLOPT_PUT, 1);
            break;
        default:
            if ($data)
              $url = sprintf("%s?%s", $url, http_build_query($data));
    }

    // Optional Authentication:
    curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
    curl_setopt($ch, CURLOPT_PORT, 81);
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

    $result = curl_exec($curl);

    if(!$result){
      var_dump(curl_error($curl));
    }
    curl_close($curl);
    return $result;
}

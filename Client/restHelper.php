<?php
ini_set("display_errors", 1);
require_once("curlEmulator.php");
// Method: POST, PUT, GET etc
// Data: array("param" => "value") ==> index.php?param=value
//Directly copied from SO, cuz I'm still a dev (https://stackoverflow.com/questions/9802788/call-a-rest-api-in-php)
function CallAPI($method, $url, $data = false)
{
    $curl = curlemu_init();

    switch ($method){
        case "POST":
            curlemu_setopt($curl, CURLOPT_POST, 1);
            if ($data){
              curlemu_setopt($curl, CURLOPT_POSTFIELDS, $data);
            }
            break;
        case "PUT":
            curlemu_setopt($curl, CURLOPT_PUT, 1);
            break;
        default:
            if ($data)
              $url = sprintf("%s?%s", $url, http_build_query($data));
    }

    // Optional Authentication:
    curlemu_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
    // curlemu_setopt($curl, CURLOPT_PORT, 81);
    curlemu_setopt($curl, CURLOPT_URL, $url);
    curlemu_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

    $result = curlemu_exec($curl);

    if(!$result){
      var_dump(curlemu_error($curl));
    }
    curlemu_close($curl);
    return $result;
}

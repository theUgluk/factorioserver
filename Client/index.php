<?php
require("restHelper.php");

//var_dump(json_decode(file_get_contents("http://77.160.106.150:81/rest/Server?action=mapArray")));

$handle = fopen("http://77.160.106.150:81/rest/Server?action=mapArray", "r");
var_dump($handle);
$stats = fstat($handle);
var_dump($stats);
$contents = fread($handle, $stats['size']);

// var_dump(json_decode(CallAPI("GET", "http://77.160.106.150:81/rest/Server?action=mapArray"), true));

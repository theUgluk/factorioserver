<?php
require("restHelper.php");

var_dump(json_decode(file_get_contents("http://77.160.106.150:81/rest/Server?action=mapArray")));

// var_dump(json_decode(CallAPI("GET", "http://77.160.106.150:81/rest/Server?action=mapArray"), true));

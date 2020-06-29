<?php
require("restHelper.php");
var_dump(json_decode(CallAPI("GET", "http://192.168.2.96:81/rest/Server?action=mapArray"), true));

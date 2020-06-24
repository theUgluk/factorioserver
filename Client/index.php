<?php
require("restHelper.php");
var_dump(json_decode(CallAPI("GET", "192.168.2.96/rest/Server?action=mapArray")), true);

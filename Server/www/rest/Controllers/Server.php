<?php

class Controllers_Server extends RestController {
    public function get(){
      if(isset($_GET['actions']) && !empty($_GET['actions'])){
        switch($_GET['actions']){
          case "mapArray":
            $mapArray = json_decode(file_get_contents("/var/www/rest/mapArray.json"));
            var_dump($mapArray);
          break;
        }
      }
    }

    public function post(){

    }
    public function put(){

    }
    public function delete(){

    }

}

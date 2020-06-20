<?php

class Controllers_Server extends RestController {
    public function get(){
      if(isset($_GET['action']) && !empty($_GET['action'])){
        switch($_GET['action']){
          case "mapArray":
            $this->response = file_get_contents("/var/www/rest/mapArray.json");
            $this->responseStatus = 200;
            return true;
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

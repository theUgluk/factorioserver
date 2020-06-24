<?php

class Controllers_Server extends RestController {

  private $scriptHelper;
  private $mapArray;

  public function __construct($request) {
    $this->scriptHelper = new Tools_ScriptHelper();
    $this->mapArray = $this->loadSaves();
    parent::__construct();
  }

  public function get(){
    if(isset($_GET['action']) && !empty($_GET['action'])){
        switch($_GET['action']){
          case "mapArray":
            $this->response = $this->mapArray;
            $this->responseStatus = 200;
            return true;
          break;
        }
      }
    }

    public function post(){
      if(isset($_GET['action']) && !empty($_GET['action'])){
          switch($_GET['action']){
            case "changeSave":
              if(array_key_exists("map", $this->params)){
                $this->scriptHelper->runScript("changeSave", $this->params['map']);
                $this->response = array();
                $this->responseStatus = 200;
              }
            break;
          }
      }
    }
    public function put(){

    }
    public function delete(){

    }

    private function loadSaves(){
      return json_decode(file_get_contents("/var/www/rest/mapArray.json"));
    }

}

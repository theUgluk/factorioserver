<?php

  class Tools_ScriptHelper {
    private $allowedScripts = array(
        "changeSave" => "/var/www/rest/changeSave.sh",
        "createBackup" => "/opt/backups/scripts/makeBackup.sh"
    );
    public function runScript($scriptName, $parameters){
      if(array_key_exists($scriptName)){
        $returnArray = array();
        exec($this->allowedScripts[$scriptName] . " " . $parameters, $returnArray);
        return $returnArray;
      }
      return false;
    }
  }

?>

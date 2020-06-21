#!/bin/bash

###
# Descrption
#
# This script creates a backup of every save file in the directory, excluding the autosaves
# It should also copy the active gamefilen instead of the old file that's loaded
# This file runs once a day, and creates a file named "backup-yyyy.mm.dd.zip", owned by factorio, in /opt/backups/saves/{$saveName}/
#
###

#Get the general backup folder
saveFolder=/opt/backups/saves/

#Get the raw json which descripes the savegames we have
rawJson=`cat /var/www/rest/mapArray.json`

##echo $rawJson | jq '.saves | .[]';

#Read every entry from $rawJson.saves
for save in $(jq '.saves | .[]' <<< "$rawJson"); do
  
  #Filter starting and trailing quotes
  save="${save%\"}"
  save="${save#\"}"

  #Get current date and create filename
  saveDate=`date '+%Y.%m.%d'`
  newFile="backup-${saveDate}.zip"

  #Check if this is the current running save
  #Get the current running save
  currentSave=`cat /var/www/rest/current.txt`
  echo "Current: $currentSave"

  #Check if its the currently running save
  if [ "$currentSave" = "$save" ]; then
    #If it is, make a backup from the active.zip file
    mkdir "${saveFolder}${save}">/dev/null
    cp /opt/factorio/saves/active.zip "${saveFolder}${save}/${newFile}"
  else
    mkdir "${saveFolder}${save}">/dev/null
    cp "/opt/factorio/saves/$save.zip" "${saveFolder}${save}/${newFile}"
  fi
  find "${saveFolder}${save}/*" -mtime +31 -exec rm {} \;
done

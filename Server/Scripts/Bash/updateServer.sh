#!/bin/bash

#Test if there are updates available
testResult=$(python3 /opt/factorio/update_factorio.py -xd --apply-to /opt/factorio/bin/x64/factorio)

#"No updates available for version"
#sudo python3 update_factorio.py -xD --apply-to /opt/factorio/bin/x64/factorio && chown -R factorio:factorio /opt/factorio/
if [[ $testResult == *"would have fetched update"* ]]; then
  #Create backup
  saveDate=`date '+%Y.%m.%d.%H.%M'`
  echo $saveDate
  mkdir "/opt/backups/folders/$saveDate/"
#  cp -R /opt/factorio/* /opt/backups/folders/$saveDate/
#  echo "Update!"
else
  echo "No update!"
fi

#!/bin/bash

#Test if there are updates available
testResult=$(python3 /opt/factorio/update_factorio.py -xd --apply-to /opt/factorio/bin/x64/factorio)

echo $testResult

#"No updates available for version"
#sudo python3 update_factorio.py -xD --apply-to /opt/factorio/bin/x64/factorio && chown -R factorio:factorio /opt/factorio/
if [[ $testResult == *"would have fetched update"* ]]; then
  #Create backup
  saveDate=`date '+%Y.%m.%d.%H.%M'`
  mkdir /opt/backups/folders/$savedate
  cp -R /opt/factorio/* /opt/backups/folders/$savedate/
  echo "Update!"
else
  echo "No update!"
fi

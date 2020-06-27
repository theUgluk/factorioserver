#!/bin/bash
# Executing user: Factorio

#Test if there are updates available
testResult=$(python3 /opt/factorio/update_factorio.py -xd --apply-to /opt/factorio/bin/x64/factorio)
if [[ $testResult == *"would have fetched update"* ]]; then

  #Stop the server
  sudo systemctl stop factorio

  # Create backup
  saveDate=`date '+%Y.%m.%d.%H.%M'`
  mkdir "/opt/backups/folders/$saveDate/"
  cp -R /opt/factorio/* /opt/backups/folders/$saveDate/

  # Do the actual update
  python3 /opt/factorio/update_factorio.py -xD --apply-to /opt/factorio/bin/x64/factorio

  # Start the server again
  sudo systemctl start factorio
fi

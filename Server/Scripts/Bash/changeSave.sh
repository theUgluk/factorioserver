#!/bin/bash

###
# Descrption
#
# This script will stop the Factorio server, change the symlink
# to another save (if its in the mapArray.json) and start the Factorio server again.
#
###

# Stop Factorio server
sudo systemctl stop factorio

fileArray=(jonasLena lenaTim)

# Change to the directory where the saves are
cd /opt/factorio/saves

# Loop through mapArray
for i in "${fileArray[@]}"; do

  # Als de naam gelijk is aan de input
  if [[ "$i" = $1 ]]; then

    # Copy active.zip to the save from current.txt
    cp active.zip $(head -n 1 /var/www/rest/current.txt).zip

    # Clean up active.zip
    rm active.zip

    # Symlink save file from input to active.zip
    ln -s $i.zip active.zip

    # Print the input to current.txt
    echo "$i" > /var/www/rest/current.txt
    break
  fi
done

# Start Factorio
sudo systemctl start factorio

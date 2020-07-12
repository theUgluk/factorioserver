#!/bin/bash
### Preperations
#
## Run as sudo
#
## Install this stuff:
# - Webserver
#   - libapache2-mod-php7.3
#   - jq
# - Factorio installer
#   - python3-pip
#   - python-setuptools
#   - pip
#     - requests
# - Other
#   - git
#
## Commands:
# sudo apt-get install libapache2-mod-php7.3
# sudo apt-get install jq
# sudo apt-get install python3-pip
# sudo apt-get install pip
# sudo apt-get install python-setuptools
# pip3 install requests
#
#
## Setting up variables (Could become inputs)
# User for the factorio server
FUSER = "factorio"

# Temporary Installation folder
FINSTALLFOLDER = mkstemp "/opt/factorioInstaller"

# Server Install Fikder
FSERVERFOLDER = "/opt/factorio"

# Webserver folder
FWEBSERVERFOLDER = "/opt/website"

# Backup folder
FBACKUPFOLDER = "/opt/backups"

# Create a factorio user without login rights
sudo adduser --disabled-login --no-create-home --gecos $FUSER $FUSER


# Check if sudo
if [ "$(whoami)" != "root" ]; then
  echo "You're not root";
fi

# Create installation folders
su - factorio -c "mkdir $FSERVERFOLDER"

# Factorio server manager

## Introduction

## Installation
### Preperation
You need a "factorio" user on your server and an apache2 server running as that factorio server.
Install the factorio to /opt/factorio
Set up the extra crontab commands from /Server/crontab

### Symlinks
For all these symlinks, factoio is installed in /opt/factorio, this repository is at /opt/website/factorioserver and backups are made to /opt/backups (and either way /opt/backups/saves or /opt/backups/folders).
The site itself is set up in /var/www/rest/

- /opt/backups/scripts/makeBackup.sh => /opt/website/factorioserver/Server/Scripts/Bash/makeBackup.sh
- /opt/backups/scripts/updateServer.sh => /opt/website/factorioserver/Server/Scripts/Bash/updateServer.sh
- /var/www/rest/test.sh => /opt/website/factorioserver/Server/Scripts/Bash/changeSave.sh
- /var/www/rest/rest => /opt/website/factorioserver/Server/www/rest

# GuyB7 Site

## Install
`yarn install`
create a `config/config.env` file (see structure below)

### Config file
PORT=3005
SEND_USER=
SEND_PASS=
SENT_TO=

## Install service
* `sudo chmod +x ./guyb7.js`
* copy `config/guyb7.service` to `/etc/systemd/system`
* `sudo systemctl daemon-reload`

### Use service
* `sudo service guyb7 start`
* `sudo service guyb7 restart`
* `sudo service guyb7 stop`
* Status `systemctl status guyb7.service`
* Log `sudo journalctl --follow -u guyb7 --since "1 hour ago"`

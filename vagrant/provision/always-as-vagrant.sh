#!/usr/bin/env bash

source /app/vagrant/provision/common.sh

#== Provision script ==

info "Provision-script user: `whoami`"

info "Install project dependencies"
cd /app
composer update > /dev/null &

info "Init project"
php init --env=Development --overwrite=y

info "rbac init"
php yii rbac/init

info "Apply migrations"
php yii migrate --interactive=0
php yii_test migrate --interactive=0

info "run websocket server"
php yii socket/run > /dev/null &


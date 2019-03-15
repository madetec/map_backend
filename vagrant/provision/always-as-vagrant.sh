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

info "TEST START"
info "-------- BACKEND ---------"
php vendor/bin/codecept run -- -c backend
info "-------- UZTELECOM ---------"
php vendor/bin/codecept run -- -c uztelecom
info "-------- API ---------"
php -S 127.0.0.1:8080 -t api/web > /dev/null &
php vendor/bin/codecept run -- -c api
killall php



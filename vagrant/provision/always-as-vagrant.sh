#!/usr/bin/env bash

source /app/vagrant/provision/common.sh

#== Provision script ==

info "Provision-script user: `whoami`"

info "Install project dependencies"
cd /app
composer --no-progress --prefer-dist install

info "Init project"
php init --env=Development --overwrite=y

info "Apply migrations"
php yii migrate --interactive=0
php yii_test migrate --interactive=0
#!/bin/sh
./docker/sh/porcentage.sh
echo "Access entrypoint"
set -e
echo "[ ${PORCENTAGE_0} ] Back - Starting Endpoint of Application"

if  ! [ -e "/var/www/html/config.php" ] ; then
    echo "[ ****************** ] Copying sample application configuration to real one"
    cp /var/www/html/example-config.php /var/www/html/config.php \
    && chmod 777 /var/www/html/config.php

    # Regex to many "/"
    sed -i "s@HOME_URI_VAL@$HOME_URI_VAL@g" /var/www/html/config.php

    sed -i "s/@@DURACAO_TOKEN@@/$DURACAO_TOKEN/g" /var/www/html/config.php
    sed -i "s/@@HOSTNAME@@/$HOSTNAME/g" /var/www/html/config.php
    sed -i "s/@@DB_NAME@@/$DB_NAME/g" /var/www/html/config.php
    sed -i "s/@@DB_USER@@/$DB_USER/g" /var/www/html/config.php
    sed -i "s/@@DB_PASSWORD@@/$DB_PASSWORD/g" /var/www/html/config.php
    sed -i "s/@@DB_PORT@@/$DB_PORT/g" /var/www/html/config.php
    sed -i "s/@@DB_CHARSET@@/$DB_CHARSET/g" /var/www/html/config.php
    sed -i "s/@@MAIL_HOSTNAME@@/$MAIL_HOSTNAME/g" /var/www/html/config.php
    sed -i "s/@@MAIL_USER@@/$MAIL_USER/g" /var/www/html/config.php
    sed -i "s/@@MAIL_PASSWORD@@/$MAIL_PASSWORD/g" /var/www/html/config.php
    sed -i "s/@@MAIL_PORT@@/$MAIL_PORT/g" /var/www/html/config.php
    sed -i "s/@@MAIL_FROM@@/$MAIL_FROM/g" /var/www/html/config.php
    sed -i "s/@@MAIL_FROM_NAME@@/$MAIL_FROM_NAME/g" /var/www/html/config.php

    sed -i "s/@@ENV@@/$ENV/g" /var/www/html/config.php
    sed -i "s/@@EMAIL_TO@@/$EMAIL_TO/g" /var/www/html/config.php

    sed -i "s/@@DEBUG@@/$DEBUG/g" /var/www/html/config.php
fi

 if ! [ -d "./vendor" ]
  then
    echo "[ ${PORCENTAGE_10} ] Install depedences whit composer..."
    # composer install --ignore-platform-reqs --verbose --no-scripts
 fi

apache2-foreground
echo "[ ${PORCENTAGE_100} ] Back - Ending Endpoint of Application"

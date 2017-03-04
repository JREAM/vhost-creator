# VirtualHost Generator

Author [Jesse Boyer (JREAM)](http://jream.com)

This is a simple PHP CLI Script to generate an Apache VirtualHost on the fly. This is primarily useful for development environments.

This requires Apache 2 which uses the `Require all granted` Directory setting. The default directory setting is to `AllowOverride All` for your `.htaccess` files if you use them. Otherwise you can edit the outputted file.

## In Development
Im going to add nginx as well as apache.
This is in development, dont use it right now please.

## Usage
In your Terminal run the following command and follow the instructions:

    $ php vhost.php

## Activate your Virtual Host

Once you save VirtualHost file using a site example lets call **unicorn**, you can activate it with:

    $ sudo mv output/unicorn.conf /etc/apache2/sites-available
    $ sudo a2ensite unicorn
    $ sudo service apache2 reload

## Access Your Site

Then you should be able to access your site:

    http://127.0.0.1/unicorn/

## Misc

If you are using .htaccess for friendly URLS, turn mod_rewrite on:

    $ sudo a2enmod rewrite
    $ sudo service apache2 restart

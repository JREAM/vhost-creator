# VHost Generator
This is a simple PHP CLI Script to be run to generate a VirtualHost. It requires Apache 2 which uses the `Require all granted` Directory setting. The default setting is to `AllowOverride All` so if you have a core configuration which does not allow that, you will need to turn it off in order to get your `.htaccess` files overwriting if you are using them.

@author [JREAM](http://jream.com)

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

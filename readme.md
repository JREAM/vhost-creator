# VHost Generator

@author [JREAM](http://jream.com)

## Usage
In your Terminal run the following command and follow the instructions:

    $ php vhost.php

Once you save the file using a site example called unicorn, you can simply run:

    $ sudo mv output/unicorn.conf /etc/apache2/sites-available
    $ sudo a2ensite unicorn
    $ sudo service apache2 reload

Then you should be able to access your site:

    http://127.0.0.1/unicorn/
    
## Misc

Turn Mod_Rewrite On:

    $ sudo a2enmod rewrite
    $ sudo service apache2 restart

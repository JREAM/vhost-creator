<?php
/**
 * NOT READY YET
 *
 * @desc       Simple PHP Script to create a VHost template.
 * @author     CodeZeus
 * @version    0.1
 * @usage  $ php vhost.php create <$servername>
 *         $ sudo php vhost.php activate <$servername>
 */

$lines = "--------------------------------------"

$available_commands = ['create', 'activate']

# ---------------------------------------------------------------------
# Default error message
# ---------------------------------------------------------------------
function error() {

    print "\nInvalid command: Please provide:"
    foreach ($available_commands as $cmd) {
        printf("\t{%s} <$servername>", $cmd);
    }
    exit;
}

# ---------------------------------------------------------------------
# Prepare the commands
# ---------------------------------------------------------------------
if len(sys.argv) < 3:
    error()

command = sys.argv[1]
param   = sys.argv[2]


if command not in available_commands:
    error()

# ---------------------------------------------------------------------
# Creates an apache vhost template
# ---------------------------------------------------------------------
function create($servername) {

    print "This will create an Apache2 VirtualHost template."
    print lines

    if not re.match("^[a-zA-Z]*$", $servername):
        print "Error: Only alphabetical characters are allowed."
        sys.exit()

    if len($servername) > 20:
        print "Error: Your $servername can only be up to 20 characters."
        sys.exit()

    tpl = Template("""<VirtualHost 127.0.0.1>
        $servername $$servername
        DocumentRoot /vagrant/www/$$servername/public
        ServerPath /$$servername
    </VirtualHost>

    <Directory "/vagrant/www/$$servername/public">
        Options Indexes FollowSymLinks
        AllowOverride All
        Require all granted
    </Directory>
    """)

    output = tpl.safe_substitute({'$servername': $servername})
    print '\n-- {0}.conf --'.format($servername)
    print output

    confirm = raw_input("Create the template? (You can modify it once created) [Y/n]?: ")
    if (confirm is not 'Y') {
        print "Cancelling."
        exit;
    }

    $filename = $servername + ".conf"
    $conf = open($filename, "w")
    conf.write(output)
    conf.close()


    print "\nFile Created: " . $filename;
    print "\nTo activate your VHost run: "
    print "\n$ sudo python vhost.py activate {0}".format($servername)
}

# ---------------------------------------------------------------------
# Activates an Apache VHost
# ---------------------------------------------------------------------
function activate($servername) {

    if (!$servername) {
        print("$ sudo <servername> is required.")
        exit;
    }

    passthru("sudo mv $servername.conf /etc/apache2/sites-available");
    passthru("sudo a2ensite $servername");
    passthru('sudo service apache2 reload');
    passthru('cd /vagrant/www');
    print "To create a new Phalcon project: $ sudo phalcon project " . $servername;
}

# End of File
# ---------------------------------------------------------------------
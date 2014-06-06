"""
@desc       Simple Python Script to create a VHost template.
@author     CodeZeus
@version    0.1
@usage  $ python vhost.py create <servername>
        $ sudo python vhost.py activate <servername>
"""
import os, sys, re
from string import Template

lines = "--------------------------------------"

available_commands = ['create', 'activate']

# ---------------------------------------------------------------------
# Default error message
# ---------------------------------------------------------------------
def error():
    print "\nInvalid command: Please provide:"
    for cmd in available_commands:
        print "\t{0} <servername>".format(cmd)
    sys.exit()

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
def create(servername):

    print "This will create an Apache2 VirtualHost template."
    print lines

    if not re.match("^[a-zA-Z]*$", servername):
        print "Error: Only alphabetical characters are allowed."
        sys.exit()

    if len(servername) > 20:
        print "Error: Your servername can only be up to 20 characters."
        sys.exit()

    tpl = Template("""<VirtualHost 127.0.0.1>
        ServerName $servername
        DocumentRoot /vagrant/www/$servername/public
        ServerPath /$servername
    </VirtualHost>

    <Directory "/vagrant/www/$servername/public">
        Options Indexes FollowSymLinks
        AllowOverride All
        Require all granted
    </Directory>
    """)

    output = tpl.safe_substitute({'servername': servername})
    print '\n-- {0}.conf --'.format(servername)
    print output

    confirm = raw_input("Create the template? (You can modify it once created) [Y/n]?: ")
    if (confirm is not 'Y'):
        print "Cancelling."
        sys.exit()

    filename = servername + ".conf"
    conf = open(filename, "w")
    conf.write(output)
    conf.close()


    print "\nFile Created: {0}".format(filename)
    print "To activate your VHost run: "
    print "$ sudo python vhost.py activate {0}".format(servername)

# ---------------------------------------------------------------------
# Activates an Apache VHost
# ---------------------------------------------------------------------
def activate(servername):
    if os.getuid() != 0:
        print("$ sudo is required.")
        sys.exit()

    os.system('sudo mv {0}.conf /etc/apache2/sites-available'.format(servername))
    os.system('sudo a2ensite {0}'.format(servername))
    os.system('sudo service apache2 reload')
    os.system('cd /vagrant/www')
    print "To create a new Phalcon project: $ sudo phalcon project {0}".format(servername)
    print "Otherwise "

# ---------------------------------------------------------------------
# Call a method
# ---------------------------------------------------------------------
locals()[command](param)

# End of File
# ---------------------------------------------------------------------
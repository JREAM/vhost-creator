<?php
/**
 * VirtualHost Generator
 * (For use with Apache 2)
 *
 * @author Jesse Boyer <hello@jream.com>
 * @copyright Copyright (c) 2014, Jese Boyer
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 * @version 0.1
 *
 * @usage
 *     Open a Terminal and follow the instructions after typing:
 *     $ php vhost.php
 */
namespace JREAM;

class VirtualHost
{

    protected $address = null;
    protected $server_name = null;
    protected $document_root = null;
    protected $server_path = null;
    protected $output = null;

    /**
     * Inits the Chain
     *
     * @return void
     */
    public function init() {
        $this->setVirtualHostAddress();
    }

    protected function setVirtualHostAddress() {
        echo 'VirtaulHost Address (default=127.0.0.1): ';
        $this->address = trim(fgets(STDIN));
        if (!$this->address) {
            $this->address = '127.0.0.1';
        }

        $this->setServerName();
    }

    protected function setServerName() {
        echo 'VirtualHost ServerName (example: unicorn): ';
        $this->server_name = trim(fgets(STDIN));
        if (!$this->server_name) {
            echo "[Error]: You must provide a server name!\n";
            $this->setServerName();
        }
        $this->setDocumentRoot();
    }

    protected function setDocumentRoot() {
        $default_document_root = "/vagrant/www/{$this->server_name}/public";
        echo "VirtualHost DocumentRoot (default=$default_document_root): ";
        $this->document_root = trim(fgets(STDIN));
        if (!$this->document_root) {
            $this->document_root = $default_document_root;
        }
        $this->setServerPath();
    }

    protected function setServerPath() {
        echo "Use VirtualHost ServerPath? (For Multiple VHosts) (default=y) [y/n]:";
        $this->server_path = trim(fgets(STDIN));
        echo $this->server_path;
        $this->server_path = sprintf("ServerPath /%s", $this->server_name);
        echo $this->server_path;

        if ($this->server_path == 'n') {
            $this->server_path = '';
        }

        echo $this->server_path;
        $this->confirmOutput();
    }

    protected function confirmOutput() {
        $this->output = "
        <VirtualHost {$this->address}>
            ServerName {$this->server_name}
            DocumentRoot {$this->document_root}
            {$this->server_path}
        </VirtualHost>

        <Directory \"{$this->document_root}\">
            Options Indexes FollowSymLinks
            AllowOverride All
            Require all granted
        </Directory>\n
        ";

        echo "\nThe following will be the output of your {$this->server_name}.conf file: \n";
        echo "\n-------------------";

        echo $this->output;

        echo "\nSite URL: {$this->address}/{$this->server_name}";
        echo "\nPublic Directory: " . $this->document_root;

        echo "\nDoes the above look correct? (startover=n) [y/n]:";
        $correct = trim(fgets(STDIN));
        echo $correct;
        if ($correct == 'n') {
            $this->setVirtualHostAddress();
            return;
        }

        $this->confirmWriteFile();
    }

    private function confirmWriteFile() {
        echo "\nWould you like to save the file in the output/ directory? (default=y) [y/n]:";
        $boolean = trim(fgets(STDIN));
        if ($boolean == 'n') {
            return;
        }

        $fp = fopen('output/' . $this->server_name . '.conf', 'w');
        fwrite($fp, $this->output);
        fclose($fp);

        echo "\n\nFile has been saved to {$this->server_name}.conf\n\n";
    }

}


if (!count(debug_backtrace()))
{
    $vhost = new \JREAM\VirtualHost();
    $vhost->init();
}

// End of File
// ---------------------------------------------------------------------

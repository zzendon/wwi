<?php
//error_reporting(E_ERROR | E_PARSE);

/// Can read config form a file.
class Config
{
    private $config;

    public function __construct()
    {
        try {
            $this->config = parse_ini_file($_SERVER['DOCUMENT_ROOT'] .  "/wwi/settings.ini");
        } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }
    }

    /// Get database connection string
    public function connection_string(){
        return $this->config["connection_string"];
    }

    /// Get database user
    public function db_user() {
        return $this->config["db_user"];
    }

    /// Get database user password
    public function db_password() {
        return $this->config["db_password"];
    }

    /// Get mollie api key
    public function mollie_api() {
        return $this->config["mollie_api"];
    }

    /// Get mollie url.
    public function mollie_url() {
        return $this->config["mollie_url"];
    }
}
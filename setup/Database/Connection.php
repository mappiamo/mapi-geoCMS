<?php

  namespace Database;

  use Database\Configuration as Config;
  use PDO;
  use PDOException;

  class Connection {
    private $Connection;
    private $Config;

    public function __construct(Config $Config) {
      $this->Config = $Config;
    }

    /**
     * Kapcsolódás és hibaüzenet ha sikertelen
     */
    public function connect() {
      try {
        $this->Connection = new PDO(
          sprintf(
            "mysql:host=%s; port=%s; dbname=%s; charset=utf8",
            $this->Config->getHost(),
						$this->Config->getPort(),
            $this->Config->getName()
          ),
          $this->Config->getUsername(),
          $this->Config->getPassword()
        );

        return $this;

        /**
         * Hiba az adatbázis csatlakozásnál
         */
      } catch (PDOException $ex) {
        print "Error!: " . $ex->getMessage();
        die();
      }
    }

    /**
     * query végrehajtás
     */
    public function query($Query) {
      return $this->Connection->query($Query);
    }

    public function getConfig() {
      return $this->Config;
    }

    public function __toString() {
      return (String) $this->Config;
    }

    public function __destruct() {
      $this->Connection = NULL;
    }
  }
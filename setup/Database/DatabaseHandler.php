<?php
  /**
   * Adatbázis kezelő
   */

  namespace Database;

  use Database\Configuration as Config;

  class DatabaseHandler {

    private $Connections = [];

    public function __construct(Config $Config = NULL) {
      if (!is_null($Config)) {
        $this->newConnection($Config);
      }
    }

    public function newConnection(Config $Config) {
      if (!$this->isKeyExist((string) $Config)) {
        $Connection = new Connection($Config);
        if (is_null($Connection->connect())) {
          return FALSE;
        } else {
          $this->Connections[(string) $Connection] = $Connection;
        }
      }

      return $this;
    }

    private function isKeyExist($ConnectionName) {
      if (array_key_exists($ConnectionName, $this->Connections)) {
        return TRUE;
      } else {
        return FALSE;
      }
    }

    public function getConnections() {
      return $this->Connections;
    }

    public function close($ConnectionName) {
      if ($this->isKeyExist($ConnectionName)) {
        $this->Connections[$ConnectionName] = new Connection(
          $this->getConnection($ConnectionName)->getConfig()
        );
      }

      return $this;
    }

    public function getConnection($ConnectionName) {
      return $this->isKeyExist($ConnectionName) ? $this->Connections[$ConnectionName] : NULL;
    }

    public function __destruct() {
      $this->closeAll();
    }

    public function closeAll() {
      foreach ($this->Connections as $ConnectionName => $Connection) {
        $this->close($ConnectionName);
      }

      return $this;
    }
  }
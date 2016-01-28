<?php

  namespace System {
    class Configuration {

      public static $DATABASE_HOST;
      public static $DATABASE_PORT;
      public static $DATABASE_NAME;
      public static $DATABASE_USERNAME;
      public static $DATABASE_PASSWORD;

      public function __construct() {
        $this::$DATABASE_HOST = $_POST['db_host'];
        $this::$DATABASE_PORT = "3306";
        $this::$DATABASE_NAME = $_POST['db'];
        $this::$DATABASE_USERNAME = $_POST['db_user'];
        $this::$DATABASE_PASSWORD = $_POST['db_pass'];
      }
    }
  }

  namespace Database {
    class Configuration {

      private $ConnectionName;
      private $DatabaseHost;
      private $DatabasePort;
      private $DatabaseName;
      private $DatabaseUsername;
      private $DatabasePassword;

      public function __construct(
        $ConnectionName,
        $DatabaseHost,
        $DatabasePort,
        $DatabaseName,
        $DatabaseUsername,
        $DatabasePassword
      ) {
        $this->ConnectionName = $ConnectionName;
        $this->DatabaseHost = $DatabaseHost;
        $this->DatabasePort = $DatabasePort;
        $this->DatabaseName = $DatabaseName;
        $this->DatabaseUsername = $DatabaseUsername;
        $this->DatabasePassword = $DatabasePassword;
      }

      public function getHost() {
        return $this->DatabaseHost;
      }

      public function getName() {
        return $this->DatabaseName;
      }

      public function getPort() {
        return $this->DatabasePort;
      }

      public function getUsername() {
        return $this->DatabaseUsername;
      }

      public function getPassword() {
        return $this->DatabasePassword;
      }

      public function __toString() {
        return $this->ConnectionName;
      }
    }
  }
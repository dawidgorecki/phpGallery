<?php

/*
 * Licensed under the MIT license - http://opensource.org/licenses/MIT
 * Copyright (c) 2017 Dawid Górecki
 */

namespace Core\Database;

/*
   public function query($sql)
   public function getLastId()
   public function getAffectedRows()
   public function escapeString($str)
*/

class Database
{
   protected $connection;
   protected $host;
   protected $username;
   protected $password;
   protected $dbname;
   protected $charset;

   public function __construct($host, $username, $password, $dbname, $charset)
   {
      $this->host     = $host;
      $this->username = $username;
      $this->password = $password;
      $this->dbname   = $dbname;
      $this->charset  = $charset;

      // połącz z bazą danych
      $this->openConnection();

      // ustaw kodowanie znaków
      $this->setCharset();
   }
   
   protected function openConnection()
   {
      // połącz z bazą danych
      $this->connection = @ new \mysqli($this->host, $this->username, $this->password, $this->dbname);

      // sprawdź połączenie
      if ($this->connection->connect_errno) {
         // błąd połączenia
         throw new \Exception($this->connection->connect_error, 1);
      }
   }

   protected function setCharset()
   {
      // ustaw kodowanie znaków
      if (!$this->connection->set_charset($this->charset)) {
         throw new \Exception($this->connection->error, 2);
      }
   }

   public function query($sql)
   {
      // wykonaj zapytanie SQL
      return @ $this->connection->query($sql);
   }

   public function getLastId()
   {
      // zwróć ostatni dodany identyfikator (id)
      return $this->connection->insert_id;
   }

   public function getAffectedRows()
   {
      // zwróć liczbę zmienionych wierszy
      return $this->connection->affected_rows;
   }

   public function escapeString($str)
   {
      // oczyść ciąg znaków
      if (get_magic_quotes_gpc()) {
         $str = stripslashes($str);
      }

      return $this->connection->real_escape_string(trim($str));
   }
}

?>
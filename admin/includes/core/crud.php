<?php

/*
 * Licensed under the MIT license - http://opensource.org/licenses/MIT
 * Copyright (c) 2017 Dawid Górecki
 */

namespace Core\Crud;

/*
   public static function executeQuery($sql)
   public static function getAll()
   public static function getObjectById($id)
   public static function countAllRows()
   public function create()
   public function update()
   public function delete()
   public function save()
*/

class Crud
{
   protected static function instantation($tableRow)
   {
      // utwórz nowy obiekt
      $calledClass = get_called_class();
      $newObject = new $calledClass;

      // nadaj wartość każdej właściwości obiektu
      foreach ($tableRow as $property => $value) 
      {
         // sprawdź czy właściwość istnieje
         if (property_exists($newObject, $property)) {
            // przypisz wartość do określonej właściwości obiektu
            $newObject->$property = $value;
         }
      }

      // zwróć utworzony obiekt
      return $newObject;
   }

   protected function getObjectProperties()
   {
      global $database;
      $properties = [];

      foreach (static::$tableFields as $fieldName) {
         // sprawdź czy właściwość istnieje
         if (property_exists($this , $fieldName)) {
            $properties[$fieldName] = $database->escapeString($this->$fieldName);
         }
      }

      return $properties;
   }

   // wykonaj zapytanie SQL i zwróć tablicę obiektów
   public static function executeQuery($sql)
   {
      global $database;
      
      $objects = [];
      $result = @ $database->query($sql);

      while ($row = $result->fetch_assoc()) {
         // utwórz obiekt dla każdego rekordu i umieść w tablicy
         $objects[] = static::instantation($row);
      }

      if (empty($objects)) {
         return false;
      } else {
         // zwróć tablicę obiektów
         return $objects;
      }
   }

   public static function getAll()
   {
      return static::executeQuery("SELECT * FROM " . static::$tableName);
   }

   public static function getObjectById($id)
   {
      $objects = static::executeQuery("SELECT * FROM " . static::$tableName . " WHERE id={$id} LIMIT 1");

      if (!empty($objects)) {
         return $objects[0];
      } 

      return false;
   }

   public static function countAllRows()
   {
      global $database;

      $result = $database->query("SELECT COUNT(*) FROM " . static::$tableName);
      $row = $result->fetch_array();

      return array_shift($row);
   }

   public function create()
   {
      global $database;

      $properties = $this->getObjectProperties();

      $sql = "INSERT INTO " . static::$tableName . "(" . implode(',', array_keys($properties)) . ") ";
      $sql .= "VALUES ('" . implode("','", array_values($properties)) . "')";

      if ($database->query($sql)) {
         $this->id = $database->getLastId();
         return true;
      } else {
         // błąd SQL
         return false;
      }
   }

   public function update()
   {
      global $database;

      $properties = $this->getObjectProperties();
      $propertiesPairs = [];

      foreach ($properties as $key => $value) {
         $propertiesPairs[] = $key . "='" . $value . "'";
      }

      $sql = "UPDATE " . static::$tableName . " SET ";
      $sql .= implode(",", $propertiesPairs);
      $sql .= " WHERE id=" . intval($this->id);

      // aktualizuj dane
      if ($database->query($sql)) {
         return ($database->getAffectedRows() == 1) ? true : false;
      } else {
         // błąd SQL
         return false;
      }
   }

   public function delete()
   {
      global $database;
      $sql = "DELETE FROM " . static::$tableName . " WHERE id=" . intval($this->id);

      if ($database->query($sql)) {
         return ($database->getAffectedRows() == 1) ? true : false;
      } else {
         // błąd SQL
         return false;
      }
   }

   public function save()
   {
      return isset($this->id) ? $this->update() : $this->create();
   }
}

?>
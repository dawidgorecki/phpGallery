<?php

/*
 * Licensed under the MIT license - http://opensource.org/licenses/MIT
 * Copyright (c) 2017 Dawid Górecki
 */

/*
   public static function newComment($photoId, $author, $body)
   public static function findComments($photoId = 0)
*/

class Comment extends \Core\Crud\Crud
{
   protected static $tableName = "comments";
   protected static $tableFields = ["photo_id","author","body"];

   public $id;
   public $photo_id;
   public $author;
   public $body;
   public $date;

   public static function newComment($photoId, $author, $body)
   {
      global $database;

      if (!empty($photoId) && !empty($author) && !empty($body)) {
         $comment = new self;
         $comment->photo_id = intval($photoId);
         $comment->author = $author;
         $comment->body = $body;

         return $comment;
      } else {
         return false;
      }
   }

   public static function findComments($photoId = 0)
   {
      $objectsArray = self::executeQuery("SELECT * FROM " . self::$tableName . " WHERE photo_id=" . intval($photoId) . " ORDER BY id DESC");

      if (!empty($objectsArray)) {
         // znaleziono komentarze
         return $objectsArray;
      } 

      // brak komentarzy
      return null;
   }

  
}

?>
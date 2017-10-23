<?php

/*
 * Licensed under the MIT license - http://opensource.org/licenses/MIT
 * Copyright (c) 2017 Dawid Górecki
 */

/*
   public function getUserImage()
   public function setUserImage($file)
   public function uploadUserImage()
   public function getFilePath()
   public function deleteUser()
   public static function verifyUser($username, $password)
   public static function hashPassword($password)
   public static function userExists($username)
   public function saveUserImage($userImage, $userId)
*/

class User extends \Core\Crud\Crud
{
   protected static $tableName = "users";
   protected static $tableFields = ["username","user_image","password","first_name","last_name"];

   public $id;
   public $username;
   public $password;
   public $first_name;
   public $last_name;

   // zdjęcie użytkownika
   public $user_image;
   public $placeholder = "http://placehold.it/100x100&text=image";
   public $filetype;
   public $size;
   public $errors = [];
   public $tempName;

   protected $uploadErrors = [
      UPLOAD_ERR_OK         => "Wysyłanie pliku zakończone sukcesem",
      UPLOAD_ERR_INI_SIZE   => "Rozmiar pliku przekroczył wartość upload_max_filesize",
      UPLOAD_ERR_FORM_SIZE  => "Rozmiar pliku przekroczył wartość max_file_size",
      UPLOAD_ERR_PARTIAL    => "Plik wysłany tylko częściowo",
      UPLOAD_ERR_NO_FILE    => "Nie wysłano żadnego pliku",
      UPLOAD_ERR_NO_TMP_DIR => "Nie można wysłać pliku: nie wskazano katalogu tymczasowego",
      UPLOAD_ERR_CANT_WRITE => "Wysyłanie pliku nie powiodło się: nie zapisano pliku na dysku",
      UPLOAD_ERR_EXTENSION  => "Wysyłanie pliku nie powiodło się"
   ];

   protected $allowedFileTypes = [
      'jpg' => 'image/jpeg', 
      'png' => 'image/png', 
      'gif' => 'image/gif',
   ];

   public function getUserImage()
   {
      if (empty($this->user_image)) {
         return $this->placeholder;
      } else {
         return UPLOAD_PATH . DS . $this->user_image;
      }
   }

   public function setUserImage($file)
   {
      if (empty($file) || !is_array($file)) {
         $this->errors[] = "Nie wysłano żadnego pliku";
         return false;
      }

      if ($file['error'] != 0) {
         $this->errors[] = $this->uploadErrors[$file['error']];
         return false;
      }

      // sprawdź format pliku
      $finfo = new finfo(FILEINFO_MIME_TYPE);
      $ext = array_search($finfo->file($file['tmp_name']), $this->allowedFileTypes, true);
      
      if ($ext === false) {
         $this->errors[] = "Wysyłanie pliku nie powiodło się: nieprawidłowy format pliku";
         return false;
      }

      $this->user_image = basename($file['name']);
      $this->filetype = $finfo->file($file['tmp_name']);
      $this->size = $file['size'];
      $this->tempName = $file['tmp_name'];

      return true;
   }

   public function uploadUserImage()
   {
      if (!empty($this->errors)) {
         // wystąpił błąd
         return false;
      }

      if (empty($this->user_image) || empty($this->tempName)) {
         $this->errors[] = "Nie wysłano żadnego pliku";
         return false;
      }

      $destinationPath = UPLOAD_PATH . DS . $this->user_image;

      // sprawdź czy plik istnieje
      if (file_exists($destinationPath)) {
         $this->errors[] = "Plik " . $this->user_image . " już istnieje";
         return false;
      }

      if (is_uploaded_file($this->tempName) && move_uploaded_file($this->tempName, $destinationPath)) {
         // przeniesiono plik
         unset($this->tempName);
         return true;
      } else {
         // możliwa próba ataku
         $this->errors[] = "Wysyłanie pliku nie powiodło się";
         return false;
      }
   }

   public function getFilePath()
   {
      return UPLOAD_PATH . DS . $this->user_image;
   }

   public function deleteUser()
   {
      if ($this->delete()) {
         if ($this->getFilePath() != $placeholder) {
            unlink($this->getFilePath());
         }
        
         return true;
      } else {
         // nie można usunąć z bazy danych
         return false;
      }
   }

   public static function verifyUser($username, $password)
   {
      global $database;

      // login i hasło wprowadzone przez użytkownika
      $username = $database->escapeString($username);
      $password = $database->escapeString($password);

      $sql = "SELECT * FROM " . self::$tableName . " WHERE username='{$username}' LIMIT 1";
      $object = self::executeQuery($sql);

      if (!empty($object)) {
         // znaleziono użytkownika
         $user = $object[0];

         if (password_verify($password, $user->password)) {
            // hasło poprawne
            return $user;
         } else {
            // błędne hasło
            return false;
         }
      } else {
         // błędna nazwa użytkownika
         return false;
      }
   }

   public static function hashPassword($password)
   {
      // zaszyfruj hasło - blowfish
      return password_hash($password, PASSWORD_BCRYPT);
   }

   public static function userExists($username)
   {
      global $database;

      // sprawdź czy użytkownik o podanej nazwie istnieje w bazie danych
      $sql = "SELECT * FROM " . self::$tableName . " WHERE username='{$username}'";

      if($result = $database->query($sql)) {
         return ($result->num_rows > 0) ? true : false;
      } else {
         return false;
      }
   }

   public function saveUserImage($userImage, $userId)
   {
      global $database;

      $userId = intval($userId);
      $userImage = $database->escapeString($userImage);

      $this->id = $userId;
      $this->user_image = $userImage;
      
      $sql = "UPDATE " . self::$tableName . " SET user_image='{$this->user_image}' WHERE id={$this->id}";
      $database->query($sql);

      echo $this->getFilePath();
   }

}

?>
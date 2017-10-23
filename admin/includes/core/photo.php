<?php

/*
 * Licensed under the MIT license - http://opensource.org/licenses/MIT
 * Copyright (c) 2017 Dawid Górecki
 */

/*
   public function getFilePath()
   public function setFile($file)
   public function save()
   public function deletePhoto()
*/

class Photo extends \Core\Crud\Crud
{
   protected static $tableName = "photos";
   protected static $tableFields = ["title","caption","description","filename","alt_text","filetype","size"];

   public $id;
   public $title;
   public $caption;
   public $description;
   public $filename;
   public $alt_text;
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

   public function getFilePath()
   {
      return UPLOAD_PATH . DS . $this->filename;
   }

   public function setFile($file)
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

      $this->filename = basename($file['name']);
      $this->filetype = $finfo->file($file['tmp_name']);
      $this->size = $file['size'];
      $this->tempName = $file['tmp_name'];

      return true;
   }

   public function save()
   {
      if (isset($this->id)) {
         return $this->update();
      } else {
         if (!empty($this->errors)) {
            // wystąpił błąd
            return false;
         }

         if (empty($this->filename) || empty($this->tempName)) {
            $this->errors[] = "Nie wysłano żadnego pliku";
            return false;
         }

         $destinationPath = UPLOAD_PATH . DS . $this->filename;

         // sprawdź czy plik istnieje
         if (file_exists($destinationPath)) {
            $this->errors[] = "Plik " . $this->filename . " już istnieje";
            return false;
         }

         if (is_uploaded_file($this->tempName) && move_uploaded_file($this->tempName, $destinationPath)) {
            // przeniesiono plik
            if ($this->create()) {
               // ...i zapisano w bazie danych
               unset($this->tempName);
               return true;
            } else {
               // błąd SQL
               return false;
            }
         } else {
            // możliwa próba ataku
            $this->errors[] = "Wysyłanie pliku nie powiodło się";
            return false;
         }
      }
   }

   public function deletePhoto()
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

}

?>
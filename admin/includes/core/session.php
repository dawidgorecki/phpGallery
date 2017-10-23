<?php

/*
 * Licensed under the MIT license - http://opensource.org/licenses/MIT
 * Copyright (c) 2017 Dawid Górecki
 */

namespace Core\Session;

/*
   public function getUserId()
   public function getUserName()
   public function userSignedIn()
   public function message($message="")
   public function login($userObject)
   public function logout()
*/

class Session
{
   protected $message;
   protected $signedIn = false;
   protected $userId;
   protected $username;

   function __construct()
   {
      // rozpocznij sesje
      session_start();

      // sprawdź czy użytkownik jest zalogowany
      $this->checkLogin();

      // sprawdź komunikaty
      $this->checkMessage(); 
   }

   protected function checkMessage()
   {
      // sprawdź czy istnieje jakiś komunikat
      if (!empty($_SESSION['message'])) {
         $this->message = $_SESSION['message'];
         unset($_SESSION['message']);
      } else {
         // brak komunikatów
         $this->message = "";
      }
   }

   protected function checkLogin()
   {
      if (isset($_SESSION['user_id'])) {
         // użytkownik zalogowany
         $this->signedIn = true;
         $this->userId   = $_SESSION['user_id'];
         $this->username = $_SESSION['username'];
      } else {
         $this->signedIn = false;
         $this->userId   = null;
         $this->username = null;
      }
   }

   public function getUserId()
   {
      // zwraca ID użytkownika
      return $this->userId;
   }

   public function getUserName()
   {
      // zwraca nazwę użytkownika
      return $this->username;
   }

   public function userSignedIn()
   {
      // jeśli użytkownik jest zalogowany zwróc true, w przeciwnym razie false
      return $this->signedIn;
   }

   public function message($message="")
   {
      if (!empty($message)) {
         // przekazano parametr - ustaw komunikat
         $_SESSION['message'] = $message;
      } else {
         // zwróć komunikat
         return $this->message;
      }
   }

   public function login($userObject)
   {
      // zaloguj użytkownika
      if ($userObject) 
      {
         $this->signedIn = true;
         $this->userId = $_SESSION['user_id'] = $userObject->id;
         $this->username = $_SESSION['username'] = $userObject->username;
         return true;
      } else {
         return false;
      }
   }

   public function logout()
   {
      // wyloguj użytkownika
      if ($this->signedIn) 
      {
         $this->signedIn = false;
         $this->userId = null;
         $_SESSION = []; // usuń zmienne sesji

         setcookie(session_name(), '', time() - 2592000); // usuń ciastko
         session_destroy(); // zakończ sesje

         return true;
      } else {
         return false;
      }
   }
}

?>
<?php

require_once 'init.php';
if (!$session->userSignedIn()) redirect('login.php');

$user = new User();

if (isset($_POST['image_name'])) {
   $user->saveUserImage($_POST['image_name'],$_POST['user_id']);
}

if (isset($_POST['photo_id'])) {
   $photo = Photo::getObjectById(intval($_POST['photo_id']));
   echo "<p>Nazwa pliku: {$photo->filename}</p><p>Typ: {$photo->filetype}</p><p>Rozmiar: {$photo->size}</p>";
}
?>
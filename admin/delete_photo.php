<?php 
  include 'includes/init.php';

  if (!$session->userSignedIn()) {
    // użytkownik nie jest zalogowany - przekieruj na stronę logowania
    redirect('login.php');
  }

  if (!isset($_GET['id']) || intval($_GET['id']) == 0) {
    // brak ID lub ID nie jest liczbą całkowitą
    redirect('photos.php');
  }

  // utwórz obiekt na podstawie ID
  $photo = Photo::getObjectById(intval($_GET['id']));

  if ($photo && $photo->deletePhoto()) {
    $session->message("Usunięto zdjęcie {$photo->filename}");
  } else {
    $session->message("Nie można usunąć zdjęcia {$photo->filename}");
  }

  redirect("photos.php");  
?>
       
<?php 
  include 'includes/init.php';

  if (!$session->userSignedIn()) {
    // użytkownik nie jest zalogowany - przekieruj na stronę logowania
    redirect('login.php');
  }

  if (!isset($_GET['id']) || intval($_GET['id']) == 0) {
    // brak ID lub ID nie jest liczbą całkowitą
    redirect('users.php');
  }

  // utwórz obiekt na podstawie ID
  $user = User::getObjectById(intval($_GET['id']));

  if ($user && $user->deleteUser()) {
    $session->message("Usunięto użytkownika {$user->username}");
  } else {
    $session->message("Nie można usunąć użytkownika {$user->username}");
  }

  redirect("users.php");
?>
       
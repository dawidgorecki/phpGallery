<?php 
  include 'includes/init.php';

  if (!$session->userSignedIn()) {
    // użytkownik nie jest zalogowany - przekieruj na stronę logowania
    redirect('login.php');
  }

  if (!isset($_GET['id']) || intval($_GET['id']) == 0) {
    // brak ID lub ID nie jest liczbą całkowitą
    redirect('comments.php');
  }

  // utwórz obiekt na podstawie ID
  $comment = Comment::getObjectById(intval($_GET['id']));

  if ($comment && $comment->delete()) {
    $session->message("Komentarz został usunięty");
  } else {
    $session->message("Nie można usunąć wybranego komentarza");
  }

  redirect("comments.php");
?>
       
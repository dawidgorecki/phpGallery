<?php 

ob_start();

define('CORE', 'core');
define('DS', DIRECTORY_SEPARATOR);
define('INCLUDES_PATH', 'includes');
define('UPLOAD_PATH', 'uploads');

require_once 'functions.php';

// konfiguracja połączenia z bazą danych
require 'db-config.php';

// klasa obsługująca bazę danych
require_once CORE . DS . 'database.php';

try {
   // utwórz obiekt odpowiedzialny za obsługę bazy danych
   $database = new \Core\Database\Database(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME, DB_CHARSET);
} catch (Exception $e) {
   die($e->getMessage());
}

// klasa obsługująca sesje
require_once CORE . DS . 'session.php';

// utwórz obiekt odpowiedzialny za obsługę sesji
$session = new \Core\Session\Session();
$message = $session->message();

// obsługa paginacji
require_once CORE . DS . 'pagination.php';

// bazowa klasa do obsługi CRUD
require_once CORE . DS . 'crud.php';

require_once CORE . DS . 'user.php';
require_once CORE . DS . 'photo.php';
require_once CORE . DS . 'comment.php';

?>
<?php

require_once 'includes/init.php';

if ($session->userSignedIn()) redirect('index.php');

if (isset($_POST['submit'])) {
   try {
      $username = sanitizeString($_POST['username']);
      $password = sanitizeString($_POST['password']);

      $userFound = User::verifyUser($username, $password);

      if ($userFound) {
         // zaloguj
         $session->login($userFound);
         redirect('index.php');
      } else {
         throw new Exception("Niepoprawny login lub hasło.");
      }
   } catch (Exception $e) {
      $errorMessage = $e->getMessage();
   }
} else {
   // nie przesłano formularza
   $username = "";
   $password = "";
   $errorMessage = "";
}

?>

<!DOCTYPE html>
<html lang="pl">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="Dawid Górecki">

    <link rel="icon" href="favicon.ico">
    
    <title>Logowanie</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/sb-admin.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

    <link rel="stylesheet" href="css/animate.min.css">
    <link rel="stylesheet" href="css/style.css">

    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
</head>

<body id="authorization">

   <div id="wrapper">
      <div class="col-md-4 col-md-offset-3">
        <?php if ($errorMessage) {
          echo alertBox($errorMessage);
          echo "<form id='login-id' action='' method='post'>";
        } else {
          echo "<form id='login-id' action='' method='post' class='animated fadeInDown'>";
        }
        ?>
            <h3 class="login-page"><i class="fa fa-fw fa-users"></i> Logowanie</h3>
            <div class="form-group">
               <label for="username">Nazwa użytkownika</label>
               <input type="text" class="form-control" name="username" value="<?php echo $username; ?>" >
            </div>

            <div class="form-group">
               <label for="password">Hasło</label>
               <input type="password" class="form-control" name="password">
            </div>

            <div class="form-group">
               <input type="submit" name="submit" value="Zaloguj" class="btn btn-info btn-block">
            </div>
         </form>
      </div>
   </div>

   <!-- jQuery -->
   <script src="js/jquery.js"></script>

   <!-- Bootstrap Core JavaScript -->
   <script src="js/bootstrap.min.js"></script>
   
</body>

</html>
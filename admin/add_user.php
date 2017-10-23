<?php 
  include 'includes/header.php';

  if (!$session->userSignedIn()) redirect('login.php');

  if (isset($_POST['create'])) {
    $user = new User();
    $user->username = sanitizeString($_POST['username']);
    $user->password = User::hashPassword(sanitizeString($_POST['password']));
    $user->first_name = sanitizeString($_POST['first_name']);
    $user->last_name = sanitizeString($_POST['last_name']);
    $user->setUserImage($_FILES['user_image']);
    $user->uploadUserImage();

    if ($user->save()) {
      $session->message("Utworzono nowego użytkownika");
    } else {
      $session->message(implode("<br>", $user->errors));
    }

    redirect('users.php');
  }
?>
    <!-- Navigation -->
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <?php include 'includes/top-nav.php'; ?>
        <?php include 'includes/side-nav.php'; ?>
    </nav>

    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">
                       <i class="fa fa-fw fa-users"></i> Nowy użytkownik
                    </h1>
                    
                    <form action="" method="post" enctype="multipart/form-data">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="username">Nazwa użytkownika</label>
                                <input type="text" name="username" id="username" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="user_image">Zdjęcie</label>
                                <input type="file" name="user_image" id="user_image">
                            </div>
                            <div class="form-group">
                                <label for="first_name">Imię</label>
                                <input type="text" name="first_name" id="first_name" class="form-control">
                            </div>   
                            <div class="form-group">
                                <label for="last_name">Nazwisko</label>
                                <input type="text" name="last_name" id="last_name" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="password">Hasło</label>
                                <input type="password" name="password" id="password" class="form-control">
                            </div>
                            <div class="form-group">
                                <input type="submit" name="create" value="Dodaj użytkownika" class="btn btn-info">
                            </div>        
                        </div>
                    </form>
                </div>
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /#page-wrapper -->

<?php include 'includes/footer.php'; ?>
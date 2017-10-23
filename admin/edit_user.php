<?php 
  include 'includes/header.php';
  include 'includes/photo-library.php';

  if (!$session->userSignedIn()) redirect('login.php');

  if (!isset($_GET['id']) || intval($_GET['id']) == 0) {
    // brak ID
    redirect('users.php');
  } else {
    $user = User::getObjectById($_GET['id']);

    if (isset($_POST['update'])) {
        if ($user) {
            $user->username = sanitizeString($_POST['username']);

            if (!empty($_POST['password'])) {
                $user->password = User::hashPassword(sanitizeString($_POST['password']));
            }
            
            $user->first_name = sanitizeString($_POST['first_name']);
            $user->last_name = sanitizeString($_POST['last_name']);

            if (!empty($_FILES['user_image'])) {
                $user->setUserImage($_FILES['user_image']);
                $user->uploadUserImage();
            } 

           if ($user->save()) {
             $session->message("Zaktualizowano dane użytkownika");
            } else {
              $session->message(implode("<br>", $user->errors));
            }
        }
    
        redirect('users.php');
    }
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
                    <h1 class="page-header"><i class="fa fa-fw fa-users"></i> Edycja użytkownika</h1>
                    
                    <div class="col-md-6 user_image">
                        <a href="#" data-toggle="modal" data-target="#photo-library">
                            <img class="img-responsive img-rounded" src="<?php echo $user->getUserImage(); ?>" alt="">
                        </a>
                    </div>

                    <form action="" method="post" enctype="multipart/form-data">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="username">Nazwa użytkownika</label>
                                <input type="text" name="username" id="username" class="form-control" value="<?php echo $user->username; ?>" readonly>
                            </div>
                            <div class="form-group">
                                <label for="user_image">Zdjęcie</label>
                                <input type="file" name="user_image" id="user_image">
                            </div>
                            <div class="form-group">
                                <label for="first_name">Imię</label>
                                <input type="text" name="first_name" id="first_name" class="form-control" value="<?php echo $user->first_name; ?>">
                            </div>   
                            <div class="form-group">
                                <label for="last_name">Nazwisko</label>
                                <input type="text" name="last_name" id="last_name" class="form-control" value="<?php echo $user->last_name; ?>">
                            </div>
                            <div class="form-group">
                                <label for="password">Wprowadź hasło, aby je zmienić</label>
                                <input type="password" name="password" id="password" class="form-control">
                            </div>
                            <div class="form-group">
                                <a id="user_id" href="delete_user.php?id=<?php echo $user->id; ?>" class="btn btn-danger">Usuń</a>   
                                <input type="submit" name="update" value="Zapisz" class="btn btn-info pull-right">
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
<?php 
    include 'includes/header.php';
    if (!$session->userSignedIn()) redirect('login.php');

    $users = User::getAll();
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
                        <i class="fa fa-fw fa-users"></i> Użytkownicy
                        <a href="add_user.php" class="btn btn-info pull-right">Nowy użytkownik</a>
                    </h1>

                    <div class="col-md-12">
                    <?php 
                        echo empty($message) ? "" : alertBox($message);
                        
                        if ($users) {
echo <<<_END
                        <table class="table table-hover table-striped">
                            <thead>
                                <tr>
                                    <th>Zdjęcie</th>
                                    <th>Nazwa użytkownika</th>
                                    <th>Imię</th>
                                    <th>Nazwisko</th>
                                </tr>
                            </thead>
                            <tbody>
_END;
                            foreach ($users as $user) :
echo <<<_END
                                <tr>
                                    <td>
                                        <img class="img-responsive user-image img-rounded" src="{$user->getUserImage()}" alt="">
                                    </td>
                                    <td>
                                        $user->username
                                        <div class='pictures-links pull-right'>
                                            <a href="edit_user.php?id={$user->id}" class="btn btn-default btn-xs">Edytuj</a>
                                            <a href="delete_user.php?id={$user->id}" class="btn btn-danger btn-xs">Usuń</a>
                                        </div>
                                    </td>
                                    <td>$user->first_name</td>
                                    <td>$user->last_name</td>
                                </tr>
_END;
                            endforeach;

                            echo "</tbody></table>";
                 
                            } else {
                                echo infoBox("Brak użytkowników do wyświetlenia");
                            } 
                    ?>
                    </div>
                </div>
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /#page-wrapper -->

<?php include 'includes/footer.php'; ?>
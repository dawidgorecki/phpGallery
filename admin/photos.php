<?php 
    include 'includes/header.php';
    if (!$session->userSignedIn()) redirect('login.php');
  
    $page = !empty($_GET['page']) ? $_GET['page'] : 1;
    $itemsCount = Photo::countAllRows();
    $itemsOnPage = 25;
    
    $pagination = new \Core\Pagination\Pagination($page, $itemsOnPage, $itemsCount);
    $sql = "SELECT * FROM photos LIMIT " . $itemsOnPage . " OFFSET " . $pagination->offset();

    $photos = Photo::executeQuery($sql);
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
                    <h1 class="page-header"><i class="fa fa-fw fa-photo"></i> Zdjęcia
                        <a href="upload.php" class="btn btn-info pull-right">Dodaj zdjęcie</a>
                    </h1>

                    <div class="col-md-12">
                    <?php
                        echo empty($message) ? "" : alertBox($message);
                        
                        if ($photos) {
echo <<<_END
                        <table class="table table-hover table-striped">
                            <thead>
                                <tr>
                                    <th>Podgląd</th>
                                    <th>Nazwa pliku</th>
                                    <th>Tytuł</th>
                                    <th>Rozmiar</th>
                                    <th>Komentarze</th>
                                </tr>
                            </thead>
                            <tbody>
_END;
                            foreach ($photos as $photo) :
echo <<<_END
                                <tr>
                                    <td>
                                        <img class="admin-thumb img-rounded" src="{$photo->getFilePath()}" alt="">
                                    </td>
                                    <td>
                                        $photo->filename;
                                        <div class='pictures-links pull-right'>
                                            <a href="../photo.php?id={$photo->id}" class="btn btn-default btn-xs">Wyświetl</a> 
                                            <a href="edit_photo.php?id={$photo->id}"" class="btn btn-default btn-xs">Edytuj</a>
                                            <a href="delete_photo.php?id={$photo->id}" class="btn btn-danger btn-xs">Usuń</a>
                                        </div>
                                    </td>
                                    <td>$photo->title</td>
                                    <td>$photo->size</td>
                                    <td>
                                        <a href="photo_comments.php?id={$photo->id}">
_END;
                                        $comments = Comment::findComments($photo->id);
                                        echo count($comments) . "</a></td></tr>";

                            endforeach; 
                         
                            echo "</tbody></table>";
                     
                            } else {
                                echo infoBox("Brak zdjęć do wyświetlenia");
                            }
                    ?>
                    </div>
                </div>
            </div>
            <!-- /.row -->

            <div class="row text-center">
            <?php 
                if ($pagination->getTotalPages() > 1) {
                    echo "<ul class='pagination'>";

                    if ($pagination->hasPrevious()) {
                        echo "<li class='page-item'><a class='page-link' href='photos.php?page=" . $pagination->previousPage() . "'>Wstecz</a></li>";
                    } else {
                        echo "<li class='page-item disabled'><a class='page-link' href='javascript:void(0);' tabindex='-1'>Wstecz</a></li>";
                    }

                    for ($pageNumber=1; $pageNumber <= $pagination->getTotalPages(); $pageNumber++) {
                        if ($page == $pageNumber) {
                            echo "<li class='page-item active'><a class='page-link' href='photos.php?page={$pageNumber}'>$pageNumber</a></li> ";
                        } else {
                            echo "<li class='page-item'><a class='page-link' href='photos.php?page={$pageNumber}'>$pageNumber</a></li> ";
                        }
                    }

                    if ($pagination->hasNext()) {
                        echo "<li class='page-item'><a class='page-link' href='photos.php?page=" . $pagination->nextPage() . "'>Dalej</a></li>";
                    } else {
                        echo "<li class='page-item disabled'><a class='page-link' href='javascript:void(0);' tabindex='-1'>Dalej</a></li>";
                    }
                    
                    echo "</ul>";
                }
            ?> 
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /#page-wrapper -->

<?php include 'includes/footer.php'; ?>
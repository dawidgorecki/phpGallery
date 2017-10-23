<?php 
    include 'includes/header.php';
    if (!$session->userSignedIn()) redirect('login.php');

    $page = !empty($_GET['page']) ? $_GET['page'] : 1; 
    $itemsCount = Comment::countAllRows();
    $itemsOnPage = 25; 

    $pagination = new \Core\Pagination\Pagination($page, $itemsOnPage, $itemsCount);
    $sql = "SELECT * FROM comments LIMIT " . $itemsOnPage . " OFFSET " . $pagination->offset();

    $comments = Comment::executeQuery($sql);
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
                    <h1 class="page-header"><i class="fa fa-fw fa-comments"></i> Komentarze</h1>

                    <div class="col-md-12">
                    <?php 
                        echo empty($message) ? "" : alertBox($message);
                        
                        if ($comments) {
echo <<<_END
                        <table class="table table-hover table-striped">
                            <thead>
                                <tr>
                                    <th>Komentarz</th>
                                    <th>Autor</th>
                                    <th>Dodane dnia</th>
                                </tr>
                            </thead>
                            <tbody>
_END;
                            foreach ($comments as $comment) :
echo <<<_END
                                <tr>
                                    <td>
                                        $comment->body
                                        <div class='pictures-links pull-right'>
                                            <a href="delete_comment.php?id={$comment->id}" class="btn btn-danger btn-xs">Usuń</a>
                                        </div>
                                    </td>
                                    <td>$comment->author</td>
                                    <td>$comment->date</td>
                                </tr>
_END;
                            endforeach; 
                         
                            echo "</tbody></table>";
                     
                            } else {
                                echo infoBox("Brak komentarzy do wyświetlenia");
                            } 
                    ?>
                    </div>
                    <!-- /.col-md-12 -->
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->

            <div class="row text-center">
            <?php 
                if ($pagination->getTotalPages() > 1) {
                    echo "<ul class='pagination'>";

                    if ($pagination->hasPrevious()) {
                        echo "<li class='page-item'><a class='page-link' href='comments.php?page=" . $pagination->previousPage() . "'>Wstecz</a></li>";
                    } else {
                        echo "<li class='page-item disabled'><a class='page-link' href='javascript:void(0);' tabindex='-1'>Wstecz</a></li>";
                    }

                    for ($pageNumber=1; $pageNumber <= $pagination->getTotalPages(); $pageNumber++) {
                        if ($page == $pageNumber) {
                            echo "<li class='page-item active'><a class='page-link' href='comments.php?page={$pageNumber}'>$pageNumber</a></li> ";
                        } else {
                            echo "<li class='page-item'><a class='page-link' href='comments.php?page={$pageNumber}'>$pageNumber</a></li> ";
                        }
                    }

                    if ($pagination->hasNext()) {
                        echo "<li class='page-item'><a class='page-link' href='comments.php?page=" . $pagination->nextPage() . "'>Dalej</a></li>";
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
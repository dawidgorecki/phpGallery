<?php 
  include 'includes/header.php';

  if (!$session->userSignedIn()) redirect('login.php');
  if (!isset($_GET['id']) || intval($_GET['id']) == 0) redirect('photos.php');

  $comments = Comment::findComments($_GET['id']);
  $photo = Photo::getObjectById($_GET['id']);
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
                    <h1 class="page-header"><i class="fa fa-fw fa-comments"></i> Komentarze
                        <small><?php echo $photo->filename; ?></small></h1>

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
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /#page-wrapper -->

<?php include 'includes/footer.php'; ?>
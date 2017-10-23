<?php 
    include 'includes/header.php';

    if (!isset($_GET['id']) || intval($_GET['id']) == 0) redirect('index.php');

    $photo = Photo::getObjectById($_GET['id']);

    if (isset($_POST['submit'])) {
        $author = sanitizeString($_POST['author']);
        $body = sanitizeString($_POST['body']);

        $comment = Comment::newComment($photo->id, $author, $body);

        if ($comment && $comment->save()) {
            $session->message("Komentarz został dodany");
        } else {
            $session->message("Nie można dodać komentarza");
        }

        redirect("photo.php?id={$photo->id}");
    }

    $allComments = Comment::findComments($photo->id);
?>
    <div class="row">

        <div class="col-lg-12">
            <h1><?php echo $photo->title; ?></h1><hr>
            <img class="img-responsive" src="admin/<?php echo $photo->getFilePath(); ?>" alt=""><hr>
            <p class="lead"><?php echo $photo->caption; ?></p>
            <p><?php echo $photo->description; ?></p>

            <hr>

            <?php echo empty($message) ? "" : alertBox($message); ?>

            <!-- Comments -->

            <div class="well">
                <h4>Dodaj komentarz:</h4>
                <form role="form" method="post">
                    <div class="form-group">
                       <input type="text" name="author" id="author" class="form-control" placeholder="Autor">
                    </div>
                    <div class="form-group">
                        <textarea class="form-control" rows="3" placeholder="Treść komentarza" name="body"></textarea>
                    </div>
                    <button type="submit" class="btn btn-info" name="submit">Dodaj</button>
                </form>
            </div>

            <!-- Posted Comments -->
            
            <?php 
                if(!empty($allComments)) { 
                    foreach ($allComments as $comment): ?>
                        <hr>
                        <div class="media">
                            <div class="media-body">
                                <h4 class="media-heading"><?php echo $comment->author; ?>
                                    <small><?php echo date("Y-m-d H:i:s", strtotime($comment->date)); ?></small>
                                </h4>
                               <?php echo $comment->body; ?>
                            </div>
                        </div>   
            <?php 
                    endforeach; 
                } 
            ?>
        </div>

    </div>
    <!-- /.row -->

<?php include 'includes/footer.php'; ?>
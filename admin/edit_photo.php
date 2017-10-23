<?php 
  include 'includes/header.php';

  if (!$session->userSignedIn()) redirect('login.php');

  if (!isset($_GET['id']) || intval($_GET['id']) == 0) {
    // błędne ID
    redirect('photos.php');
  } else {
    $photo = Photo::getObjectById($_GET['id']);

    if (isset($_POST['update'])) {
        if ($photo) {
          $photo->title = sanitizeString($_POST['title']);
          $photo->caption = sanitizeString($_POST['caption']);
          $photo->alt_text = sanitizeString($_POST['alt_text']);
          $photo->description = sanitizeString($_POST['description']);

          if($photo->save()) {
            $session->message("Zaktualizowano dane obrazu");
            } else {
              $session->message(implode("<br>", $user->errors));
            }
        } 
    
        redirect('photos.php');
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
                  <h1 class="page-header"><i class="fa fa-fw fa-photo"></i> Edycja zdjęcia</h1>
                  
                  <form action="" method="post">
                      <div class="col-md-8">
                          <div class="form-group">
                              <label for="title">Tytuł</label>
                              <input type="text" name="title" id="title" class="form-control" value="<?php echo $photo->title; ?>">
                          </div>
                          <div class="form-group">
                              <a href="#" class="thumbnail"><img src="<?php echo $photo->getFilePath(); ?>" alt=""></a>
                          </div>
                          <div class="form-group">
                              <label for="caption">Etykieta</label>
                              <input type="text" name="caption" id="caption" class="form-control" value="<?php echo $photo->caption; ?>">
                          </div>   
                          <div class="form-group">
                              <label for="alt_text">Tekst alternatywny</label>
                              <input type="text" name="alt_text" id="alt_text" class="form-control" value="<?php echo $photo->alt_text; ?>">
                          </div>
                          <div class="form-group">
                              <label for="description">Opis</label>
                              <textarea name="description" id="description" cols="30" rows="10" class="form-control"><?php echo $photo->description; ?></textarea>
                          </div>
                      </div>
                      
                      <div class="col-md-4" >
                          <div class="photo-info-box">
                              <div class="info-box-header">
                                 <h4>Szczegóły</h4>
                              </div>
                              <div class="inside">
                                <div class="box-inner">
                                    <p class="text">
                                      ID: <span class="data photo_id_box"><?php echo $photo->id; ?></span>
                                    </p>
                                    <p class="text">
                                      Nazwa pliku: <span class="data"><?php echo $photo->filename; ?></span>
                                    </p>
                                   <p class="text">
                                    Typ pliku: <span class="data"><?php echo $photo->filetype; ?></span>
                                   </p>
                                   <p class="text">
                                     Rozmiar pliku: <span class="data"><?php echo $photo->size; ?></span>
                                   </p>
                                </div>
                                <!-- /.box-inner -->
                                <div class="info-box-footer clearfix">
                                  <div class="info-box-update pull-left">
                                      <a href="delete_photo.php?id=<?php echo $photo->id; ?>" class="btn btn-danger">Usuń</a>   
                                  </div>
                                  <div class="info-box-update pull-right">
                                      <input type="submit" name="update" value="Zapisz" class="btn btn-info">
                                  </div> 
                                </div>
                              </div>
                              <!-- /.inside -->
                          </div>
                          <!-- /.photo-info-box -->
                      </div>
                      <!-- /.col-md-4 -->
                  </form>
              </div>
          </div>
          <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
  </div>
  <!-- /#page-wrapper -->

<?php include 'includes/footer.php'; ?>
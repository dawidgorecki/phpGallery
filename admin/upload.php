<?php 
   include 'includes/header.php';
   if (!$session->userSignedIn()) redirect('login.php');

   if (isset($_FILES['file'])) {
      $photo = new Photo();
      $photo->setFile($_FILES['file']);

      if ($photo->save()) {
         $session->message("Wysyłanie pliku zakończone sukcesem");
      } else {
         $session->message(implode("<br>", $photo->errors));
      }

      redirect("upload.php"); // odśwież
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
               <h1 class="page-header"><i class="fa fa-fw fa-upload"></i> Dodaj zdjęcie</h1>
               <?php echo empty($message) ? "" : alertBox($message); ?>

               <div class="row">
                  <div class="col-md-6">
                     <form action="upload.php" method="post" enctype="multipart/form-data">
                        <div class="form-group">
                           <input type="file" class="file-upload" name="file" id="file_upload">
                        </div>
                        <input type="submit" class="btn btn-info" value="Załaduj plik" name="submit">
                     </form>
                  </div>
               </div>
               <div class="row">
                  <div class="col-lg-12">
                     <form action="upload.php" class="dropzone"></form>
                  </div>
               </div>
            </div>
         </div>
         <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
   </div>
   <!-- /#page-wrapper -->

<?php include 'includes/footer.php'; ?>
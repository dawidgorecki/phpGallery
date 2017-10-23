<?php  
  require_once 'init.php';
  if (!$session->userSignedIn()) redirect('login.php');

  $photos = Photo::getAll();
?>

<div class="modal fade" id="photo-library">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Biblioteka zdjęć</h4>
      </div>
      <div class="modal-body">
          <div class="col-md-9">
             <div class="thumbnails row">
            
               <?php 
               if ($photos) {
                foreach ($photos as $photo): ?>
               <div class="col-md-3 col-xs-6">
                 <a role="checkbox" aria-checked="false" tabindex="0" id="" href="#" class="thumbnail">
                   <img class="modal_thumbnails" src="<?php echo $photo->getFilePath(); ?>" data="<?php echo $photo->id; ?>">
                 </a>
                  <div class="photo-id hidden"></div>
               </div>
              <?php endforeach; }
              else {
                echo infoBox("Brak zdjęć do wyświetlenia");
              } ?>

             </div>
          </div><!--col-md-9 -->

  <div class="col-md-3">
    <div id="modal_sidebar"></div>
  </div>

   </div>
   <!--Modal Body-->
      <div class="modal-footer">
        <div class="row">
               <!--Closes Modal-->
              <button id="set_user_image" type="button" class="btn btn-primary" disabled="true" data-dismiss="modal">Zatwierdź</button>
        </div>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
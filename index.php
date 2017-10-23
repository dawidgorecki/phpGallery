<?php 
   include 'includes/header.php';

   $page = !empty($_GET['page']) ? intval($_GET['page']) : 1;
   $itemsOnPage = 16;
   $itemsCount = Photo::countAllRows();

   $pagination = new \Core\Pagination\Pagination($page, $itemsOnPage, $itemsCount);
   $sql = "SELECT * FROM photos LIMIT " . $itemsOnPage . " OFFSET " . $pagination->offset();

   $photos = Photo::executeQuery($sql);
?>
  <div class="row">

    <div class="col-md-12">
      <div class="row">
        <?php
          if ($photos) {
            foreach ($photos as $photo): 
        ?>
           <div class="col-xs-6 col-md-3 img-gallery">
              <a href="photo.php?id=<?php echo $photo->id; ?>">
                 <img src="admin/<?php echo $photo->getFilePath(); ?>" alt="">
              </a>
           </div>
        <?php 
          endforeach; 
        } else {
          echo infoBox("Brak zdjęć do wyświetlenia");
        }
        ?>
      </div>
    </div>

    <div class="row text-center">
      <ul class="pagination">
        <?php 
          if ($pagination->getTotalPages() > 1) {
            if ($pagination->hasPrevious()) {
              echo "<li class='page-item'><a class='page-link' href='index.php?page=" . $pagination->previousPage() . "'>Wstecz</a></li>";
            } else {
              echo "<li class='page-item disabled'><a class='page-link' href='javascript:void(0);' tabindex='-1'>Wstecz</a></li>";
            }

            for ($pageNumber=1; $pageNumber <= $pagination->getTotalPages(); $pageNumber++) {
              if ($page == $pageNumber) {
                 echo "<li class='page-item active'><a class='page-link' href='index.php?page={$pageNumber}'>$pageNumber</a></li> ";
              } else {
                echo "<li class='page-item'><a class='page-link' href='index.php?page={$pageNumber}'>$pageNumber</a></li> ";
              }
            }

            if ($pagination->hasNext()) {
              echo "<li class='page-item'><a class='page-link' href='index.php?page=" . $pagination->nextPage() . "'>Dalej</a></li>";
            } else {
              echo "<li class='page-item disabled'><a class='page-link' href='javascript:void(0);' tabindex='-1'>Dalej</a></li>";
            }
          }
         ?> 
      </ul>
    </div>

  </div>
  <!-- /.row -->

<?php include 'includes/footer.php'; ?>

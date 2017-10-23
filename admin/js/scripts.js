$(document).ready(function() {
   let href;
   let hrefSplitted;
   let userId;
   let imageName;
   let photoId;

    $(".modal_thumbnails").click(function() {
      // aktywuj przycisk
      $("#set_user_image").prop('disabled', false);

      // wyciągnij z url ID użytkownika
      href = $("#user_id").prop("href");
      hrefSplitted = href.split("=");
      userId = hrefSplitted[hrefSplitted.length - 1];

      // wyciągnij nazwę klikniętego obrazka
      href = $(this).prop("src");
      hrefSplitted = href.split("/");
      imageName = hrefSplitted[hrefSplitted.length - 1];

      // ID obrazka
      photoId = $(this).attr("data");
      
      // prześlij ID obrazka do skryptu php
      $.ajax({
         url: "includes/ajax.php",
         type: "POST",
         data: {
            photo_id: photoId
         },
         success: function(data) {
            if (!data.error) {
               $("#modal_sidebar").html(data);
            }
         }
      });
   });

    $("#set_user_image").click(function() {
      // zmień zdjęcie użytkownika
      $.ajax({
         url: "includes/ajax.php",
         type: "POST",
         data: {
            user_id: userId,
            image_name: imageName
         },
         success: function(data) {
            if (!data.error) {
               $(".user_image a img").prop("src", data);
            }
         }
      });
    });

   tinymce.init({ selector:'textarea' });
});
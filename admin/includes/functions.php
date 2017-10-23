<?php

function redirect($location)
{
   // przekierowanie
   header("Location: " . $location);
   exit;
}

function sanitizeString($str)
{
   // oczyść ciąg znaków
   $str = strip_tags(trim($str));
   return htmlentities($str);
}

function infoBox($str)
{
   return "<div class='alert alert-info animated fadeInDown'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><i class='fa fa-fw fa-info-circle'></i> $str</div>";
}

function alertBox($str)
{
   return "<div class='alert alert-danger animated fadeInDown'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><i class='fa fa-fw fa-exclamation-circle'></i> $str</div>";
}

?>
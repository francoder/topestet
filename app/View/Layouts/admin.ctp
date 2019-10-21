<?php function resource_path($path)
{
  return APP . 'View/Layouts/inc/' . $path;
} ?>
<?php require resource_path('_global/config.php'); ?>
<?php require resource_path('backend/config.php'); ?>
<?php require resource_path('_global/views/head_start.php'); ?>
<?php require resource_path('_global/views/head_end.php'); ?>
<?php require resource_path('_global/views/page_start.php'); ?>



<?= $content_for_layout ?>

<?php require resource_path('_global/views/page_end.php'); ?>
<?php require resource_path('_global/views/footer_start.php'); ?>
<?php require resource_path('_global/views/footer_end.php'); ?>

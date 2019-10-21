<?php
/**
 * footer_start.php
 *
 * Author: pixelcave
 *
 * All vital JS scripts are included here
 *
 */
?>

<!-- Codebase Core JS -->
<script src="<?php echo $cb->assets_folder; ?>/js/core/jquery.min.js"></script>
<script src="<?php echo $cb->assets_folder; ?>/js/core/bootstrap.bundle.min.js"></script>
<script src="<?php echo $cb->assets_folder; ?>/js/core/jquery.slimscroll.min.js"></script>
<script src="<?php echo $cb->assets_folder; ?>/js/core/jquery.scrollLock.min.js"></script>
<script src="<?php echo $cb->assets_folder; ?>/js/core/jquery.appear.min.js"></script>
<script src="<?php echo $cb->assets_folder; ?>/js/core/jquery.countTo.min.js"></script>
<script src="<?php echo $cb->assets_folder; ?>/js/core/js.cookie.min.js"></script>

<script src="<?php echo $cb->assets_folder; ?>/js/codebase.js"></script>
<script src="<?php echo $cb->assets_folder; ?>/js/plugins/sweetalert2/sweetalert2.min.js"></script>
<!--<script src="--><?php //echo $cb->assets_folder; ?><!--/js/plugins/ckeditor/ckeditor.js""></script>-->
<script src="<?php echo $cb->assets_folder; ?>/js/plugins/summernote/summernote-bs4.min.js"></script>
<script src="<?php echo $cb->assets_folder; ?>/js/plugins/summernote/plugin/summernote-image-attributes.js"></script>
<script src="<?php echo $cb->assets_folder; ?>/js/plugins/summernote/lang/summernote-ru-RU.js"></script>
<script src="<?php echo $cb->assets_folder; ?>/js/plugins/summernote/plugin/ru-RU.js"></script>
<link rel="stylesheet" href="<?php echo $cb->assets_folder; ?>/js/plugins/summernote/summernote-bs4.css">
<style>
    .nav-tabs li {
        padding: 10px;
        background-color: #ccc;
        border: 1px solid #fff;
    }
    .nav-tabs a {
        color: #fff;
    }
</style>
<script>
    jQuery(function () {
        Codebase.helpers(['summernote']);
    });

    function prepareSummernote() {
        var content = $('textarea[class="js-summernote"]').html($('.js-summernote').code());
    }
</script>



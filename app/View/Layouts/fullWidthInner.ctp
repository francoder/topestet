<?= $this->element(
    'header',
    [
        'title_for_layout',
        'removeInner' => true,
    ]
); ?>

<?= $content_for_layout ?>

<?= $this->element(
    'footer',
    [
        'removeInner' => true,
    ]
); ?>

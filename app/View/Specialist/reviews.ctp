<?foreach ($reviews as $review):?>
    <?=$this->Element("review", array("review" => $review, "shownote" => true));?>
<?endforeach;?>

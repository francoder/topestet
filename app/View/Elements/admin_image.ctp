<?$image_data = $images_data[$alias];?>
<?if (!isset($type)) $type = "thumbnail";?>
<?if (!isset($image_data['hasMany']) || !$image_data['hasMany']):?>
  <?=$this->element("image_old", array("model" => strtolower($model), "alias" => $alias, "type" => $type, "id" => @$this->data[$model]['id']))?><BR>
<?else:?>
  <div>
    <?
    if (!empty($this->data[$model]['id']) && is_dir($dir = "image/". strtolower($model) ."/{$alias}_{$this->data[$model]['id']}")){
      $d = opendir($dir);
      while ($f = readdir($d)){
        $ex = pathinfo($f);
        $f_main = str_replace("_$type", "", $f);
        if (strpos($f, "addition_") == 0 && strpos($f, "_$type") && in_array($ex['extension'], array("jpg", "gif", "png", "bmp"))){?>
          <div class="img_preview">
            <img src="/<?=$dir?>/<?=$f?>" title="/<?=$dir?>/<?=$f_main?>" alt=""><br>
            <input type="text" value="/<?=$dir?>/<?=$f_main?>"><br>
            <a href="/admin/img_delete/<?=$model?>/<?=$alias?>/<?=$this->data[$model]['id']?>/<?=$f?>"><img src="/img/delete.png"></a>
          </div>
        <?}
      }
    }
    ?>
  </div>
<?endif;?>
<?=$this->Form->file($alias, array("class" => "field"))?>
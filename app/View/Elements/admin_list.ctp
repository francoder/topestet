<?if (isset($this->data[$model])):?>
  <?foreach ($this->data[$model] as $item):?>
    <?=$item['title']?> (<A href="/admin/self_item_del/<?=$submodel?>/<?=$item[$submodel]['id']?>/" style="color:red" title="<?=__('удалить');?>" class="item_delete">X</a>)
  <?endforeach;?>
<?endif;?>
<?=$form->text($field, array("class" => "field"))?>

<script type="text/javascript">
  <?
  foreach ($list as $id => $item){
    $list[$id] = "'$item'";
  }
  $list = implode(",", $list);
  ?>
  data = [<?=$list?>];
  $("#<?=$submodel?>").autocomplete(data, {multiple: true, matchContains: true});
</script>
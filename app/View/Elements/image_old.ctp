<?
if (!isset($type)) $type = ""; else $type = "_$type";
if (!isset($onlyurl)) $onlyurl = false;
if (!isset($alias)) $alias = "main";
if ($type == "main" || $type == "_main") $type = "";
if (!isset($also)) $also = "";
if (!isset($noimage)) $noimage = false;
if (is_array($also)) $also = array_implode("=\"", "\" ", $also).'"';
$filename = "";
$extensions = array("jpg", "gif", "png", "bmp");
foreach ($extensions as $extension){
  $prefilename = "image/$model/{$alias}_{$id}{$type}.$extension";
  if (file_exists(WWW_ROOT.$prefilename)){
    $filename = $prefilename;
  }
}
if (!empty($filename) || $noimage){
  if ($noimage && empty($filename)){
    $filename = "image/$model/{$alias}_no{$type}.png";
  }
  $sizes = getimagesize(WWW_ROOT.$filename);
  $width = $sizes[0];
  $height = $sizes[1];
  if (isset($maxwidth) && $maxwidth < $width){
    $width = $maxwidth;
    $height = 0;
  }
  if ($onlyurl){
    echo "/".$filename;
  } else {
    ?>
    <img src="/<?=$filename?>?r=<?//=rand(0,100)?>" width="<?=$width?>" <?if ($height > 0):?>height="<?=$height?>"<?endif;?> <?=$also?> vspace="0" hspace="0"/>
  <?}}
?>
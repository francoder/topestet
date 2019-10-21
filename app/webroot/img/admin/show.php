<?
	$dir = ".";
	$d = opendir($dir);
	while ($file = readdir($d)):?>
		<img src="<?=$file?>" title="<?=$file?>">
	<?endwhile;
?>
<?php
session_start();
$random_string = substr(md5(uniqid("")),0,6);
echo $_SESSION['random_string'] = $random_string;
print_r($_SESSION);

function win_utf8($in_text) {
   $output = "";
   $other[1025] = "�";
   $other[1105] = "�";
   $other[1028] = "�";
   $other[1108] = "�";
   $other[1030] = "I";
   $other[1110] = "i";
   $other[1031] = "�";
   $other[1111] = "�";
   for ($i = 0; $i < strlen($in_text); $i++){
      if (ord($in_text{$i}) > 191) {
         $output.="&#".(ord($in_text{$i})+848).";";
      }else {
         if (array_search($in_text{$i}, $other)===false){
            $output.=$in_text{$i};
         }else {
            $output.="&#".array_search($in_text{$i}, $other).";";
         }
      }
   }
   return $output;
}
$heg = 25;
// Create a 300x100 image
$im = imagecreatetruecolor(80, $heg);
$red = imagecolorallocate($im, 250, 250, 250);
$black = imagecolorallocate($im, 0x00, 0x00, 0x00);

// Make the background red
imagefilledrectangle($im, 0, 0, 80, $heg, $red);

// Path to our ttf font file
$font_file = 'arial.ttf';

		//������ ��� �� ����
		for ($i=0; $i<=128; $i++) {
			$color = imagecolorallocate ($im, rand(0,255), rand(0,255), rand(0,255)); //����� ����
			imagesetpixel($im, rand(2,80), rand(2,20), $color); //������ �������
		}

//echo $r_str;
imagefttext($im, 14, 0, 0, 20, $black, $font_file, win_utf8($random_string));

header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header('Content-Type: image/gif');

imagepng($im);
imagedestroy($im);
?>
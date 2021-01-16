<?php 

session_start();

$captcha = substr(str_shuffle("AaBbCcDdEeFfGgHhIiJjKkLlMmNnPpQqRrSsTtUuVvYyXxWwZz123456789"),0, 8);

$im = imagecreatefrompng("imagem/fundocaptch.png");

$fonte = imageloadfont("../fontes/anonymous.gdf");

$azul = imagecolorallocate($im, 0, 98, 215);

imagestring($im, $fonte, 15, 5, $captcha, $azul);

imagepng($im);

imagedestroy($im);

$_SESSION["captcha"] = $captcha;
echo $_SESSION["captcha"];

?>

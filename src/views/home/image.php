<?php
$img = @imagecreatefromjpeg( __DIR__ . '/utils/image/background.jpg');
if(!$img) {
    die('image invalide');
}
$width = imagesx($img);
$height = imagesy($img);
$offset = ($width - $height) / 2;

$newimg = imagecreatetruecolor(500, 500);

imagecopyresized($newimg, $img, 0, 0, $offset, 0, 500, 500, $height, $height);

$logo = @imagecreatefromjpeg( __DIR__ . '/utils/image/logo.jpg');
$wlogo = imagesx($logo);
$hlogo = imagesy($logo);
const LOGO_SIZE = 100;
$newlogo = imagecreatetruecolor(LOGO_SIZE, LOGO_SIZE);
imagecopyresized($newlogo, $logo, 0, 0, 0, 0, LOGO_SIZE, LOGO_SIZE, $wlogo, $hlogo);

$topleftixel = imagecolorat($newlogo, 0, 0);
imagecolortransparent($newlogo, $topleftixel);

imagecopymerge($newimg, $newlogo, 20, 20, 0, 0, LOGO_SIZE, LOGO_SIZE, 100);

$font_size = 40;
$font = __DIR__ . '/utils/image/Paul-le1V.ttf';
$text = $_GET['text'] ?? 'Hello World';
list($x1,$y1,$x2,$y2) = imageftbbox($font_size, 0, $font, $text);
imagefttext($newimg, $font_size, 0, 160 , 50, 0, $font, $text);

//header('Content-Type: image/jpeg');
//imagejpeg($newimg, null, 100);
?>
<input id="text"/>
<button id="btn">Générer</button>
<br>
<img id="img">
<script>
    document.querySelector('#btn').addEventListener('click', e => {
        let img = document.querySelector('#img');
        let txt = document.querySelector('#text');
        img.setAttribute('src', 'index.php?text=' + txt.value + '&    d=' + new Date().getTime());
    });
</script>
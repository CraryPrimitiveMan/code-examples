<?php
// File and new size
$filename = 'https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket=gQF48ToAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL0xrUEhlbDdtUjRRXy01YUJqRzFLAAIEh7MhVwMEECcAAA==';
// $icon = 'https://wx.qlogo.cn/mmopen/PiajxSqBRaELXhuETMatztxhNUwJUOTY1vk79EauzzF3O71iaxHlhBho8iaiaNGpbWP8ThAib7Vrc1swnK6G0wxjZ1Q/46';
$icon = 'icon.jpg';
// Content type
// header('Content-Type: image/jpeg');
$starttime = explode(' ', microtime());

// Get new sizes
list($width, $height) = getimagesize($filename);
list($iconWidth, $iconHeight) = getimagesize($icon);

// Load
$thumb = imagecreatefromjpeg($filename);
$source = imagecreatefromjpeg($icon);

for ($i=0; $i < 1000; $i++) {

    // merge
    // imagecopy($thumb, $source, ($width-$iconWidth)/2, ($height-$iconHeight)/2, 0, 0, $iconWidth, $iconHeight);
    imagecopyresampled($thumb, $source, 0, 0, ($width-$iconWidth)/2, ($height-$iconHeight)/2, 0, 0, $iconWidth, $iconHeight);

    // Output
    imagejpeg($thumb, 'final.jpg');
}
//程序运行时间
$endtime = explode(' ',microtime());
$thistime = $endtime[0]+$endtime[1]-($starttime[0]+$starttime[1]);
$thistime = round($thistime,3);
echo "本网页执行耗时：".$thistime." 秒。" . "\n";

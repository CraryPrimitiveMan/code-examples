<?php
// File and new size
$filename = 'https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket=gQF48ToAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL0xrUEhlbDdtUjRRXy01YUJqRzFLAAIEh7MhVwMEECcAAA==';
// $icon = 'https://wx.qlogo.cn/mmopen/PiajxSqBRaELXhuETMatztxhNUwJUOTY1vk79EauzzF3O71iaxHlhBho8iaiaNGpbWP8ThAib7Vrc1swnK6G0wxjZ1Q/46';
$icon = 'icon.jpg';
// Content type
// header('Content-Type: image/jpeg');

// Get new sizes
list($width, $height) = getimagesize($filename);
list($iconWidth, $iconHeight) = getimagesize($icon);
// Load
$thumb = imagecreatefromjpeg($filename);
$source = imagecreatefromjpeg($icon);

// merge
imagecopy($thumb, $source, ($width-$iconWidth)/2, ($height-$iconHeight)/2, 0, 0, $iconWidth, $iconHeight);

// Output
imagejpeg($thumb, 'final.jpg');

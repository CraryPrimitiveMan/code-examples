<?php
$filename = 'https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket=gQF48ToAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL0xrUEhlbDdtUjRRXy01YUJqRzFLAAIEh7MhVwMEECcAAA==';
$src = imagecreatefromjpeg($filename);
header('Content-Type: image/jpeg');
imagejpeg($src, null, 10);
imagedestroy($src);

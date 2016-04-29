<?php
function microtimeFloat(){
   list($usec, $sec) = explode(" ", microtime());
   return ((float)$usec + (float)$sec);
}
// File and new size
$filename = 'https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket=gQF48ToAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL0xrUEhlbDdtUjRRXy01YUJqRzFLAAIEh7MhVwMEECcAAA==';
$icon = 'icon.jpg';

// Get new sizes
list($width, $height) = getimagesize($filename);
list($iconWidth, $iconHeight) = getimagesize($icon);

$startTime = microtimeFloat();

for ($i=0; $i < 10; $i++) {
  // Load
  $thumb = imagecreatefromjpeg($filename);
  $source = imagecreatefromjpeg($icon);

  // merge
  imagecopy($thumb, $source, ($width-$iconWidth)/2, ($height-$iconHeight)/2, 0, 0, $iconWidth, $iconHeight);

  // Output
  imagejpeg($thumb, 'final.jpg');
  unset($thumb, $source);
}

$endTime = microtimeFloat();

echo "时间为", $endTime - $startTime, "\n";

$startTime = microtimeFloat();

for ($i=0; $i < 10; $i++) {
  // Load
  $thumb = imagecreatefromjpeg($filename);
  $source = imagecreatefromjpeg($icon);

  // merge
  imagecopyresampled($thumb, $source, ($width-$iconWidth)/2, ($height-$iconHeight)/2, 0, 0, $iconWidth, $iconHeight, $iconWidth, $iconHeight);

  // Output
  imagejpeg($thumb, 'final.jpg');
  unset($thumb, $source);
}

$endTime = microtimeFloat();

echo "时间为", $endTime - $startTime, "\n";

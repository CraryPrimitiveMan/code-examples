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
$count = 10;

$starttime = explode(' ', microtime());

for ($i=0; $i < $count; $i++) {
    // Load
    $thumb = imagecreatefromjpeg($filename);
    $source = imagecreatefromjpeg($icon);
    // merge
    imagecopy($thumb, $source, ($width-$iconWidth)/2, ($height-$iconHeight)/2, 0, 0, $iconWidth, $iconHeight);
    // imagecopyresampled($thumb, $source, 0, 0, ($width-$iconWidth)/2, ($height-$iconHeight)/2, 0, 0, $iconWidth, $iconHeight);

    // Output
    imagejpeg($thumb, 'final.jpg');
}

//程序运行时间
$endtime = explode(' ',microtime());
$thistime = $endtime[0]+$endtime[1]-($starttime[0]+$starttime[1]);
$thistime = round($thistime,3);
echo "本次执行耗时：".$thistime." 秒。" . "\n";

unset($starttime, $endtime, $thistime, $thumb, $source);

$starttime = explode(' ', microtime());

function getImageString($url)
{
    $curl = curl_init($url);
    curl_setopt($curl,CURLOPT_RETURNTRANSFER,1);
    $imageData = curl_exec($curl);
    curl_close($curl);
    return $imageData;
}
for ($i=0; $i < $count; $i++) {
    $redis = new Redis();
    $redis->connect('127.0.0.1', 6379);
    $iconKey = md5('screferral-3057c24e13b6ed0931aad-icon');
    $thumbKey = md5('screferral-3057c24e13b6ed0931aad-thumb');
    if (empty($source = $redis->get($iconKey)) || empty($thumb = $redis->get($thumbKey))) {
        // $thumb = file_get_contents($filename);
        // $source = file_get_contents($icon);
        $thumb = getImageString($filename);
        $source = getImageString($icon);
        $redis->set($iconKey, $source);
        $redis->set($thumbKey, $thumb);
    } else {
        $source = $redis->get($iconKey);
        $thumb = $redis->get($thumbKey);
    }
    // Load
    $thumb = imagecreatefromstring($thumb);
    $source = imagecreatefromstring($source);
    // merge
    imagecopy($thumb, $source, ($width-$iconWidth)/2, ($height-$iconHeight)/2, 0, 0, $iconWidth, $iconHeight);
    // imagecopyresampled($thumb, $source, 0, 0, ($width-$iconWidth)/2, ($height-$iconHeight)/2, 0, 0, $iconWidth, $iconHeight);

    // Output
    imagejpeg($thumb, 'final.jpg');
}

//程序运行时间
$endtime = explode(' ',microtime());
$thistime = $endtime[0]+$endtime[1]-($starttime[0]+$starttime[1]);
$thistime = round($thistime,3);
echo "本次执行耗时：".$thistime." 秒。" . "\n";

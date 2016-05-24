<?php
$url = 'http://music.baidu.com/tag/%E7%83%AD%E6%AD%8C';
// $curl = curl_init();
//
// curl_setopt($curl, CURLOPT_URL, $url);
// curl_setopt($curl, CURLOPT_HEADER, 0);
//
// // 抓取URL并把它传递给浏览器
// $html = curl_exec($curl);
$html = file_get_contents($url);

$doc = new DOMDocument();
@$doc->loadHTML($html);

$searchNodes = $doc->getElementsByTagName('li');

unset($html, $doc);
$data = [];
foreach($searchNodes as $searchNode)
{
    if ($searchNode->hasAttribute('data-songitem')) {
        $links = $searchNode->getElementsByTagName('a');
        $data[] = ['title' => $links->item(0)->nodeValue, 'singer' => $links->item(1)->nodeValue];
    }
}
unset($searchNodes);

file_put_contents('result.php', "<?php\nreturn " . var_export($data, true) . ';');

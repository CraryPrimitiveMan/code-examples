<?php
$domain = 'http://dev.wx.quncrm.com';
$campaignIds = [
  '5732dad9025f881e3d8b456b', '57352bebdebe338463897085', '57352c09debe338463897086',
  '57352c5d6f69eaedfdd94ea6', '57352c986f69eaedfdd94ea7', '573537916f69eaedfdd94ea8',
  '573537916f69eaedfdd94ea9', '573537916f69eaedfdd94eaa', '573537926f69eaedfdd94eab',
  '573537ab6f69eaedfdd94eac', '573537ab6f69eaedfdd94ead'
];
$channelIds = ['5679fe9de4b04f75123702dc'];
$pageSize = 20;
$maxPageNum = 10;
unlink('data.csv');
$fp = fopen('data.csv', 'w');

foreach ($campaignIds as $campaignId) {
  foreach ($channelIds as $channelId) {
    for ($pageNum = 1; $pageNum <= $maxPageNum; $pageNum++) {
      $url = "${domain}/accounts/${channelId}/users/search?pageSize=${pageSize}&pageNum=${pageNum}";
      $content = json_decode(file_get_contents($url), true);
      if ($content['code'] === 200) {
        if (empty($content['data']['results'])) {
          break;
        } else {
          $followers = $content['data']['results'];
          foreach ($followers as $follower) {
            fputcsv($fp, [$campaignId, $channelId, $follower['originId']]);
          }
        }
      }
    }
  }
}

fclose($fp);

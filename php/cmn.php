<?php
$arr = [
	[
		'id' => 'bb340471-53e4-1591-3238-d6ccf0d930a1',
		'properties' => [
			[
				'id' => 1234,
				'name' => '1'
			],
			[
				'id' => 1235,
				'name' => '2'
			],
			[
				'id' => 1236,
				'name' => '3'
			]
		]
	],
	[
		'id' => 'bb340471-53e4-1591-3238-d6ccf0d930a2',
		'properties' => [
			[
				'id' => 1237,
				'name' => '4'
			],
			[
				'id' => 1238,
				'name' => '5'
			],
			[
				'id' => 1239,
				'name' => '6'
			],
			[
				'id' => 1240,
				'name' => '7'
			]
		]
	],
	[
		'id' => 'bb340471-53e4-1591-3238-d6ccf0d930a3',
		'properties' => [
			[
				'id' => 1241,
				'name' => '8'
			],
			[
				'id' => 1242,
				'name' => '9'
			],
			[
				'id' => 1243,
				'name' => '10'
			],
			[
				'id' => 1244,
				'name' => '11'
			]
		]
	]
];
$allKeys = array_reduce($arr, function($prevSpec, $nextSpec) {
		$keys = [];
		if (empty($prevSpec)) {
			foreach ($nextSpec['properties'] as $nextSpecProp) {
					$keys[] = $nextSpecProp['id'];
			}
		}

		foreach ($prevSpec as $prevSpecPropId) {
				foreach ($nextSpec['properties'] as $nextSpecProp) {
						$keys[] = $prevSpecPropId . ',' . $nextSpecProp['id'];
				}
		}
		return $keys;
});
var_dump($allKeys);
var_dump(array_map('md5', $allKeys));
// $result = [];
// foreach ($arr as $index => $value) {
//   $result[$index] = [];
//   foreach ($value['properties'] as $propertie) {
//     $result[$index][] = $propertie['id'];
//   }
// }
//
// $a = array_reduce($result, function($pre, $next) {
//   $temp = [];
//   if (empty($pre)) {
//     return $next;
//   }
//   foreach ($pre as $key1 => $value1) {
//     foreach ($next as $key2 => $value2) {
//       $temp[] = $value1 . ',' . $value2;
//     }
//   }
//   return $temp;
// });
// var_dump($a);

--TEST--
Check for demo presence
--SKIPIF--
<?php if (!extension_loaded("demo")) print "skip"; ?>
--FILE--
<?php
$arr = array(
    0 => '0',
    1 => '123',
    'a' => 'abc',
);
$prefix = array(
    1 => '456',
    'a' => 'def',
);
var_dump(array_concat($arr, $prefix));
?>
--EXPECT--
array(3) {
  [0]=>
  string(1) "0"
  [1]=>
  string(6) "456123"
  ["a"]=>
  string(6) "defabc"
}
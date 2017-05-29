--TEST--
Check for demo get_size function
--SKIPIF--
<?php if (!extension_loaded("demo")) print "skip"; ?>
--FILE--
<?php
echo get_size('12345'), "\n";
echo get_size([1,2,3]), "\n";
echo get_size([]), "\n";
?>
--EXPECT--
string size is 5
array size is 3
array size is 0

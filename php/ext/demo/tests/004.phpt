--TEST--
Check for demo str_concat function
--SKIPIF--
<?php if (!extension_loaded("demo")) print "skip"; ?>
--FILE--
<?php
echo str_concat('hello', 'world');
?>
--EXPECT--
hello world
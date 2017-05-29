--TEST--
Check for demo hello function
--SKIPIF--
<?php if (!extension_loaded("demo")) print "skip"; ?>
--FILE--
<?php
echo hello();
?>
--EXPECT--
hello world
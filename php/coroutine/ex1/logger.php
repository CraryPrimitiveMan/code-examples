<?php
function logger($fileName) {
    $fileHandle = fopen($fileName, 'a');
    while (true) {
        //fwrite($fileHandle, yield . "\n");
        echo yield;
    }
}
 
$logger = logger(__DIR__ . '/log');
$logger->send('Foo');
$logger->send('Bar');

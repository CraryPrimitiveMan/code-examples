<?php
/**
 * Created by PhpStorm.
 * User: jun
 * Date: 2017/4/12
 * Time: 16:21
 */
require "AsyncTask.php";

function newSubGen() {
    yield 10;
    yield 11;
    yield 12;
    yield 13;
    
}

function newGen() {
    $r1 = (yield 1);
    $r2 = (yield 2);
    $r3 = (yield 3);
    yield newSubGen();
    throw new Exception('e');
    yield 5;
}

$task = new AsyncTask(newGen());
$trace = function($r) { echo $r; };
echo $task->begin($trace);
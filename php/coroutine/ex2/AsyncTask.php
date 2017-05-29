<?php

/**
 * Created by PhpStorm.
 * User: jun
 * Date: 2017/4/12
 * Time: 16:03
 */
require "Gen.php";

class AsyncTask
{
    public $gen;
    public $continuation;
    
    public function __construct(\Generator $gen)
    {
        $this->gen = new Gen($gen);
    }
    
    public function begin()//($continuation)
    {
//        $this->continuation = $continuation;
        return $this->next();
    }
    
    public function next($result = null, \Exception $exception = null)
    {
        if ($exception) {
            $this->gen->throw($exception);
        }
    
        $exception = null;
        try {
            $value = $this->gen->send($result);
        } catch (\Exception $exception) {}
        
        if ($exception) {
            if ($this->gen->valid()) {
                return $this->next(null, $exception);
            } else {
                throw $exception;
            }
        } else {
            if ($this->gen->valid()) {
                return $this->next($value);
            } else {
                return $result;
            }
        }
//        if ($this->gen->valid()) {
//            if ($value instanceof \Generator) {
//                $value = new self($value);
//            }
//
//            if ($value instanceof Async) {
//                $async = $value;
//                $continuation = [$this, "next"];
//                $async->begin($continuation);
//            } else {
//                $this->next($value);
//            }
//        } else {
//            $cc = $this->continuation;
//            $cc($result);
//        }
    }
}
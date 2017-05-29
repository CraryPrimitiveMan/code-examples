<?php

/**
 * Created by PhpStorm.
 * User: jun
 * Date: 2017/4/12
 * Time: 19:59
 */
class Gen
{
    public $isFirst = true;
    public $generator;
    
    public function __construct(\Generator $generator)
    {
        $this->generator = $generator;
    }
    
    public function throw(\Exception $exception)
    {
        return $this->generator->throw($exception);
    }
    
    public function valid()
    {
        return $this->generator->valid();
    }
    
    public function send($value = null)
    {
        if ($this->isFirst) {
            $this->isFirst = false;
            return $this->generator->current();
        } else {
            return $this->generator->send($value);
        }
    }
}
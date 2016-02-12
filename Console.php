<?php

namespace Dreamcoil;

class Console
{

    private $options;

    public function __construct(array $options)
    {
        
        if($options['timestamp']) $this->options['timestamp'] = true; else $this->options['timetsamp'] = false;
        
    }

    public function format($text, $color)
    {
        
        return chr(27) . "$color" .  "$text" . chr(27) . "[0m";
        
    }

    public function write($text, $color)
    {
        
        echo $this->format($text, $color) . PHP_EOL;
        
    }

}

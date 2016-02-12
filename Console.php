<?php

namespace Dreamcoil;

class Console
{

    private $options;

    public function __construct(array $options)
    {
        
        if($options['showTimestamp']) $this->options['showTimestamp'] = true; 
        else $this->options['showTimetsamp'] = false;
        
    }

    public function format($text, $color)
    {
        
        return chr(27) . "$color" .  "$text" . chr(27) . "[0m";
        
    }

    public function write($text, $color)
    {
        
        if ($this->options['showTimetsamp']) $date = date(DATE_RFC2822) . " ";
        else $date = "";
        
        echo $date . $this->format($text, $color) . PHP_EOL;
        
    }

}

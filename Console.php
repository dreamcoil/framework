<?php

namespace Dreamcoil;

class Console
{

    private $options;

    public function __construct(array $options)
    {
        
        if(isset($options['showTimestamp'])) $this->options['showTimestamp'] = true; 
        else $this->options['showTimestamp'] = false;
        
    }

    public function format($text, $color = CONSOLE_TEXT_WHITE)
    {
        
        return chr(27) . "$color" .  "$text" . chr(27) . "[0m";
        
    }

    public function write($text, $color = CONSOLE_TEXT_WHITE)
    {
        
        if ($this->options['showTimestamp']) $date = date(DATE_RFC2822) . " ";
        else $date = "";
        
        echo $date . $this->format($text, $color) . PHP_EOL;
        
    }

}

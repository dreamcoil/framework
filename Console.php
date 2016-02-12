<?php

namespace Dreamcoil;

class Console
{

    public function format($text, $color)
    {
        
        return chr(27) . "$color" .  "$text" . chr(27) . "[0m";
        
    }

    public function write($text, $color)
    {
        
        echo $this->format($text, $color) . PHP_EOL;
        
    }

}

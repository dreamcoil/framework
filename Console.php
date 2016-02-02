<?php

namespace Dreamcoil;

class Console
{

    public function write($text, $color)
    {
        
        echo chr(27) . "$color" .  "$text" . chr(27) . "[0m";
        
    }
    
    }

}

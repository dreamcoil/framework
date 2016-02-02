<?php

namespace Dreamcoil;

class Console
{

    public function write($text, $textColor)
    {
        
        echo chr(27) . "$textColor" .  "$text" . chr(27) . "[0m";
        
    }
    
    }

}

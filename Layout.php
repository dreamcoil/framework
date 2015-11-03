<?php

namespace Dreamcoil;

class Layout
{
    private $layout, $data, $view;

    public function __construct($layout, $data = array())
    {

        $this->view = new \Dreamcoil\View();

        $this->layout;

        $this->data = $data;

        $this->view->inc('layouts.' . $this->layout . 'head', $this->data);

    }
    
    public function require($file)
    {
        
        $file = explode('.',$file);
        
        if($file[1] == 'css') echo '<link href="'.$file[0].'" rel="stylesheet">';
        
        if($file[1] == 'js') echo '<script src="'.$file[0]'"></script>';
        
    }

    public function __destruct()
    {

        $this->view->inc('layouts.' . $this->layout . 'foot', $this->data);

    }

}

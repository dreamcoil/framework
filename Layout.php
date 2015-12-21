<?php

namespace Dreamcoil;

class Layout
{
    private $layout, $data, $view;

    /**
     * Loads a Layout
     *
     * @param $layout
     * @param array $data
     */
    public function __construct($layout, $data = array())
    {

        $this->view = new \Dreamcoil\View();

        $this->layout = $layout;

        $this->data = $data;

        $this->view->inc('layouts.' . $this->layout . '.head', $this->data);

    }

    /**
     * Finished the layout
     */
    public function __destruct()
    {
        global $config;

        $this->view->inc('layouts.' . $this->layout . '.foot', $this->data);

        $debug = Debug::get();

        if(isset($debug) && $config->get('debug')) echo '<pre>' . $debug . '</pre>';

    }

}

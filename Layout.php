<?php

namespace Dreamcoil;

class Layout extends Phase
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

        parent::__construct();

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

        $this->view->inc('layouts.' . $this->layout . '.foot', $this->data);

        if(isset(Debug::get()) && $this->config->get('debug')) echo '<pre>' . Debug::get() . '</pre>';

    }

}

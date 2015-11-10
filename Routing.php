<?php

namespace Dreamcoil;

class Route
{

    public $data;
    private $group;

    /**
     * Returns the current URL
     *
     * @return string/array
     */
    public function get($params = false)
    {

        $explode = explode('?', ROUTE);

        if($params) return $explode;

        return $explode[1];

    }

    /**
     * Returns the URL splitted into parts
     *
     * @return array
     */
    public function getArgs()
    {

        $return = explode('/',$this->get());

        return $return;

    }

    /**
     * Sends to user to a new location
     *
     * @param $to
     */
    public function set($to)
    {

        header('Location: ' . substr(PHP_DIR, 0, -1) . $to);

    }

    /**
     * Checks, if a specified route is currently requested
     *
     * @param $route
     * @return bool
     */
    public function is($route)
    {

        if(isset($this->group)) $route = '/' . $this->group . '/' . $route;

        if(preg_match_all("/{?[a-zA-Z0-9_]{1,}}/", $route, $variables))
        {

            $argv = explode('/',$route);

            if(count($argv) == count($this->getArgs()))
            {

                $i = 0;

                foreach($argv as $var)
                {

                    if($var == $this->getArgs()[$i])
                    {

                        $return[$i] = true;

                    }
                    else
                    {

                        if(strpos($var,'{') !== false)
                        {

                            //echo $var . ' = ' . $this->getArgs()[$i] . ' | ';

                            $return[$i] = true;

                            $var_name = str_replace(array('{','}'),array('',''), $var);

                            $data[$var_name] = $this->getArgs()[$i];

                        }
                        else
                        {

                            $return[$i] = false;

                        }

                    }


                    $i++;

                }


                if(in_array(false, $return))
                    return false;

                else
                {

                    $this->data = $data;

                    return true;

                }

            }
            else
                return false;

        }

        if($this->get() == $route) return true;

        return false;

    }

    /**
     * Enable group routing
     *
     * @param $group
     * @return bool
     */
    public function group($group)
    {

        if($this->getArgs()[1] == $group)
        {

            $this->group = $group;

            return true;

        }

        return false;

    }


}

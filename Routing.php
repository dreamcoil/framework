<?php

namespace Dreamcoil;

class Route
{

    public $data;
    private $group;

    /**
     * Returns the current URL
     *
     * @param $params
     *
     * @return string/array
     */
    public static function get($params = false)
    {
        $explode = explode('?', ROUTE);
        if($params) return $explode;

        return $explode[0];
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
    public static function set($to)
    {
        header('Location: ' . $to);
        die("<h1>You should be</h1><p>Target: <a href='" . $to . "'>" . $to . "</a></p>");
    }

    /**
     * Checks, if a specified route is currently requested
     *
     * @param $route
     * @return bool
     */
    public function is($route)
    {
        global $show404;

        if(isset($this->group))  {
            $route = '/' . $this->group . '/' . $route;
        }

        if(preg_match_all("/{?[a-zA-Z0-9_]{1,}}/", $route, $variables))
        {
            $argv = explode('/',$route);
            $args = $this->getArgs();

            if(count($argv) == count($args))
            {
                $i = 0;
                $return = [];
                foreach($argv as $var)
                {

                    if($var == $args[$i])
                    {
                        $return[$i] = true;
                    } else {
                        if(strpos($var,'{') !== false)
                        {
                            $return[$i] = true;
                            $var_name = str_replace(array('{','}'),'', $var);
                            $data[$var_name] = $args[$i];
                        } else {
                            $return[$i] = false;
                        }
                    }

                    $i++;
                }

                if(in_array(false, $return)) {
                    return false;
                } else {
                    $this->data = $data;
                    $show404 = false;

                    return true;
                }

            } else {
                return false;
            }

        }

        if($this->get() == $route)
        {
            $show404 = false;
            return true;
        }

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



    /**
     * Returns an error code for the routing
     *
     * @return int
     */
    public function getError()
    {
        global $show404;
        return 200;
        if($show404 === null) return 404;

    }

}

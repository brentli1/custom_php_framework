<?php

namespace Core;

/**
 * Base Controller
 *
 * PHP Version 7.1.9
 */
abstract class Controller
{
    /**
     * Parameters from the matched route
     * @var array
     */
    protected $route_params = [];

    /**
     * Class constructor
     *
     * @param array $route_params Parameters from the route
     * @return void
     **/
    public function __construct($route_params)
    {
        $this->route_params = $route_params;
    }

    /**
     * Call magic method when action is unreachable
     *
     * @param string $name Name of the called action
     * @return void
     **/
    public function __call($name, $args)
    {
        $method = $name . 'Action';

        if (method_exists($this, $method)) {
            if ($this->before() !== false) {
                call_user_func_array([$this, $method], $args);
                $this->after();
            }
        } else {
            echo "Method $method not found in controller " . get_class($this);
        }
    }

    /**
     * Before filter - called before an action.
     *
     * @return void
     **/
    public function before()
    {

    }

    /**
     * After filter - called after an action.
     *
     * @return void
     **/
    public function after()
    {

    }
}

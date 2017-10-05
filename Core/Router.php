<?php

/**
 * Router
 *
 * PHP version 7.1.9
 */
class Router 
{
    /**
     * Associate array of routes
     * @var array
     */
    protected $routes = [];

    /**
     * Parameters from the matched route
     * @var array
     */
     protected $params = [];

    /**
     * Add a route to the routing table
     *
     * @param string $route The route URL
     * @param array $params Parameters (controller, action, etc.)
     * @return void
     **/
    public function add($route, $params = [])
    {
        // Convert the route to a regular expression: escape forward slashes
        $route = preg_replace('/\//', '\\/', $route);
        
        // Convert variables e.g. {controller}
        $route = preg_replace('/\{([a-z]+)\}/', '(?<\1>[a-z-]+)', $route);

        // Convert variables with custom regular expressions e.g. {id:\d+}
        $route = preg_replace('/\{([a-z]+):([^\}]+)\}/', '(?<\1>\2)', $route);
        $route = '/^' . $route . '$/i';

        $this->routes[$route] = $params;
    }

    /**
     * Get all routes from routing table
     *
     * @return array
     **/
    public function getRoutes()
    {
        return $this->routes;
    }

    /**
     * Match the route to the routing table
     *
     * Match the route to the routes found in the routing table, setting $params property
     * if a route is found.
     *
     * @param string $url The route URL
     * @return boolean true if a match is found, otherwise false
     **/
    public function match($url)
    {
        foreach ($this->routes as $route => $params) {
            if (preg_match($route, $url, $matches)) {
                foreach ($matches as $key => $match) {
                    if (is_string($key)) {
                        $params[$key] = $match;
                    }
                }
    
                $this->params = $params;
                return true;
            }
        }
        
        return false;
    }

    /**
     * Get the currently matched parameters
     *
     * @return array
     **/
    public function getParams()
    {
        return $this->params;
    }
}

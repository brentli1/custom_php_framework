<?php

// This is no longer being used in place of AltoRouter 

namespace Core;

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
     * Dispatch the route, create the controller object and run the action
     *
     * @param string $url The route URL
     * @return void
     **/
    public function dispatch($url)
    {
        $url = $this->removeQueryString($url);
        
        if ($this->match($url)) {
            $controller = $this->params['controller'];
            $controller = $this->convertToStudlyCaps($controller);
            $controller = $this->getNamespace() . $controller;

            if (class_exists($controller)) {
                $controller_object = new $controller($this->params);

                $action = $this->params['action'];
                $action = $this->convertToCamelCase($action);

                if (preg_match('/action$/i', $action) == 0) {
                    $controller_object->$action();
                } else {
                    echo 'Method $action in controller $controller cannot be called directly - remove the Action suffix to call this method.';
                }
            } else {
                echo "Controller class $controller not found.";
            }
        } else {
            // echo 'No route matched.';
            throw new \Exception('No route matched.', 404);
        }
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

    /**
     * Convert string with hypens to StudlyCaps
     *
     * @param string $string The string to convert
     * @return string
     **/
    public function convertToStudlyCaps($string)
    {
        return str_replace(' ', '', ucwords(str_replace('-', ' ', $string)));
    }

    /**
     * Convert string with hyphens to calemCase
     *
     * @param string $string The string to convert
     * @return string
     **/
    public function convertToCamelCase($string)
    {
        return lcfirst($this->convertToStudlyCaps($string));
    }

    /**
     * Remove query string variables from url
     *
     * @param string $url The full URL
     * @return string The URL with the query string removed
     **/
    public function removeQueryString($url)
    {
        if ($url != '') {
            $parts = explode('&', $url, 2);

            if (strpos($parts[0], '=') === false) {
                $url = $parts[0];
            } else {
                $url = '';
            }
        }

        return $url;
    }

    /**
     * Get the namespace for the controller class.
     *
     * @return string The request namespace
     **/
    public function getNamespace()
    {
        $namespace = 'App\Controllers\\';

        if (array_key_exists('namespace', $this->params)) {
            $namespace .= $this->params['namespace'] . '\\';
        }

        return $namespace;
    }
}

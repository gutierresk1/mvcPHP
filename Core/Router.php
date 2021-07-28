<?php

namespace Core;

use Exception;

/**
 * Router
 * 
 * PHP Version 7.something
 */
class Router
{
    /**
     * Define Associative Array: Map, Dictionary
     * @var array
     */
    protected $routes = [];

    /**
     * Parameter array from the matched route
     * @var array
     */
    protected $params = [];

    /**
     * Add a Route to the routing table. 
     * 
     * @param string $route which is the route URL
     * @param array $params Parameters (controller, action)
     * 
     * @return void
     */
    /*
        *Old way of adding route URL to the Routes array
        public function add($route, $params)
        {
            $this->routes[$route] = $params;
        }*/

    //New way off adding url routes using regex and extract. 

    public function add($route, $params = [])
    {
        /**
         * NOTES on regex:
         * backslash in regex: disables the special character it precedes. 
         */
        //convert the route argument variable into regex expression. 
        $route = preg_replace('/\//', '\\/', $route);

        //convert the variables via extract
        $route = preg_replace('/\{([a-z]+)\}/', '(?P<\1>[a-z-]+)', $route);

        //convert variables with custom regular expressions e.g: {id:\d+}
        $route = preg_replace('/\{([a-z]+):([^\}]+)\}/', '(?P<\1>\2)', $route);

        //Add start and the end delimeters, and case insensitive flag. 
        $route = '/^' . $route . '$/i';

        $this->routes[$route] = $params;
    }

    /**
     * Get all the routes from the routing table
     * 
     * @return array
     */
    public function getRoutes()
    {
        return $this->routes;
    }

    /**
     * Match method: matches the route in the routing table, setting the $params 
     * property if the match is found!
     * 
     * @param string $url The route URL
     * 
     * @return boolean true if match found, false otherwise.
     */

    public function match($url)
    {
        /**foreach ($this->routes as $route => $params) {
            if ($url == $route) {
                $this->params = $params;
                return true;
            }
        }
        return false; 
         *simple straight forward matching! Not complex enough.. 
         **/

        //match now with regex(Regular Expressions) to the fixed URL format: /controller/action
        //$reg_exp = "/^(?P<controller>[a-z-]+)\/(?P<action>[a-z-]+)$/";
        //no longer need the fixed url format. 

        /*if (preg_match($reg_exp, $url, $matches)) {
            // Get name of capture group values!
            $params = [];

            foreach ($matches as $key => $match) {
                if (is_string($key)) {
                    $params[$key] = $match;
                }
            }
            $this->params = $params;
            return true;
        }*/

        foreach ($this->routes as $route => $params) {
            if (preg_match($route, $url, $matches)) {
                //get the named capture group values. 

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
     * Get the current matched parameters
     * 
     * @return array
     */

    public function getParams()
    {
        return $this->params;
    }

    /**
     * Convert strings with hyphens into StudlyCaps, e.g. post-authors => PostAuthors. 
     * 
     * @param string $string: The string to convert.
     * 
     * @return string
     */
    protected function convertToStudlyCaps($string)
    {
        return str_replace(' ', '', ucwords(str_replace('-', '', $string)));
    }

    /**
     * Convert strings with hyphens into camelCase, e.g. add-new => addNew
     * 
     * @param string $string: The string to convert
     * 
     * @return string 
     */
    protected function convertToCamelCase($string)
    {
        return lcfirst($this->convertToStudlyCaps($string));
    }

    /**
     * removeQueryStringVariables: cuts the url and removes the Query String 
     * 
     * After removal, we will have the route to match
     * 
     * @param string $url: The full URL string.
     * 
     * @return string : The URL with the query string variables removed. 
     */

    protected function removeQueryStringVariables($url)
    {
        if ($url != '') {
            $parts = explode('&', $url, 2);

            if (strpos($parts[0], '=') == false) {
                $url = $parts[0];
            } else {
                $url = '';
            }
        }
        return $url;
    }

    /**
     * Dispatch: following the directions that were initiated by the route.
     * The dispatch method will create the controller object and create the naming 
     * the action method
     * 
     * @param string $url The route URL
     * 
     * @return void
     */
    public function dispatch($url)
    {
        $url = $this->removeQueryStringVariables($url);

        if ($this->match($url)) {
            $controller = $this->params['controller'];
            $controller = $this->convertToStudlyCaps($controller);
            //$controller = "App\Controllers\\$controller";
            $controller = $this->getNamespace() . $controller;

            if (class_exists($controller)) {
                //when creating the controller object, route parameters coming from the router. 
                $controller_object = new $controller($this->params);

                $action = $this->params['action'];
                $action = $this->convertToCamelCase($action);

                if (is_callable([$controller_object, $action])) {
                    $controller_object->$action();
                } else {
                    throw new \Exception("Method $action (in controller $controller) not found");
                }
            } else {
                //echo "Controller class $controller does not exist";
                throw new \Exception("Controller class $controller not found");
            }
        } else {
            //echo "no route found";
            //throw new \Exception("No route matched");
            //If we do not have a route match, we then throw a 404 error
            throw new \Exception('No route matched.', 404);
        }
    }

    /**
     * Get the namespace for the controller class. The namespace defined
     * in the route parameters is added if present.
     */
    protected function getNamespace()
    {
        $namespace = 'App\Controllers\\';

        if (array_key_exists('namespace', $this->params)) {
            $namespace .= $this->params['namespace'] . '\\';
        }
        return $namespace;
    }
}

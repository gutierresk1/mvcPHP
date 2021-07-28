<?php

namespace Core;

/**
 * Base Controller 
 * 
 * The class will be the parent class of the Controller folder.
 * 
 * PHP
 */
//Abstract classes cannot be instantiated. We create objects of classes that extend this one.
abstract class Controller
{
    /**
     * Parameters fromm the matched route
     * @var array
     */
    protected $route_params = [];

    /**
     * Class constructor
     * 
     * @param array $route_params: the Parameters from the route. 
     * 
     */
    public function __construct($route_params)
    {
        $this->route_params = $route_params;
    }

    /**
     * function __call: What gets called if method is non-public or non-existent.
     * @param array $args the Arguments passed to the method
     */
    public function __call($name, $args)
    {
        $method = $name . 'Action';

        if (method_exists($this, $method)) {
            if ($this->before() !== false) {
                call_user_func_array([$this, $method], $args);
                $this->after();
            }
        } else {
            //if method is not found in the controller.
            throw new \Exception("Method $method not found in controller " . get_class($this));
        }
    }

    /**
     * Before filter: called before an action method.
     * 
     * @return void
     */

    protected function before()
    {
    }

    /**
     * After filter: Called after an action method.
     */
    protected function after()
    {
    }
}

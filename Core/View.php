<?php

namespace Core;

/**
 * View 
 * PHP
 */
class View
{
    /**
     * Render a view file
     * 
     * @param string $view The view file
     * 
     * @return void
     */
    public static function render($view, $args = [])
    {
        //note: EXTR_SKIP => do not overwrite the exisiting variable if collision is involved. 
        extract($args, EXTR_SKIP);

        $file = "../App/Views/$view"; //relative to core directory

        if (is_readable($file)) {
            require $file;
        } else {
            //echo "$file not found";
            //Essentially what these error handlers is give a better error message. 
            throw new \Exception("$file not found");
        }
    }

    /**
     * Render a view template using Twig 1.0
     * 
     * @param string $template: this is the template file. 
     * 
     * @param array $args: Associative array of data to display in the view (not required) 
     */
    //recap what is a static function again? 
    //Answer: Belongs to the class, not the instance ($this?)
    //referenced by class name and invoked without creating an object of the class. 
    public static function renderTemplate($template, $args = [])
    {
        //What is the static keyword before decalring/initializing varibale?
        //Answer: A static variable will not lose its function when exiting out of the function.
        //will continue to hold the value of the variable if the function is called again.
        static $twig = null;

        if ($twig === null) {
            //define Twig_Loader_Filesystem which takes a path of the directory
            //adds a path where the templates are stored.
            $loader = new \Twig_Loader_Filesystem('../App/Views');
            //define Twig_Environment(parameter being the path above).
            //registers a path.
            $twig = new \Twig_Environment($loader);
        }
        echo $twig->render($template, $args);
    }
}

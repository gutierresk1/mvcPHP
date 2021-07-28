<?php

/**
 *Front Controller 
 *
 *PHP Version 7
 */

//echo 'Requested URL = "' . $_SERVER['QUERY_STRING'] . '"';
//Require the controller class
//require '../App/Controllers/Posts.php';

/** Declare and instantiate the router class/object */
//require '../Core/Router.php';

/**
 * Twig library
 */
//require_once: not include the file once again via checking if file was included. 
require_once dirname(__DIR__) . '/vendor/autoload.php';
Twig_Autoloader::register();

/**
 * create the the error and exception handling
 */
//parameters are the methods in the error class of core namespace
error_reporting(E_ALL);
set_error_handler('Core\Error::errorHandler');
set_exception_handler('Core\Error::exceptionHandler');


$router = new Core\Router();

//echo get_class($router);
//Add the routes to the routing table. 
$router->add('', ['controller' => 'Home', 'action' => 'index']);
//$router->add('posts', ['controller' => 'Posts', 'action' => 'index']);
//$router->add('posts/new', ['controller' => 'Posts', 'action' => 'new']);
$router->add('{controller}/{action}');
//$router->add('admin/{action}/{controller}');
$router->add('{controller}/{id:\d+}/{action}');
$router->add('admin/{controller}/{action}', ['namespace' => 'Admin']);

$router->dispatch($_SERVER['QUERY_STRING']);



//No longer needed as the classes are autloaded via hashing through the composer.json file.
/**spl_autoload_register(function ($class) {
    $root = dirname(__DIR__); //This will grab the parent directory.
    $file = $root . '/' . str_replace('\\', '/', $class) . '.php';
    if (is_readable($file)) {
        require $root . '/' . str_replace('\\', '/',  $class) . '.php';
    }
});*/


//Display the routing table to the browser
//echo '<pre>';
//var_dump($router->getRoutes());
/**
 * NOTES
 * htmlspecialchars method: Converts special characters into HTML entities.
 * 
 * 
 */
//echo htmlspecialchars(print_r($router->getRoutes(), true));
//echo '</pre>';

//Match the requested route
/**$url = $_SERVER['QUERY_STRING'];

if ($router->match($url)) {
    echo '<pre>';
    var_dump($router->getParams());
    echo '</pre>';
} else {
    echo "No route found for the URL '$url'"; 
}*/

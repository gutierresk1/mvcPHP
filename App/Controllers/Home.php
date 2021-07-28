<?php

namespace App\Controllers;

use \Core\View;
//what is use?
//answer: importing

/**
 * PHP version 7.something.
 */

class Home extends \Core\Controller
{
    /**
     * Before filter
     * 
     * @return void
     */
    protected function before()
    {
        //echo "(before) ";
    }

    /**
     * After filter
     * 
     * @return void
     */
    protected function after()
    {
        echo "(after) ";
    }


    /**
     * Show the index page.
     * 
     * return @void
     */
    public function indexAction()
    {
        View::renderTemplate('Home/index.html', [
            'name' => 'Kris',
            'colors' => ['red', 'green', 'blue']
        ]);

        //echo 'Hello from the index action of the HomeController';
        /**View::render(
            'Home/index.php',
            [
                'name' => 'Dave',
                'colors' => ['red', 'green', 'blue']
            ]
        );*/
        //what is ::?
        //:: means Scope resolution operator.
        //Scope resolution operator: allows access to content
    }
}

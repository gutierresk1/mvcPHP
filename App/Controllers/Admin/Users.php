<?php

namespace App\Controllers\Admin;

/**
 * Users admin controller
 * 
 * PHP
 */

class Users extends \Core\Controller
{
    /**
     * Before filter
     * 
     * @return void
     */
    protected function before()
    {
        //makes sure an admin user is logged in for example
    }

    /**
     * Shows the index page
     * 
     * @return void
     */
    public function indexAction()
    {
        echo 'User admin index';
    }
}

<?php

namespace App\Controllers;

use \Core\View;
use App\Models\Post;

/**
 * Posts Controller
 * 
 * PHP version 5.4
 */
class Posts extends \Core\Controller
{
    /**
     * Show the index page
     * 
     * @return void
     */
    public function indexAction()
    {
        $posts = Post::getAll();

        View::renderTemplate('Posts/index.html', [
            'posts' => $posts
        ]);

        //echo 'Hello from the index action in the Posts Controller!';
        //echo '<p>Query string parameters <pre>' .
        //htmlspecialchars(print_r($_GET), true) . '</pre></p>';
    }

    /**
     * Show the add new page
     * 
     * @return void
     */
    public function addNewAction()
    {
        echo 'Hello from the addNew action in the posts Controller!';
    }

    /**
     * show the edit page.
     * 
     * @return void
     */
    public function editAction()
    {
        echo 'Hello from the edit action in the posts controller!';
        echo '<p>Route parameters: <pre>' .
            htmlspecialchars(print_r($this->route_params, true)) . '</pre></p>';
    }
}

<?php

namespace App\Controllers;

use Core\Controller;
use Core\View;

/**
 * Posts Controller
 *
 * PHP version 7.1.9
 */
class Posts extends Controller
{
    /**
     * Show the index page
     *
     * @return void
     **/
    public function indexAction()
    {
        View::render('Posts/index.php', [
            'name' => 'Sonic the Hedgehog'
        ]);
    }

    /**
     * Show the new page
     *
     * @return void
     **/
    public function newAction()
    {
        echo 'Hello from the new page from Posts :D';
    }

    /**
     * Show the edit page
     *
     * @return void
     **/
    public function editAction()
    {
        echo '<p> Route Parameters: <pre>' .
                htmlspecialchars(print_r($this->route_params, true)) . '</pre></p>';
    }
}

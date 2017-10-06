<?php

namespace Core;

/**
 * View controller
 * 
 * PHP version 7.1.9
 */
class View
{
    /**
     * Render a view file
     *
     * @param string $view The view file
     * @return void
     **/
    public static function render($view, $args = [])
    {
        extract($args, EXTR_SKIP);
        
        $file = "../App/Views/$view";

        if (is_readable($file)) {
            require $file;
        } else {
            echo "$file not found.";
        }
    }
}

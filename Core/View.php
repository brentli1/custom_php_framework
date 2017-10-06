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

    /**
     * Render a twig template
     *
     * @param string $template The template file name
     * @param array $args Associate array of data to display in view
     * @return void
     **/
    public static function renderTemplate($template, $args = [])
    {
        static $twig = null;
        
        if ($twig === null) {
            $loader = new \Twig_Loader_Filesystem('../App/Views');
            $twig = new \Twig_Environment($loader);
        }

        echo $twig->render($template, $args);
    }
}

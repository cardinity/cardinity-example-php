<?php

class View
{
    function render($view, $layout = 'app')
    {
        $content = '../app/views/' . $view . '.php';
        include_once '../app/views/layout/' . $layout . '.php';
    }
}

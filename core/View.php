<?php

namespace Core;

class View
{
    function render(string $view, string $layout = 'app')
    {
        $content = '../app/views/' . $view . '.php';
        include_once '../app/views/layout/' . $layout . '.php';
    }
}

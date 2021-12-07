<?php
class Controller
{
    public View $view;

    function __construct()
    {
        $this->view = new View();
    }
}

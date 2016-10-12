<?php

class Template
{

    private $name;

    function __construct($name)
    {
        $this->name = $name;
    }

    function output(array $vars)
    {
        include($this->name); 
    }
}


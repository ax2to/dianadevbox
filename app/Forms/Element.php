<?php

namespace App\Forms;

class Element
{
    public $name = 'unnamed';
    public $label = 'UnNamed';
    public $class;
    public $type = 'text';
    public $data = [];

    public function __construct($name = 'unnamed', $label = 'UnNamed', $type = 'text', $class = '')
    {
        $this->name = $name;
        $this->label = $label;
        $this->type = $type;
        $this->class = $class;
    }
}
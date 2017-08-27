<?php

namespace App\Forms;

class Element
{
    public $name = 'unnamed';
    public $label = 'UnNamed';
    public $class = null;
    public $type = 'text';
    public $data = [];
    public $default = null;

    public function __construct($name, $label = 'UnNamed', $type = 'text', $class = '')
    {
        $this->name = $name;
        $this->label = $label;
        $this->type = $type;
        $this->class = $class;
    }

    public function setData($data)
    {
        $this->data = $data;
    }

    public function setDefault($value)
    {
        $this->default = $value;
    }
}
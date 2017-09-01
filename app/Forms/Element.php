<?php

namespace App\Forms;

class Element
{
    public $name = 'unnamed';
    public $label = 'UnNamed';
    public $wrapper = null;
    public $type = 'text';
    public $data = [];
    public $default = null;
    private $options = [];

    public function __construct($name, $label = 'UnNamed', $type = 'text', $wrapper = '')
    {
        $this->name = $name;
        $this->label = $label;
        $this->type = $type;
        $this->wrapper = $wrapper;
        $this->addOption('class', 'form-control');
    }

    public function addOption($key, $value)
    {
        $this->options[$key] = $value;
        return $this;
    }

    /**
     * @return array
     */
    public function getOptions(): array
    {
        return $this->options;
    }

    /**
     * @param array $options
     * @return Element
     */
    public function setOptions(array $options): Element
    {
        $this->options = $options;
        return $this;
    }

    public function setData($data)
    {
        $this->data = $data;
        return $this;
    }

    public function setDefault($value)
    {
        $this->default = $value;
        return $this;
    }
}
<?php

namespace App\Forms;

use Collective\Html\FormFacade;

class BaseForm
{
    public $action = '';
    public $method = 'GET';
    public $class = 'form form-horizontal';
    private $isModel = false;
    private $model;
    private $elements = [];

    public function __construct($action = '', $method = 'POST')
    {
        $this->action = $action;
        $this->method = $method;
        $this->init();
    }

    public function init()
    {
    }

    public function setModel($model)
    {
        $this->isModel = true;
        $this->model = $model;

        return $this;
    }

    public function setVerticalForm()
    {
        $this->class = 'form form-vertical';
        return $this;
    }

    public function open()
    {
        $params = ['url' => $this->action, 'method' => $this->method];
        if ($this->isModel) {
            return FormFacade::model($this->model, $params);
        }
        return FormFacade::open($params);
    }

    public function body()
    {
        if ($this->isModel) {
            $this->cleanDefaultValues();
        }
        return view('forms.form')->with('form', $this);
    }

    private function cleanDefaultValues()
    {
        foreach ($this->elements as $element) {
            $element->setDefault(null);
        }
    }

    public function close()
    {
        return FormFacade::close();
    }

    public function __toString()
    {
        return 'string';
    }

    public function addElement($element)
    {
        $this->elements[$element->name] = $element;
    }

    public function getElements()
    {
        return $this->elements;
    }

    public function removeElement($name)
    {
        unset($this->elements[$name]);
        return $this;
    }

    /**
     * @param $name
     * @return Element
     */
    public function getElement($name)
    {
        return $this->elements[$name];
    }
}
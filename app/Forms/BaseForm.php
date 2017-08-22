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

    public function __construct($action = '')
    {
        $this->action = $action;
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
        if ($this->isModel) {
            return FormFacade::model($this->model);
        }
        return FormFacade::open(['url' => $this->action]);
    }

    public function body()
    {
        return view('forms.form')->with('form', $this);
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
        $this->elements[] = $element;
    }

    public function getElements()
    {
        $data = [];
        foreach ($this->elements as $element) {
            $data[] = [
                'field' => $element->name,
                'label' => $element->label,
                'class' => $element->class,
                'type' => $element->type,
                'data' => $element->data
            ];
        }
        return $data;
    }
}
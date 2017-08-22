<?php

namespace App\Forms;

class UserForm extends BaseForm
{
    public function __construct($action = '')
    {
        parent::__construct($action);
        $this->method = 'PUT';

        $this->addElement(new Element('name', 'Name', 'text', 'col-md-6'));
        $this->addElement(new Element('lastName', 'Last Name', 'text', 'col-md-6'));
        $this->addElement(new Element('email', 'Email', 'text', 'col-md-12'));
        $this->addElement(new Element('password', 'Password', 'password', 'col-md-6'));
        $this->addElement(new Element('password_confirmation', 'Confirm Password', 'password', 'col-md-6'));
    }
}
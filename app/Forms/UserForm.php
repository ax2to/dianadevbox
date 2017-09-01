<?php

namespace App\Forms;

use App\Models\RoleModel;
use DateTimeZone;
use Illuminate\Support\Facades\Auth;

class UserForm extends BaseForm
{
    public function init()
    {
        $user = Auth::user();

        $this->addElement(new Element('name', 'Name', 'text', 'col-md-6'));
        $this->addElement(new Element('lastName', 'Last Name', 'text', 'col-md-6'));
        $this->addElement(new Element('email', 'Email', 'text', 'col-md-12'));
        $this->addElement(new Element('password', 'Password', 'password', 'col-md-6'));
        $this->addElement(new Element('password_confirmation', 'Confirm Password', 'password', 'col-md-6'));

        if ($user->can('change-role', $user)) {
            $this->addElement(new Element('role_id', 'Role', 'select', 'col-md-6'));
            $this->getElement('role_id')->setData($this->getRoleOptions());
        }

        $this->addElement(new Element('timezone', 'TimeZone', 'select', 'col-md-6'));
        $this->getElement('timezone')->setData($this->getTimeZonesOptions());
    }

    public function getRoleOptions()
    {
        return RoleModel::pluck('name', 'id')->toArray();
    }

    private function getTimeZonesOptions()
    {
        $data = [];
        $all = DateTimeZone::listIdentifiers(DateTimeZone::ALL);
        foreach ($all as $timezone) {
            $data[$timezone] = $timezone;
        }
        return $data;
    }
}
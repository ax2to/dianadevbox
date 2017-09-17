<?php

namespace App\Forms;

use App\Models\ProjectModel;
use Illuminate\Support\Facades\Auth;

class GoalForm extends BaseForm
{
    public function init()
    {
        $this->addElement(new Element('project_id', 'Project', 'select', 'col-md-12'));
        $this->addElement(new Element('name', 'Goal', 'text', 'col-md-12'));
        $this->addElement(new Element('description', 'Description', 'textarea', 'col-md-12'));
        $this->addElement(new Element('start_at', 'Start Date', 'text', 'col-md-6'));
        $this->addElement(new Element('end_at', 'Due Date', 'text', 'col-md-6'));

        $this->getElement('project_id')->setData($this->getProjectOptions());
        $this->getElement('start_at')->addOption('placeholder', date('Y-m-d'));
        $this->getElement('end_at')->addOption('placeholder', date('Y-m-d'));
    }

    private function getProjectOptions()
    {
        return ProjectModel::where('company_id', Auth::user()->company_id)
            ->allowedForUser(Auth::user())
            ->orderBy('name')
            ->pluck('name', 'id')
            ->toArray();
    }
}
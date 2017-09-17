<?php

namespace App\Forms;

use App\Models\Issue\PriorityModel;
use App\Models\Issue\TypeModel;
use App\Models\ProjectModel;
use App\User;
use Illuminate\Support\Facades\Auth;

class IssueForm extends BaseForm
{
    public function init()
    {
        $project = new Element('project_id');
        $project->label = 'Project';
        $project->wrapper = 'col-md-6';
        $project->type = 'select';
        $project->data = $this->getProjectOptions();

        $issueType = new Element('type_id');
        $issueType->label = 'Issue Type';
        $issueType->wrapper = 'col-md-3';
        $issueType->type = 'select';
        $issueType->data = TypeModel::all()->pluck('name', 'id');

        $priority = new Element('priority_id', 'Priority', 'select', 'col-md-3');
        $priority->data = PriorityModel::all()->pluck('name', 'id');

        $summary = new Element('summary', 'Summary', 'text', 'col-md-12');
        $description = new Element('description', 'Description', 'textarea', 'col-md-12');
        $description->addOption('id', 'editor1')->addOption('class', 'form-control ckeditor')->addOption('rows', 5);

        $assign_to = new Element('assign_to', 'Assign To', 'select', 'col-md-6');
        $assign_to->data = $this->getAssignToOptions();
        $assign_to->setDefault(Auth::id());

        $this->addElement($project);
        $this->addElement($issueType);
        $this->addElement($priority);
        $this->addElement($summary);
        $this->addElement($description);
        $this->addElement($assign_to);
        $this->addElement((new Element('estimated', 'Estimated', 'text', 'col-md-3'))->setDefault('1H'));
    }

    public function getProjectOptions()
    {
        return ProjectModel::where('company_id', Auth::user()->company_id)
            ->allowedForUser(Auth::user())
            ->pluck('name', 'id')
            ->toArray();
    }

    public function getAssignToOptions()
    {
        return User::where('company_id', Auth::user()->company_id)
            ->orderBy('name')
            ->get()
            ->pluck('fullName', 'id')
            ->toArray();
    }
}
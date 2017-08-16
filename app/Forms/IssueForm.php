<?php

namespace App\Forms;

use App\Models\Issue\PriorityModel;
use App\Models\Issue\TypeModel;
use App\Models\ProjectModel;
use App\User;

class IssueForm extends BaseForm
{
    public function __construct($action = '')
    {
        $this->method = 'PUT';

        $project = new Element();
        $project->name = 'project_id';
        $project->label = 'Project';
        $project->class = 'col-md-6';
        $project->type = 'select';
        $project->data = ProjectModel::all()->pluck('name', 'id');

        $issueType = new Element();
        $issueType->name = 'type_id';
        $issueType->label = 'Issue Type';
        $issueType->class = 'col-md-6';
        $issueType->type = 'select';
        $issueType->data = TypeModel::all()->pluck('name', 'id');

        $summary = new Element('summary', 'Summary', 'text', 'col-md-12');
        $description = new Element('description', 'Description', 'textarea', 'col-md-12');

        $priority = new Element('priority_id', 'Priority', 'select', 'col-md-6');
        $priority->data = PriorityModel::all()->pluck('name', 'id');

        $assign_to = new Element('assign_to', 'Assign To', 'select', 'col-md-6');
        $assign_to->data = User::all()->pluck('name', 'id');

        $this->addElement($project);
        $this->addElement($issueType);
        $this->addElement($summary);
        $this->addElement($description);
        $this->addElement($priority);
        $this->addElement($assign_to);
    }
}
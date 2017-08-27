<?php

namespace App\Forms;

use App\Models\IssueModel;

class WorkLogForm extends BaseForm
{
    public function init()
    {
        $this->addElement(new Element('issue_id', 'Issue', 'select', 'col-md-12'));
        $this->addElement(new Element('worked', 'Worked', 'text', 'col-md-6'));
        $this->addElement(new Element('date', 'Date', 'date', 'col-md-6'));
        $this->addElement(new Element('description', 'Description', 'textarea', 'col-md-12'));

        $this->getElement('issue_id')->setData($this->getIssueOptions());
    }

    private function getIssueOptions()
    {
        $data = [];
        $issues = IssueModel::where('company_id', \Auth::user()->company_id)
            ->orderBy('id', 'desc')
            ->get();
        foreach ($issues as $issue) {
            $data[$issue->id] = $issue->id . ' - ' . $issue->summary;
        }
        return $data;
    }
}
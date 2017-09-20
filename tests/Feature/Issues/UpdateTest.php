<?php

namespace Tests\Feature\Issues;

use App\Models\IssueModel;
use App\User;
use Tests\TestCase;

class UpdateTest extends TestCase
{
    /**
     * @var string
     */
    private $url = 'issues/:id/update';
    /**
     * @var User
     */
    private $user;
    /**
     * @var IssueModel
     */
    private $issue;

    public function testLinkOnNavigation()
    {
        $this->visit('/')
            ->click('All Issues')
            ->seePageIs('issues');
    }

    public function testFormFields()
    {
        $this->visit($this->url)
            ->see('Project')
            ->see('Issue Type')
            ->see('Summary')
            ->see('Description')
            ->see('Priority')
            ->see('Assign To');
    }

    public function testFormFilled()
    {
        $this->visit($this->url)
            ->seeIsSelected('project_id', $this->issue->project_id)
            ->seeIsSelected('type_id', $this->issue->type_id)
            ->seeIsSelected('priority_id', $this->issue->priority_id)
            ->seeInField('summary', $this->issue->summary)
            ->seeInField('description', $this->issue->description)
            ->seeIsSelected('assign_to', $this->issue->assign_to)
            ->seeInField('estimated', $this->issue->estimated);
    }

    protected function setUp()
    {
        parent::setUp();

        // auth
        $this->user = $this->actingAs(User::find(1));

        $this->issue = IssueModel::where('company_id', auth()->user()->company_id)
            ->where('resolution_id', 8)
            ->first();

        $this->url = route('issues.edit', $this->issue);
    }
}

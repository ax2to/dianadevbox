<?php

namespace Tests\Feature\Issues;

use App\Models\IssueModel;
use App\User;
use Tests\TestCase;

class CreateTest extends TestCase
{
    private $url = 'issues/create';

    public function testLinkOnNavigation()
    {
        $this->visit('/')
            ->click('Create Issue')
            ->seePageIs($this->url);
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

    public function testCreateIssue()
    {
        $issue = factory(IssueModel::class)->make();
        $this->visit($this->url)
            //->select('3', 'project_id')
            ->type($issue->summary, 'summary')
            ->type($issue->description, 'description')
            ->press('Save')
            ->see(sprintf('The issue, %s, was created successfully.', $issue->summary));
    }

    protected function setUp()
    {
        parent::setUp();

        // auth
        $this->actingAs(User::find(1));
    }
}

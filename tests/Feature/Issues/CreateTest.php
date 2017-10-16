<?php

namespace Tests\Feature\Issues;

use App\Models\CompanyModel;
use App\Models\IssueModel;
use App\Models\ProjectModel;
use App\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class CreateTest extends TestCase
{
    use DatabaseTransactions;

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

    /**
     * @test
     */
    public function create_fast_issue()
    {
        // Data Expected...
        $summary = 'New Issue Fast Created by Unit Test Method';

        // Create New Company...
        $company = factory(CompanyModel::class)->create([
            'name' => 'Company Unit Testing Go'
        ]);

        // Create new user and associate company...
        $user = factory(User::class)->make([
            'name' => 'John',
            'lastName' => 'Monkey',
            'email' => 'john.monkey@diana.dev',
            'role_id' => 1
        ]);
        $company->users()->save($user);

        // Create new project and associate company...
        $project = factory(ProjectModel::class)->create([
            'company_id' => $company->id
        ]);

        // THEN...
        $this->actingAs($user)
            ->visit('/')
            ->within('#addIssue', function () use ($project, $summary) {
                $this->seeText($project->namespace)
                    ->select($project->id, 'project_id')
                    ->type($summary, 'summary')
                    ->press('Save');
            });

        // In Database Issues...
        $this->seeInDatabase('issues', [
            'project_id' => $project->id,
            'summary' => $summary
        ]);
    }

    /**
     * @test
     */
    public function after_create_issue_fast_then_user_see_issue_details()
    {
        // Data Expected...
        $summary = 'New Issue Fast Created by Unit Test Method';

        // Create New Company...
        $company = factory(CompanyModel::class)->create([
            'name' => 'Company Unit Testing Go'
        ]);

        // Create new user and associate company...
        $user = factory(User::class)->make([
            'name' => 'John',
            'lastName' => 'Monkey',
            'email' => 'john.monkey@diana.dev',
            'role_id' => 1
        ]);
        $company->users()->save($user);

        // Create new project and associate company...
        $project = factory(ProjectModel::class)->create([
            'company_id' => $company->id
        ]);

        // THEN...
        $this->actingAs($user)
            ->visit('/')
            ->within('#addIssue', function () use ($project, $summary) {
                $this->seeText($project->namespace)
                    ->select($project->id, 'project_id')
                    ->type($summary, 'summary')
                    ->press('Save');
            });

        // Created Issue...
        $issue = IssueModel::where([
            'project_id' => $project->id,
            'summary' => $summary,
            'status_id' => 3
        ])->first();
        // Redirect to Issue Details...
        $this->seeRouteIs('issues.show', [$issue->id])
            ->seeText($summary)
            ->seeText('In Progress');
    }

    protected function setUp()
    {
        parent::setUp();

        // auth
        $this->actingAs(User::find(1));
    }
}

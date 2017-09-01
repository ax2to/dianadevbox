<?php

namespace Tests\Feature\Projects;

use App\Models\ProjectModel;
use App\User;
use Tests\TestCase;

class CreateTest extends TestCase
{

    public function testTheLinkOnNavigation()
    {
        $this->visit('/')
            ->click('Create Project')
            ->seePageIs('projects/create');
    }

    public function testCreateForm()
    {
        $this->visit('projects/create')
            ->see('Create new project')
            ->see('Name')
            ->see('Description')
            ->see('Save');
    }

    public function testCreateProject()
    {
        $project = factory(ProjectModel::class)->make();
        $this->visit('projects/create')
            ->type($project->name, 'name')
            ->type($project->description, 'description')
            ->press('Save')
            ->see(sprintf('The project, %s, was created successfully', $project->name));
    }

    protected function setUp()
    {
        parent::setUp();

        // auth
        $this->actingAs(User::find(1));
    }
}

<?php

namespace Tests\Feature\Projects;

use App\Models\ProjectModel;
use App\User;
use Tests\TestCase;

class ReadTest extends TestCase
{
    /**
     * @group projects
     */
    public function testPage()
    {
        $project = ProjectModel::find(1);
        $this->visit('/projects/' . $project->id)
            ->see($project->name);
    }

    public function setUp()
    {
        parent::setUp();

        // auth
        $this->actingAs(User::find(1));
    }
}

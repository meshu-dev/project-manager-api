<?php

namespace App\DataFixtures;

use App\Entity\Project;
use Doctrine\Persistence\ObjectManager;

class ProjectFixtures extends BaseFixture
{
    private static $projectCount = 2;

    public function loadData(ObjectManager $manager)
    {
        $this->createMany(Project::class, self::$projectCount, function (Project $project, $count) {
            $project->setName(ucfirst($this->faker->company));
        });
    }
}

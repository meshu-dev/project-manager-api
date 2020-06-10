<?php

namespace App\DataFixtures;

use App\Entity\Project;
use Doctrine\Persistence\ObjectManager;

/**
 * Creates and saves test projects.
 */
class ProjectFixtures extends BaseFixture
{
    /**
     * @var int
     */
    private static $projectCount = 2;

    /**
     * Create test project data.
     *
     * @param ObjectManager $manager The object manager
     */
    public function loadData(ObjectManager $manager)
    {
        $this->createMany(Project::class, self::$projectCount, function (Project $project, $count) {
            $project->setName(ucfirst($this->faker->company));
        });
    }
}

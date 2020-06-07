<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

use App\Entity\Project;

class ProjectFixtures extends BaseFixture
{
	private static $projectCount = 2;

    public function loadData(ObjectManager $manager)
    {
    	$this->createMany(Project::class, self::$projectCount, function(Project $project, $count) {
	        $project->setName(ucfirst($this->faker->company));
    	});
    }
}

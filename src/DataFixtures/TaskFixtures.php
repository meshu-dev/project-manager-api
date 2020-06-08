<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use App\Entity\Task;
use App\Entity\Project;

class TaskFixtures extends BaseFixture implements DependentFixtureInterface
{
    private static $taskCount = 25;

    public function loadData(ObjectManager $manager)
    {
        $this->createMany(Task::class, self::$taskCount, function (Task $task, $count) {
            $task->setProject($this->getRandomReference(Project::class));
            $task->setName(ucfirst($this->faker->bs));
            $task->setDescription(ucfirst($this->faker->realText(100)));
        });
    }

    public function getDependencies()
    {
        return [
            ProjectFixtures::class
        ];
    }
}

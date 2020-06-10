<?php

namespace App\DataFixtures;

use App\Entity\Project;
use App\Entity\Task;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

/**
 * Creates and saves test tasks.
 */
class TaskFixtures extends BaseFixture implements DependentFixtureInterface
{
    /**
     * @var int
     */
    private static $taskCount = 25;

    /**
     * Create test task data.
     *
     * @param ObjectManager $manager The object manager
     */
    public function loadData(ObjectManager $manager)
    {
        $this->createMany(Task::class, self::$taskCount, function (Task $task, $count) {
            $task->setProject($this->getRandomReference(Project::class));
            $task->setName(ucfirst($this->faker->bs));
            $task->setDescription(ucfirst($this->faker->realText(100)));
        });
    }

    /**
     * Get project fixture as a project is required to create tasks.
     */
    public function getDependencies()
    {
        return [
            ProjectFixtures::class,
        ];
    }
}

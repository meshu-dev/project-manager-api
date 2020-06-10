<?php

namespace App\Repository;

use App\Entity\Task;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Retrieve, create and change task data in data store.
 */
class TaskRepository extends ServiceEntityRepository
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @param ManagerRegistry        $registry      Manager registry
     * @param EntityManagerInterface $entityManager Entity manager
     */
    public function __construct(
        ManagerRegistry $registry,
        EntityManagerInterface $entityManager
    ) {
        parent::__construct($registry, Task::class);
        $this->entityManager = $entityManager;
    }

    /**
     * Create a new task entity and save to data store.
     *
     * @param array $params The parameters used for new project
     *
     * @return Task The task entity
     */
    public function create($params)
    {
        $task = new Task();
        $task->setProject($params['project']);
        $task->setName($params['name']);
        $task->setDescription($params['description']);

        $this->entityManager->persist($task);
        $this->entityManager->flush();

        return $task;
    }

    /**
     * Retrieve and update task entity then save changes to data store.
     *
     * @param int   $id     The ID for the task to update
     * @param array $params The parameters used to update task
     *
     * @return Task The task entity
     */
    public function update($id, $params)
    {
        $task = $this->find($id);
        $task->setName($params['name']);

        $this->entityManager->flush();

        return $task;
    }

    /**
     * Retrieve and delete task entity then save changes to data store.
     *
     * @param int $id The ID for the task to delete
     */
    public function delete($id)
    {
        $task = $this->find($id);

        $this->entityManager->remove($task);
        $this->entityManager->flush();
    }

    /**
     * Get total number of tasks available.
     */
    public function getTotal()
    {
        return $this->count([]);
    }
}

<?php

namespace App\Repository;

use App\Entity\Task;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Task|null find($id, $lockMode = null, $lockVersion = null)
 * @method Task|null findOneBy(array $criteria, array $orderBy = null)
 * @method Task[]    findAll()
 * @method Task[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TaskRepository extends ServiceEntityRepository
{
    private $entityManager;

    public function __construct(
        ManagerRegistry $registry,
        EntityManagerInterface $entityManager
    ) {
        parent::__construct($registry, Task::class);
        $this->entityManager = $entityManager;
    }

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

    public function update($id, $params)
    {
        $task = $this->find($id);
        $task->setName($params['name']);

        $this->entityManager->flush();

        return $task;
    }

    public function delete($id)
    {
        $task = $this->find($id);

        $this->entityManager->remove($task);
        $this->entityManager->flush();
    }

    public function getTotal()
    {
        return $this->count([]);
    }
}

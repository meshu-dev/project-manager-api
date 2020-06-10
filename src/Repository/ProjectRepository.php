<?php

namespace App\Repository;

use App\Entity\Project;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Retrieve, create and change project data in data store.
 */
class ProjectRepository extends ServiceEntityRepository
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
        parent::__construct($registry, Project::class);
        $this->entityManager = $entityManager;
    }

    /**
     * Create a new project entity and save to data store.
     *
     * @param array $params The parameters used for new project
     *
     * @return Project The project entity
     */
    public function create($params)
    {
        $project = new Project();
        $project->setName($params['name']);

        $this->entityManager->persist($project);
        $this->entityManager->flush();

        return $project;
    }

    /**
     * Retrieve and update project entity then save changes to data store.
     *
     * @param int   $id     The ID for the project to update
     * @param array $params The parameters used to update project
     *
     * @return Project The project entity
     */
    public function update($id, $params)
    {
        $project = $this->find($id);
        $project->setName($params['name']);

        $this->entityManager->flush();

        return $project;
    }

    /**
     * Retrieve and delete project entity then save changes to data store.
     *
     * @param int $id The ID for the project to delete
     */
    public function delete($id)
    {
        $project = $this->find($id);

        $this->entityManager->remove($project);
        $this->entityManager->flush();
    }

    /**
     * Get total number of projects available.
     */
    public function getTotal()
    {
        return $this->count([]);
    }
}

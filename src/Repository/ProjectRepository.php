<?php

namespace App\Repository;

use App\Entity\Project;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Project|null find($id, $lockMode = null, $lockVersion = null)
 * @method Project|null findOneBy(array $criteria, array $orderBy = null)
 * @method Project[]    findAll()
 * @method Project[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProjectRepository extends ServiceEntityRepository
{
    private $entityManager;

    public function __construct(
        ManagerRegistry $registry,
        EntityManagerInterface $entityManager
    ) {
        parent::__construct($registry, Project::class);
        $this->entityManager = $entityManager;
    }

    public function create($params)
    {
        $project = new Project();
        $project->setName($params['name']);

        $this->entityManager->persist($project);
        $this->entityManager->flush();

        return $project;
    }

    public function update($id, $params)
    {
        $project = $this->find($id);
        $project->setName($params['name']);

        $this->entityManager->flush();

        return $project;
    }

    public function delete($id)
    {
        $project = $this->find($id);

        $this->entityManager->remove($project);
        $this->entityManager->flush();
    }

    public function getTotal()
    {
        return $this->count([]);
    }
}

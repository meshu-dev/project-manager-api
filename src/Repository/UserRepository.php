<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository implements PasswordUpgraderInterface
{
    private $entityManager;
    private $encoderFactory;

    public function __construct(
        ManagerRegistry $registry,
        EntityManagerInterface $entityManager,
        EncoderFactoryInterface $encoderFactory
    ) {
        parent::__construct($registry, User::class);

        $this->entityManager = $entityManager;
        $this->encoderFactory = $encoderFactory;
    }

    /**
     * Used to upgrade (rehash) the user's password automatically over time.
     */
    public function upgradePassword(UserInterface $user, string $newEncodedPassword): void
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', \get_class($user)));
        }

        $user->setPassword($newEncodedPassword);
        $this->_em->persist($user);
        $this->_em->flush();
    }

    public function create($params)
    {
        $user = new User();
        $user->setEmail($params['email']);

        $encoder = $this->encoderFactory->getEncoder($user);
        $hashedPassword = $encoder->encodePassword(
            $params['password'],
            null
        );
        $user->setPassword($hashedPassword);

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return $user;
    }

    public function update($id, $params)
    {
        $user = $this->find($id);
        $user->setEmail($params['email']);

        $encoder = $this->encoderFactory->getEncoder($user);
        $hashedPassword = $encoder->encodePassword(
            $params['password'],
            null
        );
        $user->setPassword($hashedPassword);

        $this->entityManager->flush();

        return $user;
    }

    public function delete($id)
    {
        $user = $this->find($id);

        $this->entityManager->remove($user);
        $this->entityManager->flush();
    }

    public function getTotal()
    {
        return $this->count([]);
    }
}

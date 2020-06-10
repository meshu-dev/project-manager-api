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
 * Retrieve, create and change user data in data store.
 */
class UserRepository extends ServiceEntityRepository implements PasswordUpgraderInterface
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @var EncoderFactoryInterface
     */
    private $encoderFactory;

    /**
     * @param ManagerRegistry         $registry      Manager registry
     * @param EntityManagerInterface  $entityManager Entity manager
     * @param EncoderFactoryInterface $ncoderFactory Encoder factory
     */
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
     *
     * @param UserInterface $user               The user entity
     * @param string        $newEncodedPassword The encrypted password
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

    /**
     * Create a new user entity and save to data store.
     *
     * @param array $params The parameters used for new user
     *
     * @return User The user entity
     */
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

    /**
     * Retrieve and update user entity then save changes to data store.
     *
     * @param int   $id     The ID for the user to update
     * @param array $params The parameters used to update user
     *
     * @return User The user entity
     */
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

    /**
     * Retrieve and user task entity then save changes to data store.
     *
     * @param int $id The ID for the user to delete
     */
    public function delete($id)
    {
        $user = $this->find($id);

        $this->entityManager->remove($user);
        $this->entityManager->flush();
    }

    /**
     * Get total number of users available.
     */
    public function getTotal()
    {
        return $this->count([]);
    }
}

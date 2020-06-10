<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;

/**
 * Creates and saves test users.
 */
class UserFixtures extends BaseFixture
{
    /**
     * @var EncoderFactoryInterface
     */
    private $encoderFactory;

    /**
     * @param EncoderFactoryInterface $encoderFactory The encoder factory
     */
    public function __construct(
        EncoderFactoryInterface $encoderFactory
    ) {
        $this->encoderFactory = $encoderFactory;
    }

    /**
     * Create test user data.
     *
     * @param ObjectManager $manager The object manager
     */
    public function loadData(
        ObjectManager $manager
    ) {
        $user = new User();
        $user->setEmail('test@gmail.com');

        $encoder = $this->encoderFactory->getEncoder($user);
        $hashedPassword = $encoder->encodePassword(
            'password',
            null
        );
        $user->setPassword($hashedPassword);

        $manager->persist($user);
        $manager->flush();
    }
}

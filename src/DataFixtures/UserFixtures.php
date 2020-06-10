<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;

class UserFixtures extends BaseFixture
{
    private $encoderFactory;

    public function __construct(
        EncoderFactoryInterface $encoderFactory
    ) {
        $this->encoderFactory = $encoderFactory;
    }

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

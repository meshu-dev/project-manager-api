<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory as Faker;

/**
 * Base fixture with common methods.
 */
abstract class BaseFixture extends Fixture
{
    /**
     * @var EntityManagerInterface
     */
    private $manager;

    /**
     * @var array
     */
    private $referencesIndex = [];

    /**
     * @var Faker
     */
    protected $faker;

    /**
     * Used to create test data.
     *
     * @param ObjectManager $em The object manager
     */
    abstract protected function loadData(ObjectManager $em);

    /**
     * Main method called when fixtures are run.
     *
     * @param ObjectManager $manager The object manager
     */
    public function load(ObjectManager $manager)
    {
        $this->manager = $manager;
        $this->faker = Faker::create();

        $this->loadData($manager);
    }

    /**
     * Creates and saves entities to data source.
     *
     * @param string   $className The class name
     * @param int      $count     The entity count
     * @param callable $factory   Class reference
     */
    protected function createMany(string $className, int $count, callable $factory)
    {
        for ($i = 0; $i < $count; ++$i) {
            $entity = new $className();
            $factory($entity, $i);

            $this->manager->persist($entity);
            $this->manager->flush();

            $this->addReference($className.'_'.$i, $entity);
        }
    }

    /**
     * Get random reference to specified class.
     *
     * @param string $className The class name
     *
     * @return Entity The random entity
     */
    protected function getRandomReference(string $className)
    {
        if (!isset($this->referencesIndex[$className])) {
            $this->referencesIndex[$className] = [];

            foreach ($this->referenceRepository->getReferences() as $key => $ref) {
                if (0 === strpos($key, $className.'_')) {
                    $this->referencesIndex[$className][] = $key;
                }
            }
        }
        if (empty($this->referencesIndex[$className])) {
            throw new \Exception(sprintf('Cannot find any references for class "%s"', $className));
        }
        $randomReferenceKey = $this->faker->randomElement($this->referencesIndex[$className]);

        return $this->getReference($randomReferenceKey);
    }
}

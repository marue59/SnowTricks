<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Category;
use App\Entity\User;
use App\Entity\Trick as T;
use Faker\Factory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class Trick extends Fixture
{

    /**
     * @var UserPasswordHasherInterface
     */
    private $encoder;

    public function __construct(UserPasswordHasherInterface $encoder)
    {
        $this->encoder = $encoder;
    }


    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        for($i = 0; $i < 5; $i++) {

           $user = new User();
           $user->setFullName($faker->firstName());
           $user->setPassword($this->encoder->hashPassword($user, 'password'));
           $user->setEmail("user$i@email.com");
           $user->addRole('ROLE_ADMIN');
           $manager->persist($user);
        }
        $manager->flush();

        $categories = ['Flips', 'Slide', '360'];

    
        foreach($categories as $cat) {
            $category = new Category();
            $category->setName($cat);
            $manager->persist($category);
        }
        $manager->flush();

        $categories = $manager->getRepository(Category::class)->findAll();

        for($i = 0; $i < 50; $i++) {

            $trick = new T();
            $trick->setName($faker->name());
            $trick->setCategory($faker->randomElement($categories));
            $trick->setText($faker->text());
            $trick->setSlug('slug-name' . $i);
            $manager->persist($trick);
        }
        $manager->flush();
    }
}

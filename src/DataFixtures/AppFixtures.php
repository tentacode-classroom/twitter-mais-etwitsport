<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Team;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);
        $team1= new Team();
        $team1->setEmail('test.1@gmail.com');
        $team1->setName('test1');
        $team1->setPassword($this->encoder->encodePassword($team1, 'lololo'));
        $team1->setAvatarFileName('\f3a5b46a443314c46026cc269f615f1f.jpeg');
        $manager->persist($team1);

        $team2= new Team();
        $team2->setEmail('test.2@gmail.com');
        $team2->setName('test2');
        $team2->setPassword($this->encoder->encodePassword($team2, 'lololo'));
        $team2->setAvatarFileName('\f3a5b46a443314c46026cc269f615f1f.jpeg');
        $manager->persist($team2);

        $team3= new Team();
        $team3->setEmail('test.3@gmail.com');
        $team3->setName('test3');
        $team3->setPassword($this->encoder->encodePassword($team3, 'lololo'));
        $team3->setAvatarFileName('\f3a5b46a443314c46026cc269f615f1f.jpeg');
        $manager->persist($team3);

        $admin= new Team();
        $admin->setEmail('admin@gmail.com');
        $admin->setName('admin');
        $admin->setRoles(['ROLE_ADMIN']);
        $admin->setPassword($this->encoder->encodePassword($admin, 'admine'));
        $admin->setAvatarFileName('\f1ddcf6be458130e2200ab67c0288ed0.jpeg');
        $manager->persist($admin);

        $manager->flush();
    }
}

<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Team;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);
        $team1 = new Team();
        $team1->setEmail('test.1@gmail.com');
        $team1->setName('test1');
        $team1->setPassword('lololo');
        $team1->setAvatarFileName('\uploads\f3a5b46a443314c46026cc269f615f1f.jpeg');
        $manager->persist($team1);

        $team2 = new Team();
        $team2->setEmail('test.2@gmail.com');
        $team2->setName('test2');
        $team2->setPassword('lololo');
        $team2->setAvatarFileName('\uploads\f3a5b46a443314c46026cc269f615f1f.jpeg');
        $manager->persist($team2);

        $team3 = new Team();
        $team3->setEmail('test.3@gmail.com');
        $team3->setName('test3');
        $team3->setPassword('lololo');
        $team3->setAvatarFileName('\uploads\f3a5b46a443314c46026cc269f615f1f.jpeg');
        $manager->persist($team3);

        $admin = new Team();
        $admin->setEmail('admin@gmail.com');
        $admin->setName('admin');
        $admin->setRoles(['ROLE_ADMIN']);
        $admin->setPassword('admine');
        $admin->setAvatarFileName('\uploads\f1ddcf6be458130e2200ab67c0288ed0.jpeg');
        $manager->persist($admin);

        $manager->flush();
    }
}

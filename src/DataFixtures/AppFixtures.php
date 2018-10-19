<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Team;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use \Datetime;
use App\Entity\ETweet;

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
        $team1 = new Team();
        $team1->setEmail('test.1@gmail.com');
        $team1->setName('Fnatic');
        $team1->setPassword($this->encoder->encodePassword($team1, 'lololo'));
        $team1->setAvatarFileName('\Fnatic_2018_profileicon.png');
        $manager->persist($team1);

        $team2 = new Team();
        $team2->setEmail('test.2@gmail.com');
        $team2->setName('G2 eSport');
        $team2->setPassword($this->encoder->encodePassword($team2, 'lololo'));
        $team2->setAvatarFileName('\g2-logo.jpg');
        $manager->persist($team2);

        $team3 = new Team();
        $team3->setEmail('test.3@gmail.com');
        $team3->setName('Team Vitality');
        $team3->setPassword($this->encoder->encodePassword($team3, 'lololo'));
        $team3->setAvatarFileName('\team-vitality-logo-hstl.png');
        $manager->persist($team3);

        $admin = new Team();
        $admin->setEmail('admin@gmail.com');
        $admin->setName('admin');
        $admin->setRoles(['ROLE_ADMIN']);
        $admin->setPassword($this->encoder->encodePassword($admin, 'admine'));
        $admin->setAvatarFileName('\f1ddcf6be458130e2200ab67c0288ed0.jpeg');
        $manager->persist($admin);

        $manager->flush();

        $etweet1 = new ETweet();
        $etweet1->setTeam($team1);
        $etweet1->setContent('Looking for a scrim this friday around 21 CET');
        $etweet1->setDating(new DateTime());
        $manager->persist($etweet1);

        $etweet2 = new ETweet();
        $etweet2->setTeam($team2);
        $etweet2->setContent('GG Fnatic for their win against Team Vitality in the semies. Looking toward facing them in the finals !!');
        $etweet2->setDating(new DateTime());
        $manager->persist($etweet2);

        $etweet3 = new ETweet();
        $etweet3->setTeam($team3);
        $etweet3->setContent('Baguette');
        $etweet3->setDating(new DateTime());
        $manager->persist($etweet3);

        $manager->flush();
    }
}

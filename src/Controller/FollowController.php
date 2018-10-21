<?php

namespace App\Controller;

use App\Entity\Follow;
use App\Entity\Team;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class FollowController extends AbstractController
{
    /**
     * @Route("/follow/{followerId}/{followedId}", name="follow")
     */
    public function index($followerId, $followedId, ObjectManager $manager)
    {
        $followingTeam = $this->getDoctrine()
            ->getRepository(Team::class)
            ->find($followerId);

        $followedTeam = $this->getDoctrine()
            ->getRepository(Team::class)
            ->find($followedId);

        $formerFollow = $this->getDoctrine()
            ->getRepository(Follow::class)
            ->findOneByTwoTeams($followerId, $followedId);

        if ($formerFollow == null)
        {
            $follow = new Follow();
            $follow->setFollower($followingTeam);
            $follow->setFollowed($followedTeam);

            $manager->persist($follow);
            $manager->flush();

            $this->addFlash(
                'notice',
                'You\'re now following '.$followedTeam->getName().' !'
            );
        }
        else
        {
            $manager->remove($formerFollow);
            $manager->flush();

            $this->addFlash(
                'notice',
                'You\'re now unfollowing '.$followedTeam->getName().' !'
            );
        }

        return $this->redirectToRoute('profile_team', array('teamId' => $followedId));
    }
}

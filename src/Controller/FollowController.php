<?php

namespace App\Controller;

use App\Entity\Follow;
use App\Entity\Team;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class FollowController extends AbstractController
{
    //le parametre route (followerId... Représente lors du clique sur le bouton -> envoie ses l'id de celui
    // qui est follow et de celui qui follow, qui va etre transmise a la fonction index pour etre réutiliser
    /**
     * @Route("/follow/{followerId}/{followedId}", name="follow")
     * @param $followerId
     * @param $followedId
     * @param ObjectManager $manager
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
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

        //Mettre la donnée dans la bdd si une team n'a pas été follow alors il crée une ligne follow
        // avec l'id du follower et du following
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
            //supprime la ligne dans la bdd (lien entre follower) si on clique sur le btn unfollow.
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

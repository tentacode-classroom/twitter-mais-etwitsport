<?php

namespace App\Controller;

use App\Entity\Team;
use App\Entity\ETweet;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ProfileTeamController extends AbstractController
{
    /**
     * @Route("/profile/{teamId}", name="profile_team")
     */
    public function index($teamId = 1)
    {
        $team = $this->getDoctrine()
            ->getRepository(Team::class)
            ->find($teamId);

        $eTweets = $this->getDoctrine()
            ->getRepository(ETweet::class)
            ->findByTeamId($teamId);


        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($team);
        $entityManager->flush();

//        dump($eTweets);

        return $this->render('profile_team/profile.html.twig', [
            'controller_name' => 'ProfileTeamController',
            'team' => $team,
            'eTweets' => $eTweets
        ]);
    }
}

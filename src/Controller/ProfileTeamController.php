<?php

namespace App\Controller;

use App\Entity\Team;
use App\Entity\ETweet;
use App\Entity\Follow;
use App\Entity\Vote;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

class ProfileTeamController extends AbstractController
{
    /**
     * @Route("/profile/{teamId}", name="profile_team")
     */
    public function index($teamId = 1, UserInterface $userInterface)
    {
        $loggedTeam = $this->getDoctrine()
            ->getRepository(Team::class)
            ->findOneByTeamEmail($userInterface->getUsername());

        $team = $this->getDoctrine()
            ->getRepository(Team::class)
            ->find($teamId);

        $follow = $formerFollow = $this->getDoctrine()
            ->getRepository(Follow::class)
            ->findOneByTwoTeams($loggedTeam, $team);

        $totalFollowedBy = $this->getDoctrine()
            ->getRepository(Follow::class)
            ->findByFollowedBy($team)[0]['totalFollowedBy'];

        $totalFollowing = $this->getDoctrine()
            ->getRepository(Follow::class)
            ->findByFollower($team)[0]['totalFollowing'];

        $isFollowing = false;

        if ($follow)
        {
            $isFollowing = true;
        }

        $eTweets = $this->getDoctrine()
            ->getRepository(ETweet::class)
            ->findByTeamId($teamId);

        foreach ($eTweets as $msg) {
            $votes = $this->getDoctrine()
                ->getRepository(Vote::class)
                ->findByVote($msg->getId());



            if ($votes[0]["totalVote"] == null)
            {
                $msg->setTotalVote(0);
            }
            else
            {
                $msg->setTotalVote($votes[0]["totalVote"]);
            }
        }

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($team);
        $entityManager->flush();


        return $this->render('profile_team/profile.html.twig', [
            'controller_name' => 'ProfileTeamController',
            'team' => $team,
            'eTweets' => $eTweets,
            'is_following' => $isFollowing,
            'followed_by' => $totalFollowedBy,
            'following' => $totalFollowing
        ]);
    }
}

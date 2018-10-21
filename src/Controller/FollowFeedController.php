<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Follow;
use App\Entity\Team;
use App\Entity\Vote;
use App\Entity\ETweet;
use Symfony\Component\Security\Core\User\UserInterface;

class FollowFeedController extends AbstractController
{
    /**
     * @Route("/followFeed", name="follow_feed")
     */
    public function index(UserInterface $userInterface)
    {
        $loggedTeam = $this->getDoctrine()
            ->getRepository(Team::class)
            ->findOneByTeamEmail($userInterface->getUsername());

        $teamIds = $this->getDoctrine()
            ->getRepository(Follow::class)
            ->findByFollowerByUserId($loggedTeam->getId());

        for ($i = 0; $i < count($teamIds); $i++)
        {
            $allETweets[] = $this->getDoctrine()
                    ->getRepository(ETweet::class)
                    ->findByTeamId($teamIds[$i]['id']);
        }

        foreach ($allETweets as $eTweet)
        {
            $eTweets[] = $eTweet[0];
        }

        foreach ($eTweets as $msg) {
            $votes = $this->getDoctrine()
                ->getRepository(Vote::class)
                ->findByVote($msg->getId());

            $msg->setTotalVote(0);
            if ($votes[0]["totalVote"] != null) {
                $msg->setTotalVote($votes[0]["totalVote"]);
            }
        }

        return $this->render('follow_feed/index.html.twig', [
            'controller_name' => 'FollowFeedController',
            'eTweets' => $eTweets
        ]);
    }
}

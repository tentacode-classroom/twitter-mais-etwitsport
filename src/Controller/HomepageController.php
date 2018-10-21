<?php

namespace App\Controller;

use \Datetime;
use App\Entity\Team;
use App\Entity\Vote;
use App\Entity\ETweet;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\Common\Persistence\ObjectManager;

class HomepageController extends AbstractController
{
    /**
     * @Route("/", name="homepage")
     */
    public function index(Request $request, UserInterface $userInterface)
    {
        $loggedTeam = $this->getDoctrine()
            ->getRepository(Team::class)
            ->findOneByTeamEmail($userInterface->getUsername());

        $etweet = new ETweet();


        $form = $this->createFormBuilder($etweet)
            ->add('content', TextareaType::class, array('label' => ' '))
            ->add('submit', SubmitType::class, array('label' => 'ETweet'))
            ->getForm();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->addFlash(
                'notice',
                'Your eTweet has been correctly posted !'
            );
            $etweet = $form->getData();
            $etweet->setDating(new DateTime());
            $etweet->setTeam($loggedTeam);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($etweet);
            $entityManager->flush();

            return $this->redirectToRoute("homepage");
        }

        $eTweets = $this->getDoctrine()
            ->getRepository(ETweet::class)
            ->findByDating();



        foreach ($eTweets as $msg) {
            $votes = $this->getDoctrine()
                ->getRepository(Vote::class)
                ->findByVote($msg->getId());

            $msg->setTotalVote(0);
            if ($votes[0]["totalVote"] != null) {
                $msg->setTotalVote($votes[0]["totalVote"]);
            }
        }

        return $this->render('homepage/homepage.html.twig', array(
            'formETweet' => $form->createView(),
            'eTweets' => $eTweets
        ));
    }

    /**
     * @Route("/vote/{idMessage}/{value}/{route}", name="vote")
     */
    public function updateVoteHome($idMessage, $value, $route, UserInterface $userInterface, ObjectManager $manager)
    {
        $vote = new Vote();
        $vote->setETweet($this->getDoctrine()
            ->getRepository(ETweet::class)
            ->findOneById($idMessage));
        $vote->setTeam($this->getDoctrine()
            ->getRepository(Team::class)
            ->findOneByTeamEmail($userInterface->getUsername()));

        $vote->setVoteValue($value);

        $currentTeam = $this->getDoctrine()
            ->getRepository(Team::class)
            ->findOneByTeamEmail($userInterface->getUsername());


        $formerVote = $this->getDoctrine()
            ->getRepository(Vote::class)
            ->findOneByTeamAndMsgId($currentTeam->getId(), $idMessage);

        if ($formerVote == null) {
            $manager->persist($vote);
            $manager->flush();
        } else {
            if ($formerVote->getVoteValue() == $vote->getVoteValue()) {
                $formerVote->setVoteValue(0);
                $manager->flush();
            } else {
                $formerVote->setVoteValue($value);
                $manager->flush();
            }
        }

        if ($route == 0) {
            return $this->redirectToRoute('homepage');
        } elseif ($route == 1) {
            $currentMessage = $this->getDoctrine()
                ->getRepository(ETweet::class)
                ->findOneById($idMessage);

            $teamId = $currentMessage->getTeam()->getId();

            return $this->redirectToRoute('profile_team', array('teamId' => $teamId));
        }
    }
}

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

        if ($form->isSubmitted() && $form->isValid())
        {
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

         return $this->render('homepage/homepage.html.twig', array(
             'formETweet' => $form->createView(),
             'eTweets' => $eTweets
         ));
    }

    /**
     * @Route("/vote/{idMessage}/{value}", name="vote")
     */
    public function updateVote($idMessage, $value, UserInterface $userInterface, ObjectManager $manager)
    {
        $vote = new Vote();
        $vote->setETweet($this->getDoctrine()
            ->getRepository(ETweet::class)
            ->findOneById($idMessage));
        $vote->setTeam($this->getDoctrine()
            ->getRepository(Team::class)
            ->findOneByTeamEmail($userInterface->getUsername()));

        if ($value == 1)
        {
            $vote->setVoteValue(1);
        }
        else if ($value == -1)
        {
            $vote->setVoteValue(-1);
        }

        $manager->persist($vote);
        $manager->flush();

        return $this->redirectToRoute("homepage");
    }
}

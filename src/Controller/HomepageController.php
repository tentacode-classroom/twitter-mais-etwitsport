<?php

namespace App\Controller;

use App\Entity\ETweet;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;

class HomepageController extends AbstractController
{
    /**
     * @Route("/", name="homepage")
     */
    public function index(Request $request)
    {
        $eTweets = $this->getDoctrine()
            ->getRepository(ETweet::class)
            ->findAll();

            $etweet = new ETweet();
            $form = $this->createFormBuilder($etweet)
              ->add('content', TextType::class)
              ->add('submit', SubmitType::class, array('label' => 'ETweet'))
              ->getForm();

              $form->handleRequest($request);
              if ($form->isSubmitted() && $form->isValid()) {

     $etweet = $form->getData();
     $etweet->setDating(new DateTime());
     $etweet->setTeam();
     $entityManager = $this->getDoctrine()->getManager();
     $entityManager->persist($etweet);
     $entityManager->flush();

 }

         return $this->render('homepage/homepage.html.twig', array(
             'formETweet' => $form->createView(),
             'eTweets' => $eTweets
         ));
    }
}

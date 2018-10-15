<?php

namespace App\Controller;

use App\Entity\ETweet;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomepageController extends AbstractController
{
    /**
     * @Route("/", name="homepage")
     */
    public function index()
    {
        $eTweets = $this->getDoctrine()
            ->getRepository(ETweet::class)
            ->findAll();

        return $this->render('homepage/homepage.html.twig', [
            'controller_name' => 'HomepageController',
            'eTweets' => $eTweets
        ]);
    }
}

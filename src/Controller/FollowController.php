<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class FollowController extends AbstractController
{
    /**
     * @Route("/follow", name="follow")
     */
    public function index()
    {
        return $this->render('follow/index.html.twig', [
            'controller_name' => 'FollowController',
        ]);
    }
}

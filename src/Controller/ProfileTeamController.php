<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ProfileTeamController extends AbstractController
{
    /**
     * @Route("/profile/{teamId}", name="profile_team")
     */
    public function index($teamId)
    {
        $team = null; //à modifier pour que team soit égal à findById($teamId);
        //
        return $this->render('profile_team/index.html.twig', [
            'controller_name' => 'ProfileTeamController',
            'team' => $team
        ]);
    }
}

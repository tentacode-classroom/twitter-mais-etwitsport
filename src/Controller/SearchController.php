<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Team;
use App\Entity\ETweet;



class SearchController extends AbstractController
{
    /**
     * @Route("/redirect", name="search")
     */
    public function search (Request $request)
    {
       $search = $request->get('query');

       // est-ce que l'utilisateur existe en base de données.
        $teamm = $this->getDoctrine()->getRepository(Team::class)
            ->findOneByName($search);

        /*$posts = $this->getDoctrine()->getRepository( ETweet::class )
            ->searchPosts( $search );*/
        if (!$teamm) {
           return $this->render('search/usernotfound.html.twig');
        }

       /*return $this->redirectToRoute("search_", [
           'search_team'      =>  $teamm,
       ]);*/
        return $this->render('search/index.html.twig', [
            'search_posts'   =>  $posts,
            'search_team'      =>  $teamm,
            'current_search'            =>  $search
        ]);
    }

}

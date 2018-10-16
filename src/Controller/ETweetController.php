<?php

namespace App\Controller;

use App\Entity\ETweet;
use App\Form\ETweetType;
use App\Repository\ETweetRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("admin/tweet")
 */
class ETweetController extends AbstractController
{
    /**
     * @Route("/", name="e_tweet_index", methods="GET")
     */
    public function index(ETweetRepository $eTweetRepository): Response
    {
        return $this->render('e_tweet/index.html.twig', ['e_tweets' => $eTweetRepository->findAll()]);
    }

    /**
     * @Route("/new", name="e_tweet_new", methods="GET|POST")
     */
    public function new(Request $request): Response
    {
        $eTweet = new ETweet();
        $form = $this->createForm(ETweetType::class, $eTweet);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($eTweet);
            $em->flush();

            return $this->redirectToRoute('e_tweet_index');
        }

        return $this->render('e_tweet/new.html.twig', [
            'e_tweet' => $eTweet,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="e_tweet_show", methods="GET")
     */
    public function show(ETweet $eTweet): Response
    {
        return $this->render('e_tweet/show.html.twig', ['e_tweet' => $eTweet]);
    }

    /**
     * @Route("/{id}/edit", name="e_tweet_edit", methods="GET|POST")
     */
    public function edit(Request $request, ETweet $eTweet): Response
    {
        $form = $this->createForm(ETweetType::class, $eTweet);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('e_tweet_edit', ['id' => $eTweet->getId()]);
        }

        return $this->render('e_tweet/edit.html.twig', [
            'e_tweet' => $eTweet,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="e_tweet_delete", methods="DELETE")
     */
    public function delete(Request $request, ETweet $eTweet): Response
    {
        if ($this->isCsrfTokenValid('delete'.$eTweet->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($eTweet);
            $em->flush();
        }

        return $this->redirectToRoute('e_tweet_index');
    }
}

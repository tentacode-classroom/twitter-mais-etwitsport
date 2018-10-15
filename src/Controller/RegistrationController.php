<?php

namespace App\Controller;

use App\Entity\Team;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class RegistrationController extends AbstractController
{
    /**
     * @Route("/", name="registration")
     * @param Request $request
     * @param UserPasswordEncoderInterface $encoder
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
     public function index(Request $request, UserPasswordEncoderInterface $encoder)
    {
        $team = new Team();
        $form = $this->createFormBuilder($team)
            ->add('name',TextType::class)
            ->add('avatar', FileType::class, array('label' => 'file'))
            ->add('email',EmailType::class)
            ->add('password',PasswordType::class)
            ->add('inscription',SubmitType::class)
            ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $team = $form->getData();

            //permet d'encrypter les password pour la bdd
            $plainPassword = $team->getPassword();
            $encryptedPassword = $encoder->encodePassword($team, $plainPassword);
            $team->setPassword($encryptedPassword);
            //fichier recuperer via form
            $avatarFile = $team->getAvatar();
            $entityManager = $this->getDoctrine()->getManager();
            //nom du fichier qui sera mis dans la bdd
            $team->setAvatarFileName( md5(uniqid()).'.'.$avatarFile->guessExtension());
            $entityManager->persist($team);

            $avatarFile->move(
                $this->getParameter('file_directory'),
                $team->getAvatarFileName()
            );

            $entityManager->flush();

            return $this->redirectToRoute('homepage');
        }
        return $this->render('registration/registration.html.twig', [
            'formTeam' => $form->createView()
        ]);
    }
}

<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;


use App\Entity\User;
use App\Form\RegistrationType;


class SecurityController extends AbstractController
{
    /**
     * @Route("/register", name="security_registration")
     */
     public function registration(Request $request, ObjectManager $manager, UserPasswordEncoderInterface $encoder){
         if($this->container->get('security.authorization_checker')->isGranted('ROLE_USER')){
            return $this->redirectToRoute('site');
        }
        $user = new User();
        $form = $this->createForm(RegistrationType::class, $user);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $hash = $encoder->encodePassword($user, $user->getPassword());
            $user->setQuality1("Pas de qualité enregistrée");
            $user->setQuality2("Pas de qualité enregistrée");
            $user->setQuality3("Pas de qualité enregistrée");
            $user->setQuality4("Pas de qualité enregistrée");
            $user->setProfilePic("/Uploads/image_base.png");
            $user->setSubject("rien");
            $user->setPassword($hash);
            $manager->persist($user);
            $manager->flush();
            return $this->redirectToRoute('security_login');
        }
        return $this->render('security/registration.html.twig',
          ['form'=>$form->createView()]
        );

     }

     /**
     * @Route("/login", name="security_login")
     */
     public function login(AuthenticationUtils $authenticationUtils){
        if($this->container->get('security.authorization_checker')->isGranted('ROLE_USER')){
            return $this->redirectToRoute('site');
        }
         $error = $authenticationUtils->getLastAuthenticationError();
         $lastUsername = $authenticationUtils->getLastUsername();
         if($error){
             return $this->render('security/login.html.twig', ['invalid_credentials' => 'E-mail ou mot de passe erroné']);
         }


        return $this->render('security/login.html.twig', ['invalid_credentials' => '']);
     }


     /**
     * @Route("/logout", name="security_logout")
     */
     public function logout(){}


}

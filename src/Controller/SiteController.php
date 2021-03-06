<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Doctrine\Common\Persistence\ObjectManager;

use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TelType;


use App\Form\FirstnameType;

use Symfony\Component\HttpFoundation\Response;
use Knp\Component\Pager\PaginatorInterface;
use Knp\Component\Pager\Pagination\AbstractPagination;
use App\Form\UserSearchType;
use App\Entity\UserSearch;
use App\Entity\Availability;
use App\Entity\RDV;
use App\Entity\Notification;

class SiteController extends AbstractController
{
   /**
    * @Route("/", name="site")
    */
   public function index()
   {
       return $this->render('site/index.html.twig', [
           'controller_name' => 'SiteController',
       ]);
   }

    /**
    * @Route("/", name="home")
    */
    public function home(){
     return $this->render('site/home.html.twig');
   }





    /**
    * @Route("/my_account", name="my_account")
    */
    public function my_account(Request $request, ObjectManager $manager, UserPasswordEncoderInterface $encoder){
       if($this->container->get('security.authorization_checker')->isGranted('ROLE_USER')){
          $username = $this->get('security.token_storage')->getToken()->getUsername();
          $repo = $this->getDoctrine()->getRepository(User::class);
          $user = $repo->findOneBy(['username' => $this->get('security.token_storage')->getToken()->getUsername()]);
          $userbase = $repo->findOneBy(['username' => $this->get('security.token_storage')->getToken()->getUsername()]);
          $savepass = $userbase->getPassword();


          $userData = ['Firstname' => $user->getFirstname(), 'Email' => $user->getEmail(), 'Description' => $user->getDescription(), 'address' => $user->getAddress(), 'phoneNumber' => $user->getPhoneNumber()];
          $userForm = $this->createFormBuilder($userData)
                             ->add('Firstname', TextType::class, ['label' => 'Votre prénom'])
                             ->add('Email', EmailType::class)
                             ->add('Description', TextareaType::class)
                             ->add('Password', PasswordType::class, ['required' => true, 'label' => 'Validez en entrant votre mot de passe'])
                             ->add('profile_pic' , FileType::class, ['required' => false, 'attr' => ['accept' => 'image/*']])
                             ->add('address',TextType::class, ['required' => false])
                             ->add('phoneNumber',TelType::class, ['required' => false])
                             ->add('Submit', SubmitType::class)
                             ->getForm();

         $userForm->handleRequest($request);
         if($userForm->isSubmitted() && $userForm->isValid()){
            $data = $userForm->getData();
            if(password_verify($data['Password'], $user->getPassword())){
                $user->setFirstname($data['Firstname']);
                $user->setDescription($data['Description']);

                //CHANGEMENT EMAIL
                if($user->getEmail() != $data['Email']){
                    $usermail = $repo->findOneBy(['email' => $data['Email']]);
                    //ON PEUT CHOISIR L'ADRESSE
                    if($usermail == NULL){
                        $user->setEmail($data['Email']);
                    }else{
                         return $this->render('site/my_account.html.twig', [
                            'userForm' => $userForm->createView(),
                            'message_modif' => '',
                            'message_change_data' => "<p style='color:red'> Email déjà pris </p>"
                         ]);
                    }
                }

                //CHANGEMENT PHOTO DE PROFILE
                if($data['profile_pic'] != NULL){
                    $file = $data['profile_pic'];
                    $filename = '/Uploads/'.md5(uniqid().'.'.$file->guessExtension());
                    $file->move($this->getParameter('upload_directory'), $filename);
                    $user->setProfilePic($filename);
                }

                if($data['address'] != NULL){
                    $address = $data['address'];
                    $user->setAddress($address);
                }else{
                    $user->setAddress(NULL);

                }

                 if($data['phoneNumber'] != NULL){
                    $phoneNumber = $data['phoneNumber'];
                    $user->setPhoneNumber($phoneNumber);
                }else{
                    $user->setPhoneNumber(NULL);

                }


                $manager->persist($user);
                $manager->flush();
                return $this->render('site/my_account.html.twig', [
                    'userForm' => $userForm->createView(),
                    'message_modif' => '',
                    'message_change_data' => "<p style='color:green'> Modification effectuées avec succès </p>"
                 ]);



            }else{
                return $this->render('site/my_account.html.twig', [
                    'userForm' => $userForm->createView(),
                    'message_modif' => '',
                    'message_change_data' => "<p style='color:red'> Mot de pass invalide </p>"
                 ]);
            }

            dump($userData);
         }


            return $this->render('site/my_account.html.twig', [
                'userForm' => $userForm->createView(),
                'message_modif' => '',
                'message_change_data' => ''

              ]);


       }else{
            return $this->redirectToRoute('site');
       }
   }






   /**
    * @Route("/ajax_change_quality", name="change_quality")
    */
   public function ajaxAction(Request $request,ObjectManager $manager): Response{
        if(($request->request->get('quality1') == NULL) && ($request->request->get('quality2') == NULL)  && ($request->request->get('quality3') == NULL)  && ($request->request->get('quality4') == NULL) ){
            return $this->redirectToRoute('site');
        }

        $repo = $this->getDoctrine()->getRepository(User::class);
        $user = $repo->findOneBy(['username' => $this->get('security.token_storage')->getToken()->getUsername()]);
        //AJOUTER LA QUALITE A LA BDD
        $user = $repo->findOneBy(['username' => $this->get('security.token_storage')->getToken()->getUsername()]);
        $quality = $request->request->get('quality1');
        if($quality != NULL){
            $user->setQuality1($quality);
            $manager->persist($user);
            $manager->flush();
            $response = new Response();
            $response->setContent(json_encode([
                'qual' => $quality

             ]));
            return $response;
        }

        $quality = $request->request->get('quality2');
        if($quality != NULL){
            $user->setQuality2($quality);
            $manager->persist($user);
            $manager->flush();
            $response = new Response();
            $response->setContent(json_encode([
                'qual' => $quality

             ]));
            return $response;
        }

        $quality = $request->request->get('quality3');
        if($quality != NULL){
            $user->setQuality3($quality);
            $manager->persist($user);
            $manager->flush();
             $response = new Response();
            $response->setContent(json_encode([
                'qual' => $quality

             ]));
            return $response;
        }
        $quality = $request->request->get('quality4');
        if($quality != NULL){
            $user->setQuality4($quality);
            $manager->persist($user);
            $manager->flush();
            $response = new Response();
            $response->setContent(json_encode([
                'qual' => $quality

             ]));
            return $response;
        }
          $response = new Response();
            $response->setContent(json_encode([
                'qual' => "Appuyez pour entrer une qualité"

         ]));
        return $response;
}







    /**
    * @Route("/ajax_subject_change", name="totooo")
    */
   public function changeSubject(Request $request,ObjectManager $manager): Response{
        if($request->request->get('subject') == NULL){
            return $this->redirectToRoute('site');
        }
        //CHANGE LE SUJET D'ENSEIGNEMENT
        $repo = $this->getDoctrine()->getRepository(User::class);
        $user = $repo->findOneBy(['username' => $this->get('security.token_storage')->getToken()->getUsername()]);
        $subj = $request->request->get('subject');
        $user->setSubject($subj);
        $manager->persist($user);
        $manager->flush();
        $response = new Response();
        $response->setContent(json_encode([
           'qual' => $subj
         ]));
         return $response;
    }







    /**
    * @Route("/ajax_level_change", name="update_level")
    */
   public function updateLevel(Request $request,ObjectManager $manager): Response{
        if( $request->request->get('level') == NULL){
            return $this->redirectToRoute('site');
        }

        $repo = $this->getDoctrine()->getRepository(User::class);
        $user = $repo->findOneBy(['username' => $this->get('security.token_storage')->getToken()->getUsername()]);
        $level = $request->request->get('level');
        $user->setLevel($level);
        $manager->persist($user);
        $manager->flush();
        $response = new Response();
        $response->setContent(json_encode([
                'level' => $level
         ]));
         return $response;
    }






    /**
    * @Route("/user/{username}", name="find_user")
    */
    public function findUser($username){
        if(!$this->container->get('security.authorization_checker')->isGranted('ROLE_USER')){
            return $this->redirectToRoute('site');
        }
        $repo = $this->getDoctrine()->getRepository(User::class);
        $user = $repo->findOneBy(['username' => $username]);

        if($user != NULL){
            $address = NULL;

             if($user->getAddress()!= NULL){
                $address = $user->getAddress();
             }

             if($user->getPhoneNumber() != NULL){
                $phoneNumber = $user->getPhoneNumber();
             }else{
                $phoneNumber = NULL;
             }

            $firstname = $user->getFirstname();
             return $this->render('site/find_user.html.twig', [
                'username' => $user->getUsername(),
                'image' => $user->getProfilePic(),
                'subject' => $user->getSubject(),
                'level' => $user->getLevel(),
                 'description' => $user->getDescription(),
                 'email' => $user->getEmail(),
                 'quality1' => $user->getQuality1(),
                 'quality2' => $user->getQuality2(),
                 'quality3' => $user->getQuality3(),
                 'quality4' => $user->getQuality4(),
                'firstname' => $firstname,
                'address' => $address,
                'phoneNumber' => $phoneNumber
            ]);
        }
         return $this->render('site/user_not_found.html.twig');

    }







    /**
    * @Route("/find_teacher", name="find_teacher")
    */
    public function findTeacher(PaginatorInterface $paginator, Request $request){
        if(!$this->container->get('security.authorization_checker')->isGranted('ROLE_USER')){
            return $this->redirectToRoute('site');
        }
        $search = new UserSearch();
        $form = $this->createForm(UserSearchType::class, $search);
        $form->handleRequest($request);


        $repo = $this->getDoctrine()->getRepository(User::class);
        //$users = $repo->findAllUsers();
        //$users = $paginator->paginate($repo->findAllUsers(), $request->query->getInt('page',1),5);

        $users = $paginator->paginate($repo->findAllUsersWithLevelSearch($search), $request->query->getInt('page',1),5);

        $numberUser = $users->getTotalItemCount();
         return $this->render('site/find_teacher.html.twig', [
                'users' => $users,
                 'numberUser' => $numberUser,
                 'form' => $form->createView()
         ]);

    }









    /**
    * @Route("/ajax_notif_delete", name="ajax_notif_delete")
    */
    public function  ajaxNotificationDelete(Request $request,ObjectManager $manager): Response{
        if($request->request->get('notif_id') == NULL){
            return $this->redirectToRoute('site');
        }
        $notif_id = $request->request->get('notif_id');
        $repo = $this->getDoctrine()->getRepository(Notification::class);
        $notif = $repo->findOneBy(['id' => $notif_id]);
        $manager->remove($notif);
        $manager->flush();
        $response = new Response();

        $notifs = $repo->findBy(['Username' => $this->get('security.token_storage')->getToken()->getUsername()]);
        $nb_notifs = count($notifs);
        $response->setContent(json_encode([
           'nb_notifs' => $nb_notifs
         ]));
         return $response;
    }








     /**
    * @Route("/ajax_get_number_of_notifications", name="ajax_get_number")
    */
    public function  ajaxGetNumberOfNotifications(Request $request,ObjectManager $manager): Response{
        if($request->request->get('Username') == NULL){
            return $this->redirectToRoute('site');
        }
        $repo = $this->getDoctrine()->getRepository(Notification::class);
        $notifications = $repo->findBy(['Username' => $request->request->get('Username')]);
        $number = count($notifications);
        $response = new Response();
        $response->setContent(json_encode([
           'number' => $number
         ]));
         return $response;
    }







    /**
    * @Route("/{unknown}", name="error_404")
    */
    public function  error404($unknown){
        return $this->render('site/error_404.html.twig', [
           'controller_name' => 'SiteController',
       ]);
    }


}

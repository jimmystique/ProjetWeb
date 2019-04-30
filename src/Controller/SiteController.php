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

use App\Form\FirstnameType;

use Symfony\Component\HttpFoundation\Response;
use Knp\Component\Pager\PaginatorInterface;
use Knp\Component\Pager\Pagination\AbstractPagination;
use App\Form\UserSearchType;
use App\Entity\UserSearch;
use App\Entity\Availability;

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


          $userData = ['Firstname' => $user->getFirstname(), 'Email' => $user->getEmail(), 'Description' => $user->getDescription()];
          $userForm = $this->createFormBuilder($userData)
                             ->add('Firstname', TextType::class, ['label' => 'Votre prénom'])
                             ->add('Email', EmailType::class)
                             ->add('Description', TextareaType::class)
                             ->add('Password', PasswordType::class, ['label' => 'Validez en entrant votre mot de passe'])
                             ->add('profile_pic' , FileType::class, ['required' => false, 'attr' => ['accept' => 'image/*']])
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
           return $this->redirectToRoute('security_login');
       }
   }

   /**
    * @Route("/ajax_change_quality", name="change_quality")
    */
   public function ajaxAction(Request $request,ObjectManager $manager): Response{
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
        $repo = $this->getDoctrine()->getRepository(User::class);
        $user = $repo->findOneBy(['username' => $username]);
        if($user != NULL){
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
                'firstname' => $firstname
            ]);
        }
        // A REMPLACE PAS USER NOT FOUND
         return $this->render('site/user_not_found.html.twig');

    }


    /**
    * @Route("/find_teacher", name="find_teacher")
    */
    public function findTeacher(PaginatorInterface $paginator, Request $request){
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
    * @Route("/my_agenda", name="find_teacherr")
    */
    public function myAgenda(){

         return $this->render('agenda/my_agenda.html.twig');

    }

    /**
    * @Route("/ajax_agenda_change", name="agenda_change")
    */
    public function agendaChange(Request $request,ObjectManager $manager): Response{
        $week = $request->request->get('week');
        $dayhour = $request->request->get('val');
        $availability = new Availability();
        $availability->setUsername($this->get('security.token_storage')->getToken()->getUsername());
        $availability->setWeek($week);
        $availability->setBeginHour($dayhour);
        $manager->persist($availability);
        $manager->flush();
        $response = new Response();
        $response->setContent(json_encode([
           'qual' => 'toto'
         ]));
         return $response;
    }


     /**
    * @Route("/ajax_agenda_delete", name="agenda_delete")
    */
    public function agendaDelete(Request $request,ObjectManager $manager): Response{
        $repo = $this->getDoctrine()->getRepository(Availability::class);
        $week = $request->request->get('week');
        $dayhour = $request->request->get('val');
        $availabilities = $repo->findBy(['Username' => $this->get('security.token_storage')->getToken()->getUsername(), 'Week' => $week, 'Begin_hour' => $dayhour]);
        for($i = 0 ; $i < count($availabilities); $i++){
             $manager->remove($availabilities[$i]);
        }
         $manager->flush();
        $response = new Response();
        $response->setContent(json_encode([
           'qual' => 'toto'
         ]));
         return $response;
    }



    /**
    * @Route("/ajax_agenda_availabilities", name="agenda_availabilities")
    */
    public function agendaGetAvailabilities(Request $request,ObjectManager $manager): Response{
        $repo = $this->getDoctrine()->getRepository(Availability::class);
        $week = $request->request->get('week');
        $username = $request->request->get('username');

        $availabilities = $repo->findBy(['Username' => $username, 'Week' => $week]);

        $ar = array();
        foreach($availabilities as $availability){
            array_push($ar,$availability->getBeginHour());
        }


        $response = new Response();
        $response->setContent(json_encode(['availabilities' => $ar]));
         return $response;
    }


}

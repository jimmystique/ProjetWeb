<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;



class UserFixture extends Fixture
{

    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }




    public function load(ObjectManager $manager)
    {
        $listquality = ['Pas de qualité enregistrée', 'A l\'écoute', 'Abordable', 'Accessible', 'Accompli', 'Acceuillant','Actif','Admirable','Adorable','Adroit','Affable','Affectueux','Affirmatif','Agréable','Aidant','Aimable','Aimant','Ambitieux','Amical','Amusant','Animé','Apaisant','Appliqué','Ardent','Artistique','Assertif','Assidu','Astucieux','Attachant','Attentif','Attentionné','Attractif','Audacieux','Authentique','Autonome','Autoritaire','Avenant','Aventureux','Bavard','Beau','Bienfaisant','Bienveillant','Bon','Brave','Brillant','Bûcheur','Câlin','Calme','Capable','Captivant','Chaleureux','chanceux','Charismatique','Charitable','Charmant','Charmeur','Chouette','Civil','Clément','Cohérent','Collaborateur','Combatif','Comique','Communicatif','Compatissant','Compétent','Compétitif','Complaisant','Complice','Compréhensif','Concentré','Concerné','Conciliant','Confiant','Consciencieux','Conséquence','Convaincant','Coopératif','Courageur','Courtois','Créatif','Culitvé','Curieux','Débonnaire','Débrouillard','Décidé','Décontracté','Délicat','Détendu','Déterminé','Dévoué','Digne','Diligent','Diplomate','Direct','Discipliné','Diponible','Distingué','Divertissant','Doué','Droit','Drôle','Dynamique','Eclatant','Efficace','Eloquent','Empathique','Encourageant','Energique','Engagé','Epanoui','Galant','Humble','Humouristique','Imaginatif','Impliqué','Infatigable','Ingénieux','Inspiré','Intègre','Intéressé','Intrépide','Intuitif','Inventif','Joyeux','Judicieux','Juste','Leader','Libéré','Libre','Logique','Loyal','Mature','Malin','Méritant','Minutieux','Méthodique','Pédagogue','Motivé','Observateur','Objectif','Original','Organisé','Ordonné','Passionné','Patient','Persévérent','Persuasif','Perspicace','Pétillant','Philosophe','Plaisant','Poli','Polyvalent','Ponctuel','Positif','Pragmatique','Productif','Prévenant','Prudent','Réceptif','Réaliste','Reconfortant','Réfléchi','Rationnel','Résistant','Respectueux','Responsable','Rigoureux','Rusé','Sage','Sensible','Serein','Sérieux','Serviable','Sociable','Sincère','Soigneux','Sportif','Souriant','Structuré','Studieux','Sympathique','Tranquille','Vif','Vigilant','Cool'];
        $listLevel = [NULL,'6eme','5eme','4eme','3eme','2nde','1re','Terminale','L1','L2','L3'];
        $listSubject = ['rien','maths','physique','anglais','francais','histoire','espagnol','svt'];
        $faker = Factory::create('fr_FR');
        for($i = 0; $i < 50; $i++){
           $files = glob('public/images_user'. '/*.*');
           $file = array_rand($files);
           $str = ltrim($files[$file],'public');
            $user = new User();
            $user->setEmail($faker->email);
            $user->setUsername($faker->username);
            $user->setDescription($faker->sentences('5',true));
            $hash = $this->encoder->encodePassword($user, "test");
            $user->setPassword($hash);
            $user->setFirstname($faker->firstname(null));
            $user->setProfilePic($str);
            $user->setQuality1($faker->randomElement($listquality));
            $user->setQuality2($faker->randomElement($listquality));
            $user->setQuality3($faker->randomElement($listquality));
            $user->setQuality4($faker->randomElement($listquality));
            $user->setSubject($faker->randomElement($listSubject));
            $user->setLevel($faker->randomElement($listLevel));
            $manager->persist($user);
        }

        // $product = new Product();
        // $manager->persist($product);

        $manager->flush();
    }
}

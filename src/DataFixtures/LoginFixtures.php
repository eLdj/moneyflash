<?php

namespace App\DataFixtures;

use App\Entity\Utilisateur;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class LoginFixtures extends Fixture
{
    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        $user = new Utilisateur();
        $user->setUsername('admin');
        $password = $this->encoder->encodePassword($user, 'admin');
        $user->setRoles(['ROLE_SUPER_ADMIN_SYSTEM']);
        $user->setPassword($password);
        $user->setNom('NDIAYE');
        $user->setPrenom('El Hadji');
        $user->setAdresse('SICAP');
        $user->setEmail('eldji22@hotmail.fr');
        $user->setStatut('-');
        $user->setTelephone("774456858");
    
        $manager->persist($user);
        $manager->flush();
    }
}

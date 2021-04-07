<?php

namespace App\DataFixtures;

use App\Infra\Doctrine\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Ramsey\Uuid\Uuid;

class UserFixtures extends Fixture
{
  public function load(ObjectManager $manager)
  {
    echo 'toto';

    for ($i = 0; $i < 10; $i++) {
      $user = new User();
      $user->setEmail("true" . $i . "@ok.fr")
        ->setPseudo("Pseudo" . $i . "Ok")
        ->setIdentifiant(Uuid::uuid4())
        ->setRoles([])
        ->setPassword("passwordOk");

      $manager->persist($user);
    }

    $manager->flush();
  }
}
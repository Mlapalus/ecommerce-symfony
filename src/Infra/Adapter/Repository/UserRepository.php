<?php

namespace App\Infra\Adapter\Repository;

use Domain\Auth\User\User;
use App\Infra\Doctrine\Entity\User as DoctrineUser;
use Doctrine\Persistence\ManagerRegistry;
use Domain\Auth\Gateway\UserGatewayInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository implements UserGatewayInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DoctrineUser::class);
    }


    public function getUserByEmail(string $email): ?User
    {
        /** 
         * @var DoctrineUser $doctrineUser 
         * 
         */

        $doctrineUser = $this->findOneBy(['email' => $email]); //dd($doctrineParticipant);
        if ($doctrineUser === null) {
            return null;
        }

        return new User(
            $doctrineUser->getIdentifiant(),
            $doctrineUser->getEmail(),
            $doctrineUser->getPseudo(),
            $doctrineUser->getPassword(),
            $doctrineUser->getPasswordResetToken(),
            $doctrineUser->getPasswordResetRequestedAt()
        );
    }

    public function isEmailUnique(?string $email): bool
    {
        return $this->count(["email" => $email]) === 0;
    }

    public function isPseudoUnique(?string $pseudo): bool
    {
        return $this->count(["pseudo" => $pseudo]) === 0;
    }

    public function register(User $user): void
    {
        $doctrineUser = new DoctrineUser();
        $doctrineUser->setIdentifiant($user->getId());
        $doctrineUser->setEmail($user->getEmail());
        $doctrineUser->setPassword($user->getPassword());
        $doctrineUser->setPseudo($user->getPseudo());

        $this->_em->persist($doctrineUser);
        $this->_em->flush();
    }

    public function update(User $user): void
    {
        /** @var DoctrineUser $doctrineUser */
        $doctrineUser = $this->find($user->getId());

        if (null === $doctrineUser) {
            return;
        }

        $doctrineUser->setEmail($user->getEmail());
        $doctrineUser->setPassword($user->getPassword());
        $doctrineUser->setPseudo($user->getPseudo());
        $doctrineUser->setPasswordResetToken($user->getResetPasswordToken());
        $doctrineUser->setPasswordResetRequestedAt($user->getPasswordResetRequestAt);
    }


    // /**
    //  * @return User[] Returns an array of User objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?User
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
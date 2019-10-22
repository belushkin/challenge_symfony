<?php

namespace App\Service;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class UserManager
{
    /**
     * @var EntityRepository
     */
    private $userRepository;

    /**
     * @var EncoderFactoryInterface
     */
    protected $encoderFactory;

    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * UserManager constructor.
     *
     * @param UserRepository $ur
     * @param EncoderFactoryInterface $ef
     * @param EntityManagerInterface $em
     */
    public function __construct(
        UserRepository $ur,
        EncoderFactoryInterface $ef,
        EntityManagerInterface $em
    )
    {
        $this->userRepository = $ur;
        $this->encoderFactory = $ef;
        $this->em             = $em;
    }


    /**
     * @param $email
     *
     * @return null|object
     */
    public function findUserByEmail($email)
    {
        return $this->userRepository->findOneBy(['email' => $email]);
    }


    /**
     * @param UserInterface $user
     */
    public function updatePassword(UserInterface $user)
    {
        if (0 < mb_strlen($password = $user->getPlainPassword())) {
            $encoder = $this->getEncoder($user);
            $user->setPassword($encoder->encodePassword($password, $user->getSalt()));
        }
    }

    /**
     * @param UserInterface $user
     *
     * @return mixed
     */
    protected function getEncoder(UserInterface $user)
    {
        return $this->encoderFactory->getEncoder($user);
    }

    /**
     * @param UserInterface $user
     */
    public function saveUser(UserInterface $user)
    {
        $this->em->persist($user);
        $this->em->flush();
    }


    /**
     * @param User $user
     */
    public function remove(User $user)
    {
        $this->em->remove($user);
        $this->em->flush();
    }
}

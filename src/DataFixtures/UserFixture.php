<?php
/**
 * IGNORE FIXTURE FILES
 */

namespace App\DataFixtures;

use App\Entity\User;
use App\Service\UserManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class UserFixture extends Fixture
{
    /**
     * @var UserManager
     */
    private $userManager;

    public function __construct(UserManager $userManager)
    {
        $this->userManager = $userManager;
    }

    public function load(ObjectManager $manager)
    {
        $user = new User();

        $user
            ->setTitle(User::TITLE_MR)
            ->setName('test')
            ->setEmail('test@ecocode.de')
            ->setLocale('en')
            ->setPlainPassword('test');

        $this->userManager->updatePassword($user);

        $manager->persist($user);
        $manager->flush();
    }
}

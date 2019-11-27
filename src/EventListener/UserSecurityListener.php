<?php

namespace PhpGuild\RhapsodyBundle\EventListener;

use Doctrine\ORM\Event\LifecycleEventArgs;
use PhpGuild\RhapsodyBundle\Entity\UserSecurityInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * Class UserSecurityListener
 */
class UserSecurityListener
{
    private $userPasswordEncoder;

    /**
     * UserSecurityListener constructor.
     *
     * @param UserPasswordEncoderInterface $passwordEncoder
     */
    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->userPasswordEncoder = $passwordEncoder;
    }

    /**
     * @param LifecycleEventArgs $args
     */
    public function prePersist(LifecycleEventArgs $args): void
    {
        /** @var UserSecurityInterface $user */
        $user = $args->getEntity();
        if (!$user instanceof UserSecurityInterface) {
            return;
        }

        if ($user->getPlainPassword()) {
            $user->setPassword($this->userPasswordEncoder->encodePassword($user, $user->getPlainPassword()));
        }

        if (!$user->getSalt()) {
            $user->setSalt(hash('sha256', microtime() . uniqid('', true)));
        }
    }
}

<?php

namespace HomeBundle\Doctrine;

use Doctrine\ORM\Event\LifecycleEventArgs;
use HomeBundle\Entity\User;
use Symfony\Component\Security\Core\Encoder\EncoderFactory;


class UserListener
{
    private $container;

    public function __construct(EncoderFactory $container)
    {
        $this->container = $container;
    }

    public function prePersist(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();
        if ($entity instanceof User) {
            $this->EncodePassword($entity);
        }
    }

    private function EncodePassword(User $user)
    {
        $plainPassword = $user->getPassword();
        $encoder = $this->container->getEncoder($user);
        $password = $encoder->encodePassword($plainPassword, $user->getSalt());
        $user->setPassword($password);
    }
}
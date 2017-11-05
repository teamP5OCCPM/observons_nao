<?php
// src/AppBundle/DoctrineListener/UserAddListener.php

namespace AppBundle\DoctrineListener;

use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use AppBundle\Service\UserMailer;
use AppBundle\Entity\User;

class UserAddListener
{
    /**
     * @var UserMailer
     */
    private $userMailer;

    public function __construct(UserMailer $userMailer)
    {
        $this->userMailer = $userMailer;
    }

    public function postPersist(LifecycleEventArgs $args)
    {
        $entity = $args->getObject();

        // On ne veut envoyer un email que pour les entités Observation
        if (!$entity instanceof User) {
            return;
        }

        $this->userMailer->sendNewNotification($entity);
    }
}

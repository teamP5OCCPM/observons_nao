<?php
// src/AppBundle/DoctrineListener/ObservationAddListener.php

namespace AppBundle\DoctrineListener;

use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use AppBundle\Service\ObservationMailer;
use AppBundle\Entity\Observation;

class ObservationAddListener
{
    /**
     * @var ObservationMailer
     */
    private $observationMailer;

    public function __construct(ObservationMailer $observationMailer)
    {
        $this->observationMailer = $observationMailer;
    }

    public function postPersist(LifecycleEventArgs $args)
    {
        $entity = $args->getObject();

        // On ne veut envoyer un email que pour les entités Observation
        if (!$entity instanceof Observation) {
            return;
        }

        $this->observationMailer->sendNewNotification($entity);
    }
}

<?php
// AppBundle/Service/ObservationMailer.php

namespace AppBundle\Service;

use AppBundle\Entity\Observation;
use Symfony\Component\Templating\EngineInterface;

class ObservationMailer
{
    /**
     * @var \Swift_Mailer
     */
    private $mailer;
    protected $templating;
    private $from = "teamp5.oc.cpm@gmail.com";
    private $reply = "teamp5.oc.cpm@gmail.com";
    private $name = "Nos amis les oiseaux";

    public function __construct(\Swift_Mailer $mailer, EngineInterface $templating)
    {
        $this->mailer = $mailer;
        $this->templating = $templating;
    }

    public function sendNewNotification(Observation $observation)
    {
        $mail = \Swift_Message::newInstance();
        $logo = $mail->embed(\Swift_Image::fromPath('./img/logo-mail.jpg'));

        $mail
            ->setFrom($this->from, $this->name)
            ->setTo($observation->getUser()->getEmail())
            ->setSubject($this->name)
            ->setBody(
                $this->templating->render(
                    'mail/observation-model.html.twig',
                    array('observation' => $observation, 'image' => $logo)
                )
            )
            ->setReplyTo($this->reply, $this->name)
            ->setContentType('text/html');
        $this->mailer->send($mail);
    }
}

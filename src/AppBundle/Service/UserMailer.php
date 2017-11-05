<?php
// AppBundle/Service/UserMailer.php

namespace AppBundle\Service;

use AppBundle\Entity\User;
use Symfony\Component\Templating\EngineInterface;

class UserMailer
{
    /**
     * @var \Swift_Mailer
     */
    private $mailer;
    protected $templating;
    private $from = "teamp5.oc.cpm@gmail.com";
    private $reply = "teamp5.oc.cpm@gmail.com";
    private $name = "Création d'un nouvel utilisateur";

    public function __construct(\Swift_Mailer $mailer, EngineInterface $templating)
    {
        $this->mailer = $mailer;
        $this->templating = $templating;

    }

    public function sendNewNotification(User $user)
    {
        $mail = \Swift_Message::newInstance();
        $logo = $mail->embed(\Swift_Image::fromPath('./img/logo-mail.jpg'));

        $mail
            ->setFrom($this->from, $this->name)
            ->setTo($this->reply)
            ->setSubject($this->name)
            ->setBody( $this->templating->render('mail/user-model.html.twig',
                array('user' => $user, 'image' => $logo)))
            ->setReplyTo($this->reply,$this->name)
            ->setContentType('text/html');
        $this->mailer->send($mail);

    }
}


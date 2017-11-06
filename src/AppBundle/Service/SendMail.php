<?php
// src/AppBundle/Service/SendMail.php

namespace AppBundle\Service;

use Doctrine\ORM\Mapping\Entity;
use Symfony\Component\Templating\EngineInterface;

class SendMail {
    protected $mailer;
    protected $templating;


    public function __construct(\Swift_Mailer $mailer, EngineInterface $templating)
    {
        $this->mailer = $mailer;
        $this->templating = $templating;


    }

    public function sendMessage($to, $subject, $template,$from, $object = null)
    {
        $mail = \Swift_Message::newInstance();
        $logo = $mail->embed(\Swift_Image::fromPath('./img/logo-mail.jpg'));
        $mail
            ->setFrom($from)
            ->setTo($to)
            ->setSubject($subject)
            ->setBody( $this->templating->render($template,
                array('object' => $object, 'image' => $logo)))
            ->setReplyTo($from)
            ->setContentType('text/html');

        $this->mailer->send($mail);
    }


}

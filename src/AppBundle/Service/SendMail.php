<?php
// src/AppBundle/Services/SendMail.php

namespace AppBundle\Services;

use Symfony\Component\Templating\EngineInterface;

class SendMail {
    protected $mailer;
    protected $templating;
    private $from = "octicketing@gmail.com";
    private $reply = "octicketing@gmail.com";
    private $name = "Billetterie du louvre";

    public function __construct(\Swift_Mailer $mailer, EngineInterface $templating)
    {
        $this->mailer = $mailer;
        $this->templating = $templating;
    }

    protected function sendMessage($to, $subject, $template, $object)
    {
        $mail = \Swift_Message::newInstance();
        $logo = $mail->embed(\Swift_Image::fromPath('./img/logo-mail.png'));
        $mail
            ->setFrom($this->from,$this->name)
            ->setTo($to)
            ->setSubject($subject)
            ->setBody( $this->templating->render($template,
                array('image' => $logo, 'objet' => $object)))
            ->setReplyTo($this->reply,$this->name)
            ->setContentType('text/html');
        $this->mailer->send($mail);
    }

    public function sendMail() {
        $this->sendMessage($to, $subject, $template, $object);
    }
}

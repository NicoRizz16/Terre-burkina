<?php
/**
 * Created by PhpStorm.
 * User: Nicolas
 * Date: 24/10/2017
 * Time: 21:27
 */

namespace AppBundle\Utils;


use AppBundle\Entity\Newsletter;
use Doctrine\ORM\EntityManager;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Welp\MailchimpBundle\Event\SubscriberEvent;
use Welp\MailchimpBundle\Subscriber\Subscriber;

class subscribeNewsletter
{
    private $em;
    private $mailchimp_api_key;
    private $mailchimp_list_id;
    private $dispatcher;

    public function __construct(EntityManager $em, $mailchimp_api_key, $mailchimp_list_id, EventDispatcherInterface $dispatcher)
    {
        $this->em = $em;
        $this->mailchimp_api_key = $mailchimp_api_key;
        $this->mailchimp_list_id = $mailchimp_list_id;
        $this->dispatcher = $dispatcher;
    }

    public function subscribeNewsletter($email)
    {
        $em = $this->em;
        if(!$em->getRepository('AppBundle:Newsletter')->findOneBy(array('email' => $email))){
            $newsletter = new Newsletter();
            $newsletter->setEmail($email);
            $em->persist($newsletter);
            $em->flush();

            $subscriber = new Subscriber($email, [
                'FIRSTNAME' => '',
            ], [
                'language' => 'fr'
            ]);

            $this->dispatcher->dispatch(
                SubscriberEvent::EVENT_SUBSCRIBE,
                new SubscriberEvent($this->mailchimp_list_id, $subscriber)
            );
        }
    }
}
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

class unsubscribeNewsletter
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

    public function unsubscribeNewsletter($email)
    {
        $em = $this->em;
        $newsletter = $em->getRepository('AppBundle:Newsletter')->findOneBy(array('email' => $email));

        if($newsletter){

            $em->remove($newsletter);
            $em->flush();

            $subscriber = new Subscriber($email);

            $this->dispatcher->dispatch(
                SubscriberEvent::EVENT_UNSUBSCRIBE,
                new SubscriberEvent($this->mailchimp_list_id, $subscriber)
            );

        }
    }
}
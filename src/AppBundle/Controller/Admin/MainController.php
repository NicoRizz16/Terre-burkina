<?php

/**
 * Created by PhpStorm.
 * User: Nicolas
 * Date: 29/04/2017
 * Time: 10:54
 */

namespace AppBundle\Controller\Admin;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/admin")
 */
class MainController extends Controller
{
    /**
     * @Route("/", name="admin_board")
     * @Security("has_role('ROLE_MODERATOR')")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $newMessages = $em->getRepository('AppBundle:Message')->findBy(array('isNotificationAdmin' => true), array('creationDate' => 'ASC'));
        $waitingPosts = $em->getRepository('AppBundle:Post')->findBy(array('published' => false), array('creationDate' => 'ASC'));
        $waitingLetters = $em->getRepository('AppBundle:Letter')->findBy(array('isPublished' => false), array('creationDate' => 'ASC'));
        $waitingInformationRequests = $em->getRepository('AppBundle:SponsorshipRequest')->findBy(array('isSponsorshipRequest' => false, 'isValid' => false), array('requestedAt' => 'ASC'));
        $waitingSponsorshipRequests = $em->getRepository('AppBundle:SponsorshipRequest')->findBy(array('isSponsorshipRequest' => true, 'isValid' => false), array('requestedAt' => 'ASC'));
        $waitingAccountRequests = $em->getRepository('AppBundle:SponsorshipRequest')->findBy(array('isSponsorshipRequest' => true, 'isValid' => true), array('requestedAt' => 'ASC'));
        $waitingNews = $em->getRepository('AppBundle:News')->findBy(array('isValid' => false), array('creationDate' => 'ASC'));
        $changedProfiles = $em->getRepository('AppBundle:User')->findBy(array('profileChanged' => true));

        return $this->render('admin/board/index.html.twig', array(
            'newMessages' => $newMessages,
            'waitingPosts' => $waitingPosts,
            'waitingLetters' => $waitingLetters,
            'waitingInformationRequests' => $waitingInformationRequests,
            'waitingSponsorshipRequests' => $waitingSponsorshipRequests,
            'waitingAccountRequests' => $waitingAccountRequests,
            'waitingNews' => $waitingNews,
            'changedProfiles' => $changedProfiles
        ));
    }
}

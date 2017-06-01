<?php
/**
 * Created by PhpStorm.
 * User: Nicolas
 * Date: 01/06/2017
 * Time: 09:22
 */

namespace AppBundle\Controller\Admin\Sponsors;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Entity\User;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * @Route("/admin/parrains/messages")
 * @Security("has_role('ROLE_MODERATOR')")
 */
class MessagesController extends Controller
{
    /**
     * @Route("/parrain/{id}", name="admin_sponsors_messages_sponsor", requirements={"id": "\d+"})
     */
    public function indexAction(User $user)
    {
        if(!$user->hasRole('ROLE_SPONSOR')){
            throw new NotFoundHttpException('Le parrain dont vous souhaitez consulter les messages n\'existe pas.');
        }

        $messages = $this->getDoctrine()->getManager()->getRepository('AppBundle:Message')->getUserMessages($user);

        return $this->render('admin/sponsors/sponsors/view_messages.html.twig', array(
            'sponsor' => $user,
            'messages' => $messages
        ));
    }
}